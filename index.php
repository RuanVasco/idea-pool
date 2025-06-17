<?php
session_start();

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/app/Controllers/',
        __DIR__ . '/app/Core/',
        __DIR__ . '/app/Entities/',
        __DIR__ . '/app/Repositories/',
        __DIR__ . '/app/Views/',
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);
