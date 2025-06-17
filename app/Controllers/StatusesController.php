<?php

class StatusesController {
	public function index() {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		if (!isset($_SESSION['user_id'])) {
			header('Location: /login');
			exit;
		}

		$statuses = (new StatusRepository())->findAll();

		$viewFile = __DIR__ . '/../Views/status.php';
		require __DIR__ . '/../Views/layout.php';
	}

	public function create(): void {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		if (!isset($_SESSION['user_id'])) {
			header('Location: /login');
			exit;
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$name = $_POST['name'] ?? '';

			if (empty($name)) {
				echo json_encode(['success' => false, 'message' => 'Nome do status é obrigatório.']);
				return;
			}

			$statusRepository = new StatusRepository();
			$statusRepository->create(['name' => $name]);

			echo json_encode(['success' => true]);
			return;
		}

		http_response_code(405);
		echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
		return;
	}
}
