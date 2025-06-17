<?php

class IdeasController {
	public function index() {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		if (!isset($_SESSION['user_id'])) {
			header('Location: /login');
			exit;
		}

		$ideas = (new IdeaRepository())->findAll();
		$categories = (new CategoryRepository())->findAll();
		$statuses = (new StatusRepository())->findAll();
		$viewFile = __DIR__ . '/../Views/idea.php';

		require __DIR__ . '/../Views/layout.php';
	}
}
