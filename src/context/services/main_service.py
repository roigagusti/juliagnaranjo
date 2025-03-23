from context.infrastructure.notion_client import NotionClient
from context.domain.main import Main

class MainService:
    def __init__(self, notion_client: NotionClient, main_db_id: str):
        self.notion_client = notion_client
        self.main_db_id = main_db_id

    def get_main(self) -> Main:
        url = f"https://api.notion.com/v1/databases/{self.main_db_id}/query"
        response = self.notion_client.request(url, method="POST")
        main_obj = self.notion_client.parse_main(response)
        return main_obj
