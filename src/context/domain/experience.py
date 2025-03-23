from dataclasses import dataclass, field

@dataclass
class Experience:
    title: str
    type: str
    where: str
    start: int
    end: int
    description: str
    url: str
    url_beauty: str
    tasks: str
    order: str = field(init=False)

    def __post_init__(self):
        # Genera el orden a partir de start y end (puedes ajustar la lógica según tus necesidades)
        self.order = f"{self.start}{self.end}"
