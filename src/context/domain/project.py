from dataclasses import dataclass

@dataclass
class Project:
    title: str
    brand: str
    description: str
    column: str
    content_type: str
    url: str
    confidencialidad: str = "Show"
