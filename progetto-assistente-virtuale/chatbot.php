<?php
require_once './//openai_wrapper.php';

class Chatbot {
    private $openai;

    public function __construct($api_key) {
        $this->openai = new OpenAIWrapper($api_key);
    }

    public function processMessage($message) {
        return $this->openai->generateResponse($message);
    }
}