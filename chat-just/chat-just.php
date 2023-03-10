<?php

// Carichiamo le risposte preimpostate dal file risposte.json
$file = file_get_contents('risposte.json');
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

// Se non è stata trovata una risposta corrispondente, effettua una richiesta all'API di Wikipedia
if (!$found_response) {
    $query = urlencode($_POST['user_input']);
    $url = "https://it.wikipedia.org/w/api.php?action=query&list=search&srsearch=$query&format=json";
    $data = file_get_contents($url);
    $wikipedia_response = json_decode($data, true);
    if (count($wikipedia_response['query']['search']) > 0) {
        $bot_output = "Secondo Wikipedia, " . $wikipedia_response['query']['search'][0]['snippet'];
    } else {
        $bot_output = "Le mie risposte sono limitate, devi farmi le domande giuste";
    }
}
// Rimuoviamo i tag <span class="searchmatch">
$bot_output = str_replace('<span class="searchmatch">', '', $bot_output);
$bot_output = str_replace('</span>', '', $bot_output);
$bot_output = str_replace(' (AFI: [ˈt͡ʃaːo])', '', $bot_output);
$bot_output = str_replace(' (disambigua)', '', $bot_output);

// Salviamo la conversazione nel file storiadelleconv.json
$file = file_get_contents('storiadelleconv.json');
$conversations = json_decode($file, true);
$new_conversation = array(
    "user_input" => $_POST['user_input'],
    "bot_output" => $bot_output
);
array_push($conversations, $new_conversation);
$file = fopen('storiadelleconv.json', 'w');
fwrite($file, json_encode($conversations));
fclose($file);

// Restituiamo la risposta del bot all'utente
echo $bot_output;

?>