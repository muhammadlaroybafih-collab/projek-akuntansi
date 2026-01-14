<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div data-aos="fade-up">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 font-weight-bold">Daftar Akun (CoA)</h1>
        <a href="<?= base_url('accounts/create') ?>" class="btn btn-info-neon shadow-sm px-4">
            <i class="fas fa-plus fa-sm mr-2"></i> Tambah Akun
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-white align-middle">
                    <thead class="text-info-neon">
                        <tr>
                            <th width="15%">Kode Akun</th>
                            <th>Nama Akun</th>
                            <th>Kategori</th>
                            <th>Posisi Normal</th>
                            <th class="text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($accounts)): foreach ($accounts as $acc): ?>
                        <tr>
                            <td class="font-weight-bold"><code><?= $acc['kode_akun'] ?></code></td>
                            <td><?= $acc['nama_akun'] ?></td>
                            <td><span class="badge badge-dark border border-secondary"><?= $acc['kategori'] ?? 'General' ?></span></td>
                            <td>
                                <span class="badge <?= $acc['posisi_normal'] == 'Debit' ? 'btn-success' : 'btn-danger' ?> btn-sm px-3">
                                    <?= $acc['posisi_normal'] ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-info mr-1"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-4">Belum ada data akun.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>