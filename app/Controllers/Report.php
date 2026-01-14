<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Report extends BaseController
{
    /**
     * Tampilan Web Neraca [cite: 2025-11-01]
     */
    public function balanceSheet()
    {
        $start = $this->request->getGet('start_date') ?? date('Y-m-01');
        $end   = $this->request->getGet('end_date')   ?? date('Y-m-t');

        $data = $this->prepareData($start, $end);
        $data['title'] = 'Laporan Neraca';

        return view('reports/balance_sheet', $data);
    }

    /**
     * Ekspor ke PDF [cite: 2025-11-01]
     */
    public function exportPdf()
    {
        $start = $this->request->getGet('start_date') ?? date('Y-m-01');
        $end   = $this->request->getGet('end_date')   ?? date('Y-m-t');

        $data = $this->prepareData($start, $end);
        $data['title'] = 'Laporan Neraca';

        $dompdf = new Dompdf();
        $html = view('reports/balance_sheet_pdf', $data);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        return $dompdf->stream("Neraca_".$start."_to_".$end.".pdf", ["Attachment" => false]);
    }

    /**
     * Ekspor ke Excel [cite: 2025-11-01]
     */
    public function exportExcel()
    {
        $start = $this->request->getGet('start_date') ?? date('Y-m-01');
        $end   = $this->request->getGet('end_date')   ?? date('Y-m-t');

        $data = $this->prepareData($start, $end);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul
        $sheet->setCellValue('A1', 'LAPORAN NERACA');
        $sheet->setCellValue('A2', 'Periode: ' . $data['periodName']);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        // Header Tabel
        $row = 4;
        $sheet->setCellValue('A' . $row, 'KETERANGAN AKUN');
        $sheet->setCellValue('B' . $row, 'SALDO (IDR)');
        $sheet->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
        $row++;

        // Section Aset
        $sheet->setCellValue('A' . $row++, '--- AKTIVA (ASSETS) ---');
        foreach ($data['assets'] as $a) {
            $sheet->setCellValue('A' . $row, '[' . $a['kode_akun'] . '] ' . $a['nama_akun']);
            $sheet->setCellValue('B' . $row++, $a['saldo_akhir']);
        }
        $sheet->setCellValue('A' . $row, 'TOTAL AKTIVA');
        $sheet->setCellValue('B' . $row++, array_sum(array_column($data['assets'], 'saldo_akhir')));
        $row++;

        // Section Pasiva
        $sheet->setCellValue('A' . $row++, '--- PASIVA (LIABILITIES & EQUITY) ---');
        foreach ($data['liabilities'] as $l) {
            $sheet->setCellValue('A' . $row, '[' . $l['kode_akun'] . '] ' . $l['nama_akun']);
            $sheet->setCellValue('B' . $row++, $l['saldo_akhir']);
        }
        foreach ($data['equity'] as $e) {
            $sheet->setCellValue('A' . $row, '[' . $e['kode_akun'] . '] ' . $e['nama_akun']);
            $sheet->setCellValue('B' . $row++, $e['saldo_akhir']);
        }
        $sheet->setCellValue('A' . $row, 'Laba Periode Berjalan');
        $sheet->setCellValue('B' . $row++, $data['laba_berjalan']);

        $totalPasiva = array_sum(array_column($data['liabilities'], 'saldo_akhir')) + 
                       array_sum(array_column($data['equity'], 'saldo_akhir')) + 
                       $data['laba_berjalan'];

        $sheet->setCellValue('A' . $row, 'TOTAL PASIVA');
        $sheet->setCellValue('B' . $row, $totalPasiva);
        $sheet->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);

        // Auto size kolom
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getStyle('B4:B'.$row)->getNumberFormat()->setFormatCode('#,##0');

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Neraca_'.$start.'_to_'.$end.'.xlsx"');
        $writer->save('php://output');
        exit;
    }

    /**
     * Helper: Menyiapkan Data Gabungan [cite: 2025-11-01]
     */
    private function prepareData($start, $end)
    {
        $detailModel = new \App\Models\JournalDetailModel();

        // Hitung Laba Berjalan (Pendapatan - Beban)
        $rev = $detailModel->join('journal_headers', 'journal_headers.id = journal_details.header_id')
                    ->where('tanggal >=', $start)->where('tanggal <=', $end)
                    ->where('account_id IN (SELECT id FROM accounts WHERE kode_akun LIKE "4%")')
                    ->selectSum('kredit')->selectSum('debit')->first();
        
        $exp = $detailModel->join('journal_headers', 'journal_headers.id = journal_details.header_id')
                    ->where('tanggal >=', $start)->where('tanggal <=', $end)
                    ->where('account_id IN (SELECT id FROM accounts WHERE kode_akun LIKE "5%")')
                    ->selectSum('debit')->selectSum('kredit')->first();
        
        $laba = ($rev['kredit'] - $rev['debit']) - ($exp['debit'] - $exp['kredit']);

        return [
            'start_date'    => $start,
            'end_date'      => $end,
            'periodName'    => date('d/m/Y', strtotime($start)) . ' - ' . date('d/m/Y', strtotime($end)),
            'assets'        => $this->getSaldos('1%', $start, $end),
            'liabilities'   => $this->getSaldos('2%', $start, $end),
            'equity'        => $this->getSaldos('3%', $start, $end),
            'laba_berjalan' => $laba
        ];
    }

    private function getSaldos($kode, $start, $end)
    {
        $db = \Config\Database::connect();
        $res = $db->table('accounts')
            ->select('accounts.nama_akun, accounts.kode_akun, accounts.posisi_normal, SUM(debit) as d, SUM(kredit) as k')
            ->join('journal_details', 'journal_details.account_id = accounts.id', 'left')
            ->join('journal_headers', 'journal_headers.id = journal_details.header_id', 'left')
            ->where('kode_akun LIKE', $kode)
            ->where('tanggal >=', $start)->where('tanggal <=', $end)
            ->groupBy('accounts.id')->get()->getResultArray();

        foreach ($res as &$r) {
            $r['saldo_akhir'] = ($r['posisi_normal'] == 'Debit') ? ($r['d'] - $r['k']) : ($r['k'] - $r['d']);
        }
        return $res;
    }
}