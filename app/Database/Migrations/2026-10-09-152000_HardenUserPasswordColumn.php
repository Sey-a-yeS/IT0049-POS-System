<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HardenUserPasswordColumn extends Migration
{
    private const LOCKED_PASSWORD = '!password-not-initialized!';

    public function up(): void
    {
        $this->db->table('users')
            ->groupStart()
                ->where('password', null)
                ->orWhere('password', '')
            ->groupEnd()
            ->update(['password' => self::LOCKED_PASSWORD]);

        $this->forge->modifyColumn('users', [
            'password' => [
                'name'       => 'password',
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->modifyColumn('users', [
            'password' => [
                'name'       => 'password',
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);
    }
}
