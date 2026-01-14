<?php

namespace App\Controllers;

use App\Models\JournalHeaderModel;
use App\Models\JournalDetailModel;

class Dashboard extends BaseController
{
  public function index()
{
    if (!session()->get('logged_in')) return redirect()->to('/');

    $headerModel = new \App\Models\JournalHeaderModel();
    $db = \Config\Database::connect();
    
    // Query Tren Bulanan [cite: 2025-11-01]
    $query = $db->query("SELECT MONTHNAME(tanggal) as bulan, SUM(total_debit) as total 
                         FROM journal_headers 
                         GROUP BY MONTH(tanggal) 
                         ORDER BY tanggal ASC LIMIT 6");

    $result = $query->getResultArray();

    $data = [
        'title'           => 'Dashboard Akuntansi',
        'user'            => session()->get('nama'),
        'role'            => session()->get('role'),
        'total_transaksi' => $headerModel->countAllResults(),
        'total_nominal'   => $headerModel->selectSum('total_debit')->first()['total_debit'] ?? 0,
        
        // Pastikan nama key ini SAMA dengan yang dipanggil di View [cite: 2025-11-01]
        'chart_labels'    => array_column($result, 'bulan'),
        'chart_data'      => array_column($result, 'total'),
    ];

    return view('dashboard/index', $data);
}
}