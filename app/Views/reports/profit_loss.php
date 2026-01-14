<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div data-aos="fade-up">
    <div class="card shadow mb-4 no-print bg-dark border-left-success">
        <div class="card-body">
            <form action="<?= base_url('profit-loss') ?>" method="get" class="row align-items-end">
                <div class="col-md-3">
                    <label class="small font-weight-bold text-success-neon">Mulai Tanggal</label>
                    <input type="date" name="start_date" class="form-control bg-dark text-white border-secondary" value="<?= $start_date ?>">
                </div>
                <div class="col-md-3">
                    <label class="small font-weight-bold text-success-neon">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control bg-dark text-white border-secondary" value="<?= $end_date ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success btn-block font-weight-bold shadow-sm">
                        <i class="fas fa-filter mr-1"></i> FILTER
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="<?= base_url("profit-loss/pdf?start_date=$start_date&end_date=$end_date") ?>" class="btn btn-danger btn-block shadow-sm" target="_blank">
                        <i class="fas fa-file-pdf mr-1"></i> PDF
                    </a>
                </div>
                <div class="col-md-2">
                    <a href="<?= base_url("profit-loss/excel?start_date=$start_date&end_date=$end_date") ?>" class="btn btn-success btn-block shadow-sm">
                        <i class="fas fa-file-excel mr-1"></i> EXCEL
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 bg-dark text-white">
        <div class="card-body p-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-0 text-white">LAPORAN LABA RUGI</h2>
                <p class="text-success-neon mt-2" style="font-size: 1.1rem;">Rentang: <?= $periodName ?></p>
            </div>

            <table class="table table-borderless text-white mb-4">
                <thead>
                    <tr class="border-bottom border-secondary">
                        <th class="fs-5 text-info-neon">PENDAPATAN</th>
                        <th class="text-end px-4">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($revenues as $rev): if($rev['saldo'] != 0): ?>
                    <tr>
                        <td class="ps-4"><?= $rev['nama_akun'] ?></td>
                        <td class="text-end px-4">Rp <?= number_format($rev['saldo'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endif; endforeach; ?>
                    <tr class="fw-bold bg-black-50">
                        <td class="text-info-neon">TOTAL PENDAPATAN</td>
                        <td class="text-end px-4 text-info-neon">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-borderless text-white mb-5">
                <thead>
                    <tr class="border-bottom border-secondary">
                        <th class="fs-5 text-danger-neon">BEBAN USAHA</th>
                        <th class="text-end px-4">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($expenses as $exp): if($exp['saldo'] != 0): ?>
                    <tr>
                        <td class="ps-4"><?= $exp['nama_akun'] ?></td>
                        <td class="text-end px-4">Rp <?= number_format($exp['saldo'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endif; endforeach; ?>
                    <tr class="fw-bold bg-black-50">
                        <td class="text-danger-neon">TOTAL BEBAN</td>
                        <td class="text-end px-4 text-danger-neon">Rp <?= number_format($totalExpense, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="card <?= $netProfit >= 0 ? 'bg-success' : 'bg-danger' ?> text-white border-0 rounded-4 shadow">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <h3 class="fw-bold mb-0"><?= $netProfit >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' ?></h3>
                    <h2 class="fw-bold mb-0">Rp <?= number_format(abs($netProfit), 0, ',', '.') ?></h2>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>