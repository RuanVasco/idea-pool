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
			$status = new Status(null, $name);
			$statusRepository->create($status);

			echo json_encode(['message' => "Status criado com sucesso."]);
			return;
		}

		http_response_code(405);
		echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
		return;
	}

	public function delete($id): void {
		if (!($_SERVER['REQUEST_METHOD'] === 'DELETE')) {
			http_response_code(405);
			echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
			return;
		}

		if (empty($id)) {
			echo json_encode(['success' => false, 'message' => 'Informar id do status.']);
			return;
		}

		$statusRepository = new StatusRepository();
		$status = $statusRepository->findById($id);
		$statusRepository->delete($status);

		echo json_encode(['message' => "Status deletado com sucesso."]);
		return;
	}

	public function update(int $id): void {
		if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
			http_response_code(405);
			echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
			return;
		}

		parse_str(file_get_contents('php://input'), $putData);

		$name = trim($putData['name'] ?? '');
		if ($name === '') {
			echo json_encode(['success' => false, 'message' => 'Nome obrigatório.']);
			return;
		}

		$repo = new StatusRepository();
		$old  = $repo->findById($id);
		if (!$old) {
			http_response_code(404);
			echo json_encode(['success' => false, 'message' => 'Status não encontrado.']);
			return;
		}

		$repo->update($old, new Status($id, $name));

		echo json_encode(['success' => true, 'message' => 'Status atualizado com sucesso.']);
	}
}
