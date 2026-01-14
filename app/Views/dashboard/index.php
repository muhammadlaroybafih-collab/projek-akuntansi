<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div data-aos="fade-up">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 font-weight-bold">Ringkasan Aktivitas</h1>
    </div>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100 py-2 border-left-info" style="background: rgba(0, 210, 255, 0.1) !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info-neon text-uppercase mb-1">Total Nilai Jurnal</div>
                            <div class="h4 mb-0 font-weight-bold">Rp <?= number_format($total_nominal, 0, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-info-neon shadow-sm"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100 py-2 border-left-success" style="background: rgba(57, 255, 20, 0.1) !important;">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success-neon text-uppercase mb-1">Jumlah Transaksi</div>
                            <div class="h4 mb-0 font-weight-bold"><?= $total_transaksi ?> Item</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exchange-alt fa-2x text-success-neon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-12 mb-4">
            <div class="card h-100 py-2 bg-dark border-secondary shadow">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info-neon text-uppercase mb-2">Akses Cepat</div>
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('ledger') ?>" class="btn btn-info-neon btn-sm flex-fill font-weight-bold">
                            <i class="fas fa-table mr-1"></i> Ledger
                        </a>
                        <a href="<?= base_url('journal') ?>" class="btn btn-outline-info btn-sm flex-fill font-weight-bold">
                            <i class="fas fa-search mr-1"></i> Filter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-transparent border-bottom-info d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-info-neon">Tren Transaksi Bulanan</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 320px;">
                        <canvas id="myJournalChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-2">
        <div class="col-lg-6 mb-4">
            <div class="card shadow py-5 text-center border-0 h-100" style="background: rgba(252, 2, 2, 0.04) !important;">
                <div class="card-body">
                    <i class="fas fa-edit fa-4x text-info-neon mb-4"></i>
                    <h4 class="font-weight-bold text-white">Input Jurnal</h4>
                    <p class="text-gray-400 small mb-4">Catat mutasi keuangan baru ke dalam sistem.</p>
                    <a href="<?= base_url('journal/create') ?>" class="btn btn-info-neon px-5 rounded-pill shadow-lg font-weight-bold text-uppercase">
                        Tambah Data
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow py-5 text-center border-0 h-100" style="background: rgba(255,255,255,0.04) !important;">
                <div class="card-body">
                    <i class="fas fa-history fa-4x text-success-neon mb-4"></i>
                    <h4 class="font-weight-bold text-white">Riwayat Jurnal</h4>
                    <p class="text-gray-400 small mb-4">Lihat dan audit semua rekaman transaksi.</p>
                    <a href="<?= base_url('journal') ?>" class="btn btn-success px-5 rounded-pill shadow-lg font-weight-bold text-uppercase" style="background-color: var(--success-neon) !important; color: #000; border:none;">
                        Buka Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('template/vendor/chart.js/Chart.min.js') ?>"></script>
<script>
    var ctx = document.getElementById("myJournalChart");
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($chart_labels) ?>,
            datasets: [{
                label: "Total Nominal",
                backgroundColor: "#00D2FF",
                hoverBackgroundColor: "#00A3C2",
                data: <?= json_encode($chart_data) ?>,
                borderRadius: 5
            }],
        },
        options: {
            maintainAspectRatio: false,
            legend: { display: false },
            scales: {
                yAxes: [{ 
                    ticks: { fontColor: "#858796", beginAtZero: true, callback: function(value) { return 'Rp ' + value.toLocaleString(); } }, 
                    gridLines: { color: "rgba(255,255,255,0.05)", zeroLineColor: "rgba(255,255,255,0.1)" } 
                }],
                xAxes: [{ ticks: { fontColor: "#858796" }, gridLines: { display: false } }]
            },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        return "Total: Rp " + tooltipItem.yLabel.toLocaleString();
                    }
                }
            }
        }
    });
</script>
<?= $this->endSection() ?>