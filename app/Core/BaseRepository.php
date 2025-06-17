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

	public function delete(BaseEntity $entity): void {
		$data = $entity->toArray();
		$id = $data['id'];

		if ($id === null) {
			throw new RuntimeException('Entidade sem ID — não é possível excluir.');
		}

		$sql  = "DELETE FROM {$this->getTable()} WHERE id = :id";
		$stmt = $this->db->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	public function update(BaseEntity $oldEntity, BaseEntity $newEntity): void {
		$data = $oldEntity->toArray();
		$id = $data['id'];

		if ($id === null) {
			throw new RuntimeException('Entidade antiga sem ID — não é possível atualizar.');
		}

		$data = $newEntity->toArray();
		unset($data['id']);

		$set = implode(', ', array_map(
			fn($col) => "$col = :$col",
			array_keys($data)
		));

		$sql  = "UPDATE {$this->getTable()} SET $set WHERE id = :id";
		$stmt = $this->db->prepare($sql);

		foreach ($data as $col => $val) {
			$stmt->bindValue(":$col", $val);
		}
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);

		$stmt->execute();
	}
}
