<?php

namespace App\Controllers;

use App\Models\JournalHeaderModel;
use App\Models\JournalDetailModel;
use App\Models\AccountModel;

class Adjustment extends BaseController
{
    public function index()
    {
        $headerModel = new JournalHeaderModel();
        $data = [
            'title' => 'Jurnal Penyesuaian',
            // Filter cuma tipe Penyesuaian
            'adjustments' => $headerModel->where('tipe_jurnal', 'Penyesuaian')->findAll()
        ];
        return view('adjustment/index', $data);
    }

    public function create()
    {
        $accountModel = new AccountModel();
        $data = [
            'title' => 'Input Penyesuaian Baru',
            'accounts' => $accountModel->orderBy('kode_akun', 'ASC')->findAll()
        ];
        return view('adjustment/create', $data);
    }

    public function store()
{
    $headerModel = new \App\Models\JournalHeaderModel();
    $detailModel = new \App\Models\JournalDetailModel();

    $dataHeader = [
        'no_bukti'     => $this->request->getPost('no_bukti'),
        'tanggal'      => $this->request->getPost('tanggal'),
        'keterangan'   => $this->request->getPost('keterangan'),
        'total_debit'  => $this->request->getPost('total_nominal'),
        'total_kredit' => $this->request->getPost('total_nominal'),
        'tipe_jurnal'  => 'Penyesuaian', // WAJIB DIKUNCI DI SINI
    ];

    $headerId = $headerModel->insert($dataHeader);

    // Ambil data detail akun dari form dynamic lo
    $accounts = $this->request->getPost('account_id');
    $debits   = $this->request->getPost('debit');
    $kredits  = $this->request->getPost('kredit');

    foreach ($accounts as $i => $accId) {
        $detailModel->insert([
            'header_id'  => $headerId,
            'account_id' => $accId,
            'debit'      => $debits[$i],
            'kredit'     => $kredits[$i],
        ]);
    }

    return redirect()->to('/adjustment')->with('success', 'Penyesuaian berhasil disimpan!');
 }

 public function detail($id)
    {
        $headerModel = new JournalHeaderModel();
        $detailModel = new JournalDetailModel();

        // 1. Cari Header Jurnal Penyesuaiannya [cite: 2025-11-01]
        $header = $headerModel->find($id);

        if (!$header) {
            return redirect()->to('/adjustment')->with('error', 'Jurnal tidak ditemukan!');
        }

        // 2. Ambil detail akun yang terlibat (Join ke tabel accounts) [cite: 2025-11-01]
        $details = $detailModel->select('journal_details.*, accounts.nama_akun, accounts.kode_akun')
                               ->join('accounts', 'accounts.id = journal_details.account_id')
                               ->where('header_id', $id)
                               ->findAll();

        $data = [
            'title'   => 'Detail Jurnal Penyesuaian',
            'header'  => $header,
            'details' => $details
        ];

        // 3. Lempar ke view detail jurnal (pake view yang udah ada di folder journal) [cite: 2025-11-01]
        return view('journal/detail', $data);
    }
}