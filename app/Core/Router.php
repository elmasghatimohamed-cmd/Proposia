<?php

<<<<<<< HEAD
namespace Src\Core;
use RuntimeException;
use Closure;

class Router
{
    private static array $routes = [];
    private static $router;
    private function __construct()
    {
    }
=======
class Router
{
    /**
     * @var array $routes Stores all registered routes.
     */
    private static array $routes = [];

    /**
     * @var Router|null $router Singleton instance of the Router.
     */
    private static $router;

    /**
     * Private constructor to prevent direct instantiation.
     */
    private function __construct()
    {
    }

    /**
     * Get the singleton instance of the Router.
     * 
     * @return Router The singleton instance of the Router.
     */
>>>>>>> 74a6cbdd19201a3dfddf36b16d16138bc89bd22f
    public static function getRouter(): Router
    {
        if (!isset(self::$router)) {

            self::$router = new Router();
        }

        return self::$router;
    }
<<<<<<< HEAD
    private function register(string $route, string $method, array|callable $action)
    {
        $route = trim($route, '/');

        self::$routes[$method][$route] = $action;
    }
=======

    /**
     * prevent cloning of the singleton instance.
     */

    private function __clone()
    {
    }

    /**
     * Register a route with a specified HTTP method and action.
     * 
     * @param string $route The route path.
     * @param string $method The HTTP method (GET, POST, PUT, DELETE).
     * @param array|callable $action The action to execute for the route.
     */
    private function register(string $route, string $method, array|callable $action)
    {
        // Trim slashes
        $route = trim($route, '/');

        // Assign action to the passed route
        self::$routes[$method][$route] = $action;
    }

>>>>>>> 74a6cbdd19201a3dfddf36b16d16138bc89bd22f
    public function get(string $route, array|callable $action)
    {
        $this->register($route, 'GET', $action);
    }
    public function post(string $route, array|callable $action)
    {
        $this->register($route, 'POST', $action);
    }
    public function put(string $route, array|callable $action)
    {
        $this->register($route, 'PUT', $action);
    }
    public function delete(string $route, array|callable $action)
    {
        $this->register($route, 'DELETE', $action);
    }
<<<<<<< HEAD
    public function dispatch()
    {
        $requestedRoute = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        $method = $_SERVER['REQUEST_METHOD'];
        $routes = self::$routes[$method] ?? [];

        foreach ($routes as $route => $action) {
            $routeRegex = preg_replace_callback('/{\w+(:([^}]+))?}/', function ($matches) {
                return isset($matches[1]) ? '(' . $matches[2] . ')' : '([a-zA-Z0-9_-]+)';
            }, $route);

            $routeRegex = '@^' . $routeRegex . '$@';

            if (preg_match($routeRegex, $requestedRoute, $matches)) {
                array_shift($matches);
                $routeParamsValues = $matches;

                $routeParamsNames = [];
                if (preg_match_all('/{(\w+)(:[^}]+)?}/', $route, $matches)) {
                    $routeParamsNames = $matches[1];
                }

                $routeParams = array_combine($routeParamsNames, $routeParamsValues);

                return $this->resolveAction($action, $routeParams);
=======

    /**
     * Resolve the current request to the corresponding route action.
     * 
     */
    public function dispatch()
    {
        // Get the requested route.
        $requestedRoute = trim($_SERVER['REQUEST_URI'], '/') ?? '/';

        $routes = self::$routes[$_SERVER['REQUEST_METHOD']];

        foreach ($routes as $route => $action)
        {
            // Transform route to regex pattern.
            $routeRegex = preg_replace_callback('/{\w+(:([^}]+))?}/', function ($matches)
            {
                return isset($matches[1]) ? '(' . $matches[2] . ')' : '([a-zA-Z0-9_-]+)';
            }, $route);

            // Add the start and end delimiters.
            $routeRegex = '@^' . $routeRegex . '$@';

            // Check if the requested route matches the current route pattern.
            if (preg_match($routeRegex, $requestedRoute, $matches))
            {
                // Get all user requested path params values after removing the first matches.
                array_shift($matches);
                $routeParamsValues = $matches;

                // Find all route params names from route and save in $routeParamsNames
                $routeParamsNames = [];
                if (preg_match_all('/{(\w+)(:[^}]+)?}/', $route, $matches))
                {
                    $routeParamsNames = $matches[1];
                }

                // Combine between route parameter names and user provided parameter values.
                $routeParams = array_combine($routeParamsNames, $routeParamsValues);

                return  $this->resolveAction($action, $routeParams);
>>>>>>> 74a6cbdd19201a3dfddf36b16d16138bc89bd22f
            }
        }
        return $this->abort('404 Page not found');
    }
<<<<<<< HEAD
    private function resolveAction($action, array $routeParams): mixed
    {
        if ($action instanceof Closure) {
            return $action(...array_values($routeParams));
        }

        if (is_array($action) && count($action) === 2) {
            return call_user_func_array(
                [new $action[0], $action[1]],
                array_values($routeParams)
            );
        }

        throw new RuntimeException('Invalid route action');
    }
=======

    /**
     * Execute the action for a matched route.
     * 
     * @param array|callable $action The action to execute.
     * @param array $routeParams The parameters extracted from the route.
     * 
     * @return mixed The result of the action executed.
     */
    private function resolveAction($action, $routeParams)
    {
        if (is_callable($action))
        {
            return call_user_func_array($action, $routeParams);
        }
        else if (is_array($action))
        {
            return call_user_func_array([new $action[0], $action[1]], $routeParams);
        }
    }

    /**
     * Abort the request with an appropriate message.
     * 
     * @param string $message The message to display.
     * @param int $code HTTP response code.
     * 
     */
>>>>>>> 74a6cbdd19201a3dfddf36b16d16138bc89bd22f
    private function abort(string $message, int $code = 404)
    {

        http_response_code($code);
        echo $message;
        exit();
    }
<<<<<<< HEAD

}
=======
}

?>
>>>>>>> 74a6cbdd19201a3dfddf36b16d16138bc89bd22f
