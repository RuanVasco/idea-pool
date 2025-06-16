<?php

class HomeController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $users = (new UserRepository())->findAll();
        require __DIR__ . '/../Views/home.php';
    }
}
