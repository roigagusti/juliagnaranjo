from flask import Flask, request, redirect, render_template


### Instaciar serveis ###
# Iniciar la APP i el Sistema
app = Flask(__name__)
    

# ----- PRODUCCIÓ ----- #
@app.route('/')
def index():
    return render_template('index.html')


if __name__ == '__main__':
    app.run(debug=True) 