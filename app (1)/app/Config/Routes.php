<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/',  'Dashboard::Index', ['filter' => 'permission:dashboard']);
$routes->group('admin/', ['filter' => 'permission:laporanbulanan'], function ($routes) {

    $routes->get('gantigrupsementara', 'Grup::Index');

    $routes->get('laporanbulanan', 'Laporan::Laporanbulanan');
    $routes->add('laporan/tabellaporanbulanan', 'Laporan::Tabelabsenlaporanbulanan');
    $routes->add('laporan/tabeldivlaporanbulanan', 'Laporan::Tabelabsendivlaporanbulanan');
    $routes->add('laporan/tabeltanlaporanbulanan', 'Laporan::Tabelabsentanlaporanbulanan');

    $routes->get('rekap', 'Rekap::Index');

    $routes->add('rekap/tabellaporanharian', 'Rekap::Tabelabsenlaporanharian');
    $routes->add('rekap', 'Rekap::Addrekap');
    $routes->add('rekap/detailunit', 'Rekap::Detaildataunit');

    $routes->add('izin', 'Izin::index');
    $routes->add('gantishift', 'Jamkerja::gantishift');
    $routes->add('validasi/gantishift', 'Jamkerja::validasi');
    $routes->add('deletegantishift', 'Jamkerja::Deletegantishift');
    $routes->add('tambahgantishift', 'Jamkerja::tambahgantishift');
    $routes->add('gantishift/datatables', 'Jamkerja::Datatablesgantijamkerja');
    $routes->add('validasi/izin', 'Izin::validasi');
    $routes->add('izin/tambahizin', 'Izin::Addizin');
    
    $routes->add('formjamkerja/datatables', 'Jamkerja::Formjamkerja');
    $routes->add('formpjamkerja/datatables', 'Jamkerja::Formpjamkerja');
    $routes->add('formtjamkerja/datatables', 'Jamkerja::Formtjamkerja');

    $routes->add('logizin', 'Izin::Logizin');

    $routes->add('logkaryawan', 'Karyawan::Logkaryawan');
    $routes->add('logkaryawan/datatables', 'Karyawan::Datatableslogkaryawan');

    $routes->add('logizin/datatables', 'Izin::Datatableslogizin');


    $routes->add('izin/datanamaform', 'Izin::Ajaxform');
    $routes->add('izin/delete', 'Izin::Delete');
    $routes->add('izin/ubahbs', 'Izin::Ubahbs');
    $routes->add('izin/ubahbt', 'Izin::Ubahbt');
    $routes->add('izin/fio', 'Izin::Fio');

    $routes->add('printrekap/rekapunit', 'Rekap::Printrekapunit');
    $routes->add('formizin/datatables', 'Izin::Formizin');
    $routes->add('formpizin/datatables', 'Izin::Formpizin');
    $routes->add('formphizin/datatables', 'Izin::Formphizin');
    $routes->add('formtizin/datatables', 'Izin::Formtizin');
    
});

$routes->group('admin/', ['filter' => 'permission:dashboard'], function ($routes) {
    $routes->get('', 'Dashboard::Index');
    $routes->add('dashboard/moreinfo', 'Dashboard::Detail');
});

$routes->group('admin/', ['filter' => 'permission:datakaryawan'], function ($routes) {
    $routes->get('karyawan', 'Karyawan::Index');
    $routes->add('karyawanjp3a/datatables', 'Karyawan::datatablesjp3a');
    $routes->add('karyawanjp3k/datatables', 'Karyawan::datatablesjp3k');
    $routes->add('karyawanjp3a/add', 'Karyawan::tambahkaryawanjp3');
    $routes->add('karyawanjp3a/detaila', 'Karyawan::detailakaryawanjp3');
    $routes->add('karyawan/tambahkaryawan', 'Karyawan::Add');
    $routes->add('karyawan/idpembagian', 'Karyawan::Pembagian');
    $routes->add('karyawan/edit', 'Karyawan::Edit');
    $routes->add('karyawan/save', 'Karyawan::Save');
    $routes->add('karyawan/keluar', 'Karyawan::Keluar');
    $routes->add('karyawan/karyawankerja', 'Karyawan::Karyawankerja');
    $routes->add('diliburkan', 'Karyawan::Diliburkan');
    $routes->add('deletediliburkan', 'Karyawan::Deletediliburkan');
    $routes->add('adddiliburkan', 'Karyawan::Adddiliburkan');
    $routes->add('diliburkan/datatables', 'Karyawan::Datatablesdiliburkan');
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}