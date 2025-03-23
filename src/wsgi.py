from gunicorn.app.base import BaseApplication
from app import app

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000)

    class FlaskApplication(BaseApplication):
        def __init__(self, app, options=None):
            self.options = options or {}
            self.application = app
            super(FlaskApplication, self).__init__()

        def load_config(self):
            config = {key: value for key, value in self.options.items() if key in self.cfg.settings and value is not None}
            for key, value in config.items():
                self.cfg.set(key.lower(), value)

        def load(self):
            return self.application

    options = {
        'bind': '0.0.0.0:80',
        'workers': 4  # Número de workers, ajusta según tus necesidades
    }

    FlaskApplication(app, options).run()