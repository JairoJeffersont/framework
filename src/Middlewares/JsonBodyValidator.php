<?php

namespace Framework\Middlewares;

use function Framework\Utils\responseJson;

class JsonBodyValidator {
    public static function handle(array $requiredFields): ?string {
        // Verifica se o header é JSON
        if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
            echo responseJson(415, ['error' => 'Content-Type deve ser application/json']);
            exit;
        }

        // Lê e valida o corpo
        $input = json_decode(file_get_contents('php://input'), true);

        if (!is_array($input)) {
            echo responseJson(400, ['error' => 'Invalid or empty JSON']);
            exit;
        }

        // Verifica campos obrigatórios
        foreach ($requiredFields as $field) {
            if (!isset($input[$field]) || empty(trim($input[$field]))) {
                echo responseJson(422, ['error' => "Required field: {$field}"]);
                exit;
            }
        }

        // Armazena input válido em variável global (simples)
        $GLOBALS['__json'] = $input;

        return null;
    }
}
