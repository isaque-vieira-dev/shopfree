<?php

namespace App\Core;

class Router {
    private array $routes = [];

    public function get(string $path, $handler): void {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, $handler): void {
        $this->routes['POST'][$path] = $handler;
    }

    public function resolve(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remover pasta pública se houver
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        $uri = '/' . trim($uri, '/');

        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            
            if (is_callable($handler)) {
                $handler();
                return;
            }

            if (is_array($handler)) {
                [$controllerClass, $methodName] = $handler;
                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    if (method_exists($controller, $methodName)) {
                        $controller->$methodName();
                        return;
                    }
                }
            }
        }

        // Página não encontrada (404)
        http_response_code(404);
        echo "404 - Página não encontrada";
    }
}
