<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div data-aos="fade-left" class="col-lg-7 mx-auto">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-transparent border-bottom-info">
            <h6 class="m-0 font-weight-bold text-info-neon"><i class="fas fa-plus-circle mr-2"></i>Tambah Akun Baru</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('accounts/store') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="small font-weight-bold">Kode Akun</label>
                        <input type="text" name="kode_akun" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: 101" required>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="small font-weight-bold">Nama Akun</label>
                        <input type="text" name="nama_akun" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: Kas Utama" required>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="small font-weight-bold">Posisi Normal</label>
                    <select name="posisi_normal" class="form-control bg-dark text-white border-secondary">
                        <option value="Debit">Debit (Aktiva / Beban)</option>
                        <option value="Kredit">Kredit (Pasiva / Pendapatan)</option>
                    </select>
                </div>

                <hr class="border-secondary opacity-25">
                
                <div class="d-flex justify-content-between align-items-center">
                    <a href="<?= base_url('accounts') ?>" class="text-gray-400 small"><i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar</a>
                    <button type="submit" class="btn btn-info-neon px-5 shadow-lg font-weight-bold">
                        SIMPAN AKUN
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>