<?php

class IdeaRepository extends BaseRepository {
    protected function getTable(): string {
        return 'ideas';
    }

    protected function getSchema(): string {
        return <<<SQL
        CREATE TABLE IF NOT EXISTS ideas (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            description TEXT NOT NULL,
            category_id INTEGER NOT NULL,
            status_id INTEGER NOT NULL,
            owner_id INTEGER NOT NULL,
            created_at TEXT NOT NULL,

            FOREIGN KEY (category_id) REFERENCES categories(id),
            FOREIGN KEY (status_id) REFERENCES statuses(id),
            FOREIGN KEY (owner_id) REFERENCES users(id)
        );
        SQL;
    }
}
