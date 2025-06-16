<?php

class Router {
    public function dispatch($uri) {
        $uri = trim($uri, '/');
        $segments = explode('/', $uri);
        $controller = ucfirst($segments[0] ?? 'home') . 'Controller';
        $method = $segments[1] ?? 'index';

        require_once "../app/Controllers/{$controller}.php";
        $obj = new $controller();
        call_user_func_array([$obj, $method], array_slice($segments, 2));
    }
}
