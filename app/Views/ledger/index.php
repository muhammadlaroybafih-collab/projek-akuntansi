<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-2">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <h3 class="fw-bold mb-4">📊 Buku Besar (General Ledger)</h3>
            
            <form action="<?= base_url('ledger') ?>" method="get" class="row g-2 mb-4">
                <div class="col-md-8">
                    <select name="account_id" class="form-select border-primary shadow-sm" required>
                        <option value="">-- Pilih Akun Untuk Melihat Mutasi --</option>
                        <?php foreach($accounts as $acc): ?>
                            <option value="<?= $acc['id'] ?>" <?= (isset($_GET['account_id']) && $_GET['account_id'] == $acc['id']) ? 'selected' : '' ?>>
                                [<?= $acc['kode_akun'] ?>] - <?= $acc['nama_akun'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">Tampilkan Laporan</button>
                </div>
            </form>

            <?php if ($selectedAccount): ?>
                <div class="alert alert-light border mb-4">
                    <h5 class="mb-0 fw-bold text-dark">Laporan Akun: <?= $selectedAccount['nama_akun'] ?> (<?= $selectedAccount['kode_akun'] ?>)</h5>
                </div>
                
                <table class="table table-hover border align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>No. Bukti</th>
                            <th>Keterangan</th>
                            <th class="text-end">Debit</th>
                            <th class="text-end">Kredit</th>
                            <th class="text-end">Saldo Berjalan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $saldo = 0;
                        foreach($ledger as $l): 
                            // Logika saldo berjalan berdasarkan posisi normal akun [cite: 2025-11-01]
                            if ($selectedAccount['posisi_normal'] == 'Debit') {
                                $saldo += ($l['debit'] - $l['kredit']);
                            } else {
                                $saldo += ($l['kredit'] - $l['debit']);
                            }
                        ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($l['tanggal'])) ?></td>
                            <td class="fw-bold text-primary"><?= $l['no_bukti'] ?></td>
                            <td class="small text-muted"><?= $l['keterangan'] ?></td>
                            <td class="text-end text-success"><?= number_format($l['debit'], 2, ',', '.') ?></td>
                            <td class="text-end text-danger"><?= number_format($l['kredit'], 2, ',', '.') ?></td>
                            <td class="text-end fw-bold">Rp <?= number_format($saldo, 2, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="text-center py-5">
                    <div class="display-1 text-muted opacity-25">📁</div>
                    <p class="text-muted mt-3">Silakan pilih akun terlebih dahulu untuk melihat histori transaksi.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>