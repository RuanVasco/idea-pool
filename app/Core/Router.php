<?php

class Router {
    public function dispatch(string $uri): void {
        $segments = array_values(array_filter(
            explode('/', trim($uri, '/'))
        ));

        $controllerName = ucfirst($segments[0] ?? 'home') . 'Controller';
        $method         = $segments[1] ?? 'index';
        $params         = array_slice($segments, 2);

        $file = __DIR__ . '/../Controllers/' . $controllerName . '.php';

        if (!file_exists($file)) {
            http_response_code(404);
            exit("Controller {$controllerName} não encontrado.");
        }

        require_once $file;

        if (!class_exists($controllerName)) {
            http_response_code(500);
            exit("Classe {$controllerName} não encontrada no arquivo.");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            http_response_code(404);
            exit("Método {$method} não encontrado.");
        }

        call_user_func_array([$controller, $method], $params);
    }
}
