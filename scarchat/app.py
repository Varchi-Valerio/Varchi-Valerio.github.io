from flask import Flask, render_template, request
from transformers import pipeline, set_seed

app = Flask(__name__)
generator = pipeline('text-generation', model='gpt2-medium')

def generate_response(user_input):
    set_seed(42)
    response = generator(user_input, max_length=100, num_return_sequences=1)[0]['generated_text']
    return response.strip()

@app.route('/', methods=['GET', 'POST'])
def index():
    bot_output = ''
    if request.method == 'POST':
        user_input = request.form['user_input']
        bot_output = generate_response(user_input)
    return render_template('index.html', bot_output=bot_output)

if __name__ == '__main__':
    app.run(debug=True)