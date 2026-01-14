<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                // Password kita hash biar aman bro!
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'fullname' => 'Administrator Utama',
                'role'     => 'Admin',
            ],
            [
                'username' => 'staff',
                'password' => password_hash('staff123', PASSWORD_DEFAULT),
                'fullname' => 'Staff Akuntansi',
                'role'     => 'Staff',
            ],
        ];

        // Masukkan data ke tabel users
        foreach ($data as $user) {
            $this->db->table('users')->insert($user);
        }
    }
}