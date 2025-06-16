<?php

class HomeController {
    public function index() {
        $users = (new User())->getAll();
        require '../app/Views/home.php';
    }
}
