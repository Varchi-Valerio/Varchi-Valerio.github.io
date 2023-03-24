function addMessage(content, messageType) {
    const message = document.createElement('div');
    message.classList.add('message', messageType);
    message.textContent = content;
    document.getElementById('chat-messages').appendChild(message);
}

document.getElementById('api-keys-form').addEventListener('submit', (event) => {
    event.preventDefault();
    document.getElementById('chat-container').style.display = 'block';
    document.getElementById('api-keys-form').style.display = 'none';
});

document.getElementById('user-input-form').addEventListener('submit', async (event) => {
    event.preventDefault();
    const openaiApiKey = document.getElementById('openai-api-key').value;
    const githubToken = document.getElementById('github-token').value;
    const userInput = document.getElementById('user-input');
    const userMessage = userInput.value;

    // Aggiungi il messaggio dell'utente alla chat
    addMessage(userMessage, 'user-message');

    // Invia il messaggio all'assistente virtuale e ottieni la risposta
    const response = await fetch('process_message.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            message: userMessage,
            openaiApiKey: openaiApiKey,
            githubToken: githubToken,
        }),
    });

    const jsonResponse = await response.json();
    const botResponse = jsonResponse.message;

    // Aggiungi la risposta del bot alla chat
    addMessage(botResponse, 'bot-message');

    // Pulisci l'input dell'utente
    userInput.value = '';
});