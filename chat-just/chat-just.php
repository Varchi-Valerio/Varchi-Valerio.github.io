<?php

// Inizializza un array per le risposte preimpostate
$responses = array();

// Leggi il file JSON con le risposte preimpostate
$json = file_get_contents('responses/responses.json');
$responses = json_decode($json, true);

// Verifica se l'utente ha inviato un input
if (isset($_POST['user_input'])) {
    $input = $_POST['user_input'];
    $output = "Le mie risposte sono limitate, devi farmi le domande giuste.";

    // Verifica se esiste una risposta preimpostata per l'input dell'utente
    foreach ($responses as $key => $value) {
        if ($key == $input) {
            $output = $value;
            break;
        }
    }

    // Memorizza la conversazione nel file JSON
    $conversations = array();
    if (file_exists('data/conversations.json')) {
        $json = file_get_contents('data/conversations.json');
        $conversations = json_decode($json, true);
    }
    $conversations[] = array('input' => $input, 'output' => $output);
    file_put_contents('data/conversations.json', json_encode($conversations));
}

?>