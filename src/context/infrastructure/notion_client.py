import json
import requests
from typing import Any, Dict, List, Optional, Union

from context.domain.main import Main
from context.domain.experience import Experience
from context.domain.project import Project

NOTION_VERSION = "2022-06-28"

def safe_get(data: Any, keys: List[Union[str, int]], default: Any = "") -> Any:
    """
    Recorre en cadena 'data' con la lista de keys.
    Si en algún punto no se puede acceder (None, índice inexistente, etc.),
    retorna el valor por defecto.
    
    Ejemplo de uso:
      safe_get(props, ["Title", "title", 0, "text", "content"], default="")
    """
    for key in keys:
        if isinstance(key, int):
            # Si se espera un índice en una lista
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

    def parse_main(self, response: Dict[str, Any]) -> Optional[Main]:
        """Analiza la respuesta para construir la entidad Main."""
        if not response.get("results"):
            return None

        # Valores por defecto
        title = basedin = experience = projects = contact = ""
        experience_title_1 = experience_title_2 = experience_title_3 = experience_title_4 = ""
        up = ""

        for item in response["results"]:
            properties = item.get("properties", {})
            name = safe_get(properties, ["Name", "title", 0, "text", "content"], "")
            # Se asume que "select" de properties tiene la estructura deseada
            type_sel = safe_get(properties, ["select", "name"], "")
            text = safe_get(properties, ["Text", "rich_text", 0, "text", "content"], "")
            status_val = safe_get(properties, ["Status", "select", "name"], "")

            title = self.create_data(status_val, name, text, "Title", title)
            basedin = self.create_data(status_val, name, text, "Based in", basedin)
            experience = self.create_data(status_val, name, text, "Experience", experience)
            projects = self.create_data(status_val, name, text, "Projects", projects)
            contact = self.create_data(status_val, name, text, "Contact", contact)
            experience_title_1 = self.create_data(status_val, name, text, "Experience title 1", experience_title_1)
            experience_title_2 = self.create_data(status_val, name, text, "Experience title 2", experience_title_2)
            experience_title_3 = self.create_data(status_val, name, text, "Experience title 3", experience_title_3)
            experience_title_4 = self.create_data(status_val, name, text, "Experience title 4", experience_title_4)
            up = self.create_data(status_val, name, text, "Start again", up)

        return Main(
            title,
            basedin,
            experience,
            projects,
            contact,
            experience_title_1,
            experience_title_2,
            experience_title_3,
            experience_title_4,
            up
        )

    def parse_experiences(self, response: Dict[str, Any]) -> List[Experience]:
        """Analiza la respuesta para construir una lista de entidades Experience."""
        experiences: List[Experience] = []
        if not response.get("results"):
            return experiences

        for item in response["results"]:
            props = item.get("properties", {})
            title = safe_get(props, ["Title", "title", 0, "text", "content"], "")
            type_sel = safe_get(props, ["Type", "select", "name"], "")
            where = safe_get(props, ["Where", "rich_text", 0, "text", "content"], "")
            start = safe_get(props, ["startYear", "formula", "number"], 0)
            end = safe_get(props, ["endYear", "formula", "number"], 0)
            description = safe_get(props, ["Description", "rich_text", 0, "text", "content"], "")
            url = safe_get(props, ["Url", "rich_text", 0, "text", "content"], "")
            url_beauty = safe_get(props, ["Url-text", "rich_text", 0, "text", "content"], "")
            tasks = safe_get(props, ["Tasks", "rich_text", 0, "text", "content"], "")
            
            exp = Experience(title, type_sel, where, start, end, description, url, url_beauty, tasks)
            experiences.append(exp)

        # Ordenamientos según la lógica deseada
        experiences.sort(key=lambda x: (x.start, x.end), reverse=True)
        experiences.sort(key=lambda x: x.order, reverse=True)
        return experiences

    def parse_projects(self, response: Dict[str, Any]) -> List[Project]:
        """Analiza la respuesta para construir una lista de entidades Project."""
        projects: List[Project] = []
        if not response.get("results"):
            return projects

        for item in response["results"]:
            props = item.get("properties", {})
            title = safe_get(props, ["Title", "title", 0, "text", "content"], "")
            brand = safe_get(props, ["Brand", "rich_text", 0, "text", "content"], "")
            description = safe_get(props, ["Description", "rich_text", 0, "text", "content"], "")
            column = safe_get(props, ["Column", "select", "name"], "")
            content_type = safe_get(props, ["Content type", "select", "name"], "")
            url = safe_get(props, ["URL", "url"], "")
            confidencialidad = safe_get(props, ["Confidencialidad", "select", "name"], "Show")
            proj = Project(title, brand, description, column, content_type, url, confidencialidad)
            projects.append(proj)
        return projects
