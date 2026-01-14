<?php
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index');

// Master Data & Jurnal
$routes->group('accounts', function($routes) {
    $routes->get('/', 'Account::index');
    $routes->get('create', 'Account::create');
    $routes->post('store', 'Account::store');
    $routes->get('edit/(:num)', 'Account::edit/$1');
    $routes->post('update/(:num)', 'Account::update/$1');
    $routes->get('delete/(:num)', 'Account::delete/$1');
});

$routes->group('journal', function($routes) {
    $routes->get('/', 'Journal::index');
    $routes->get('create', 'Journal::create');
    $routes->post('store', 'Journal::store');
    $routes->get('detail/(:num)', 'Journal::detail/$1');
    $routes->get('get_auto_number', 'Journal::get_auto_number');
});

// Laporan dengan Fitur Filter & Export [cite: 2025-11-01]
// Update rute Laba Rugi [cite: 2025-11-01]
$routes->group('profit-loss', function($routes) {
    $routes->get('/', 'ProfitLoss::index');
    $routes->get('pdf', 'ProfitLoss::exportPdf'); // Ini yang tadi 404 bro
    $routes->get('excel', 'ProfitLoss::exportExcel');
});

// Update rute Neraca [cite: 2025-11-01]
$routes->get('balance-sheet', 'Report::balanceSheet');
$routes->get('balance-sheet/pdf', 'Report::exportPdf');
$routes->get('balance-sheet/excel', 'Report::exportExcel');

$routes->get('ledger', 'Ledger::index');
$routes->get('trial-balance', 'TrialBalance::index');

// Pengaturan Periode & Penyesuaian
$routes->group('period', function($routes) {
    $routes->get('/', 'Period::index');
    $routes->post('store', 'Period::store');
    $routes->get('toggle/(:num)', 'Period::toggle/$1');
    $routes->post('update/(:num)', 'Period::update/$1');
});

$routes->group('adjustment', function($routes) {
    $routes->get('/', 'Adjustment::index');
    $routes->get('create', 'Adjustment::create');
    $routes->post('store', 'Adjustment::store');
    $routes->get('detail/(:num)', 'Adjustment::detail/$1');
});