<?php

namespace App\Controllers;

use App\Models\AccountModel;
use App\Models\JournalDetailModel;
use App\Models\PeriodModel;
// Library untuk Export [cite: 2025-11-01]
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ProfitLoss extends BaseController
{
    protected $accountModel, $detailModel, $periodModel;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
        $this->detailModel = new JournalDetailModel();
        $this->periodModel = new PeriodModel();
    }

    /**
     * Fungsi central untuk hitung data Laba Rugi berdasarkan filter tanggal [cite: 2025-11-01]
     */
    private function getReportData($start = null, $end = null)
    {
        // 1. Logika Filter Tanggal [cite: 2025-11-01]
        // Jika tidak ada input, ambil dari periode aktif. Jika periode aktif gak ada, ambil bulan ini.
        if (!$start || !$end) {
            $activePeriod = $this->periodModel->where('is_closed', 0)->orderBy('start_date', 'ASC')->first();
            $startDate = $activePeriod ? $activePeriod['start_date'] : date('Y-m-01');
            $endDate   = $activePeriod ? $activePeriod['end_date'] : date('Y-m-t');
        } else {
            $startDate = $start;
            $endDate   = $end;
        }

        // 2. Hitung Pendapatan (Akun Kepala 4) [cite: 2025-11-01]
        $revenueAccounts = $this->accountModel->where('kode_akun LIKE', '4%')->findAll();
        $totalRevenue = 0;
        foreach ($revenueAccounts as &$acc) {
            $sums = $this->detailModel->join('journal_headers', 'journal_headers.id = journal_details.header_id')
                                ->where('account_id', $acc['id'])
                                ->where('tanggal >=', $startDate)
                                ->where('tanggal <=', $endDate)
                                ->selectSum('debit')->selectSum('kredit')->first();
                                
            $acc['saldo'] = ($sums['kredit'] ?? 0) - ($sums['debit'] ?? 0);
            $totalRevenue += $acc['saldo'];
        }

        // 3. Hitung Beban (Akun Kepala 5) [cite: 2025-11-01]
        $expenseAccounts = $this->accountModel->where('kode_akun LIKE', '5%')->findAll();
        $totalExpense = 0;
        foreach ($expenseAccounts as &$acc) {
            $sums = $this->detailModel->join('journal_headers', 'journal_headers.id = journal_details.header_id')
                                ->where('account_id', $acc['id'])
                                ->where('tanggal >=', $startDate)
                                ->where('tanggal <=', $endDate)
                                ->selectSum('debit')->selectSum('kredit')->first();
                                
            $acc['saldo'] = ($sums['debit'] ?? 0) - ($sums['kredit'] ?? 0);
            $totalExpense += $acc['saldo'];
        }

        return [
            'start_date'   => $startDate,
            'end_date'     => $endDate,
            'periodName'   => date('d/m/Y', strtotime($startDate)) . ' - ' . date('d/m/Y', strtotime($endDate)),
            'revenues'     => $revenueAccounts,
            'expenses'     => $expenseAccounts,
            'totalRevenue' => $totalRevenue,
            'totalExpense' => $totalExpense,
            'netProfit'    => $totalRevenue - $totalExpense
        ];
    }

    public function index()
    {
        if (!session()->get('logged_in')) return redirect()->to('/');

        // Ambil filter dari GET request [cite: 2025-11-01]
        $start = $this->request->getGet('start_date');
        $end   = $this->request->getGet('end_date');

        $data = $this->getReportData($start, $end);
        $data['title'] = 'Laporan Laba Rugi';
        
        return view('reports/profit_loss', $data);
    }

   public function exportPdf()
{
    // 1. Tangkap tanggal dari URL yang dikirim tombol [cite: 2025-11-01]
    $start = $this->request->getGet('start_date') ?? date('Y-m-01');
    $end   = $this->request->getGet('end_date')   ?? date('Y-m-t');

    // 2. Gunakan fungsi getReportData yang sudah mendukung filter [cite: 2025-11-01]
    $data = $this->getReportData($start, $end);
    $data['title'] = 'Laporan Laba Rugi';

    $dompdf = new \Dompdf\Dompdf();
    $html = view('reports/profit_loss_pdf', $data);
    
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    
    return $dompdf->stream("Laba_Rugi_".$start."_to_".$end.".pdf", ["Attachment" => false]);
}

    public function exportExcel()
    {
        $start = $this->request->getGet('start_date');
        $end   = $this->request->getGet('end_date');

        $data = $this->getReportData($start, $end);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header Style [cite: 2025-11-01]
        $sheet->setCellValue('A1', 'LAPORAN LABA RUGI');
        $sheet->setCellValue('A2', 'Periode: ' . $data['periodName']);
        $sheet->mergeCells('A1:B1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        
        $sheet->setCellValue('A4', 'KETERANGAN');
        $sheet->setCellValue('B4', 'TOTAL (IDR)');
        $sheet->getStyle('A4:B4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF333333');
        $sheet->getStyle('A4:B4')->getFont()->getColor()->setARGB('FFFFFFFF');

        $row = 5;
        // Bagian Pendapatan [cite: 2025-11-01]
        $sheet->setCellValue('A' . $row, 'PENDAPATAN');
        $sheet->getStyle('A'.$row)->getFont()->setBold(true);
        $row++;
        
        foreach ($data['revenues'] as $rev) {
            if ($rev['saldo'] != 0) {
                $sheet->setCellValue('A' . $row, $rev['nama_akun']);
                $sheet->setCellValue('B' . $row++, $rev['saldo']);
            }
        }
        $sheet->setCellValue('A' . $row, 'TOTAL PENDAPATAN');
        $sheet->setCellValue('B' . $row, $data['totalRevenue']);
        $sheet->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
        $row += 2;

        // Bagian Beban [cite: 2025-11-01]
        $sheet->setCellValue('A' . $row, 'BEBAN USAHA');
        $sheet->getStyle('A'.$row)->getFont()->setBold(true);
        $row++;

        foreach ($data['expenses'] as $exp) {
            if ($exp['saldo'] != 0) {
                $sheet->setCellValue('A' . $row, $exp['nama_akun']);
                $sheet->setCellValue('B' . $row++, $exp['saldo']);
            }
        }
        $sheet->setCellValue('A' . $row, 'TOTAL BEBAN');
        $sheet->setCellValue('B' . $row, $data['totalExpense']);
        $sheet->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);
        $row += 2;

        // Final Laba/Rugi [cite: 2025-11-01]
        $sheet->setCellValue('A' . $row, 'LABA/RUGI BERSIH');
        $sheet->setCellValue('B' . $row, $data['netProfit']);
        $sheet->getStyle('A' . $row . ':B' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row . ':B' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFEEEEEE');

        // Format [cite: 2025-11-01]
        $sheet->getStyle('B5:B' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Laba_Rugi_'.str_replace([' ', '/'], '_', $data['periodName']).'.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        $writer->save('php://output');
        exit;
    }
}