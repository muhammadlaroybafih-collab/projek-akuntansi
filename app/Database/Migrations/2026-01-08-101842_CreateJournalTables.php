<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJournalTables extends Migration
{
    public function up()
    {
        // Header
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'no_bukti' => ['type' => 'VARCHAR', 'constraint' => '50'],
            'tanggal' => ['type' => 'DATE'],
            'keterangan' => ['type' => 'TEXT'],
            'total_debit' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'total_kredit' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('journal_headers');

        // Detail
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'header_id' => ['type' => 'INT', 'unsigned' => true],
            'account_id' => ['type' => 'INT', 'unsigned' => true],
            'debit' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
            'kredit' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('header_id', 'journal_headers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('account_id', 'accounts', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('journal_details');
    }

    public function down()
    {
        $this->forge->dropTable('journal_details');
        $this->forge->dropTable('journal_headers');
    }
}