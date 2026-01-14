<?php

namespace App\Controllers;
use App\Models\AccountModel;
use App\Models\JournalDetailModel;

class TrialBalance extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');

        $accountModel = new AccountModel();
        $detailModel = new JournalDetailModel();
        
        $accounts = $accountModel->orderBy('kode_akun', 'ASC')->findAll();
        $results = [];

        foreach ($accounts as $acc) {
            // Ambil total debit dan kredit per akun
            $sums = $detailModel->where('account_id', $acc['id'])
                                ->selectSum('debit')
                                ->selectSum('kredit')
                                ->first();
            
            $debit = $sums['debit'] ?? 0;
            $kredit = $sums['kredit'] ?? 0;
            
            // Hitung saldo akhir berdasarkan posisi normal [cite: 2025-11-01]
            $final_debit = 0;
            $final_kredit = 0;

            if ($acc['posisi_normal'] == 'Debit') {
                $final_debit = $debit - $kredit;
            } else {
                $final_kredit = $kredit - $debit;
            }

            // Simpan jika ada saldo atau transaksi
            if ($final_debit != 0 || $final_kredit != 0) {
                $results[] = [
                    'kode' => $acc['kode_akun'],
                    'nama' => $acc['nama_akun'],
                    'debit' => $final_debit,
                    'kredit' => $final_kredit
                ];
            }
        }

        return view('reports/trial_balance', [
            'title' => 'Neraca Saldo',
            'data'  => $results
        ]);
    }
}