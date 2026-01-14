<?php

namespace App\Core;

use Closure;

class Router
{
    /**
     * Stores all registered routes.
     * @var array<string, array<string, array|callable>>
     */
    private static array $routes = [];

    /**
     * Singleton instance.
     */
    private static ?Router $router = null;

    private function __construct() {}

    public static function getRouter(): Router
    {
        if (!self::$router) {
            self::$router = new Router();
        }

        return self::$router;
    }

    private function __clone() {}

    /**
     * Register a route with an HTTP method and action.
     */
    private function register(string $route, string $method, array|callable $action): void
    {
        $route = trim($route, '/');
        self::$routes[$method][$route] = $action;
    }

    public function get(string $route, array|callable $action): void
    {
        $this->register($route, 'GET', $action);
    }

    public function post(string $route, array|callable $action): void
    {
        $this->register($route, 'POST', $action);
    }

    public function put(string $route, array|callable $action): void
    {
        $this->register($route, 'PUT', $action);
    }

    public function delete(string $route, array|callable $action): void
    {
        $this->register($route, 'DELETE', $action);
    }

    /**
     * Dispatch the current request.
     */
    public function dispatch(): mixed
    {
        // Only match the path, not query string
        $requestedRoute = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/', '/');
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $routes = self::$routes[$method] ?? [];

        foreach ($routes as $route => $action) {
            // Convert route placeholders to regex
            // {id} -> ([a-zA-Z0-9_-]+)
            // {id:\d+} -> (\d+)
            $routeRegex = preg_replace_callback('/{\w+(:([^}]+))?}/', function ($matches) {
                return isset($matches[1]) ? '(' . $matches[2] . ')' : '([a-zA-Z0-9_-]+)';
            }, $route);

            $routeRegex = '@^' . $routeRegex . '$@';

            if (preg_match($routeRegex, $requestedRoute, $matchValues)) {
                array_shift($matchValues);

                // Extract param names from the route: {id} {slug}
                $paramNames = [];
                if (preg_match_all('/{(\w+)(:[^}]+)?}/', $route, $matchNames)) {
                    $paramNames = $matchNames[1];
                }

                $routeParams = [];
                if (!empty($paramNames)) {
                    $routeParams = array_combine($paramNames, $matchValues) ?: [];
                }

                return $this->resolveAction($action, $routeParams);
            }
        }

        return $this->abort('404 Page not found', 404);
    }

    /**
     * Execute matched route action.
     */
    private function resolveAction(array|callable $action, array $routeParams): mixed
    {
        // Closure or any callable function
        if ($action instanceof Closure || is_callable($action)) {
            return call_user_func_array($action, array_values($routeParams));
        }

        // Controller action: [ControllerClass::class, 'method']
        if (is_array($action) && count($action) === 2) {
            return call_user_func_array(
                [new $action[0], $action[1]],
                array_values($routeParams)
            );
        }

        return $this->abort('Invalid route action', 500);
    }

    private function abort(string $message, int $code = 404): void
    {
        http_response_code($code);
        echo $message;
        exit();
    }
}
