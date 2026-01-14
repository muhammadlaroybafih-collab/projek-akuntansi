<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?? 'UKM PRO' ?></title>

    <link href="<?= base_url('template/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?= base_url('template/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        /* 1. VARIABEL WARNA (NEON GLASS CALIBRATED) */
        :root {
            --sidebar-width: 13rem;
            --topbar-height: 4.375rem;
            --primary-neon: #00D2FF;
            --success-neon: #39FF14;
            --danger-neon: #FF3131;
            --warning-neon: #FFD700;
            --glass-bg: rgba(20, 30, 40, 0.8);
            --glass-border: rgba(255, 255, 255, 0.12);
            --dark-deep: #0F171C;
        }

        /* 2. BODY & BACKGROUND */
        body {
            background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%) !important;
            color: #F8F9FA !important;
            overflow-x: hidden;
        }

        #content-wrapper, #content { background-color: transparent !important; }

        /* 3. SIDEBAR STYLING */
        .sidebar {
            width: var(--sidebar-width) !important;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1040;
            background-color: rgba(15, 23, 42, 0.9) !important; 
            backdrop-filter: blur(15px);
            transition: all 0.2s ease-in-out;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar .sidebar-brand {
            height: var(--topbar-height) !important;
            background-color: rgba(30, 58, 95, 0.4) !important; 
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .sidebar .nav-item .nav-link.collapsed::after, 
        .sidebar .nav-item .nav-link::after {
            margin-right: 0.8rem !important;
            transition: all 0.3s;
        }

        /* 4. TOPBAR STYLING */
        .topbar {
            height: var(--topbar-height) !important;
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            z-index: 1030;
            background-color: var(--glass-bg) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border) !important;
        }

        /* 5. UI COMPONENTS */
        .card {
            background-color: var(--glass-bg) !important;
            border: 1px solid var(--glass-border) !important;
            border-radius: 1.2rem !important;
        }

        .btn-info, .btn-primary { 
            background-color: var(--primary-neon) !important; 
            color: #000 !important; 
            font-weight: 800;
        }

        .text-info-neon { color: var(--primary-neon) !important; }

        #content-wrapper { margin-left: var(--sidebar-width); }
        .container-fluid { padding-top: calc(var(--topbar-height) + 25px); }

        /* Badge Periode Styling [cite: 2025-11-01] */
        .badge-periode-top {
            background: rgba(0, 210, 255, 0.1);
            border: 1px solid var(--primary-neon);
            border-radius: 50px;
            padding: 5px 15px;
            display: flex;
            align-items: center;
        }

        @media (max-width: 768px) {
            .sidebar { left: calc(var(--sidebar-width) * -1); }
            .topbar, #content-wrapper { left: 0; margin-left: 0; width: 100%; }
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-wallet text-info-neon"></i>
                </div>
                <div class="sidebar-brand-text mx-2 text-info-neon font-weight-bold">ACCOUNTING PROJECT</div>
            </a>
            <hr class="sidebar-divider my-0">
            <?= $this->include('layout/menu') ?>
            <div class="text-center d-none d-md-inline mt-4">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light topbar mb-4 shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3 text-info-neon">
                        <i class="fa fa-bars"></i>
                    </button>
                    
                    <div class="d-flex align-items-center">
                        <h5 class="ml-3 font-weight-bold mb-0 text-white mr-3">Panel Kontrol Akuntansi</h5>
                        
                        <div class="badge-periode-top d-none d-lg-flex shadow-sm">
                            <i class="fas fa-calendar-alt text-info-neon mr-2"></i>
                            <span class="text-xs font-weight-bold text-info-neon text-uppercase" style="letter-spacing: 0.5px;">
                                Periode: 
                                <?php 
                                    $db = \Config\Database::connect();
                                    $active = $db->table('periods')->where('is_closed', 0)->orderBy('start_date', 'ASC')->get()->getRow();
                                    echo $active ? $active->period_name : '<span class="text-danger italic">Semua Tutup</span>';
                                ?>
                            </span>
                        </div>
                    </div>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-toggle="dropdown">
                                <span class="mr-2 d-none d-lg-inline text-gray-100 small"><?= session()->get('nama') ?: 'Admin' ?></span>
                                <div class="bg-info" style="width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #000;">
                                    <i class="fas fa-user"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">
                                <a class="dropdown-item text-danger font-weight-bold" href="<?= base_url('auth/logout') ?>">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i> Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url('template/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('template/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('template/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
    <script src="<?= base_url('template/js/sb-admin-2.min.js') ?>"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>AOS.init();</script>
</body>
</html>