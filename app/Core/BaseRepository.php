<?php

namespace App\Core;

abstract class BaseRepository {
    protected $db;

    public function __construct() {
        $this->db = $this->connect();
    }

    private function connect() {
        $host = 'localhost';
        $dbname = 'seu_banco';
        $user = 'seu_usuario';
        $pass = 'sua_senha';

        try {
            $pdo = new \PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $e) {
            die('Erro ao conectar: ' . $e->getMessage());
        }
    }

    abstract protected function getTable(): string;

    public function findAll(): array {
        $stmt = $this->db->query('SELECT * FROM ' . $this->getTable());
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
