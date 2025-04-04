<?php

namespace Framework;

use function Framework\Utils\responseJson;

/**
 * Class App
 *
 * A simple HTTP routing system for handling GET, POST, PUT, and DELETE requests.
 *
 * @package Framework
 */
class App {
    /**
     * Stores all defined routes grouped by HTTP method.
     *
     * @var array
     */
    private array $routes = [];

    /**
     * Registers a GET route.
     *
     * @param string   $path    The route path (e.g. "/users/{id}").
     * @param callable $handler The callback to handle the route.
     */
    public function get(string $path, callable $handler) {
        $this->routes['GET'][$path] = $handler;
    }

    /**
     * Registers a POST route.
     *
     * @param string   $path    The route path.
     * @param callable $handler The callback to handle the route.
     */
    public function post(string $path, callable $handler) {
        $this->routes['POST'][$path] = $handler;
    }

    /**
     * Registers a DELETE route.
     *
     * @param string   $path    The route path.
     * @param callable $handler The callback to handle the route.
     */
    public function delete(string $path, callable $handler) {
        $this->routes['DELETE'][$path] = $handler;
    }

    /**
     * Registers a PUT route.
     *
     * @param string   $path    The route path.
     * @param callable $handler The callback to handle the route.
     */
    public function put(string $path, callable $handler) {
        $this->routes['PUT'][$path] = $handler;
    }

    /**
     * Executes the routing system, matches the current request URI and method
     * against the registered routes, and dispatches the corresponding handler.
     *
     * Route parameters can be defined using curly braces (e.g. /users/{id}).
     * Parameters will be passed as an associative array to the handler.
     *
     * Returns a 404 JSON response if no matching route is found.
     *
     * @return void
     */
    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Remove trailing slash if not root
        if ($uri !== '/' && str_ends_with($uri, '/')) {
            $uri = rtrim($uri, '/');
        }

        $routes = $this->routes[$method] ?? [];

        foreach ($routes as $route => $handler) {
            // Convert route with {param} to regex
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

        // No matching route found
        echo responseJson(404, [], 'Route not found');
    }
}
