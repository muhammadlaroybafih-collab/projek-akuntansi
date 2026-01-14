<?php

namespace App\Controllers;

use App\Models\PeriodModel;
use App\Models\JournalHeaderModel;
use App\Models\JournalDetailModel;

class Period extends BaseController
{
    protected $periodModel;

    public function __construct()
    {
        $this->periodModel = new PeriodModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Periode Akuntansi',
            'periods' => $this->periodModel->orderBy('start_date', 'DESC')->findAll(),
        ];
        return view('period/index', $data);
    }

    public function store()
    {
        $this->periodModel->save([
            'period_name' => $this->request->getPost('period_name'),
            'start_date'  => $this->request->getPost('start_date'),
            'end_date'    => $this->request->getPost('end_date'),
            'is_closed'   => 0
        ]);
        return redirect()->to('/period')->with('success', 'Periode baru dibuka!');
    }

    public function toggle($id)
    {
        $period = $this->periodModel->find($id);
        if (!$period) return redirect()->back();

        $newStatus = ($period['is_closed'] == 1) ? 0 : 1;
        $noBuktiCLO = 'CLO-' . date('Ymd', strtotime($period['end_date']));
        
        $db = \Config\Database::connect();
        $db->transStart();

        $headerModel = new JournalHeaderModel();
        $detailModel = new JournalDetailModel();

        // KONDISI 1: TUTUP BUKU (GENERATE JURNAL PENUTUP LENGKAP) [cite: 2025-11-01]
        if ($newStatus == 1) {
            // 1. Ambil SEMUA akun Pendapatan (4) & Beban (5) yang ada saldonya di periode ini [cite: 2025-11-01]
            $accounts = $detailModel->join('journal_headers', 'journal_headers.id = journal_details.header_id')
                                    ->join('accounts', 'accounts.id = journal_details.account_id')
                                    ->where('tanggal >=', $period['start_date'])
                                    ->where('tanggal <=', $period['end_date'])
                                    ->where('(kode_akun LIKE "4%" OR kode_akun LIKE "5%")')
                                    ->select('account_id, kode_akun, SUM(debit) as total_debit, SUM(kredit) as total_kredit')
                                    ->groupBy('account_id')->findAll();

            if (!empty($accounts)) {
                // Insert Header Jurnal Penutup [cite: 2025-11-01]
                $headerId = $headerModel->insert([
                    'no_bukti'    => $noBuktiCLO,
                    'tipe_jurnal' => 'Penyesuaian',
                    'tanggal'     => $period['end_date'],
                    'keterangan'  => 'Jurnal Penutup Otomatis: ' . $period['period_name'],
                    'total_debit' => 0, // Akan diupdate setelah loop
                    'total_kredit'=> 0
                ]);

                $netProfit = 0;
                $runningTotalJurnal = 0;

                foreach ($accounts as $acc) {
                    if (strpos($acc['kode_akun'], '4') === 0) { 
                        // AKUN PENDAPATAN: Normal di Kredit, maka di-DEBIT biar jadi 0 [cite: 2025-11-01]
                        $saldo = $acc['total_kredit'] - $acc['total_debit'];
                        if ($saldo != 0) {
                            $detailModel->insert([
                                'header_id'  => $headerId,
                                'account_id' => $acc['account_id'],
                                'debit'      => $saldo,
                                'kredit'     => 0
                            ]);
                            $netProfit += $saldo;
                            $runningTotalJurnal += $saldo;
                        }
                    } else { 
                        // AKUN BEBAN: Normal di Debit, maka di-KREDIT biar jadi 0 [cite: 2025-11-01]
                        $saldo = $acc['total_debit'] - $acc['total_kredit'];
                        if ($saldo != 0) {
                            $detailModel->insert([
                                'header_id'  => $headerId,
                                'account_id' => $acc['account_id'],
                                'debit'      => 0,
                                'kredit'     => $saldo
                            ]);
                            $netProfit -= $saldo;
                            // Saldo beban dikredit, tapi untuk total nominal jurnal tetap dicatat nilai positifnya
                        }
                    }
                }

                // 2. Transfer Selisih (Laba/Rugi) ke Modal (Akun ID 37 / Kode 301)
                if ($netProfit != 0) {
                    $detailModel->insert([
                        'header_id'  => $headerId,
                        'account_id' => 37, 
                        'debit'      => ($netProfit < 0) ? abs($netProfit) : 0, // Rugi di Debit
                        'kredit'     => ($netProfit > 0) ? abs($netProfit) : 0, // Laba di Kredit
                    ]);
                }

                // 3. Update total di Header agar sesuai dengan total Debit/Kredit [cite: 2025-11-01]
                $totalFinal = $detailModel->where('header_id', $headerId)->selectSum('debit')->first();
                $headerModel->update($headerId, [
                    'total_debit'  => $totalFinal['debit'],
                    'total_kredit' => $totalFinal['debit']
                ]);
            }
        } 
        // KONDISI 2: BUKA BUKU (HAPUS REKAP LAMA) [cite: 2025-11-01]
        else {
            $headerModel->where('no_bukti', $noBuktiCLO)->delete();
        }

        $this->periodModel->update($id, ['is_closed' => $newStatus]);

        $db->transComplete();

        $msg = ($newStatus == 1) ? 'Buku Ditutup & Jurnal Rekap Dibuat!' : 'Periode Dibuka & Jurnal Rekap Dihapus!';
        return redirect()->to('/period')->with('success', $msg);
    }

    public function update($id)
    {
        $this->periodModel->update($id, [
            'period_name' => $this->request->getPost('period_name'),
            'start_date'  => $this->request->getPost('start_date'),
            'end_date'    => $this->request->getPost('end_date'),
        ]);
        return redirect()->to('/period')->with('success', 'Periode berhasil diperbarui!');
    }
}