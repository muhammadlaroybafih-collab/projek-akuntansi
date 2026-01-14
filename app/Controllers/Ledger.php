<?php

namespace App\Controllers;
use App\Models\AccountModel;
use App\Models\JournalDetailModel;

class Ledger extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');

        $accountModel = new AccountModel();
        $detailModel = new JournalDetailModel();
        
        // Ambil ID akun dari filter dropdown
        $accountId = $this->request->getGet('account_id');
        
        $data = [
            'title'    => 'Buku Besar',
            'accounts' => $accountModel->getAccounts(),
            'ledger'   => $accountId ? $detailModel->getLedger($accountId) : [], // Ambil mutasi jika akun dipilih
            'selectedAccount' => $accountId ? $accountModel->find($accountId) : null
        ];

        return view('ledger/index', $data);
    }
}