<?php

declare(strict_types=1);

namespace Framework;

class Router  //Maintains an array of registered routes ($routes). Provides an add() method to register routes with a specific HTTP method (e.g., GET) and path.
{
    private array $routes = []; // Stores registered routes
    private array $middleware = [];

    public function add(string $method, string $path, array $controller)
    {
        $path = $this->normalizePath($path);
        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method), // Ensure method is uppercase
            'controller' => $controller
        ];
    }
    private function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        $path = "/{$path}/";
        $path = preg_replace('#[/]{2,}#', '/', $path);

        return $path;
    }
    //Separation of Concerns(Real World)

    public function dispatch(string $path, string $method, Container $container = null)
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['path']}$#", $path)
                || $route['method'] !== $method
            ) {
                continue;
            }

            [$class, $function] = $route['controller'];

            $controllerInstance = $container ? $container->resolve($class) : new $class;

            $action = fn() => $controllerInstance->{$function}();

            foreach ($this->middleware as $middleware) {
                $middleware =  $container ?
                    $container->resolve($middleware) :
                    new $middleware;
                $action = fn() => $middleware->process($action);
            }

            $action();

            return;
        }
    }
    public function addMiddleware(string $middleware)
    {
        $this->middleware[] = $middleware;
    }
}
