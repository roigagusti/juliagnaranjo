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
        projects = ""
        text_value = ""

        for item in response.get("results", []):
            props = item.get("properties", {})
            type_ = safe_get(props, ["Type", "select", "name"], "")
            text = safe_get(props, ["Text", "rich_text", 0, "text", "content"], "")
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
                else:
                    projects = text
            elif type_ == "Text":
                text_value = text

        navbar = Navbar(bio=bio, teach=teach, projects=projects)
        return Main(logo=logo, navbar=navbar, text=text_value)

    def parse_teaches(self, response: Dict[str, Any]) -> List[Teach]:
        """Analiza la respuesta para construir una lista de entidades Experience."""
        teaches: List[Teach] = []
        if not response.get("results"):
            return teaches

        for item in response["results"]:    
            props = item.get("properties", {})
            id = item.get("id", "")
            title = safe_get(props, ["Title", "title", 0, "text", "content"], "")
            description = safe_get(props, ["Description", "rich_text", 0, "text", "content"], "")
            year = safe_get(props, ["Year", "number"], "")
            status = safe_get(props, ["Status", "select", "name"], "")

            if status != "Active":
                continue
            teach = Teach(id, title, description, year, status)
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
            title = safe_get(props, ["Title", "title", 0, "text", "content"], "")
            description = safe_get(props, ["Description", "rich_text", 0, "text", "content"], "")
            year = safe_get(props, ["Year", "number"], "")
            status = safe_get(props, ["Status", "select", "name"], "")

            if status != "Active":
                continue
            project = Project(id, title, description, year, status)
            projects.append(project)

        return projects