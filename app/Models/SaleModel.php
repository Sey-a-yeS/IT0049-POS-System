<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table      = 'sales';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'product_id',
        'customer_id',
        'sold_by',
        'quantity',
        'total_price',
        'created_at',
    ];

    public function countRecorded(): int
    {
        return $this->builder()->countAllResults();
    }

    public function findHistory(?int $limit = null): array
    {
        $builder = $this->select('sales.id, sales.product_id, sales.customer_id, sales.sold_by, sales.quantity, sales.total_price, sales.created_at, products.name AS product_name, customers.full_name AS customer_name, users.full_name AS staff_name')
            ->join('products', 'products.id = sales.product_id')
            ->join('customers', 'customers.id = sales.customer_id', 'left')
            ->join('users', 'users.id = sales.sold_by')
            ->orderBy('sales.created_at', 'DESC')
            ->orderBy('sales.id', 'DESC');

        return $limit === null ? $builder->findAll() : $builder->findAll($limit);
    }
}
