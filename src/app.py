from flask import Flask, request, redirect, render_template


### Instaciar serveis ###
# Iniciar la APP i el Sistema
app = Flask(__name__)

# Forçar HTTPS
@app.before_request
def before_request():
    if request.headers.get('X-Forwarded-Proto') == 'http' and request.remote_addr != 'localhost':
        url = request.url.replace('http://', 'https://', 1)
        return redirect(url, code=301)
    

# ----- PRODUCCIÓ ----- #
@app.route('/')
def index():
    return render_template('index.html')


if __name__ == '__main__':
    app.run(debug=True) 