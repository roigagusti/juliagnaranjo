from dataclasses import dataclass, asdict


@dataclass
class Navbar:
    bio: str
    teach: str
    projects: str


@dataclass
class Main:
    logo: str
    navbar: Navbar
    text: str

    def to_dict(self) -> dict:
        return {
            "logo": self.logo,
            "navbar": asdict(self.navbar),
            "text": self.text,
        }
