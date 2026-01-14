<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<style>
    /* Fix untuk masalah modal freeze & input date [cite: 2025-11-01] */
    .modal-backdrop { z-index: 1040 !important; }
    .modal { z-index: 1050 !important; }
    input[type="date"] { cursor: pointer; }
</style>

<div data-aos="fade-up">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 font-weight-bold text-white">Panel Kontrol Akuntansi</h1>
        <button class="btn btn-sm btn-outline-light border-0" data-toggle="modal" data-target="#addPeriodModal">
            <i class="fas fa-plus fa-sm mr-2"></i> Buka Periode Baru
        </button>
    </div>

    <div class="card shadow mb-4 bg-dark border-0" style="border-radius: 15px;">
        <div class="card-header bg-transparent border-secondary py-3">
            <h6 class="m-0 font-weight-bold text-info-neon">Periode Akuntansi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-borderless text-white">
                    <thead class="text-info">
                        <tr class="border-bottom border-secondary">
                            <th>Nama Periode</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($periods as $p): ?>
                        <tr class="border-bottom border-secondary-50">
                            <td class="align-middle font-weight-bold"><?= $p['period_name'] ?></td>
                            <td class="align-middle"><?= date('d M Y', strtotime($p['start_date'])) ?></td>
                            <td class="align-middle"><?= date('d M Y', strtotime($p['end_date'])) ?></td>
                            <td class="text-center align-middle">
                                <div class="d-flex align-items-center justify-content-center">
                                    <button class="btn btn-sm btn-link text-info p-0 mr-2" data-toggle="modal" data-target="#editModal<?= $p['id'] ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>

                                    <a href="<?= base_url('period/toggle/' . $p['id']) ?>" class="text-decoration-none" onclick="return confirm('Ubah status?')">
                                        <?php if($p['is_closed'] == 1): ?>
                                            <span class="badge badge-danger px-3 py-2"><i class="fas fa-lock mr-1"></i> CLOSED</span>
                                        <?php else: ?>
                                            <span class="badge badge-success px-3 py-2"><i class="fas fa-lock-open mr-1"></i> OPEN</span>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <a href="<?= base_url('period/toggle/' . $p['id']) ?>" class="btn btn-sm <?= $p['is_closed'] == 1 ? 'btn-outline-success' : 'btn-outline-danger' ?> btn-block shadow-sm">
                                   <?= $p['is_closed'] == 1 ? 'Buka Kembali' : 'Tutup Buku' ?>
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

<div class="modal fade" id="addPeriodModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark text-white border-info shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title font-weight-bold text-info-neon">Buka Periode Baru</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?= base_url('period/store') ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold">Nama Periode</label>
                        <input type="text" name="period_name" class="form-control bg-dark text-white border-secondary" required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="small font-weight-bold">Mulai</label>
                            <input type="date" name="start_date" class="form-control bg-dark text-white border-secondary" required>
                        </div>
                        <div class="col-6">
                            <label class="small font-weight-bold">Selesai</label>
                            <input type="date" name="end_date" class="form-control bg-dark text-white border-secondary" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="submit" class="btn btn-info-neon px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach($periods as $p): ?>
<div class="modal fade" id="editModal<?= $p['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark text-white border-info shadow-lg">
            <div class="modal-header border-secondary">
                <h5 class="modal-title font-weight-bold text-info-neon">Edit: <?= $p['period_name'] ?></h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?= base_url('period/update/'.$p['id']) ?>" method="POST">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold">Nama Periode</label>
                        <input type="text" name="period_name" class="form-control bg-dark text-white border-secondary" value="<?= $p['period_name'] ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="small font-weight-bold">Mulai</label>
                            <input type="date" name="start_date" class="form-control bg-dark text-white border-secondary" value="<?= $p['start_date'] ?>" required>
                        </div>
                        <div class="col-6">
                            <label class="small font-weight-bold">Selesai</label>
                            <input type="date" name="end_date" class="form-control bg-dark text-white border-secondary" value="<?= $p['end_date'] ?>" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="submit" class="btn btn-info-neon px-4">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?= $this->endSection() ?>