<?php

namespace Framework\Utils;

function responseJson(int $status, array $data = [], ?string $error = null): string {
    http_response_code($status);
    header('Content-Type: application/json');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Access-Control-Allow-Origin: *');

    $response = ['status' => $status];

    if ($error !== null) {
        $response['message'] = $error;
    } else {
        $response['data'] = $data;
    }

    return json_encode($response);
}



function validateJsonBody(array $requiredFields): void
{
    if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
        echo responseJson(415, ['error' => 'Content-Type must be application/json']);
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);

    if (!is_array($input)) {
        echo responseJson(400, ['error' => 'Invalid or empty JSO']);
        exit;
    }

    foreach ($requiredFields as $field) {
        if (!isset($input[$field]) || empty(trim($input[$field]))) {
            echo responseJson(422, ['error' => "Required field: {$field}"]);
            exit;
        }
    }

    $GLOBALS['__json'] = $input;
}
