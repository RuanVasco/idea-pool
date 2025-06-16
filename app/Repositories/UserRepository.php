<?php

namespace App\Repositories;

require_once __DIR__ . '/../Core/BaseRepository.php';

use App\Core\BaseRepository;

class UserRepository extends BaseRepository {
    protected function getTable(): string {
        return 'users';
    }
}
