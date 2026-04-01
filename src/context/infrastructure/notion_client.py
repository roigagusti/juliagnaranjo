import requests
from typing import Any, Dict, List, Optional, Union

from context.domain.main import Main, Navbar
from context.domain.teach import Teach
from context.domain.project import Project


NOTION_VERSION = "2022-06-28"

def safe_get(data: Any, keys: List[Union[str, int]], default: Any = "") -> Any:
    for key in keys:
        if isinstance(key, int):
            if isinstance(data, list) and len(data) > key:
                data = data[key]
            else:
                return default
        else:
            if isinstance(data, dict):
                data = data.get(key, default)
            else:
                return default
        if data is None:
            return default
    return data


def extract_plain_text(items: Any) -> str:
    if not isinstance(items, list):
        return ""

    parts: List[str] = []
    for item in items:
        if not isinstance(item, dict):
            continue
        plain_text = item.get("plain_text")
        if plain_text:
            parts.append(plain_text)
            continue
        content = safe_get(item, ["text", "content"], "")
        if content:
            parts.append(content)

    return "".join(parts)

class NotionClient:
    def __init__(self, auth_token: str):
        self.auth_token = auth_token

    def request(self, url: str, method: str = "GET", payload: Optional[Dict[str, Any]] = None) -> Dict[str, Any]:
        headers = {
            "Authorization": f"Bearer {self.auth_token}",
            "Notion-Version": NOTION_VERSION,
        }
        if method.upper() == "POST":
            headers["Content-Type"] = "application/json"
            response = requests.post(url, headers=headers, json=payload, verify=False)
        else:
            headers["Accept"] = "application/json"
            response = requests.get(url, headers=headers, verify=False)
        response.raise_for_status()
        return response.json()

    def create_page(self, database_id: str, properties: Dict[str, Any]) -> Dict[str, Any]:
        payload = {
            "parent": {"database_id": database_id},
            "properties": properties,
        }
        return self.request(
            "https://api.notion.com/v1/pages",
            method="POST",
            payload=payload,
        )

    def filter(self, property_name: str, filter_type: str, filter_value: str) -> Dict[str, Any]:
        """Genera un filtro para la consulta a Notion."""
        return {
            "filter": {
                "property": property_name,
                filter_type: {
                    "equals": filter_value
                }
            },
            "sorts": [
                {
                    "property": "Order",
                    "direction": "ascending"
                }
            ]
        }

    def create_data(self, status: str, name: str, text: str, find: str, current: str) -> str:
        """Actualiza el valor si el status es 'Active' y el nombre coincide."""
        return text if status == 'Active' and name == find else current

    def parse_main(self, response: Dict[str, Any]) -> Main:
        """Analiza la respuesta y construye la entidad Main."""
        logo = ""
        bio = ""
        teach = ""
        glosa = "Glosa"
        projects = ""
        text_value = ""

        for item in response.get("results", []):
            props = item.get("properties", {})
            type_ = safe_get(props, ["Type", "select", "name"], "")
            text = extract_plain_text(safe_get(props, ["Text", "rich_text"], []))
            status = safe_get(props, ["Status", "select", "name"], "")

            if status != "Active":
                continue

            if type_ == "Logo":
                logo = text
            elif type_ == "Button":
                lowered = text.lower()
                if "bio" in lowered:
                    bio = text
                elif "teach" in lowered:
                    teach = text
                elif "glosa" in lowered:
                    glosa = text
                else:
                    projects = text
            elif type_ == "Text":
                text_value = text

        navbar = Navbar(bio=bio, teach=teach, glosa=glosa, projects=projects)
        return Main(logo=logo, navbar=navbar, text=text_value)

    def parse_teaches(self, response: Dict[str, Any]) -> List[Teach]:
        """Analiza la respuesta para construir una lista de entidades Experience."""
        teaches: List[Teach] = []
        if not response.get("results"):
            return teaches

        for item in response["results"]:    
            props = item.get("properties", {})
            id = item.get("id", "")
            title = extract_plain_text(safe_get(props, ["Title", "title"], []))
            description = extract_plain_text(safe_get(props, ["Description", "rich_text"], []))
            year = safe_get(props, ["Year", "number"], "")
            status = safe_get(props, ["Status", "select", "name"], "")
            order = safe_get(props, ["Order", "number"], 0)

            if status != "Active":
                continue
            teach = Teach(id, title, description, year, status, order)
            teaches.append(teach)

        return teaches

    def parse_projects(self, response: Dict[str, Any]) -> List[Project]:
        """Analiza la respuesta para construir una lista de entidades Project."""
        projects: List[Project] = []
        if not response.get("results"):
            return projects

        for item in response["results"]:    
            props = item.get("properties", {})
            id = item.get("id", "")
            title = extract_plain_text(safe_get(props, ["Title", "title"], []))
            description = extract_plain_text(safe_get(props, ["Description", "rich_text"], []))
            year = safe_get(props, ["Year", "number"], "")
            status = safe_get(props, ["Status", "select", "name"], "")
            order = safe_get(props, ["Order", "number"], 0)

            if status != "Active":
                continue
            project = Project(id, title, description, year, status, order)
            projects.append(project)

        return projects

    def parse_glosa_content(self, response: Dict[str, Any]) -> Dict[str, str]:
        content = {
            "text": "",
            "link_label": "",
            "link_url": "",
        }

        if not response.get("results"):
            return content

        for item in response["results"]:
            props = item.get("properties", {})
            title = extract_plain_text(safe_get(props, ["Title", "title"], [])).strip()
            description = extract_plain_text(safe_get(props, ["Description", "rich_text"], []))
            status = safe_get(props, ["Status", "select", "name"], "").strip()

            if status.lower() != "active":
                continue

            lowered_title = title.lower()
            if lowered_title == "main text":
                content["text"] = description
            elif lowered_title == "link label":
                content["link_label"] = description
            elif lowered_title == "link url":
                content["link_url"] = description

        return content
