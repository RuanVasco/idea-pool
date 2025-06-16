<?php

namespace App\Controllers;

require_once __DIR__ . '/../Repositories/UserRepository.php';

use App\Repositories\UserRepository;

class HomeController {
    public function index() {
        $users = (new UserRepository())->findAll();
        require '../app/Views/home.php';
    }
}
