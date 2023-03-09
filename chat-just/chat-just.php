<?php

// Carichiamo le risposte preimpostate dal file responses.json
$file = file_get_contents('responses/responses.json');
$responses = json_decode($file, true);

// Cerca una risposta corrispondente all'input dell'utente
$found_response = false;
foreach ($responses as $response) {
    if ($_POST['user_input'] == $response['user_input']) {
        $found_response = true;
        $bot_output = $response['bot_output'];
        break;
    }
}

// Se non è stata trovata una risposta corrispondente, restituisce un messaggio di errore
if (!$found_response) {
    $bot_output = "Le mie risposte sono limitate, devi farmi le domande giuste";
}

// Salviamo la conversazione nel file storiadelleconv.json
$file = file_get_contents('data/storiadelleconv.json');
$conversations = json_decode($file, true);
$new_conversation = array(
    "user_input" => $_POST['user_input'],
    "bot_output" => $bot_output
);
array_push($conversations, $new_conversation);
$file = fopen('data/storiadelleconv.json', 'w');
fwrite($file, json_encode($conversations));
fclose($file);

// Restituiamo la risposta del bot all'utente
echo $bot_output;

?>