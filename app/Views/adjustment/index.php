<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div data-aos="fade-up">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 font-weight-bold">Jurnal Penyesuaian</h1>
        <a href="<?= base_url('adjustment/create') ?>" class="btn btn-info-neon shadow-sm">
            <i class="fas fa-plus fa-sm mr-2"></i> Buat Penyesuaian
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-white">
                    <thead class="text-info-neon">
                        <tr>
                            <th>Tanggal</th>
                            <th>No. Bukti</th>
                            <th>Keterangan</th>
                            <th class="text-right">Total Nominal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($adjustments as $adj): ?>
                        <tr>
                            <td><?= $adj['tanggal'] ?></td>
                            <td><span class="badge badge-dark border border-info"><?= $adj['no_bukti'] ?></span></td>
                            <td><?= $adj['keterangan'] ?></td>
                            <td class="text-right">Rp <?= number_format($adj['total_debit'], 0, ',', '.') ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('adjustment/detail/'.$adj['id']) ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
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