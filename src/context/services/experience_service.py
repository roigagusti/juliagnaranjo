from typing import List
from context.infrastructure.notion_client import NotionClient
from context.domain.experience import Experience

class ExperienceService:
    def __init__(self, notion_client: NotionClient, exp_db_id: str):
        self.notion_client = notion_client
        self.exp_db_id = exp_db_id

    def get_experiences(self) -> List[Experience]:
        url = f"https://api.notion.com/v1/databases/{self.exp_db_id}/query"
        response = self.notion_client.request(url, method="POST")
        experiences = self.notion_client.parse_experiences(response)
        return experiences
