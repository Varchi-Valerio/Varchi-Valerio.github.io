<?php

class OpenAIWrapper {
    private $guzzleClient;
    private $api_key;

    public function __construct($api_key) {
        $this->api_key = $api_key;
        $this->guzzleClient = new GuzzleClient([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $this->api_key,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    public function generateResponse($message) {
        $params = [
            'engine' => 'text-davinci-002',
            'prompt' => $message,
            'max_tokens' => 50,
            'n' => 1,
            'stop' => null,
            'temperature' => 0.5,
        ];

        $response = $this->guzzleClient->post('engines/text-davinci-002/completions', [
            'json' => $params,
        ]);

        $responseBody = json_decode($response->getBody(), true);
        return $responseBody['choices'][0]['text'];
    }

    public function processMessage($message) {
        $openaiPrompt = "I am an AI trained by OpenAI. " .
            "My purpose is to help you with your tasks. " .
            "You can ask me anything, and I will do my best to help you. " .
            "Please type your question or request below:\n\n" . $message;

        $response = $this->guzzleClient->post('engines/text-davinci-002/completions', [
            'json' => [
                'prompt' => $openaiPrompt,
                'max_tokens' => 150,
                'n' => 1,
                'stop' => null,
                'temperature' => 0.5,
            ],
        ]);

        $responseBody = json_decode($response->getBody(), true);
        return $responseBody['choices'][0]['text'];
    }
}