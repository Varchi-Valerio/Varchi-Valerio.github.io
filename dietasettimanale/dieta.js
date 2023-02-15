// Questa è una funzione che mostra la tabella menù Prima settimana se si preme nel nav Prima settimana
function mostraPrimaSettimana() {
    // Questa è una variabile che seleziona l'elemento HTML con l'id "prima-settimana"
    var tabellaPrimaSettimana = document.getElementById("prima-settimana");
    // Questa è una variabile che seleziona tutti gli elementi HTML con la classe "tabella-settimana"
    var tabelleSettimana = document.getElementsByClassName("tabella-settimana");
    // Questo è un ciclo che nasconde tutte le tabelle settimana
    for (var i = 0; i < tabelleSettimana.length; i++) {
      tabelleSettimana[i].style.display = "none";
    }
    // Questa è una istruzione che mostra la tabella Prima settimana
    tabellaPrimaSettimana.style.display = "block";
  }
  
  // Questa è una funzione che mostra la tabella menù Seconda settimana se si preme nel nav Seconda settimana
  function mostraSecondaSettimana() {
    // Questa è una variabile che seleziona l'elemento HTML con l'id "seconda-settimana"
    var tabellaSecondaSettimana = document.getElementById("seconda-settimana");
    // Questa è una variabile che seleziona tutti gli elementi HTML con la classe "tabella-settimana"
    var tabelleSettimana = document.getElementsByClassName("tabella-settimana");
    // Questo è un ciclo che nasconde tutte le tabelle settimana
    for (var i = 0; i < tabelleSettimana.length; i++) {
      tabelleSettimana[i].style.display = "none";
    }
    // Questa è una istruzione che mostra la tabella Seconda settimana
    tabellaSecondaSettimana.style.display = "block";
  }
  
  // Questa è una funzione che mostra la tabella menù Terza settimana se si preme nel nav Terza settimana
  function mostraTerzaSettimana() {
    // Questa è una variabile che seleziona l'elemento HTML con l'id "terza-settimana"
    var tabellaTerzaSettimana = document.getElementById("terza-settimana");
    // Questa è una variabile che seleziona tutti gli elementi HTML con la classe "tabella-settimana"
    var tabelleSettimana = document.getElementsByClassName("tabella-settimana");
    // Questo è un ciclo che nasconde tutte le tabelle settimana
    for (var i = 0; i < tabelleSettimana.length; i++) {
      tabelleSettimana[i].style.display = "none";
    }
    // Questa è una istruzione che mostra la tabella Terza settimana
    tabellaTerzaSettimana.style.display = "block";
  }
  
  // Questa è una funzione che mostra la tabella menù Quarta settimana se si preme nel nav Quarta settimana
  function mostraQuartaSettimana() {
    // Questa è una variabile che seleziona l'elemento HTML con l'id "quarta-settimana"
    var tabellaQuartaSettimana = document.getElementById("quarta-settimana");
    // Questa è una variabile che seleziona tutti gli elementi HTML con la classe "tabella-settimana"
    var tabelleSettimana = document.getElementsByClassName("tabella-settimana");
    // Questo è un ciclo che nasconde tutte le tabelle settimana
    for (var i = 0; i < tabelleSettimana.length; i++) {
      tabelleSettimana[i].style.display = "none";
    }
    // Questa è una istruzione che mostra la tabella Quarta settimana
    tabellaQuartaSettimana.style.display = "block";
  }