<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
require_once './/chatbot.php';
header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $message = $input['message'];
    $openaiApiKey = $input['openaiApiKey'];
    $githubToken = $input['githubToken'];

    file_put_contents('log.txt', "Input data: " . json_encode($input) . "\n", FILE_APPEND);

    $chatbot = new Chatbot($openaiApiKey);
    $response = $chatbot->processMessage($message);

    file_put_contents('log.txt', "Response: " . json_encode($response) . "\n", FILE_APPEND);

    echo json_encode(['message' => $response]);
} catch (Exception $e) {
    file_put_contents('log.txt', "Error: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(['error' => $e->getMessage()]);
}