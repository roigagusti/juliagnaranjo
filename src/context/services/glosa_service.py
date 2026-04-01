from typing import Dict

from context.infrastructure.notion_client import NotionClient


class GlosaService:
    def __init__(self, notion_client: NotionClient, glosa_db_id: str):
        self.notion_client = notion_client
        self.glosa_db_id = glosa_db_id

    def get_content(self) -> Dict[str, str]:
        url = f"https://api.notion.com/v1/databases/{self.glosa_db_id}/query"
        response = self.notion_client.request(url, method="POST")
        return self.notion_client.parse_glosa_content(response)
