<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-2">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 text-dark">
                <h3 class="fw-bold mb-0">⚖️ Neraca Saldo (Trial Balance)</h3>
                <span class="text-muted small">Periode: <?= date('F Y') ?></span>
            </div>
            
            <table class="table table-hover border align-middle">
                <thead class="table-dark">
                    <tr>
                        <th width="15%">Kode Akun</th>
                        <th>Nama Akun</th>
                        <th class="text-end" width="20%">Debit</th>
                        <th class="text-end" width="20%">Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $totalD = 0; $totalK = 0;
                    foreach($data as $row): 
                        $totalD += $row['debit'];
                        $totalK += $row['kredit'];
                    ?>
                    <tr>
                        <td><code><?= $row['kode'] ?></code></td>
                        <td class="fw-bold"><?= $row['nama'] ?></td>
                        <td class="text-end"><?= $row['debit'] > 0 ? number_format($row['debit'], 2, ',', '.') : '-' ?></td>
                        <td class="text-end text-danger"><?= $row['kredit'] > 0 ? number_format($row['kredit'], 2, ',', '.') : '-' ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-secondary fw-bold fs-5">
                    <tr>
                        <td colspan="2" class="text-center">TOTAL BALANCE</td>
                        <td class="text-end text-primary">Rp <?= number_format($totalD, 2, ',', '.') ?></td>
                        <td class="text-end text-primary">Rp <?= number_format($totalK, 2, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
            
            <?php if($totalD != $totalK): ?>
                <div class="alert alert-danger mt-3">⚠️ Peringatan: Neraca Saldo tidak seimbang! Periksa kembali jurnal Anda.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>