from flask import Flask, render_template, request, url_for
from context.infrastructure.notion_client import NotionClient
from context.services.main_service import MainService
from context.services.experience_service import ExperienceService
from context.services.project_service import ProjectService

import os
import json


app = Flask(__name__)

NOTION_AUTH_TOKEN = os.getenv("NOTION_AUTH_TOKEN")
MAIN_DB_ID = os.getenv("MAIN_DB_ID")
EXP_DB_ID = os.getenv("EXP_DB_ID")
PROJECT_DB_ID = os.getenv("PROJECT_DB_ID")

notion_client = NotionClient(NOTION_AUTH_TOKEN)
main_service = MainService(notion_client, MAIN_DB_ID)
experience_service = ExperienceService(notion_client, EXP_DB_ID)
project_service = ProjectService(notion_client, PROJECT_DB_ID)

# Simple page
@app.route('/')
def index():
    return render_template('index.html', active="bio")

@app.route('/work')
def work():
    with open('./static/data/work.json', 'r') as f:
        work_data = json.load(f)
    return render_template('work.html', active="work", projects=work_data)

@app.route('/teach')
def teach():
    with open('./static/data/teach.json', 'r') as f:
        teach_data = json.load(f)
    return render_template('work.html', active="teach", projects=teach_data)


# OLD Page
@app.route('/home')
def home():
    main_data = main_service.get_main()
    return render_template('home.html', main=main_data)

@app.route('/experience')
def experience():
    experiences_data = experience_service.get_experiences()
    back_link = request.args.get('from') and url_for('index', for_=request.args.get('from')) or url_for('index')
    return render_template('experience.html', work=experiences_data, back_link=back_link)

@app.route('/projects')
def projects():
    projects_data = project_service.get_projects()
    on_julia = True
    return render_template('projects.html', projects=projects_data, on_julia=on_julia)



if __name__ == '__main__':
    app.run(debug=True)
