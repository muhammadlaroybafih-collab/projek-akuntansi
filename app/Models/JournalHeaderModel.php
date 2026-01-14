<?php

namespace App\Models;

use CodeIgniter\Model;

class JournalHeaderModel extends Model
{
    protected $table            = 'journal_headers';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['no_bukti', 'tipe_jurnal', 'tanggal', 'keterangan', 'total_debit', 'total_kredit'];

    public function generateNoBukti($tipe)
    {
        $kode = [
            'Umum'        => 'JU',
            'Penjualan'   => 'JP',
            'Pembelian'   => 'JB',
            'Masuk'       => 'BKM',
            'Keluar'      => 'BKK',
            'Penyesuaian' => 'AJP'
        ];
        
        $prefix = ($kode[$tipe] ?? 'JU') . '-' . date('Ym');

        $last = $this->like('no_bukti', $prefix, 'after')
                     ->orderBy('no_bukti', 'DESC')
                     ->first();

        if ($last) {
            $lastNo = substr($last['no_bukti'], -3); 
            $nextNo = str_pad((int)$lastNo + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNo = '001';
        }

        return $prefix . $nextNo;
    }
}