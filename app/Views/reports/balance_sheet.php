<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div data-aos="fade-up">
    <div class="card shadow mb-4 no-print bg-dark border-left-info">
        <div class="card-body">
            <form action="<?= base_url('balance-sheet') ?>" method="get" class="row align-items-end">
                <div class="col-md-3">
                    <label class="small font-weight-bold text-info-neon">Mulai Tanggal</label>
                    <input type="date" name="start_date" class="form-control bg-dark text-white border-secondary" value="<?= $start_date ?>">
                </div>
                <div class="col-md-3">
                    <label class="small font-weight-bold text-info-neon">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control bg-dark text-white border-secondary" value="<?= $end_date ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info-neon btn-block font-weight-bold">FILTER</button>
                </div>
                <div class="col-md-2">
                    <a href="<?= base_url("balance-sheet/pdf?start_date=$start_date&end_date=$end_date") ?>" class="btn btn-danger btn-block" target="_blank">PDF</a>
                </div>
                <div class="col-md-2">
                    <a href="<?= base_url("balance-sheet/excel?start_date=$start_date&end_date=$end_date") ?>" class="btn btn-success btn-block">EXCEL</a>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center mb-4">
        <h2 class="text-white font-weight-bold">LAPORAN NERACA</h2>
        <h5 class="text-info-neon">Periode: <?= $periodName ?></h5>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card bg-dark text-white border-left-info shadow mb-4">
                <div class="card-header bg-transparent"><h6 class="m-0 font-weight-bold text-info-neon">AKTIVA</h6></div>
                <div class="card-body">
                    <table class="table table-borderless table-sm text-white">
                        <?php 
                        $totalA = 0; 
                        foreach($assets as $a): 
                            // LOGIKA AKUN KONTRA: Jika Aset tapi Normal Kredit, maka NILAI MINUS [cite: 2025-11-01]
                            $isContra = ($a['posisi_normal'] == 'Kredit');
                            $val = $a['saldo_akhir'];
                            
                            if ($isContra) {
                                $totalA -= $val; // Mengurangi total
                                $displayVal = "(Rp " . number_format($val, 0, ',', '.') . ")";
                            } else {
                                $totalA += $val; // Menambah total
                                $displayVal = "Rp " . number_format($val, 0, ',', '.');
                            }
                        ?>
                        <tr>
                            <td>[<?= $a['kode_akun'] ?>] <?= $a['nama_akun'] ?></td>
                            <td class="text-right"><?= $displayVal ?></td>
                        </tr>
                        <?php endforeach; ?>

                        <tr class="border-top border-info text-info-neon font-weight-bold">
                            <td class="pt-2">TOTAL AKTIVA</td>
                            <td class="text-right pt-2">Rp <?= number_format($totalA, 0, ',', '.') ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card bg-dark text-white border-left-success shadow mb-4">
                <div class="card-header bg-transparent"><h6 class="m-0 font-weight-bold text-success-neon">PASIVA</h6></div>
                <div class="card-body">
                    <table class="table table-borderless table-sm text-white">
                        <?php 
                        $totalP = 0; 
                        // Loop Liabilitas
                        foreach($liabilities as $l): 
                            $totalP += $l['saldo_akhir']; 
                        ?>
                        <tr>
                            <td>[<?= $l['kode_akun'] ?>] <?= $l['nama_akun'] ?></td>
                            <td class="text-right">Rp <?= number_format($l['saldo_akhir'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php foreach($equity as $e): 
                            $totalP += $e['saldo_akhir']; 
                        ?>
                        <tr>
                            <td>[<?= $e['kode_akun'] ?>] <?= $e['nama_akun'] ?></td>
                            <td class="text-right">Rp <?= number_format($e['saldo_akhir'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <tr>
                            <td class="font-italic text-muted">Laba Periode Berjalan</td>
                            <td class="text-right">Rp <?= number_format($laba_berjalan, 0, ',', '.') ?></td>
                        </tr>
                        <?php $totalP += $laba_berjalan; ?>

                        <tr class="border-top border-success text-success-neon font-weight-bold">
                            <td class="pt-2">TOTAL PASIVA</td>
                            <td class="text-right pt-2">Rp <?= number_format($totalP, 0, ',', '.') ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <?php if(round($totalA) == round($totalP)): ?>
                <div class="alert alert-success py-3 shadow-sm border-0 bg-success text-white">
                    <i class="fas fa-check-circle mr-2"></i> <strong>Neraca Seimbang (Balanced)</strong>
                </div>
            <?php else: ?>
                <div class="alert alert-danger py-3 shadow-sm border-0 bg-danger text-white">
                    <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Neraca Belum Seimbang</strong>
                    <br><small>Selisih: Rp <?= number_format(abs($totalA - $totalP), 0, ',', '.') ?></small>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>