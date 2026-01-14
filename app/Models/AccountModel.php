<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table            = 'accounts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    // Field yang sesuai dengan tabel accounts lo tadi
    protected $allowedFields    = [
        'kode_akun', 
        'nama_akun', 
        'header_akun', 
        'posisi_normal', 
        'saldo_awal'
    ];

    // Otomatis catat kapan akun dibuat
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = ''; // Kita nggak pake updated_at di sini

    // Fungsi buat ngambil daftar akun biar urut berdasarkan kode
    public function getAccounts()
    {
        return $this->orderBy('kode_akun', 'ASC')->findAll();
    }
}