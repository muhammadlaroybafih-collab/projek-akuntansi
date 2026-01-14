<?php

namespace App\Models;

use CodeIgniter\Model;

class JournalDetailModel extends Model
{
    protected $table            = 'journal_details';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields    = [
        'header_id', 
        'account_id', 
        'debit', 
        'kredit'
    ];

    // Buat nampilin rincian di halaman Detail Jurnal
    public function getDetailWithAccount($headerId)
    {
        return $this->db->table($this->table)
            ->select('journal_details.*, accounts.nama_akun, accounts.kode_akun')
            ->join('accounts', 'accounts.id = journal_details.account_id')
            ->where('header_id', $headerId)
            ->get()
            ->getResultArray();
    }

    // Fungsi BARU buat narik mutasi di halaman Buku Besar
    public function getLedger($accountId)
    {
        return $this->select('journal_details.*, journal_headers.tanggal, journal_headers.no_bukti, journal_headers.keterangan')
                    ->join('journal_headers', 'journal_headers.id = journal_details.header_id')
                    ->where('account_id', $accountId)
                    ->orderBy('journal_headers.tanggal', 'ASC')
                    ->findAll();
    }
}