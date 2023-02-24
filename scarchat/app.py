from flask import Flask, render_template, request
from transformers import AutoTokenizer, AutoModelForCausalLM

app = Flask(__name__)
tokenizer = AutoTokenizer.from_pretrained("EleutherAI/gpt-neo-1.3B")
model = AutoModelForCausalLM.from_pretrained("EleutherAI/gpt-neo-1.3B")

def generate_response(user_input):
    inputs = tokenizer.encode(user_input, return_tensors="pt")
    output = model.generate(inputs, max_length=50, do_sample=True)
    response = tokenizer.decode(output[0], skip_special_tokens=True)
    return response

@app.route('/', methods=['GET', 'POST'])
def index():
    bot_output = ''
    if request.method == 'POST':
        user_input = request.form['user_input']
        bot_output = generate_response(user_input)
    return render_template('index.html', bot_output=bot_output)

if __name__ == '__main__':
    app.run(debug=True)