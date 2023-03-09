function mostraBenvenuto() {
    var messaggio = document.createElement("div");
    messaggio.style.position = "fixed";
    messaggio.style.top = "0";
    messaggio.style.left = "0";
    messaggio.style.width = "100%";
    messaggio.style.backgroundColor = "green";
    messaggio.style.color = "white";
    messaggio.style.fontSize = "24px";
    messaggio.style.textAlign = "center";
    messaggio.style.padding = "10px";
    messaggio.textContent = "Benvenuto nel mio curriculum online!";
    // Aggiungo il messaggio al body
    document.body.appendChild(messaggio);
    // Rimuovo il messaggio dopo 3 secondi
    setTimeout(function() {
        document.body.removeChild(messaggio);
    }, 3000);
}

// Questa funzione cambia il colore di sfondo di una sezione ogni volta che si passa il mouse sopra
function cambiaSfondo() {
    // Seleziono tutti gli elementi con la classe section
    var sezioni = document.querySelectorAll(".section");
    // Creo un array con i colori possibili
    var colori = ["#f0f0f0", "#e0e0e0", "#d0d0d0", "#c0c0c0", "#b0b0b0"];
    // Per ogni sezione, aggiungo un evento al mouseover
    for (var i = 0; i < sezioni.length; i++) {
        sezioni[i].addEventListener("mouseover", function(event) {
            // Scelgo un colore casuale dall'array
            var colore = colori[Math.floor(Math.random() * colori.length)];
            // Cambio il colore di sfondo della sezione con quello scelto
            event.target.style.backgroundColor = colore;
        });
        // Aggiungo un evento al mouseout
        sezioni[i].addEventListener("mouseout", function(event) {
            // Rimetto il colore di sfondo originale
            event.target.style.backgroundColor = "white";
        });
    }
}

// Questa funzione mostra un messaggio di ringraziamento al visitatore del curriculum quando clicca sul link del mio sito
function mostraRingraziamento() {
    // Seleziono l'elemento a con il link del mio sito
    var link = document.querySelector(".footer a");
    // Aggiungo un evento al click
    link.addEventListener("click", function(event) {
        // Preveno il comportamento di default del link
        event.preventDefault();
        // Creo un elemento div per il messaggio
        var messaggio = document.createElement("div");
        // Aggiungo uno stile al messaggio
        messaggio.style.position = "fixed";
        messaggio.style.bottom = "0";
        messaggio.style.left = "0";
        messaggio.style.width = "100%";
        messaggio.style.backgroundColor = "green";
        messaggio.style.color = "white";
        messaggio.style.fontSize = "24px";
        messaggio.style.textAlign = "center";
        messaggio.style.padding = "10px";
        messaggio.textContent = "Grazie per aver visitato il mio curriculum online!";
        // Aggiungo il messaggio al body
        document.body.appendChild(messaggio);
        // Apro il link del mio sito in una nuova finestra
        window.open(link.href, "_blank");
    });
}

// Chiamo le funzioni al caricamento della pagina
window.onload = function() {
    mostraBenvenuto();
    cambiaSfondo();
    mostraRingraziamento();
};