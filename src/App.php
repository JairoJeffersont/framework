<?php

namespace Framework;

use function Framework\Utils\responseJson;


class App {
    private array $routes = [];

    public function get(string $path, callable $handler) {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler) {
        $this->routes['POST'][$path] = $handler;
    }

    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $handler = $this->routes[$method][$uri] ?? null;

        if ($handler) {
            echo $handler();
        } else {
            echo responseJson(200, ['status' => '404', 'message' => 'route not found']);
        }
    }
}
