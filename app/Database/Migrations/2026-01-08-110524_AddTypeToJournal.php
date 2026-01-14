<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTypeToJournal extends Migration
{
    public function up()
    {
        $fields = [
            'tipe_jurnal' => [
                'type'       => 'ENUM',
                'constraint' => ['Umum', 'Penjualan', 'Pembelian', 'Masuk', 'Keluar', 'Penyesuaian'],
                'default'    => 'Umum',
                'after'      => 'no_bukti'
            ],
        ];
        $this->forge->addColumn('journal_headers', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('journal_headers', 'tipe_jurnal');
    }
}