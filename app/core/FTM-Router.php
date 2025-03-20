<?php

class FTM_Router
{
    private $routes = [];

    public function get($route, $action)
    {
        $this->routes['GET'][$route] = $action;
    }

    public function post($route, $action)
    {
        $this->routes['POST'][$route] = $action;
    }

    public function dispatch()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes[$requestMethod] ?? [] as $route => $action) {
            if ($route === $requestUri) {
                return $this->execute($action);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    private function execute($action)
    {
        [$controller, $method] = explode('@', $action);
        $controllerFile = __DIR__ . "/../controllers/$controller.php";

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $controllerInstance = new $controller();
            if (method_exists($controllerInstance, $method)) {
                return call_user_func([$controllerInstance, $method]);
            }
        }

        http_response_code(500);
        echo "Error: Controller or method not found.";
    }
}
