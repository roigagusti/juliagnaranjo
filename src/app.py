from flask import Flask, redirect, render_template, request, url_for
from context.infrastructure.notion_client import NotionClient
from context.services.main_service import MainService
from context.services.teach_service import TeachService
from context.services.glosa_service import GlosaService
from context.services.project_service import ProjectService

import os
import json
import requests


app = Flask(__name__)

NOTION_AUTH_TOKEN = os.getenv("NOTION_AUTH_TOKEN")
MAIN_DB_ID = os.getenv("MAIN_DB_ID")
PROJECTS_DB_ID = os.getenv("PROJECTS_DB_ID")
TEACH_DB_ID = os.getenv("TEACH_DB_ID")
GLOSA_DB_ID = os.getenv("GLOSA_DB_ID")
EMAIL_DB_ID = os.getenv("EMAIL_DB_ID")

notion_client = NotionClient(NOTION_AUTH_TOKEN)
main_service = MainService(notion_client, MAIN_DB_ID)
project_service = ProjectService(notion_client, PROJECTS_DB_ID)
teach_service = TeachService(notion_client, TEACH_DB_ID)
glosa_service = GlosaService(notion_client, GLOSA_DB_ID)

# Simple page
@app.route('/')
def index():
    with open('./src/static/data/main.json', 'r', encoding='utf-8') as f:
        main_data = json.load(f)
    form_status = request.args.get("portfolio_request")
    return render_template('index.html', active="bio", main=main_data, form_status=form_status)

@app.route('/projects')
def projects():
    with open('./src/static/data/main.json', 'r', encoding='utf-8') as f:
        main_data = json.load(f)

    with open('./src/static/data/projects.json', 'r', encoding='utf-8') as f:
        projects_data = json.load(f)
    projects_data.sort(key=lambda x: x['order'])
    form_status = request.args.get("portfolio_request")
    return render_template('work.html', active="projects", main=main_data, projects=projects_data, form_status=form_status)

@app.route('/teach')
def teach():
    with open('./src/static/data/main.json', 'r', encoding='utf-8') as f:
        main_data = json.load(f)
    with open('./src/static/data/teach.json', 'r', encoding='utf-8') as f:
        teach_data = json.load(f)
    teach_data.sort(key=lambda x: x['order'])
    return render_template('work.html', active="teach", main=main_data, projects=teach_data)

@app.route('/glosa')
def glosa():
    with open('./src/static/data/main.json', 'r', encoding='utf-8') as f:
        main_data = json.load(f)
    with open('./src/static/data/glosa.json', 'r', encoding='utf-8') as f:
        glosa_data = json.load(f)
    return render_template('glosa.html', active="glosa", main=main_data, glosa=glosa_data)


@app.route('/portfolio-request', methods=['POST'])
def portfolio_request():
    email = request.form.get("email", "").strip()
    next_path = request.form.get("next", "/projects").strip()

    if not next_path.startswith("/"):
        next_path = "/projects"

    if not email:
        return redirect(f"{next_path}?portfolio_request=empty")

    if not NOTION_AUTH_TOKEN or not EMAIL_DB_ID:
        print("Portfolio request skipped: NOTION_AUTH_TOKEN or EMAIL_DB_ID missing.")
        return redirect(f"{next_path}?portfolio_request=error")

    try:
        notion_client.create_page(
            EMAIL_DB_ID,
            {
                "Email": {
                    "title": [
                        {
                            "text": {
                                "content": email,
                            }
                        }
                    ]
                }
            },
        )
        return redirect(f"{next_path}?portfolio_request=sent")
    except Exception as exc:
        print(f"Portfolio request save failed: {exc}")
        return redirect(f"{next_path}?portfolio_request=error")


# API
@app.route('/api/update')
def api_update():
    os.makedirs('./src/static/data', exist_ok=True)
    
    main_obj = main_service.get_main()
    with open('./src/static/data/main.json', 'w', encoding='utf-8') as f:
        json.dump(main_obj.to_dict(), f, ensure_ascii=False, indent=2)
    
    teach_list = teach_service.getTeachs()
    with open('./src/static/data/teach.json', 'w', encoding='utf-8') as f:
        json.dump([t.to_dict() for t in teach_list], f, ensure_ascii=False, indent=2)
    
    projects_list = project_service.get_projects()
    with open('./src/static/data/projects.json', 'w', encoding='utf-8') as f:
        json.dump([p.to_dict() for p in projects_list], f, ensure_ascii=False, indent=2)

    try:
        glosa_content = glosa_service.get_content()
        with open('./src/static/data/glosa.json', 'w', encoding='utf-8') as f:
            json.dump(glosa_content, f, ensure_ascii=False, indent=2)
    except requests.exceptions.HTTPError as exc:
        print(f"Glosa update skipped: {exc}")
    except Exception as exc:
        print(f"Unexpected Glosa update error: {exc}")
    
    return "Se han actualizado todas las tablas."



if __name__ == '__main__':
    app.run(debug=True)
