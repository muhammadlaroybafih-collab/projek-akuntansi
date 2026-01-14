<?php

namespace App\Controllers;

use App\Models\AccountModel;
use CodeIgniter\Controller;

class Account extends BaseController
{
    protected $accountModel;

    public function __construct()
    {
        $this->accountModel = new AccountModel(); // Pastikan lo udah punya AccountModel bro
    }

    // Method index untuk menampilkan daftar akun
    public function index()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');

        $data = [
            'title'   => 'Daftar Akun (CoA)',
            'accounts' => $this->accountModel->orderBy('kode_akun', 'ASC')->findAll(),
            'user'    => session()->get('nama'),
            'role'    => session()->get('role')
        ];

        return view('accounts/index', $data); // Pastikan view ini ada
    }

    // Method create untuk form tambah akun
    public function create()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');

        $data = [
            'title' => 'Tambah Akun Baru',
            'user'  => session()->get('nama'),
            'role'  => session()->get('role')
        ];

        return view('accounts/create', $data); // Pastikan view ini ada
    }
}