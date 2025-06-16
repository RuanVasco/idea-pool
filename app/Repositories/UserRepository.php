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
        SQL;
    }
}
