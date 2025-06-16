<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/app/Core/Router.php';

$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);
