<?php

class LoginController
{
	public function index()
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		if (isset($_SESSION['user_id'])) {
			header('Location: /');
			exit;
		}

		require __DIR__ . '/../Views/login.php';
	}

	public function login()
	{
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			http_response_code(405);
			exit('Método não permitido');
		}

		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		$email = $_POST['email'] ?? '';
		$password = $_POST['password'] ?? '';

		$userRepo = new UserRepository();
		$users = $userRepo->findAll();

		foreach ($users as $user) {
			if ($user['email'] === $email && $user['password'] === $password) {
				$_SESSION['user_id'] = $user['id'];
				header('Location: /');
				exit;
			}
		}

		echo 'Login inválido.';
	}

	public function logout()
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		session_destroy();
		header('Location: /login');
		exit;
	}
}
