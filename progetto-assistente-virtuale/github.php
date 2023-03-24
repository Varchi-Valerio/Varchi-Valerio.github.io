<?php

require_once './/vendor/autoload.php';

use GuzzleHttp\Client;

class GitHub {
    private $client;
    private $token;

    public function __construct($github_token) {
        $this->client = new Client(['base_uri' => 'https://api.github.com/']);
        $this->token = $github_token;
    }

    public function createRepository($name, $description) {
        $headers = [
            'Authorization' => 'token ' . $this->token,
            'Content-Type' => 'application/json',
        ];

        $body = json_encode([
            'name' => $name,
            'description' => $description,
            'private' => false,
            'auto_init' => true,
        ]);

        $response = $this->client->post('user/repos', [
            'headers' => $headers,
            'body' => $body,
        ]);

        return json_decode($response->getBody(), true);
    }
}