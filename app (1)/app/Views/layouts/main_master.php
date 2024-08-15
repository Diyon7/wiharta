<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title; ?></title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/summernote/summernote-bs4.min.css">
    <script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= base_url() ?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/select2/js/select2.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/jszip/jszip.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse nav-compact nav-child-indent">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= base_url() ?>/assets/dist/img/WIHARTA.png" alt="WIHARTA KARYA AGUNG"
                height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <div class="media">
                                <img src="<?= base_url() ?>/assets/dist/img/user1-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item"> -->
                <!-- <div class="media">
                                <img src="<?= base_url() ?>/assets/dist/img/user8-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div> -->
                <!-- </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li> -->
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <?= user()->username ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- <span class="dropdown-item">15 Notifications</span> -->
                        <div class="dropdown-divider"></div>
                        <a href="<?= base_url() ?>/logout" class="dropdown-item">
                            Logout
                        </a>
                        <!-- <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
                    </div>
                </li>
                <!--<li class="nav-item">-->
                <!--    <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"-->
                <!--        role="button">-->
                <!--        <i class="fas fa-th-large"></i>-->
                <!--    </a>-->
                <!--</li>-->
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url() ?>" class="brand-link">
                <img src="<?= base_url() ?>/assets/dist/img/avatar.png" alt="WIHARTA"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= $devisi ? $devisi : 'DASHBOARD SDM' ?></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">

                <!-- SidebarSearch Form -->
                <!-- <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div> -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <?php if (has_permission('dashboard')) : ?>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>/admin"
                                class="nav-link <?= $halaman == 'Dashboard' ? 'active' : 'DASHBOARD SDM' ?>">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    HOME
                                </p>
                            </a>
                        </li>
                        <?php endif ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    LAPORAN
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php if (has_permission('laporanbulanan')) : ?>
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/admin/laporanbulanan"
                                        class="nav-link <?= $halaman == 'Laporan Bulanan' ? 'active' : 'DASHBOARD SDM' ?>">
                                        <i class="far fa-file nav-icon"></i>
                                        <p>LAPORAN BULANAN</p>
                                    </a>
                                </li>
                                <?php endif ?>
                                <?php if (has_permission('logkaryawan')) : ?>
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/admin/logkaryawan"
                                        class="nav-link <?= $halaman == 'Log Karyawan' ? 'active' : 'DASHBOARD SDM' ?>">
                                        <i class="far fa-file nav-icon"></i>
                                        <p>LOG KARYAWAN</p>
                                    </a>
                                </li>
                                <?php endif ?>
                                <?php if (has_permission('laporanharian')) : ?>
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/admin/rekap"
                                        class="nav-link <?= $halaman == 'Laporan Harian' ? 'active' : 'DASHBOARD SDM' ?>">
                                        <i class="far fa-file nav-icon"></i>
                                        <p>LAPORAN HARIAN</p>
                                    </a>
                                </li>
                                <?php endif ?>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-inbox"></i>
                                <p>
                                    PENGECUALIAN
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <?php if (has_permission('izin')) : ?>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/admin/izin"
                                        class="nav-link <?= $halaman == 'Izin' ? 'active' : 'DASHBOARD SDM' ?>">
                                        <i class="far fa-file nav-icon"></i>
                                        <p>izin</p>
                                    </a>
                                </li>
                            </ul>
                            <?php endif ?>
                            <?php if (has_permission('izin')) : ?>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/admin/gantishift"
                                        class="nav-link <?= $halaman == 'Ganti Shift' ? 'active' : 'DASHBOARD SDM' ?>">
                                        <i class="far fa-file nav-icon"></i>
                                        <p>Ganti shift</p>
                                    </a>
                                </li>
                            </ul>
                            <?php endif ?>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/admin/logizin"
                                        class="nav-link <?= $halaman == 'Log Izin' ? 'active' : 'DASHBOARD SDM' ?>">
                                        <i class="far fa-file nav-icon"></i>
                                        <p>log izin</p>
                                    </a>
                                </li>
                            </ul>
                            <?php if (has_permission('gantigrupsementara')) : ?>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/admin/gantigrupsementara" class="nav-link">
                                        <i class="far fa-file nav-icon"></i>
                                        <p>Merubah Grup</p>
                                    </a>
                                </li>
                            </ul>
                            <?php endif ?>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-inbox"></i>
                                <p>
                                    VALIDASI
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <?php if (has_permission('validasiizin')) : ?>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/admin/validasi/gantishift"
                                        class="nav-link <?= $halaman == 'Validasi Ganti Shift' ? 'active' : 'DASHBOARD SDM' ?>">
                                        <i class="far fa-file nav-icon"></i>
                                        <p>validasi Ganti Shift</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/admin/validasi/izin"
                                        class="nav-link <?= $halaman == 'Validasi Izin' ? 'active' : 'DASHBOARD SDM' ?>">
                                        <i class="far fa-file nav-icon"></i>
                                        <p>validasi Izin</p>
                                    </a>
                                </li>
                            </ul>
                            <?php endif ?>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>
                                    DATA
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php if (has_permission('datakaryawan')) : ?>
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/admin/karyawan"
                                        class="nav-link <?= $halaman == 'Karyawan' ? 'active' : 'DASHBOARD SDM' ?>">
                                        <i class="far fa-file nav-icon"></i>
                                        <p>KARYAWAN</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= base_url() ?>/admin/diliburkan" class="nav-link">
                                        <i class="far fa-file nav-icon"></i>
                                        <p>DILIBURKAN</p>
                                    </a>
                                </li>
                                <?php endif ?>
                                <!-- <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>TAGIHAN HARI KERJA</p>
                                    </a>
                                </li> -->
                            </ul>
                        </li>
                        <li class="nav-item">
                            <!--<a href="#" class="nav-link">-->
                            <!--    <i class="nav-icon fas fa-calendar"></i>-->
                            <!--    <p>-->
                            <!--        Jadwal-->
                            <!--        <i class="fas fa-angle-left right"></i>-->
                            <!--    </p>-->
                            <!--</a>-->
                            <ul class="nav nav-treeview">
                                <!-- <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>To</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Be</p>
                                    </a>
                                </li> -->
                                <!-- <li class="nav-item">
                                    <a href="pages/UI/buttons.html" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Buttons</p>
                                    </a>
                                </li> -->
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?= $halaman ?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>/admin">Home</a></li>
                                <li class="breadcrumb-item active"><?= $halaman ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <div class="flash-data" data-flashdata="<?= session()->getFlashdata('success') ?>"></div>
            <div class="flash-data-e" data-flashdata="<?= session()->getFlashdata('error') ?>"></div>
            <?php if (session()->has('success')) : ?>

            <?php endif; ?>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <?= $this->renderSection('isi'); ?>

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Made By ❤️ WIHARTA KARYA AGUNG</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                Theme &copy; <a href="#"> AdminLTE</a>.
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
    $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="<?= base_url() ?>/assets/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?= base_url() ?>/assets/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="<?= base_url() ?>/assets/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?= base_url() ?>/assets/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?= base_url() ?>/assets/plugins/moment/moment.min.js"></script>
    <script src="<?= base_url() ?>/assets/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Summernote -->
    <script src="<?= base_url() ?>/assets/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= base_url() ?>/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/assets/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!--<script src="<?= base_url() ?>/assets/dist/js/demo.js"></script>-->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?= base_url() ?>/assets/dist/js/pages/dashboard.js"></script>
</body>
<script type="text/javascript">
const flashData = $('.flash-data').data('flashdata');
if (flashData) {
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 15000
        });
        Toast.fire({
            icon: 'success',
            title: flashData,
            type: 'success',
        });

    });
}
const flashDatae = $('.flash-data-e').data('flashdata');
if (flashDatae) {
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: true,
            timerProgressBar: true,
            // timer: 10000
        });
        Toast.fire({
            icon: 'error',
            title: flashDatae,
            type: 'success',
        });

    });
}
$(function() {
    // Summernote
    $('.textarea').summernote()
})
</script>

</html>