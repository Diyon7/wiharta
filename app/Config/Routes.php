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
$routes->group('admin/', ['filter' => 'permission:datalaporan'], function ($routes) {

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

    $routes->add('karyawan/nambahkaryawan', 'Karyawan::Nambahkaryawan');
    $routes->add('karyawan/validasikaryawan', 'Karyawan::Validasikaryawan');
    $routes->add('karyawan/vkdatatables', 'Karyawan::Vkdatatables');
    $routes->add('karyawanjp3kf/datatables', 'Karyawan::Datatablesjp3kf');
    $routes->add('karyawan/karyawanbaru', 'Karyawan::Karyawanbaru');
    $routes->add('karyawan/validasikaryawanedit', 'Karyawan::Vkaryawanedit');
    $routes->add('karyawan/validasisave', 'Karyawan::Savevalidasi');
    $routes->add('karyawan/savekaryawanbaru', 'Karyawan::Savekaryawanbaru');

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
    $routes->add('karyawanjp3kf/datatables', 'Karyawan::Datatablesjp3kf');
    $routes->add('karyawanjp3k/datatables', 'Karyawan::datatablesjp3k');
    $routes->add('karyawanjp3a/add', 'Karyawan::tambahkaryawanjp3');
    $routes->add('karyawanjp3a/detaila', 'Karyawan::detailakaryawanjp3');
    $routes->add('karyawan/nambahkaryawan', 'Karyawan::Nambahkaryawan');
    $routes->add('karyawan/idpembagian', 'Karyawan::Pembagian');
    $routes->add('karyawan/edit', 'Karyawan::Edit');
    // $routes->add('karyawan/karyawanbaru', 'Karyawan::Karyawanbaru');
    $routes->add('karyawan/save', 'Karyawan::Save');
    // $routes->add('karyawan/savekaryawanbaru', 'Karyawan::Savekaryawanbaru');
    $routes->add('karyawan/keluar', 'Karyawan::Keluar');
    $routes->add('karyawan/karyawankerja', 'Karyawan::Karyawankerja');
    $routes->add('diliburkan', 'Karyawan::Diliburkan');
    $routes->add('deletediliburkan', 'Karyawan::Deletediliburkan');
    $routes->add('adddiliburkan', 'Karyawan::Adddiliburkan');
    $routes->add('diliburkan/datatables', 'Karyawan::Datatablesdiliburkan');
});

$routes->group('admin/', ['filter' => 'permission:exim'], function ($routes) {


    // export
    $routes->add('exim/searchitem', 'Exim\Saldoawalbjadi::Searchitem');
    $routes->add('exim/searchbapb', 'Exim\Pemasukanbahanbaku::Searchbapb');
    $routes->add('exim/searchajufrombapb', 'Exim\Pemasukanbahanbaku::Searchajufrombapb');
    $routes->add('exim/searchsupplier', 'Exim\Pemasukanbahanbaku::Searchsupplier');
    $routes->add('exim/searchcountryfromsupplier', 'Exim\Pemasukanbahanbaku::Searchcountryfromsupplier');
    $routes->add('exim/ajax/carikodeitem', 'Exim\Saldoawalbjadi::Searchkodeitem');


    $routes->add('exim/wkaitv', 'Exim\Eximitv::Index');
    $routes->add('exim/wkaitv/add', 'Exim\Eximitv::Add');
    $routes->add('exim/wkaitv/save', 'Exim\Eximitv::Save');
    $routes->add('exim/wkaitv/delete', 'Exim\Eximitv::Delete');
    $routes->add('exim/wkaitv/datatables', 'Exim\Eximitv::Datatables');
    $routes->add('exim/wkaitv/update', 'Exim\Eximitv::Update');


    // negara
    $routes->add('exim/negara', 'Exim\Negara::Index');
    $routes->add('exim/negara/datatables', 'Exim\Negara::Datatables');
    $routes->add('exim/negara/addnegara', 'Exim\Negara::Addnegara');

    // user
    $routes->add('exim/userloginbc', 'Exim\Userloginbc::Index');
    $routes->add('exim/userloginbc/datatables', 'Exim\Userloginbc::Datatables');

    // delterm
    $routes->add('exim/delterm', 'Exim\Delterm::Index');
    $routes->add('exim/delterm/datatables', 'Exim\Delterm::Datatables');
    $routes->add('exim/delterm/adddelterm', 'Exim\Delterm::Adddelterm');

    // kemasan
    $routes->add('exim/kemasan', 'Exim\Kemasan::Index');
    $routes->add('exim/kemasan/datatables', 'Exim\Kemasan::Datatables');
    $routes->add('exim/kemasan/addkemasan', 'Exim\Kemasan::Addkemasan');

    // produk
    $routes->add('exim/produk', 'Exim\Produk::Index');
    $routes->add('exim/produk/datatables', 'Exim\Produk::Datatables');
    $routes->add('exim/produk/addproduk', 'Exim\Produk::Addproduk');

    // satuan
    $routes->add('exim/satuan', 'Exim\Satuan::Index');
    $routes->add('exim/satuan/datatables', 'Exim\Satuan::Datatables');
    $routes->add('exim/satuan/addsatuan', 'Exim\Satuan::Addsatuan');

    // tipeproduksi
    $routes->add('exim/tipeproduksi', 'Exim\Tipeproduksi::Index');
    $routes->add('exim/tipeproduksi/datatables', 'Exim\Tipeproduksi::Datatables');
    $routes->add('exim/tipeproduksi/addtipeproduksi', 'Exim\Tipeproduksi::Addtipeproduksi');

    // port
    $routes->add('exim/port', 'Exim\Port::Index');
    $routes->add('exim/port/datatables', 'Exim\Port::Datatables');
    $routes->add('exim/port/addport', 'Exim\Port::Addport');

    // itemfg
    $routes->add('exim/itemfinishgood', 'Exim\Itemfg::Index');
    $routes->add('exim/itemfg/datatables', 'Exim\Itemfg::Datatables');
    $routes->add('exim/itemfg/additemfg', 'Exim\Itemfg::Additemfg');

    // agent
    $routes->add('exim/agent', 'Exim\Agent::Index');
    $routes->add('exim/agent/datatables', 'Exim\Agent::Datatables');
    $routes->add('exim/agent/addagent', 'Exim\Agent::Addagent');

    // data customer
    $routes->add('exim/customer', 'Exim\Customer::Index');
    $routes->add('exim/customer/datatables', 'Exim\Customer::Datatables');
    $routes->add('exim/customer/addcustomer', 'Exim\Customer::Addcustomer');

    // penyerahan
    $routes->add('barangjadi/penyerahan', 'Exim\Penyerahan::Index');
    $routes->add('barangjadi/penyerahan/datatables', 'Exim\Penyerahan::Datatables');
    $routes->add('barangjadi/penyerahan/addcustomer', 'Exim\Penyerahan::Addcustomer');

    // import
    $routes->add('exim/importbahanbaku', 'Exim\Import::Index');
    $routes->add('exim/importbahanbaku/deletedata', 'Exim\Import::Deleteimport');
    $routes->add('exim/importbahanbaku/rab', 'Exim\Import::Rab');
    $routes->add('exim/importbahanbaku/datatables', 'Exim\Import::Datatablesimport');
    $routes->add('exim/importbahanbaku/edit', 'Exim\Import::Edit');
    $routes->add('exim/importbahanbaku/saveeditimport', 'Exim\Import::Saveedit');
    $routes->add('exim/importbahanbaku/datatablesjkt', 'Exim\Import::Datatablesimportjkt');
    $routes->add('exim/tambahimportbahanbaku', 'Exim\Import::Tambah');
    $routes->add('exim/saveimport', 'Exim\Import::Saveimport');
    $routes->add('exim/import/searchitem', 'Exim\Import::Searchitem');

    // bclkt
    $routes->add('exim/bclktitv', 'Exim\Bclkt::Index');
    $routes->add('exim/bclktitv/datatables', 'Exim\Bclkt::Datatablesbclkt');
    $routes->add('exim/bclktitv/nambah', 'Exim\Bclkt::Nambah');
    $routes->add('exim/bclktitv/cancel', 'Exim\Bclkt::Cancel');
    $routes->add('exim/bclktitv/laporkanbclkt', 'Exim\Bclkt::Laporkanbclkt');

    //mutasi produksi
    $routes->add('mutasi/mutasiproduksi', 'Exim\Mutasiproduksi::Index');
    $routes->add('mutasi/mutasiproduksi/addmutasiproduksi', 'Exim\Mutasiproduksi::Addmutasiproduksi');
    $routes->add('mutasi/mutasiproduksi/searchitem', 'Exim\Mutasiproduksi::Searchitem');
    $routes->add('mutasi/mutasiproduksi/modalcetak', 'Exim\Mutasiproduksi::Modalcetak');
    $routes->add('mutasi/mutasiproduksi/searchkode2', 'Exim\Mutasiproduksi::Searchkode2');
    $routes->add('mutasi/mutasiproduksi/nambahaju', 'Exim\Mutasiproduksi::Addaju');
    $routes->add('mutasi/mutasiproduksi/tampilcetak', 'Exim\Mutasiproduksi::Cetak');
    $routes->add('mutasi/mutasiproduksi/deletemutasiproduksi', 'Exim\Mutasiproduksi::Deletemutasiproduksi');
    $routes->add('mutasi/mutasiproduksi/edit', 'Exim\Mutasiproduksi::Edit');
    $routes->add('mutasi/mutasiproduksi/editm', 'Exim\Mutasiproduksi::Editm');
    $routes->add('mutasi/mutasiproduksi/editi', 'Exim\Mutasiproduksi::Editi');
    $routes->add('mutasi/mutasiproduksi/save', 'Exim\Mutasiproduksi::Save');
    $routes->add('mutasi/mutasiproduksi/editselected', 'Exim\Mutasiproduksi::Editselected');
    $routes->add('mutasi/mutasiproduksi/savem', 'Exim\Mutasiproduksi::Savem');
    $routes->add('mutasi/mutasiproduksi/savei', 'Exim\Mutasiproduksi::Savei');
    $routes->add('mutasi/mutasiproduksi/saveaju', 'Exim\Mutasiproduksi::Saveaju');
    // $routes->group('', ['filter' => 'permission:maintenance'], function ($routes) {
    $routes->add('mutasi/mutasiproduksi/datatables', 'Exim\Mutasiproduksi::Datatablesmutasiproduksi');
    // });

    //jurnalpembelian
    $routes->add('jurnal/jurnalpembelian', 'Exim\Jurnalpembelian::Index');
    $routes->add('jurnal/bjurnalpembelian/datatables', 'Exim\Jurnalpembelian::Datatablesbjurnalpembelian');
    $routes->add('jurnal/sejurnalpembelian/datatables', 'Exim\Jurnalpembelian::Datatablessejurnalpembelian');
    $routes->add('jurnal/sejurnalpembelian/edit', 'Exim\Jurnalpembelian::Edit');
    $routes->add('jurnal/sejurnalpembelian/delete', 'Exim\Jurnalpembelian::Delete');
    $routes->add('jurnal/sejurnalpembelian/saveedit', 'Exim\Jurnalpembelian::Saveedit');
    $routes->add('jurnal/bjurnalpembelian/add', 'Exim\Jurnalpembelian::Addjurnalpembelian');
    $routes->add('jurnal/bjurnalpembelian/modalcetakperiode', 'Exim\Jurnalpembelian::Modalcetakperiode');
    $routes->add('jurnal/bjurnalpembelian/tampilcetakperiode', 'Exim\Jurnalpembelian::Cetakperiode');
    $routes->add('jurnal/bjurnalpembelian/tampilcetakkode', 'Exim\Jurnalpembelian::Cetakkode');
    $routes->add('jurnal/jurnalpembelian/savetambahjurnalpembelian', 'Exim\Jurnalpembelian::Savejurnalpembelian');

    //jurnalpenjualan
    $routes->add('jurnal/jurnalpenjualan', 'Exim\Jurnalpenjualan::Index');
    $routes->add('jurnal/jurnalpenjualan/nambahjurnal', 'Exim\Jurnalpenjualan::Addjurnalpenjualan');
    $routes->add('jurnal/jurnalpenjualan/edit', 'Exim\Jurnalpenjualan::Edit');
    $routes->add('jurnal/jurnalpenjualan/saveedit', 'Exim\Jurnalpenjualan::Saveedit');
    $routes->add('jurnal/jurnalpenjualan/modalcetakperiode', 'Exim\Jurnalpenjualan::Modalcetakperiode');
    $routes->add('jurnal/jurnalpenjualan/tampilcetakperiode', 'Exim\Jurnalpenjualan::Cetakperiode');
    $routes->add('jurnal/jurnalpenjualan/tampilcetakkode', 'Exim\Jurnalpenjualan::Cetakkode');
    $routes->add('jurnal/semuajurnalpenjualan/datatables', 'Exim\Jurnalpenjualan::Datatablessemuajurnalpenjualan');
    $routes->add('jurnal/belumjurnalpenjualan/datatables', 'Exim\Jurnalpenjualan::Datatablesbelumjurnalpenjualan');
    $routes->add('jurnal/jurnalpenjualan/savetambahjurnalpenjualan', 'Exim\Jurnalpenjualan::Savejurnalpenjualan');

    //jurnalpenerimaanbank
    $routes->add('jurnal/jurnalpenerimaanbank', 'Exim\Jurnalpenerimaanbank::Index');
    $routes->add('jurnal/jurnalpenerimaanbank/datatables', 'Exim\Jurnalpenerimaanbank::Datatablesjurnalpenerimaanbank');
    $routes->add('jurnal/jurnalpenerimaanbank/edit', 'Exim\Jurnalpenerimaanbank::Edit');
    $routes->add('jurnal/jurnalpenerimaanbank/deletejurnal', 'Exim\Jurnalpenerimaanbank::Deletejurnal');
    $routes->add('jurnal/jurnalpenerimaanbank/tambah', 'Exim\Jurnalpenerimaanbank::Nambah');
    $routes->add('jurnal/jurnalpenerimaanbank/tampilcetakkode', 'Exim\Jurnalpenerimaanbank::Cetakkode');
    $routes->add('jurnal/jurnalpenerimaanbank/serversideinv', 'Exim\Jurnalpenerimaanbank::Serversideinv');
    $routes->add('jurnal/jurnalpenerimaanbank/serversideaju', 'Exim\Jurnalpenerimaanbank::Serversideaju');
    $routes->add('jurnal/jurnalpenerimaanbank/addjurnalpenerimaanbank', 'Exim\Jurnalpenerimaanbank::Addjurnalpenerimaanbank');
    $routes->add('jurnal/jurnalpenerimaanbank/saveeditjurnalpenerimaanbank', 'Exim\Jurnalpenerimaanbank::Saveeditjurnalpenerimaanbank');

    //jurnalpengeluaranbank
    $routes->add('jurnal/jurnalpengeluaranbank', 'Exim\Jurnalpengeluaranbank::Index');
    $routes->add('jurnal/jurnalpengeluaranbank/tambah', 'Exim\Jurnalpengeluaranbank::Tambah');
    $routes->add('jurnal/jurnalpengeluaranbank/tampilcetakkode', 'Exim\Jurnalpengeluaranbank::Cetakkode');
    $routes->add('jurnal/jurnalpengeluaranbank/datatables', 'Exim\Jurnalpengeluaranbank::Datatablesjurnalpengeluaranbank');
    $routes->add('jurnal/jurnalpengeluaranbank/edit', 'Exim\Jurnalpengeluaranbank::Edit');
    $routes->add('jurnal/jurnalpengeluaranbank/serversideaju', 'Exim\Jurnalpengeluaranbank::Serversideaju');
    $routes->add('jurnal/jurnalpengeluaranbank/serversideinv', 'Exim\Jurnalpengeluaranbank::Serversideinv');
    $routes->add('jurnal/jurnalpengeluaranbank/deletejurnal', 'Exim\Jurnalpengeluaranbank::Deletejurnal');
    $routes->add('jurnal/jurnalpengeluaranbank/addjurnalpengeluaranbank', 'Exim\Jurnalpengeluaranbank::Addjurnalpengeluaranbank');
    $routes->add('jurnal/jurnalpengeluaranbank/saveeditjurnalpengeluaranbank', 'Exim\Jurnalpengeluaranbank::Saveeditjurnalpengeluaranbank');

    $routes->add('jurnal/jurnalproduksi/addjurnalproduksi', 'Exim\jurnalproduksi::Addjurnalproduksi');
    $routes->add('jurnal/jurnalproduksi/nambahaju', 'Exim\jurnalproduksi::Addaju');
    $routes->add('jurnal/jurnalproduksi/deletejurnalproduksi', 'Exim\jurnalproduksi::Deletejurnalproduksi');
    $routes->add('jurnal/jurnalproduksi/edit', 'Exim\jurnalproduksi::Edit');
    $routes->add('jurnal/jurnalproduksi/editm', 'Exim\jurnalproduksi::Editm');
    $routes->add('jurnal/jurnalproduksi/editi', 'Exim\jurnalproduksi::Editi');
    $routes->add('jurnal/jurnalproduksi/save', 'Exim\jurnalproduksi::Save');
    $routes->add('jurnal/jurnalproduksi/savem', 'Exim\jurnalproduksi::Savem');
    $routes->add('jurnal/jurnalproduksi/savei', 'Exim\jurnalproduksi::Savei');
    $routes->add('jurnal/jurnalproduksi/saveaju', 'Exim\jurnalproduksi::Saveaju');

    //mutasi export
    $routes->add('mutasi/mutasiekspor', 'Exim\Exportmutasi::Index');
    $routes->add('mutasi/mutasiekspor/addekspormutasi', 'Exim\Exportmutasi::Addexport');
    $routes->add('mutasi/mutasiekspor/deleteekspormutasi', 'Exim\Exportmutasi::Deleteexport');
    $routes->add('mutasi/mutasiekspor/edit', 'Exim\Exportmutasi::Edit');
    $routes->add('mutasi/mutasiekspor/modalcetak', 'Exim\Exportmutasi::Modalcetak');
    $routes->add('mutasi/mutasiekspor/nambahaju', 'Exim\Exportmutasi::Nambahaju');
    $routes->add('mutasi/mutasiekspor/editi', 'Exim\Exportmutasi::Editi');
    $routes->add('mutasi/mutasiekspor/save', 'Exim\Exportmutasi::Save');
    $routes->add('mutasi/mutasiekspor/savei', 'Exim\Exportmutasi::Savei');
    $routes->add('mutasi/mutasiekspor/saveaju', 'Exim\Exportmutasi::Saveaju');
    $routes->add('mutasi/mutasiekspor/tampilcetak', 'Exim\Exportmutasi::Cetak');
    $routes->add('mutasi/mutasiekspor/datatables', 'Exim\Exportmutasi::Datatablesexport');

    $routes->add('bahanbaku/pemasukan', 'Exim\Pemasukanbahanbaku::Index');
    $routes->add('bahanbaku/pemasukan/edit', 'Exim\Pemasukanbahanbaku::Editpemasukan');
    $routes->add('bahanbaku/pemasukan/datatables', 'Exim\Pemasukanbahanbaku::Datatablespemasukanbahanbaku');
});
$routes->group('admin/', ['filter' => 'permission:potong'], function ($routes) {

    // item
    $routes->add('potong/tipeitem', 'Potong\Item::Index');
    $routes->add('potong/tipeitem/datatables', 'Potong\Item::Datatablestipeitem');
    $routes->add('potong/tipe/datatables', 'Potong\Item::Datatablestipe');
    $routes->add('potong/item/datatables', 'Potong\Item::Datatablesitem');
    $routes->add('potong/tipeitem/edit', 'Potong\Item::Tipeitemedit');
    $routes->add('potong/tipe/edit', 'Potong\Item::Tipeedit');
    $routes->add('potong/tipeitem/save', 'Potong\Item::Savetipeitem');
    $routes->add('potong/tipe/save', 'Potong\Item::Savetipe');
    $routes->add('potong/tambahtipedtl', 'Potong\Item::Tambahtipedtl');
    $routes->add('potong/tambahtipe', 'Potong\Item::Tambahtipe');
    $routes->add('potong/tambahitem', 'Potong\Item::Tambahitem');

    // produksi
    $routes->add('potong/rcnproduksi', 'Potong\Rcnproduksi::Index');
    $routes->add('potong/item/datatables', 'Potong\Item::Datatablestipeitem');
    $routes->add('potong/item/edit', 'Potong\Item::Edit');
    $routes->add('potong/tipeitem/save', 'Potong\Item::Savetipeitem');
    $routes->add('potong/tambahtipedtl', 'Potong\Item::Tambahtipedtl');

    // rencana produksi
    $routes->add('potong/tambahrcn', 'Potong\Rcnproduksi::Tambahrencana');
    $routes->add('potong/carircn', 'Potong\Rcnproduksi::Carircn');
    $routes->add('potong/tambahdetailrcn', 'Potong\Rcnproduksi::Tambahdetailrencana');
    $routes->add('potong/rencana/datatables', 'Potong\Rcnproduksi::Datatablesrcn');
    $routes->add('potong/rencana/delete', 'Potong\Rcnproduksi::Delete');
    $routes->add('potong/rencana/edit', 'Potong\Rcnproduksi::Edit');
    $routes->add('potong/rencana/datatablesbalance', 'Potong\Rcnproduksi::Datatablesrabalance');

    // proses produksi
    $routes->add('potong/prosesproduksi', 'Potong\Prosesproduksi::Index');
    $routes->add('potong/carirls', 'Potong\Prosesproduksi::Carirls');
    $routes->add('potong/tambahdetailri', 'Potong\Prosesproduksi::Tambahdetailrealisasi');
    $routes->add('potong/tambahsaldori', 'Potong\Prosesproduksi::Tambahsaldorealisasi');
    $routes->add('potong/tambahproses', 'Potong\Prosesproduksi::Tambahrencana');
    $routes->add('potong/cariproses', 'Potong\Prosesproduksi::Cariproses');
    $routes->add('potong/tambahdetailproses', 'Potong\Prosesproduksi::Tambahdetailrencana');
    $routes->add('potong/realisasi/datatables', 'Potong\Prosesproduksi::Datatablesri');
    $routes->add('potong/realisasi/datatablesbalance', 'Potong\Prosesproduksi::Datatablesribalance');
    $routes->add('potong/realisasi/delete', 'Potong\Prosesproduksi::Delete');
    $routes->add('potong/realisasi/edit', 'Potong\Prosesproduksi::Edit');
    $routes->add('potong/realisasi/saverealisasi', 'Potong\Prosesproduksi::Saverealisasi');
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