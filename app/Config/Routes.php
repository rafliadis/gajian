<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ─── Public Routes ───────────────────────────────────────────────────────────
$routes->get('/', 'Login::index');
$routes->get('login', 'Login::index');
$routes->post('login/auth', 'Login::auth');
$routes->get('login/logout', 'Login::logout');

// ─── Admin Routes (require: admin filter) ────────────────────────────────────
$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // Departemen
    $routes->get('departemen', 'Admin\Departemen::index');
    $routes->get('departemen/create', 'Admin\Departemen::create');
    $routes->post('departemen/save', 'Admin\Departemen::save');
    $routes->get('departemen/edit/(:num)', 'Admin\Departemen::edit/$1');
    $routes->post('departemen/update/(:num)', 'Admin\Departemen::update/$1');
    $routes->get('departemen/delete/(:num)', 'Admin\Departemen::delete/$1');

    // Jabatan
    $routes->get('jabatan', 'Admin\Jabatan::index');
    $routes->get('jabatan/create', 'Admin\Jabatan::create');
    $routes->post('jabatan/save', 'Admin\Jabatan::save');
    $routes->get('jabatan/edit/(:num)', 'Admin\Jabatan::edit/$1');
    $routes->post('jabatan/update/(:num)', 'Admin\Jabatan::update/$1');
    $routes->get('jabatan/delete/(:num)', 'Admin\Jabatan::delete/$1');

    // Karyawan
    $routes->get('karyawan', 'Admin\Karyawan::index');
    $routes->get('karyawan/create', 'Admin\Karyawan::create');
    $routes->post('karyawan/save', 'Admin\Karyawan::save');
    $routes->get('karyawan/edit/(:num)', 'Admin\Karyawan::edit/$1');
    $routes->post('karyawan/update/(:num)', 'Admin\Karyawan::update/$1');
    $routes->get('karyawan/delete/(:num)', 'Admin\Karyawan::delete/$1');
    $routes->get('karyawan/detail/(:num)', 'Admin\Karyawan::detail/$1');

    // Komponen Gaji
    $routes->get('komponen-gaji', 'Admin\KomponenGaji::index');
    $routes->get('komponen-gaji/karyawan/(:num)', 'Admin\KomponenGaji::form/$1');
    $routes->post('komponen-gaji/save/(:num)', 'Admin\KomponenGaji::save/$1');

    // Payroll Run
    $routes->get('payroll', 'Admin\PayrollRun::index');
    $routes->get('payroll/buat', 'Admin\PayrollRun::create');
    $routes->post('payroll/run', 'Admin\PayrollRun::run');
    $routes->get('payroll/preview/(:num)', 'Admin\PayrollRun::preview/$1');
    $routes->post('payroll/koreksi/(:num)', 'Admin\PayrollRun::koreksi/$1');
    $routes->post('payroll/finalisasi/(:num)', 'Admin\PayrollRun::finalisasi/$1');
    $routes->get('payroll/detail/(:num)', 'Admin\PayrollRun::detail/$1');

    // Slip Gaji (Admin View)
    $routes->get('slip-gaji', 'Admin\SlipGaji::index');
    $routes->get('slip-gaji/periode/(:num)', 'Admin\SlipGaji::periode/$1');
    $routes->get('slip-gaji/cetak/(:num)', 'Admin\SlipGaji::cetak/$1');

    // Laporan
    $routes->get('laporan', 'Admin\Laporan::index');
    $routes->get('laporan/export/(:num)', 'Admin\Laporan::export/$1');

    // Akun Management
    $routes->get('akun', 'Admin\Akun::index');
    $routes->get('akun/reset-password/(:num)', 'Admin\Akun::resetPasswordForm/$1');
    $routes->post('akun/reset-password/(:num)', 'Admin\Akun::resetPassword/$1');
    $routes->get('akun/ubah-password', 'Admin\Akun::ubahPasswordForm');
    $routes->post('akun/ubah-password', 'Admin\Akun::ubahPassword');
    $routes->get('akun/buat-akun/(:num)', 'Admin\Akun::buatAkunForm/$1');
    $routes->post('akun/buat-akun/(:num)', 'Admin\Akun::buatAkun/$1');
    $routes->get('akun/toggle/(:num)', 'Admin\Akun::toggle/$1');
});

// ─── Karyawan Routes (require: auth filter) ───────────────────────────────────
$routes->group('karyawan', ['filter' => 'auth'], function ($routes) {
    $routes->get('dashboard', 'Karyawan\Dashboard::index');

    // Slip Gaji Karyawan (hanya milik sendiri)
    $routes->get('slip-gaji', 'Karyawan\SlipGaji::index');
    $routes->get('slip-gaji/detail/(:num)', 'Karyawan\SlipGaji::detail/$1');
    $routes->get('slip-gaji/download/(:num)', 'Karyawan\SlipGaji::download/$1');

    // Ubah Password
    $routes->get('akun/ubah-password', 'Karyawan\Akun::ubahPasswordForm');
    $routes->post('akun/ubah-password', 'Karyawan\Akun::ubahPassword');
});