<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    // Field yang boleh diisi (Mass Assignment)
    protected $allowedFields    = [
        'username', 
        'password', 
        'fullname', 
        'role'
    ];

    // Aktifkan fitur otomatis catat waktu
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Opsional: Fungsi buat nyari user berdasarkan username (buat login)
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}