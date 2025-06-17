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

		$categories = (new CategoryRepository())->findAll();
		$viewFile = __DIR__ . '/../Views/category.php';
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

		if (!($_SERVER['REQUEST_METHOD'] === 'POST')) {
			http_response_code(405);
			echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
			return;
		}

		$name = $_POST['name'] ?? '';

		if (empty($name)) {
			echo json_encode(['success' => false, 'message' => 'Nome da categoria é obrigatório.']);
			return;
		}

		$categoryRepository = new CategoryRepository();
		$category = new Category(null, $name);
		$categoryRepository->create($category);

		echo json_encode(['message' => "Categoria criada com sucesso."]);
		return;
	}

	public function delete($id): void {
		if (!($_SERVER['REQUEST_METHOD'] === 'DELETE')) {
			http_response_code(405);
			echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
			return;
		}

		if (empty($id)) {
			echo json_encode(['success' => false, 'message' => 'Informar id da categoria.']);
			return;
		}

		$categoryRepository = new CategoryRepository();
		$category = $categoryRepository->findById($id);
		$categoryRepository->delete($category);

		echo json_encode(['message' => "Categoria deletada com sucesso."]);
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

		$repo = new CategoryRepository();
		$old  = $repo->findById($id);
		if (!$old) {
			http_response_code(404);
			echo json_encode(['success' => false, 'message' => 'Categoria não encontrada.']);
			return;
		}

		$repo->update($old, new Category($id, $name));

		echo json_encode(['success' => true, 'message' => 'Categoria atualizada com sucesso.']);
	}
}
