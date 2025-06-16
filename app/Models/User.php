<?php

class User extends Model {
    public function getAll() {
        return $this->db->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
    }
}