import openai
import os
import base64
import requests

# Inserisci il tuo token API di OpenAI
openai.api_key = ""

# Inserisci il tuo token di accesso personale di GitHub
GITHUB_TOKEN = ""

# Funzione per leggere il contenuto di un file nel tuo repository GitHub
def read_github_file(user, repo, path, token):
    url = f"https://api.github.com/repos/{user}/{repo}/contents/{path}"
    headers = {"Authorization": f"token {token}"}
    response = requests.get(url, headers=headers).json()
    content = response["content"]
    decoded_content = base64.b64decode(content).decode("utf-8")
    return decoded_content

# Funzione per ottenere tutti i file in un repository GitHub
def get_all_files(user, repo, token, path=''):
    url = f"https://api.github.com/repos/{user}/{repo}/contents/{path}"
    headers = {"Authorization": f"token {token}"}
    response = requests.get(url, headers=headers).json()
    print(response)
    files = []
    for item in response:
        if item['type'] == 'file':
            files.append(item['path'])
        elif item['type'] == 'dir':
            files.extend(get_all_files(user, repo, token, item['path']))
    return files

def ask_codex(question, model="text-davinci-002"):
    response = openai.Completion.create(
        engine=model,
        prompt=f"{question}\n",
        max_tokens=100,
        n=1,
        stop=None,
        temperature=0.5,
    )

    answer = response.choices[0].text.strip()
    return answer

# Esempio di utilizzo della funzione get_all_files e read_github_file
all_files = get_all_files("Varchi-Valerio", "Varchi-Valerio.github.io", GITHUB_TOKEN, "sfkcookiebanner")

for file_path in all_files:
    file_content = read_github_file("Varchi-Valerio", "Varchi-Valerio.github.io", file_path, GITHUB_TOKEN)
    print(f"File: {file_path}\nContent:\n{file_content}\n{'='*80}\n")

# Esempio di utilizzo della funzione ask_codex
question = "devo creare un modo che salvi chi accetta i cookie nel database, vorrei che creasse direttamente le tabelle come già fa ma che inserisse anche nel database chi accetta i cookie, controlla eventuali errori e dimmi come modificare il progetto"
suggestion = ask_codex(question)
print(suggestion)
