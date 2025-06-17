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
	abstract protected function mapRow(array $row): BaseEntity;

	public function findAll(): array {
		$rows = $this->db->query('SELECT * FROM ' . $this->getTable())
			->fetchAll(PDO::FETCH_ASSOC);

		return array_map([$this, 'mapRow'], $rows);
	}

	public function findById(int $id): ?BaseEntity {
		$stmt = $this->db->prepare('SELECT * FROM ' . $this->getTable() . ' WHERE id = :id');
		$stmt->execute(['id' => $id]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row ? $this->mapRow($row) : null;
	}

	public function create(BaseEntity $entity): void {
		$data = $entity->toArray();
		unset($data['id']);

		$cols = implode(', ', array_keys($data));
		$marks = ':' . implode(', :', array_keys($data));
		$stmt = $this->db->prepare("INSERT INTO {$this->getTable()} ($cols) VALUES ($marks)");
		$stmt->execute($data);
	}
}
