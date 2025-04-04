<?php

namespace Framework\Utils;

/**
 * Returns a standardized JSON HTTP response.
 *
 * Sets appropriate headers and encodes the given data and optional error message
 * into a JSON response format.
 *
 * @param int $status HTTP status code.
 * @param array $data The data payload to include in the response.
 * @param string|null $error Optional error message.
 *
 * @return string JSON-encoded response.
 */
function responseJson(int $status, array $data = [], ?string $error = null): string {
    http_response_code($status);
    header('Content-Type: application/json');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Access-Control-Allow-Origin: *');

    $response = [
        'status' => $status,
        'data' => $data
    ];

    if ($error !== null) {
        $response['message'] = $error;
    }

    return json_encode($response);
}

/**
 * Validates the JSON body of an incoming request.
 *
 * Checks for 'Content-Type: application/json', decodes the JSON input,
 * and ensures required fields are present and not empty.
 * Sanitizes input and stores it in $GLOBALS['__json'].
 *
 * If validation fails, sends an error JSON response and stops script execution.
 *
 * @param array $requiredFields An array of field names that must be present in the JSON body.
 *
 * @return void
 */
function validateJsonBody(array $requiredFields): void {
    if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
        echo responseJson(415, ['error' => 'Content-Type must be application/json']);
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);

    if (!is_array($input)) {
        echo responseJson(400, ['error' => 'Invalid or empty JSON']);
        exit;
    }

    $sanitizedInput = [];

    foreach ($requiredFields as $field) {
        if (!isset($input[$field]) || empty(trim($input[$field]))) {
            echo responseJson(422, ['error' => "Required field: {$field}"]);
            exit;
        }

        $sanitizedInput[$field] = htmlspecialchars(trim($input[$field]), ENT_QUOTES, 'UTF-8');
    }

    $GLOBALS['__json'] = $sanitizedInput;
}
