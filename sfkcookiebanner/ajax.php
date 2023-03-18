<?php

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
require_once(dirname(__FILE__).'/sfkcookiebanner.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['user_ip']) && isset($data['user_agent']) && isset($data['acceptance_date'])) {
        $sfkcookiebanner = new Sfkcookiebanner();
        $sfkcookiebanner->insertUserAcceptance($data['user_ip'], $data['user_agent'], $data['acceptance_date']);
        http_response_code(200);
        echo json_encode(['success' => true]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid request']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}