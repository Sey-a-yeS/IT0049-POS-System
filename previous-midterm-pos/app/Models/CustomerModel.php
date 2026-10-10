<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table      = 'customers';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'full_name',
        'email',
        'phone',
        'is_archived',
        'created_at',
    ];

    public function findActive(int $id): ?array
    {
        return $this->where('id', $id)->where('is_archived', 0)->first();
    }

    public function findAllActive(): array
    {
        return $this->where('is_archived', 0)->orderBy('id', 'ASC')->findAll();
    }

    public function countActive(): int
    {
        return $this->builder()->where('is_archived', 0)->countAllResults();
    }
}
