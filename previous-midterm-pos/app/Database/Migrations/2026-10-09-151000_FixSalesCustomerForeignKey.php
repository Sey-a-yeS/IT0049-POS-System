<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixSalesCustomerForeignKey extends Migration
{
    public function up(): void
    {
        $this->forge->dropForeignKey('sales', 'sales_customer_id_foreign');
        $this->db->query(
            'ALTER TABLE `sales` ADD CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON UPDATE RESTRICT ON DELETE RESTRICT',
        );
    }

    public function down(): void
    {
        $this->forge->dropForeignKey('sales', 'sales_customer_id_foreign');
        $this->db->query(
            'ALTER TABLE `sales` ADD CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON UPDATE SET NULL ON DELETE RESTRICT',
        );
    }
}
