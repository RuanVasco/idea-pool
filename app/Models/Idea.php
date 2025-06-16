<?php

class Idea extends Model {
    public function getAll() {
        return $this->db->query("SELECT * FROM ideas")->fetchAll(PDO::FETCH_ASSOC);
    }
}
