<?php

namespace App\Controllers;

use App\Models\JournalHeaderModel;
use App\Models\JournalDetailModel;
use App\Models\AccountModel;
use App\Models\PeriodModel; // Tambahin ini bro [cite: 2025-11-01]

class Journal extends BaseController
{
    protected $headerModel, $detailModel, $accountModel, $periodModel;

    public function __construct() {
        $this->headerModel = new JournalHeaderModel();
        $this->detailModel = new JournalDetailModel();
        $this->accountModel = new AccountModel();
        $this->periodModel = new PeriodModel(); // Inisialisasi model periode [cite: 2025-11-01]
    }

    public function index() {
        if (!session()->get('logged_in')) return redirect()->to('/');
        
        $tipe = $this->request->getGet('tipe');
        $query = $this->headerModel->orderBy('tanggal', 'DESC');
        
        if ($tipe && $tipe !== 'Semua') {
            $query->where('tipe_jurnal', $tipe);
        }

        return view('journal/index', [
            'title'          => 'Daftar Jurnal',
            'journals'       => $query->findAll(),
            'current_filter' => $tipe ?? 'Semua'
        ]);
    }

    public function create() {
        if (!session()->get('logged_in')) return redirect()->to('/');
        return view('journal/create', [
            'title' => 'Input Transaksi Baru',
            'accounts' => $this->accountModel->getAccounts(),
            'no_bukti' => $this->headerModel->generateNoBukti('Umum')
        ]);
    }

    public function get_auto_number() {
        $tipe = $this->request->getGet('tipe');
        return $this->response->setJSON(['nomor' => $this->headerModel->generateNoBukti($tipe)]);
    }

    public function store() {
        $tanggalInput = $this->request->getPost('tanggal'); // Ambil tanggal dari form [cite: 2025-11-01]

        // --- VALIDASI PERIODE (SECURITY GATE) [cite: 2025-11-01] ---
        // Cek apakah tanggal jurnal masuk ke dalam periode yang statusnya CLOSED (1) [cite: 2025-11-01]
        $isClosed = $this->periodModel->where('start_date <=', $tanggalInput)
                                     ->where('end_date >=', $tanggalInput)
                                     ->where('is_closed', 1)
                                     ->first();

        if ($isClosed) {
            // Jika periode sudah tutup, lempar balik pake pesan error [cite: 2025-11-01]
            return redirect()->back()->with('error', 'Transaksi ditolak! Periode ' . $isClosed['period_name'] . ' sudah TUTUP BUKU.')->withInput();
        }
        // ----------------------------------------------------------

        $debits = $this->request->getPost('debit');
        $kredits = $this->request->getPost('kredit');

        if (array_sum($debits) != array_sum($kredits) || array_sum($debits) <= 0) {
            return redirect()->back()->with('error', 'Debit & Kredit harus balance dan > 0!')->withInput();
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $headerId = $this->headerModel->insert([
            'no_bukti' => $this->request->getPost('no_bukti'),
            'tipe_jurnal' => $this->request->getPost('tipe_jurnal'),
            'tanggal' => $tanggalInput,
            'keterangan' => $this->request->getPost('keterangan'),
            'total_debit' => array_sum($debits),
            'total_kredit' => array_sum($kredits)
        ]);

        $acc_ids = $this->request->getPost('account_id');
        foreach ($acc_ids as $key => $id) {
            if ($debits[$key] > 0 || $kredits[$key] > 0) {
                $this->detailModel->insert([
                    'header_id' => $headerId,
                    'account_id' => $id,
                    'debit' => $debits[$key],
                    'kredit' => $kredits[$key]
                ]);
            }
        }

        $db->transComplete();
        return redirect()->to('journal')->with('success', 'Berhasil disimpan!');
    }

    public function detail($id) {
        $header = $this->headerModel->find($id);
        if (!$header) return redirect()->to('journal');
        return view('journal/detail', [
            'title' => 'Detail ' . $header['no_bukti'],
            'header' => $header,
            'details' => $this->detailModel->getDetailWithAccount($id)
        ]);
    }
}