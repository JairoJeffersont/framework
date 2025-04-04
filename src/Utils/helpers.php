<?php

namespace Framework\Utils;

function responseJson(int $status, array $data): string {
    http_response_code($status);
    header('Content-Type: application/json');
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Access-Control-Allow-Origin: *');
    return json_encode([
        'status' => $status,
        'data' => $data
    ]);
}
