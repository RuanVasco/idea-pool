<?php

class UserRepository extends BaseRepository {
	protected function getTable(): string {
		return 'users';
	}

	protected function getSchema(): string {
		return <<<SQL
	CREATE TABLE IF NOT EXISTS users (
		id INTEGER PRIMARY KEY AUTOINCREMENT,
		name TEXT NOT NULL,
		email TEXT NOT NULL UNIQUE,
		password TEXT NOT NULL
	);

	INSERT OR IGNORE INTO users (name, email, password) VALUES
		('Admin', 'admin@admin', '123');
	SQL;
	}

	public function findByUsername(string $username): array {
		$query = "SELECT * FROM {$this->getTable()} WHERE email = :email";
		$stmt = $this->db->prepare($query);
		$stmt->bindParam(':email', $username);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}
