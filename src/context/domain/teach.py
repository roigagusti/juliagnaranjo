from dataclasses import dataclass, field

@dataclass
class Teach:
    id: str
    title: str
    description: str
    year: str
    status: str

    def to_dict(self):
        return {
            "id": self.id,
            "title": self.title,
            "description": self.description,
            "year": self.year,
            "status": self.status,
        }
