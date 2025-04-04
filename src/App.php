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

    public function delete(string $path, callable $handler) {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function put(string $path, callable $handler) {
        $this->routes['PUT'][$path] = $handler;
    }

    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        
        if ($uri !== '/' && str_ends_with($uri, '/')) {
            $uri = rtrim($uri, '/');
        }

        $routes = $this->routes[$method] ?? [];

        foreach ($routes as $route => $handler) {
            // Transform /users/{id} into regex
            $pattern = preg_replace('#\{(\w+)\}#', '(?P<\1>[^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                $params = array_filter(
                    $matches,
                    fn($key) => is_string($key),
                    ARRAY_FILTER_USE_KEY
                );

                echo $handler($params);
                return;
            }
        }

        
        echo responseJson(404, [], 'Route not found');
    }
}
