<?php

abstract class BaseRepository {
    protected $db;

    public function __construct() {
        $this->db = $this->connect();
		$this->initializeSchema();
    }

	private function initializeSchema(): void {
        $this->db->exec($this->getSchema());
    }

    private function connect() {
		$path = __DIR__ . '/../../database.sqlite';

        try {
            $pdo = new \PDO("sqlite:$path");
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $e) {
            die('Erro ao conectar ao SQLite: ' . $e->getMessage());
        }
    }

    abstract protected function getTable(): string;
	abstract protected function getSchema(): string;

    public function findAll(): array {
        $stmt = $this->db->query('SELECT * FROM ' . $this->getTable());
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
