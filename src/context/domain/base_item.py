from dataclasses import dataclass

@dataclass
class BaseItem:
    id: str
    title: str
    description: str
    year: str
    status: str
    order: int

    def to_dict(self) -> dict:
        return {
            "id": self.id,
            "title": self.title,
            "description": self.description,
            "year": self.year,
            "status": self.status,
            "order": self.order,
        }