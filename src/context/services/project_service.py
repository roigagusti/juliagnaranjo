from typing import List
from context.infrastructure.notion_client import NotionClient
from context.domain.project import Project

class ProjectService:
    def __init__(self, notion_client: NotionClient, project_db_id: str):
        self.notion_client = notion_client
        self.project_db_id = project_db_id

    def get_projects(self) -> List[Project]:
        url = f"https://api.notion.com/v1/databases/{self.project_db_id}/query"
        response = self.notion_client.request(url, method="POST")
        projects = self.notion_client.parse_projects(response)
        return projects
