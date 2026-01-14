<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-5 mb-5">
    <div class="card shadow border-0 overflow-hidden">
        <div class="card-header bg-info text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">DETAIL TRANSAKSI: <?= $header['no_bukti'] ?></h5>
            <a href="<?= base_url('journal') ?>" class="btn btn-sm btn-light shadow-sm">Kembali ke Daftar</a>
        </div>
        <div class="card-body p-4">
            <div class="row mb-5 border-bottom pb-3">
                <div class="col-md-4">
                    <label class="small text-muted fw-bold text-uppercase d-block mb-1">Tanggal Transaksi</label>
                    <p class="fs-5 fw-bold text-dark mb-0"><?= date('d F Y', strtotime($header['tanggal'])) ?></p>
                </div>
                <div class="col-md-4">
                    <label class="small text-muted fw-bold text-uppercase d-block mb-1">Jenis Jurnal</label>
                    <span class="badge bg-dark fs-6"><?= $header['tipe_jurnal'] ?></span>
                </div>
                <div class="col-md-4">
                    <label class="small text-muted fw-bold text-uppercase d-block mb-1">Keterangan / Memo</label>
                    <p class="fs-6 text-dark mb-0 italic font-monospace"><?= $header['keterangan'] ?: 'Tidak ada catatan.' ?></p>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover border">
                    <thead class="table-light text-secondary">
                        <tr>
                            <th class="py-3 px-4">KODE AKUN</th>
                            <th class="py-3">NAMA AKUN (POSTING)</th>
                            <th class="py-3 text-end px-4">DEBIT (RP)</th>
                            <th class="py-3 text-end px-4">KREDIT (RP)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($details as $d): ?>
                        <tr>
                            <td class="px-4 text-secondary font-monospace"><?= $d['kode_akun'] ?></td>
                            <td class="<?= $d['kredit'] > 0 ? 'ps-5 border-start-0' : 'fw-bold' ?>">
                                <?= $d['nama_akun'] ?>
                            </td>
                            <td class="text-end px-4 text-success fw-bold">
                                <?= $d['debit'] > 0 ? number_format($d['debit'], 2, ',', '.') : '-' ?>
                            </td>
                            <td class="text-end px-4 text-danger fw-bold">
                                <?= $d['kredit'] > 0 ? number_format($d['kredit'], 2, ',', '.') : '-' ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-secondary fw-bold fs-5">
                        <tr>
                            <td colspan="2" class="text-center py-3">TOTAL KESELURUHAN</td>
                            <td class="text-end px-4">Rp <?= number_format($header['total_debit'], 2, ',', '.') ?></td>
                            <td class="text-end px-4">Rp <?= number_format($header['total_kredit'], 2, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light py-3">
            <small class="text-muted italic">* Pastikan saldo Debit dan Kredit selalu dalam keadaan seimbang (Balance).</small>
        </div>
    </div>
</div>
<?= $this->endSection() ?>