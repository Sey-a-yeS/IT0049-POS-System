<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMidtermPosSchema extends Migration
{
    public function up(): void
    {
        if (! $this->db->fieldExists('is_archived', 'customers')) {
            $this->forge->addColumn('customers', [
                'is_archived' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'null'       => false,
                    'default'    => 0,
                    'after'      => 'phone',
                ],
            ]);
        }

        if (! $this->db->fieldExists('is_archived', 'users')) {
            $this->forge->addColumn('users', [
                'is_archived' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'null'       => false,
                    'default'    => 0,
                    'after'      => 'password',
                ],
            ]);
        }

        if (! $this->db->tableExists('products')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                ],
                'price' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '10,2',
                ],
                'stock_quantity' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'default'    => 0,
                ],
                'is_archived' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 0,
                ],
                'image' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->createTable('products');

            $this->db->table('products')->insertBatch([
                ['name' => 'Arabica Coffee Beans', 'price' => '425.00', 'stock_quantity' => 24, 'is_archived' => 0, 'image' => null, 'created_at' => '2026-10-01 09:00:00'],
                ['name' => 'Ceramic Pour-Over Set', 'price' => '780.00', 'stock_quantity' => 12, 'is_archived' => 0, 'image' => null, 'created_at' => '2026-10-01 09:15:00'],
                ['name' => 'Insulated Travel Tumbler', 'price' => '650.00', 'stock_quantity' => 18, 'is_archived' => 0, 'image' => null, 'created_at' => '2026-10-01 09:30:00'],
                ['name' => 'Cold Brew Bottle', 'price' => '520.00', 'stock_quantity' => 8, 'is_archived' => 0, 'image' => null, 'created_at' => '2026-10-01 09:45:00'],
                ['name' => 'Reusable Filter Pack', 'price' => '195.00', 'stock_quantity' => 30, 'is_archived' => 0, 'image' => null, 'created_at' => '2026-10-01 10:00:00'],
            ]);
        }

        if (! $this->db->tableExists('sales')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'product_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'customer_id' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'null'       => true,
                ],
                'sold_by' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'quantity' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                ],
                'total_price' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '10,2',
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addKey('product_id');
            $this->forge->addKey('customer_id');
            $this->forge->addKey('sold_by');
            $this->forge->addForeignKey('product_id', 'products', 'id', 'RESTRICT', 'RESTRICT');
            $this->forge->addForeignKey('customer_id', 'customers', 'id', 'RESTRICT', 'RESTRICT');
            $this->forge->addForeignKey('sold_by', 'users', 'id', 'RESTRICT', 'RESTRICT');
            $this->forge->createTable('sales');
        }
    }

    public function down(): void
    {
        $this->forge->dropTable('sales', true);
        $this->forge->dropTable('products', true);

        if ($this->db->fieldExists('is_archived', 'customers')) {
            $this->forge->dropColumn('customers', 'is_archived');
        }

        if ($this->db->fieldExists('is_archived', 'users')) {
            $this->forge->dropColumn('users', 'is_archived');
        }
    }
}
