<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // 10 AKTIVA LANCAR [cite: 2025-11-01]
            ['kode_akun' => '101', 'nama_akun' => 'Kas', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '102', 'nama_akun' => 'Persediaan barang dagang', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '103', 'nama_akun' => 'Piutang usaha', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '104', 'nama_akun' => 'Penyisihan piutang usaha', 'header_akun' => '1', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],
            ['kode_akun' => '105', 'nama_akun' => 'Wesel tagih', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '106', 'nama_akun' => 'Perlengkapan', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '107', 'nama_akun' => 'Iklan dibayar dimuka', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '108', 'nama_akun' => 'Sewa dibayar dimuka', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '109', 'nama_akun' => 'Asuransi dibayar dimuka', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],

            // 11 INVESTASI JANGKA PANJANG [cite: 2025-11-01]
            ['kode_akun' => '111', 'nama_akun' => 'Investasi saham', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '112', 'nama_akun' => 'Investasi obligasi', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],

            // 12 AKTIVA TETAP [cite: 2025-11-01]
            ['kode_akun' => '121', 'nama_akun' => 'Peralatan', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '122', 'nama_akun' => 'Akumulasi penyusutan peralatan', 'header_akun' => '1', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],
            ['kode_akun' => '123', 'nama_akun' => 'Kendaraan', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '124', 'nama_akun' => 'Akumulasi penyusutan kendaraan', 'header_akun' => '1', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],
            ['kode_akun' => '125', 'nama_akun' => 'Gedung', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '126', 'nama_akun' => 'Akumulasi penyusutan gedung', 'header_akun' => '1', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],
            ['kode_akun' => '127', 'nama_akun' => 'Tanah', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],

            // 13 AKTIVA TETAP TIDAK BERWUJUD [cite: 2025-11-01]
            ['kode_akun' => '131', 'nama_akun' => 'Hak paten', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '132', 'nama_akun' => 'Hak cipta', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '133', 'nama_akun' => 'Merk dagang', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '134', 'nama_akun' => 'Goodwill', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '135', 'nama_akun' => 'Franchise', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],

            // 14 AKTIVA LAIN-LAIN [cite: 2025-11-01]
            ['kode_akun' => '141', 'nama_akun' => 'Mesin yang tidak digunakan', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '142', 'nama_akun' => 'Beban yang ditangguhkan', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '143', 'nama_akun' => 'Piutang kepada pemegang saham', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '144', 'nama_akun' => 'Beban emisi saham', 'header_akun' => '1', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],

            // 20 KEWAJIBAN [cite: 2025-11-01]
            ['kode_akun' => '201', 'nama_akun' => 'Utang usaha', 'header_akun' => '2', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],
            ['kode_akun' => '202', 'nama_akun' => 'Utang wesel', 'header_akun' => '2', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],
            ['kode_akun' => '203', 'nama_akun' => 'Beban yang masih harus dibayar', 'header_akun' => '2', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],
            ['kode_akun' => '204', 'nama_akun' => 'Utang gaji', 'header_akun' => '2', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],
            ['kode_akun' => '205', 'nama_akun' => 'Utang sewa gedung', 'header_akun' => '2', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],
            ['kode_akun' => '206', 'nama_akun' => 'Utang pajak penghasilan', 'header_akun' => '2', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],

            // 21 KEWAJIBAN JANGKA PANJANG [cite: 2025-11-01]
            ['kode_akun' => '211', 'nama_akun' => 'Utang hipotek', 'header_akun' => '2', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],
            ['kode_akun' => '212', 'nama_akun' => 'Utang obligasi', 'header_akun' => '2', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],
            ['kode_akun' => '213', 'nama_akun' => 'Utang gadai', 'header_akun' => '2', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],

            // 30 EKUITAS [cite: 2025-11-01]
            ['kode_akun' => '301', 'nama_akun' => 'Modal/ekuitas pemilik', 'header_akun' => '3', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],
            ['kode_akun' => '302', 'nama_akun' => 'Prive', 'header_akun' => '3', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],

            // 40 PENDAPATAN [cite: 2025-11-01]
            ['kode_akun' => '401', 'nama_akun' => 'Pendapatan usaha', 'header_akun' => '4', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],
            ['kode_akun' => '410', 'nama_akun' => 'Pendapatan di luar usaha', 'header_akun' => '4', 'posisi_normal' => 'Kredit', 'saldo_awal' => 0],

            // 50 BEBAN [cite: 2025-11-01]
            ['kode_akun' => '501', 'nama_akun' => 'Beban gaji toko', 'header_akun' => '5', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '502', 'nama_akun' => 'Beban gaji kantor', 'header_akun' => '5', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '503', 'nama_akun' => 'Beban sewa gedung', 'header_akun' => '5', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '504', 'nama_akun' => 'Beban penyesuaian piutang', 'header_akun' => '5', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '505', 'nama_akun' => 'Beban perlengkapan kantor', 'header_akun' => '5', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '506', 'nama_akun' => 'Beban perlengkapan toko', 'header_akun' => '5', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '507', 'nama_akun' => 'Beban iklan', 'header_akun' => '5', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '508', 'nama_akun' => 'Beban penyusutan peralatan', 'header_akun' => '5', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '509', 'nama_akun' => 'Beban penyusutan', 'header_akun' => '5', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '510', 'nama_akun' => 'Beban bunga', 'header_akun' => '5', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
            ['kode_akun' => '511', 'nama_akun' => 'Beban lain-lain', 'header_akun' => '5', 'posisi_normal' => 'Debit', 'saldo_awal' => 0],
        ];

        foreach ($data as $d) {
            $this->db->table('accounts')->insert($d);
        }
    }
}