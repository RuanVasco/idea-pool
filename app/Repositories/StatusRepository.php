<?php

class StatusRepository extends BaseRepository {
    protected function getTable(): string {
        return 'statuses';
    }

    protected function getSchema(): string {
        return <<<SQL
        CREATE TABLE IF NOT EXISTS statuses (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL
        );
        SQL;
    }

    protected function mapRow(array $row): Status {
        return Status::fromArray($row);
    }
}
