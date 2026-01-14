<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAccountsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'kode_akun' => ['type' => 'VARCHAR', 'constraint' => '20', 'unique' => true],
            'nama_akun' => ['type' => 'VARCHAR', 'constraint' => '100'],
            'header_akun' => ['type' => 'INT', 'constraint' => 1],
            'posisi_normal' => ['type' => 'ENUM', 'constraint' => ['Debit', 'Kredit']],
            'saldo_awal' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0.00],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('accounts');
    }

    public function down() { $this->forge->dropTable('accounts'); }
}