<?php
// Ambil segment URI untuk menentukan menu aktif
$uri = service('uri');
$currentSegment = $uri->getSegment(1, '');
$currentAdminSegment = $uri->getSegment(2, '');

// Variabel untuk delay AOS agar animasi tetap smooth
$delay = 50;
?>

<div style="flex: 1; overflow-y: auto; overflow-x: hidden; scrollbar-width: none; -ms-overflow-style: none;">
    <style> 
        /* Menyembunyikan scrollbar di Chrome/Safari agar tetap bersih [cite: 2025-11-01] */
        div::-webkit-scrollbar { display: none; } 
    </style>

    <hr class="sidebar-divider">

    <div class="sidebar-heading" data-aos="fade-right" data-aos-delay="<?= $delay ?>">
        Halaman Utama
    </div>
    <?php $delay += 100; ?>

    <?php $isDashboardActive = ($currentSegment == 'dashboard' || $currentSegment == ''); ?>
    <li class="nav-item <?= $isDashboardActive ? 'active' : '' ?>" data-aos="fade-right" data-aos-delay="<?= $delay ?>">
        <a class="nav-link" href="<?= base_url('dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <?php $delay += 100; ?>

    <hr class="sidebar-divider">

    <div class="sidebar-heading" data-aos="fade-right" data-aos-delay="<?= $delay ?>">
        DATA MASTER
    </div>
    <?php $delay += 100; ?>

    <?php $isMasterActive = ($currentSegment == 'accounts'); ?>
    <li class="nav-item <?= $isMasterActive ? 'active' : '' ?>" data-aos="fade-right" data-aos-delay="<?= $delay ?>">
        <a class="nav-link <?= $isMasterActive ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseMaster"
            aria-expanded="<?= $isMasterActive ? 'true' : 'false' ?>" aria-controls="collapseMaster">
            <i class="fas fa-fw fa-database"></i>
            <span>Menu Master Data</span>
        </a>
        <div id="collapseMaster" class="collapse <?= $isMasterActive ? 'show' : '' ?>"
            aria-labelledby="headingMaster" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                <h6 class="collapse-header">Kelola COA</h6>
                <a class="collapse-item <?= ($currentSegment == 'accounts' && $currentAdminSegment == '') ? 'active' : '' ?>" href="<?= base_url('accounts') ?>">
                    <i class="fas fa-fw fa-list mr-1"></i> Daftar Akun
                </a>
                <a class="collapse-item <?= ($currentSegment == 'accounts' && $currentAdminSegment == 'create') ? 'active' : '' ?>" href="<?= base_url('accounts/create') ?>">
                    <i class="fas fa-fw fa-plus-circle mr-1"></i> Tambah Akun
                </a>
            </div>
        </div>
    </li>
    <?php $delay += 100; ?>

    <hr class="sidebar-divider">

    <div class="sidebar-heading" data-aos="fade-right" data-aos-delay="<?= $delay ?>">
        ALUR TRANSAKSI
    </div>
    <?php $delay += 100; ?>

    <?php $isTransaksiActive = in_array($currentSegment, ['journal', 'adjustment']); ?>
    <li class="nav-item <?= $isTransaksiActive ? 'active' : '' ?>" data-aos="fade-right" data-aos-delay="<?= $delay ?>">
        <a class="nav-link <?= $isTransaksiActive ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseTransaksi"
            aria-expanded="<?= $isTransaksiActive ? 'true' : 'false' ?>" aria-controls="collapseTransaksi">
            <i class="fas fa-fw fa-book"></i>
            <span>Menu Transaksi</span>
        </a>
        <div id="collapseTransaksi" class="collapse <?= $isTransaksiActive ? 'show' : '' ?>"
            aria-labelledby="headingTransaksi" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                <h6 class="collapse-header">Pencatatan Jurnal:</h6>
                <a class="collapse-item <?= ($currentSegment == 'journal' && $currentAdminSegment == 'create') ? 'active' : '' ?>" href="<?= base_url('journal/create') ?>">
                    <i class="fas fa-fw fa-edit mr-1"></i> Input Jurnal
                </a>
                <a class="collapse-item <?= ($currentSegment == 'journal' && $currentAdminSegment == '') ? 'active' : '' ?>" href="<?= base_url('journal') ?>">
                    <i class="fas fa-fw fa-history mr-1"></i> Riwayat Jurnal
                </a>
                <a class="collapse-item <?= ($currentSegment == 'adjustment') ? 'active' : '' ?>" href="<?= base_url('adjustment') ?>">
                    <i class="fas fa-fw fa-magic mr-1 text-info"></i> Penyesuaian
                </a>
            </div>
        </div>
    </li>
    <?php $delay += 100; ?>

    <hr class="sidebar-divider">

    <div class="sidebar-heading" data-aos="fade-right" data-aos-delay="<?= $delay ?>">
        LAPORAN KEUANGAN
    </div>
    <?php $delay += 100; ?>

    <?php $isLaporanActive = in_array($currentSegment, ['ledger', 'trial-balance', 'profit-loss', 'balance-sheet']); ?>
    <li class="nav-item <?= $isLaporanActive ? 'active' : '' ?>" data-aos="fade-right" data-aos-delay="<?= $delay ?>">
        <a class="nav-link <?= $isLaporanActive ? '' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseLaporan"
            aria-expanded="<?= $isLaporanActive ? 'true' : 'false' ?>" aria-controls="collapseLaporan">
            <i class="fas fa-fw fa-file-invoice-dollar"></i>
            <span>Laporan</span>
        </a>
        <div id="collapseLaporan" class="collapse <?= $isLaporanActive ? 'show' : '' ?>"
            aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded shadow-sm">
                <a class="collapse-item <?= ($currentSegment == 'ledger') ? 'active' : '' ?>" href="<?= base_url('ledger') ?>">
                    <i class="fas fa-fw fa-table mr-1"></i> Buku Besar
                </a>
                <a class="collapse-item <?= ($currentSegment == 'trial-balance') ? 'active' : '' ?>" href="<?= base_url('trial-balance') ?>">
                    <i class="fas fa-fw fa-balance-scale mr-1"></i> Neraca Saldo
                </a>
                <a class="collapse-item <?= ($currentSegment == 'profit-loss') ? 'active' : '' ?>" href="<?= base_url('profit-loss') ?>">
                    <i class="fas fa-fw fa-chart-line mr-1"></i> Laba Rugi
                </a>
                <a class="collapse-item <?= ($currentSegment == 'balance-sheet') ? 'active' : '' ?>" href="<?= base_url('balance-sheet') ?>">
    <i class="fas fa-fw fa-balance-scale-left mr-1"></i> Neraca
</a>
            </div>
        </div>
    </li>
    <?php $delay += 100; ?>

    <hr class="sidebar-divider">

    <div class="sidebar-heading" data-aos="fade-right" data-aos-delay="<?= $delay ?>">
        PENGATURAN
    </div>
    <?php $delay += 100; ?>

    <li class="nav-item <?= ($currentSegment == 'period') ? 'active' : '' ?>" data-aos="fade-right" data-aos-delay="<?= $delay ?>">
        <a class="nav-link" href="<?= base_url('period') ?>">
            <i class="fas fa-fw fa-calendar-alt text-warning"></i>
            <span>Periode Akuntansi</span>
        </a>
    </li>
    <?php $delay += 100; ?>

    <li class="nav-item" data-aos="fade-right" data-aos-delay="<?= $delay ?>">
        <a class="nav-link text-danger font-weight-bold" href="<?= base_url('auth/logout') ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>
</div> 


