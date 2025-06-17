<?php

class CategoriesController {
	public function index() {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		if (!isset($_SESSION['user_id'])) {
			header('Location: /login');
			exit;
		}

		$viewFile = __DIR__ . '/../Views/category.php';
		require __DIR__ . '/../Views/layout.php';
	}
}
