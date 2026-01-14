<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePeriodsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'period_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '50', // Contoh: Januari 2026 [cite: 2025-11-01]
            ],
            'start_date' => [
                'type' => 'DATE',
            ],
            'end_date' => [
                'type' => 'DATE',
            ],
            'is_closed' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0, // 0 = Open, 1 = Closed [cite: 2025-11-01]
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('periods'); // [cite: 2025-11-01]
    }

    public function down()
    {
        $this->forge->dropTable('periods');
    }
}