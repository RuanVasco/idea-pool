<?php

class CategoryRepository extends BaseRepository {
    protected function getTable(): string {
        return 'categories';
    }

    protected function getSchema(): string {
        return <<<SQL
        CREATE TABLE IF NOT EXISTS categories (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL
        );
        SQL;
    }

    protected function mapRow(array $row): Category {
        return Category::fromArray($row);
    }
}
