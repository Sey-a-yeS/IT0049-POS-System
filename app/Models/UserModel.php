<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'username',
        'full_name',
        'avatar',
        'password',
        'is_archived',
        'created_at',
    ];

    public function findActive(int $id): ?array
    {
        return $this->where('id', $id)->where('is_archived', 0)->first();
    }

    public function countActive(): int
    {
        return $this->builder()->where('is_archived', 0)->countAllResults();
    }
}
