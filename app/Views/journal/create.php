<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container mt-4">
    <?php if (session()->getFlashdata('error')) : ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Akses Ditolak!',
                text: '<?= session()->getFlashdata('error') ?>',
                confirmButtonColor: '#FF3131'
            });
        </script>
    <?php endif; ?>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold">Input Transaksi Multi-Jurnal</h5>
            <a href="<?= base_url('journal') ?>" class="btn btn-sm btn-outline-light">Kembali ke Daftar</a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('journal/store') ?>" method="post" id="journal-form">
                <div class="row g-3 mb-4 p-3 bg-light rounded border">
                    <div class="col-md-3">
                        <label class="fw-bold small text-secondary">JENIS JURNAL</label>
                        <select name="tipe_jurnal" id="tipe_jurnal" class="form-select border-primary shadow-sm" required>
                            <option value="Umum">Jurnal Umum (JU)</option>
                            <option value="Penjualan">Jurnal Penjualan (JP)</option>
                            <option value="Pembelian">Jurnal Pembelian (JB)</option>
                            <option value="Masuk">Kas Masuk (BKM)</option>
                            <option value="Keluar">Kas Keluar (BKK)</option>
                            <option value="Penyesuaian">Jurnal Penyesuaian (AJP)</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="fw-bold small text-secondary">NO. BUKTI (OTOMATIS)</label>
                        <input type="text" name="no_bukti" id="no_bukti" class="form-control bg-white fw-bold shadow-sm" value="<?= $no_bukti ?>" readonly required title="Nomor digenerate otomatis">
                    </div>
                    <div class="col-md-2">
                        <label class="fw-bold small text-secondary">TANGGAL</label>
                        <input type="date" name="tanggal" class="form-control shadow-sm" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold small text-secondary">KETERANGAN / MEMO</label>
                        <input type="text" name="keterangan" class="form-control shadow-sm" placeholder="Contoh: Pembayaran Gaji Karyawan Jan 2026">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th width="50%">Akun (Chart of Account)</th>
                                <th width="22%">Debit (Rp)</th>
                                <th width="22%">Kredit (Rp)</th>
                                <th width="6%"></th>
                            </tr>
                        </thead>
                        <tbody id="rows">
                            <tr>
                                <td>
                                    <select name="account_id[]" class="form-select" required>
                                        <option value="">-- Pilih Akun --</option>
                                        <?php foreach($accounts as $acc): ?>
                                            <option value="<?= $acc['id'] ?>">[<?= $acc['kode_akun'] ?>] - <?= $acc['nama_akun'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="number" name="debit[]" class="form-control in-debit" value="0" step="0.01"></td>
                                <td><input type="number" name="kredit[]" class="form-control in-kredit" value="0" step="0.01"></td>
                                <td class="text-center"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-outline-primary btn-sm px-3 shadow-sm fw-bold" id="add-btn">+ TAMBAH BARIS AKUN</button>
                    <div class="d-flex gap-4">
                        <div class="alert alert-info py-2 px-4 mb-0 fw-bold border-info shadow-sm rounded-pill">
                            TOTAL: Rp <span id="total-val">0</span>
                        </div>
                        <div id="status-label" class="badge bg-danger p-3 shadow-sm fs-6 rounded-pill">Status: Tidak Balance ❌</div>
                    </div>
                </div>

                <hr class="my-4">
                <button type="submit" id="save-btn" class="btn btn-success w-100 py-3 fw-bold shadow-sm" disabled>SIMPAN TRANSAKSI KE JURNAL</button>
            </form>
        </div>
    </div>
</div>

<script>
    const rows = document.getElementById('rows');
    const saveBtn = document.getElementById('save-btn');
    const labelStatus = document.getElementById('status-label');

    // Auto Number AJAX logic
    document.getElementById('tipe_jurnal').addEventListener('change', function() {
        fetch(`<?= base_url('journal/get_auto_number') ?>?tipe=${this.value}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('no_bukti').value = data.nomor;
            })
            .catch(err => console.error("Gagal ambil nomor:", err));
    });

    // Add row logic
    document.getElementById('add-btn').addEventListener('click', () => {
        const tr = rows.querySelector('tr').cloneNode(true);
        tr.querySelectorAll('input').forEach(i => i.value = 0);
        tr.lastElementChild.innerHTML = '<button type="button" class="btn btn-danger btn-sm del shadow-sm">X</button>';
        rows.appendChild(tr);
    });

    // Delete row and Calculation triggers
    document.addEventListener('click', e => { 
        if(e.target.classList.contains('del')) { 
            e.target.closest('tr').remove(); 
            check(); 
        } 
    });
    document.addEventListener('input', check);

    function check() {
        let d = 0, k = 0;
        document.querySelectorAll('.in-debit').forEach(i => d += parseFloat(i.value || 0));
        document.querySelectorAll('.in-kredit').forEach(i => k += parseFloat(i.value || 0));
        
        const isOk = (d.toFixed(2) === k.toFixed(2) && d > 0);
        
        document.getElementById('total-val').innerText = d.toLocaleString('id-ID');
        
        if(isOk) {
            labelStatus.innerText = "Status: Balance ✅";
            labelStatus.className = "badge bg-success p-3 shadow-sm fs-6 rounded-pill";
            saveBtn.disabled = false;
        } else {
            labelStatus.innerText = "Status: Tidak Balance ❌";
            labelStatus.className = "badge bg-danger p-3 shadow-sm fs-6 rounded-pill";
            saveBtn.disabled = true;
        }
    }
</script>
<?= $this->endSection() ?>