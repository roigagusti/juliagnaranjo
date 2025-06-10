from dataclasses import dataclass

@dataclass
class Main:
    id: str
    type: str
    text: str
    status: str

    def to_dict(self):
        return {
            "id": self.id,
            "type": self.type,
            "text": self.text,
            "status": self.status,
        }
        