<?php

require_once 'app/Core/Router.php';
$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);