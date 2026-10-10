<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'name',
        'price',
        'stock_quantity',
        'image',
        'is_archived',
        'created_at',
    ];

    public function findActive(int $id): ?array
    {
        return $this->where('id', $id)->where('is_archived', 0)->first();
    }

    public function findAllActive(): array
    {
        return $this->where('is_archived', 0)->orderBy('name', 'ASC')->findAll();
    }

    public function countActive(): int
    {
        return $this->builder()->where('is_archived', 0)->countAllResults();
    }

    public function countLowStock(int $threshold = 5): int
    {
        return $this->builder()
            ->where('is_archived', 0)
            ->where('stock_quantity <=', $threshold)
            ->countAllResults();
    }
}
