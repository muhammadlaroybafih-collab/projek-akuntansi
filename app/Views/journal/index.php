<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">📖 Riwayat Transaksi Jurnal</h3>
                <a href="<?= base_url('journal/create') ?>" class="btn btn-primary shadow-sm">+ Input Jurnal Baru</a>
            </div>

            <form action="<?= base_url('journal') ?>" method="get" class="row g-2 mb-4">
                <div class="col-md-3">
                    <select name="tipe" class="form-select border-primary shadow-sm">
                        <option value="Semua">-- Semua Jenis Jurnal --</option>
                        <option value="Umum" <?= $current_filter == 'Umum' ? 'selected' : '' ?>>Jurnal Umum (JU)</option>
                        <option value="Penjualan" <?= $current_filter == 'Penjualan' ? 'selected' : '' ?>>Jurnal Penjualan (JP)</option>
                        <option value="Pembelian" <?= $current_filter == 'Pembelian' ? 'selected' : '' ?>>Jurnal Pembelian (JB)</option>
                        <option value="Masuk" <?= $current_filter == 'Masuk' ? 'selected' : '' ?>>Kas Masuk (BKM)</option>
                        <option value="Keluar" <?= $current_filter == 'Keluar' ? 'selected' : '' ?>>Kas Keluar (BKK)</option>
                        <option value="Penyesuaian" <?= $current_filter == 'Penyesuaian' ? 'selected' : '' ?>>Jurnal Penyesuaian (AJP)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary w-100 shadow-sm">Filter Data</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover border align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Tanggal</th>
                            <th>No. Bukti</th>
                            <th>Tipe</th>
                            <th>Keterangan</th>
                            <th class="text-end">Total Nominal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($journals)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data transaksi yang tersimpan.</td>
                            </tr>
                        <?php endif; ?>
                        
                        <?php foreach($journals as $j): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($j['tanggal'])) ?></td>
                            <td><span class="fw-bold text-primary"><?= $j['no_bukti'] ?></span></td>
                            <td><span class="badge bg-info text-dark shadow-sm"><?= $j['tipe_jurnal'] ?></span></td>
                            <td><?= $j['keterangan'] ?: '-' ?></td>
                            <td class="text-end fw-bold">Rp <?= number_format($j['total_debit'], 2, ',', '.') ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('journal/detail/'.$j['id']) ?>" class="btn btn-sm btn-outline-primary">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>