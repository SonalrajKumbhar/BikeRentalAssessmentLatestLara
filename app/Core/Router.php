<?php

namespace App\Core;

/**
 * Router Class
 * Handles HTTP routing
 */
class Router
{
    private array $routes = [];
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Register GET route
     */
    public function get(string $path, callable $handler): void
    {
        $this->register('GET', $path, $handler);
    }

    /**
     * Register POST route
     */
    public function post(string $path, callable $handler): void
    {
        $this->register('POST', $path, $handler);
    }

    /**
     * Register route for any method
     */
    public function any(string $path, callable $handler): void
    {
        $this->register('ANY', $path, $handler);
    }

    /**
     * Register a route
     */
    private function register(string $method, string $path, callable $handler): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
        ];
    }

    /**
     * Dispatch the request
     */
    public function dispatch(): mixed
    {
        $method = $this->request->getMethod();
        $path = $this->request->getPath();

        foreach ($this->routes as $route) {
            if (($route['method'] === $method || $route['method'] === 'ANY') && $route['path'] === $path) {
                return call_user_func($route['handler'], $this->request);
            }
        }

        // 404
        http_response_code(404);
        return null;
    }
}
