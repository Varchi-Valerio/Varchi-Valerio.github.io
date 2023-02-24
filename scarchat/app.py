from flask import Flask, request
from transformers import pipeline

app = Flask(__name__)

@app.route('/')
def home():
    return 'Benvenuti nel mio sito!'

@app.route('/chatbot', methods=['POST'])
def chatbot():
    data = request.get_json()
    text = data['text']
    chatbot = pipeline('conversational', device=0 if torch.cuda.is_available() else -1)
    response = chatbot(text)[0]['generated_text']
    return {'response': response}

if __name__ == '__main__':
    app.run(debug=True)