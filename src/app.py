from flask import Flask, render_template, request, url_for
from context.infrastructure.notion_client import NotionClient
from context.services.main_service import MainService
from context.services.teach_service import TeachService
from context.services.project_service import ProjectService

import os
import json


app = Flask(__name__)

NOTION_AUTH_TOKEN = os.getenv("NOTION_AUTH_TOKEN")
MAIN_DB_ID = os.getenv("MAIN_DB_ID")
TEACH_DB_ID = os.getenv("TEACH_DB_ID")
PROJECT_DB_ID = os.getenv("PROJECT_DB_ID")

notion_client = NotionClient(NOTION_AUTH_TOKEN)
main_service = MainService(notion_client, MAIN_DB_ID)
teach_service = TeachService(notion_client, TEACH_DB_ID)
project_service = ProjectService(notion_client, PROJECT_DB_ID)

# Simple page
@app.route('/')
def index():
    with open('./src/static/data/main.json', 'r', encoding='utf-8') as f:
        main_data = json.load(f)
    return render_template('index.html', active="bio", main=main_data)

@app.route('/projects')
def projects():
    with open('./src/static/data/main.json', 'r', encoding='utf-8') as f:
        main_data = json.load(f)
    with open('./src/static/data/projects.json', 'r', encoding='utf-8') as f:
        projects_data = json.load(f)
    return render_template('work.html', active="projects", main=main_data, projects=projects_data)

@app.route('/teach')
def teach():
    with open('./src/static/data/main.json', 'r', encoding='utf-8') as f:
        main_data = json.load(f)
    with open('./src/static/data/teach.json', 'r', encoding='utf-8') as f:
        teach_data = json.load(f)
    return render_template('work.html', active="teach", main=main_data, projects=teach_data)


# API
@app.route('/api/update')
def api_update():
    os.makedirs('./src/static/data', exist_ok=True)
    
    main_obj = main_service.get_main()
    with open('./src/static/data/main.json', 'w', encoding='utf-8') as f:
        json.dump([m.to_dict() for m in main_obj], f, ensure_ascii=False, indent=2)
    
    teach_list = teach_service.getTeachs()
    with open('./src/static/data/teach.json', 'w', encoding='utf-8') as f:
        json.dump([t.to_dict() for t in teach_list], f, ensure_ascii=False, indent=2)
    
    projects_list = project_service.get_projects()
    with open('./src/static/data/projects.json', 'w', encoding='utf-8') as f:
        json.dump([p.to_dict() for p in projects_list], f, ensure_ascii=False, indent=2)
    
    return "Se han actualizado todas las tablas."



if __name__ == '__main__':
    app.run(debug=True)
