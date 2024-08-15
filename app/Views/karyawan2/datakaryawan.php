<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<?php
error_reporting(0);
include "koneksihrd.php";
if (isset($_POST['submit'])) {
  $idkar = $_POST['idkar'];
  $nama = $_POST['nama'];
  $grup = $_POST['grup'];
  $tmt = $_POST['tmt'];
  $bagian = $_POST['bagian'];
  $vendor = $_POST['vendor'];
  $kven = $_POST['kven'];
  $kdvsql = mysql_query("select nvendor from tb_vendor where kodev='$kven'");
  while ($ven = mysql_fetch_array($kdvsql)) {
    $vend = $ven['nvendor'];
  }
  $sqladdkar = mysql_query("insert into tb_karyawan(idkar,asal,nama,bagian,grup,tmt,idkar2,resign) values('$idkar','$vend','$nama','$bagian','$grup','$tmt','$idkar',0)");
  header("location:datakaryawan.php?tambah");
}
if (isset($_POST['submit2'])) {
  $idkar = $_POST['idkar'];

  $grup = $_POST['grup'];
  $sqlfgr = mysql_query("select grup from tb_karyawan where idkar='$idkar'");
  while ($fgr = mysql_fetch_array($sqlfgr)) {
    $fgrup = $fgr['grup'];
  }
  $kven = $_POST['kven'];
  $kdvsql = mysql_query("select nvendor from tb_vendor where kodev='$kven'");
  while ($ven = mysql_fetch_array($kdvsql)) {
    $vend = $ven['nvendor'];
  }
  $sqlgt = mysql_query("update tb_karyawan set grup='$grup' where idkar='$idkar' and asal='$vend'");
  $sqlgt2 = mysql_query("insert into tb_ganti_grup(vendor,idkar,from_grup,to_grup,time) values('$vend','$idkar','$fgrup','$grup',now())");
  header("location:datakaryawan.php");
}
if (isset($_POST['submit3'])) {

  $seq = $_POST['seq'];
  $idkar = $_POST['idkar'];
  $asal = $_POST['asl'];
  $nkar = $_POST['nkar'];
  $bag = $_POST['bag'];
  $grup = $_POST['grup'];
  $tmt = $_POST['tmt'];
  $rs = $_POST['rs'];
  $harikerja = $_POST['harikerja'];

  $sqledit = mysql_query("UPDATE tb_karyawan SET nama='$nkar',bagian='$bag',asal='$asal',grup='$grup',tmt='$tmt',resign='$rs' WHERE idkar='$idkar' AND seq='$seq'");
  header("location:datakaryawan.php?seq=$seq&rs=$rs&id=$idkar");
}
if (isset($_POST['submit4'])) {

  $idkar = $_POST['idkar'];
  $nama = $_POST['nama'];
  $grup = $_POST['grup'];
  $tmt = $_POST['tmt'];
  $bagian = $_POST['bagian'];
  $vendor = $_POST['vendor'];

  $sqledit = mysql_query("INSERT INTO tb_karyawan(idkar,asal,nama,bagian,grup,tmt,idkar2,resign) VALUE('$idkar','$vendor','$nama','$bagian','$grup','$tmt','$idkar',0)");
  header("location:datakaryawan.php?baru");
}
if (isset($_POST['submit5'])) {

  $nama = $_POST['nama'];
  $sqledit = mysql_query("INSERT INTO tb_bagian(namab) VALUE('$nama')");
  header("location:datakaryawan.php");
}
if (isset($_POST['submit6'])) {

  // $grup = $_POST['grup'];
  // $mtagihan = $_POST['mtagihan'];
  // $kkerja = $_POST['kkerja'];
  // $bulantahun = $_POST['bulan'];
  // $bulan = substr($bulantahun, 0, -5);
  // $tahun = substr($bulantahun, 3);
  // $sqledit = mysql_query("INSERT INTO tb_nilaikerja VALUE('$grup','$mtagihan','$kkerja','$bulan','$tahun')");
  // header("location:datakaryawan.php");
}
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Aplikasi HRD</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="plugins/sweetalert2/sweetalert2.min.css" />

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    <script>
    // $(document).ready(function() {
    //   $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    //     localStorage.setItem('activeTab', $(e.target).attr('href'));
    //   });
    //   var activeTab = localStorage.getItem('activeTab');
    //   if (activeTab) {
    //     $('#custom-tabs-three-slip a[href="' + activeTab + '"]').tab('show');
    //   }
    // });
    </script>
    <style>
    .table-condensed thead tr:nth-child(2) {
        display: none;
    }

    .table-condensed tbody {
        display: none;
    }
    </style>
</head>

<body class="hold-transition layout-top-nav">
    <!-- Site wrapper -->
    <div class="wrapper">

        <?php
    include "nav.php";
    ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">DATA KARYAWAN</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">

                            <ol class="breadcrumb float-sm-right">
                                <!-- <a href="datakaryawan.php?tambah">
                  <button class="btn btn-primary btn-flat">+ Tambah Karyawan!</button>
                </a> -->
                                <a href="#">
                                    <button class="btn btn-primary btn-flat" data-toggle="modal"
                                        data-target="#harikerja">+ Hari Kerja</button>
                                </a>
                                <a href="#">
                                    <button class="btn btn-primary btn-flat" data-toggle="modal"
                                        data-target="#bagianl">+ Bagian</button>
                                </a>
                                <a href="datakaryawan.php?ganti">
                                    <button class="btn btn-success btn-flat">+ Ganti Group!</button>
                                </a>
                            </ol>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->


            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <section class="content">
                        <div class="container-fluid">

                            <?php

              $employeeactive = mysql_query("SELECT * FROM tb_karyawan WHERE resign=0");

              ?>

                            <div class="card text-white bg-success ms-5" style="max-width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title">data karyawan aktif</h5>
                                    <p class="card-text"><?php echo mysql_num_rows($employeeactive) ?></p>
                                </div>
                            </div>


                            <br>
                            <?php
              if (isset($_GET['tambah'])) {

              ?>
                            <form method="POST" action="datakaryawan.php" id="form">


                                <div class="input-group input-group">


                                </div><!-- /.form-group -->

                                <div class="input-group input-group-sm">
                                    <label>ID:</label>
                                    <input type="text" class="form-control" name="idkar" id="idkar"
                                        placeholder="NOMOR ID">
                                    <label>NAMA:</label>
                                    <input type="text" class="form-control" name="nama" id="nama" placeholder="NAMA">
                                    <label>Group:</label>
                                    <input type="text" class="form-control" name="grup" id="grup"
                                        placeholder="Grup Kerja">
                                    <label>TMT:</label>
                                    <input type="date" class="form-control" name="tmt" id="tmt" placeholder="TMT">

                                    <select class="form-control select2" name="bagian" id="bagian">
                                        <option value="%">Pilih Bagian</option>
                                        <?php
                      $sqlbag = mysql_query("select bagian from tb_karyawan group by bagian");
                      while ($bg = mysql_fetch_array($sqlbag)) { ?>
                                        <option value="<?php echo $bg['bagian']; ?>"><?php echo $bg['bagian']; ?>
                                        </option>
                                        <?php
                      }
                      ?>
                                    </select>


                                    <input type="password" class="form-control" name="kven" id="kven"
                                        placeholder="KODE VENDOR">
                                    <span class="input-group-append">
                                        <button type="submit" name="submit" id="submit"
                                            class="btn btn-primary btn-flat">SIMPAN!</button>
                                    </span>
                                </div>
                            </form>
                            <?php
              }
              ?>

                            <div class="modal fade" id="harikerja" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">HARI KERJA</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Tambah HARI KERJA</h4>
                                            <form method="POST" action="proseskaryawan.php?action=inputnilaikaryawan"
                                                class="insertnilaikaryawan" id="form">
                                                <div class="input-group input-group-sm">
                                                    <label>Grup</label>
                                                    <select class="form-control mx-sm-1" name="grup"
                                                        id="grupnilaikerja">
                                                        <?php
                            $gruptambah = mysql_query("SELECT grup FROM tb_nilaikerja GROUP BY grup");

                            while ($grup2 = mysql_fetch_array($gruptambah)) {
                              if ($grup2['grup'] == "NS1") {
                            ?>
                                                        <option value="<?php echo $grup2['grup'] ?>"> NS (21 Tagian
                                                            Kerja)</option>
                                                        <?php
                              } elseif ($grup2['grup'] == "NS2") {
                              ?>
                                                        <option value="<?php echo $grup2['grup'] ?>"> NS (25 Tagian
                                                            Kerja)</option>
                                                        <?php
                              } else {
                              ?>
                                                        <option value="<?php echo $grup2['grup'] ?>">
                                                            <?php echo $grup2['grup'] ?></option>
                                                        <?php
                              }
                            }

                            ?>
                                                    </select>
                                                    <label>HTagihan</label>
                                                    <input type="number" class="form-control mx-sm-1" name="mtagihan"
                                                        id="mtagihan" placeholder="Nilai Tagian">
                                                    <label>HKerja</label>
                                                    <input type="number" class="form-control mx-sm-1" name="kkerja"
                                                        id="kkerja" placeholder="Maks Kerja">
                                                    <label>Bln/Th</label>
                                                    <input type="text" class="form-control mx-sm-1" name="bulan"
                                                        id="bulan" value="<?= date('m/Y') ?>" readonly>
                                                    <span class="input-group-append">
                                                        <button type="submit" name="submit6" id="submit6"
                                                            class="btn btn-primary btn-flat btn-inkerja">SIMPAN!</button>
                                                    </span>
                                                </div>
                                            </form>

                                            <?php
                      $bagian = mysql_query("SELECT * FROM tb_nilaikerja");
                      ?>

                                            <div class="dropdown-divider"></div>

                                            <div class="container-fluid">
                                                <table id="example10" class="table table-striped table-bordered"
                                                    style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>NOMOR ID</th>
                                                            <th>GRUP</th>
                                                            <th>KERJA MAKS TAGIHAN</th>
                                                            <th>KALENDER KERJA</th>
                                                            <th>BULAN - TAHUN</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="bagianl" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Bagian</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Tambah Bagian</h4>
                                            <form method="POST" action="datakaryawan.php" id="form">
                                                <div class="input-group input-group-sm">
                                                    <label>Nama:</label>
                                                    <input type="text" class="form-control mx-sm-3" name="nama"
                                                        id="nama" placeholder="Nama Bagian">
                                                    <span class="input-group-append">
                                                        <button type="submit" name="submit5" id="submit5"
                                                            class="btn btn-primary btn-flat">SIMPAN!</button>
                                                    </span>
                                                </div>
                                            </form>

                                            <?php
                      $bagian = mysql_query("SELECT * FROM tb_bagian");
                      ?>

                                            <div class="dropdown-divider"></div>

                                            <table id="example9" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead class="col">
                                                    <tr>
                                                        <th>NOMOR ID</th>
                                                        <th>NAMA BAGIAN</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($dt3 = mysql_fetch_array($bagian)) {
                          ?>
                                                    <tr>
                                                        <td><?php echo $dt3['id']; ?></td>
                                                        <td><?php echo $dt3['namab']; ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <?php
              if (isset($_GET['ganti'])) {

              ?>
                            <form method="POST" action="datakaryawan.php" id="form">


                                <div class="input-group input-group">


                                </div><!-- /.form-group -->

                                <div class="input-group input-group-sm">
                                    <label>PILIH KARYAWAN:</label>

                                    <select class="form-control select2" name="idkar" id="idkar">
                                        <?php
                      $sqlbag = mysql_query("select idkar,nama from tb_karyawan ");
                      while ($bg = mysql_fetch_array($sqlbag)) { ?>
                                        <option value="<?php echo $bg['idkar']; ?>">
                                            <?php echo $bg['idkar'] . ' || ' . $bg['nama']; ?></option>
                                        <?php
                      }
                      ?>
                                    </select>

                                    <select name="grup" id="grup">
                                        <option value="">Pilih grup</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="R">R</option>
                                        <option value="S">S</option>
                                        <option value="T">T</option>
                                        <option value="K">K</option>
                                        <option value="L">L</option>
                                        <option value="NS">NS</option>
                                    </select>

                                    <input type="password" class="form-control" name="kven" id="kven"
                                        placeholder="KODE VENDOR">
                                    <span class="input-group-append">
                                        <button type="submit" name="submit2" id="submit2"
                                            class="btn btn-primary btn-flat">SIMPAN!</button>
                                    </span>
                                </div>
                            </form>
                            <?php
              }
              ?>
                            <br>
                            <?php
              if (isset($_GET['edit'])) {
                $seq = $_GET['seq'];
                $sqledit = mysql_query("select * from tb_karyawan where seq='$seq' ");
                while ($ed = mysql_fetch_array($sqledit)) {
                  $idkar = $ed['idkar'];
                  $asl = $ed['asal'];
                  $nkar = $ed['nama'];
                  $bag = $ed['bagian'];
                  $grup = $ed['grup'];
                  $tmt = $ed['tmt'];
                  // $grup_t = $ed['grup_t'];
                  $rs = $ed['resign'];
                }
              ?>
                            <form method="POST" action="datakaryawan.php" id="form">


                                <div class="input-group input-group">


                                </div><!-- /.form-group -->

                                <div class="input-group input-group-sm">
                                    <input type="text" hidden class="form-control" name="seq" id="seq"
                                        value="<?php echo $seq; ?>">
                                    <input type="text" hidden class="form-control" name="idkar" id="idkar"
                                        value="<?php echo $idkar; ?>">
                                    <input type="text" readonly class="form-control" name="info" id="info"
                                        value="<?php echo $idkar ?> ">
                                    <select name="asl" id="asl">
                                        <?php
                      $sqlvendor = mysql_query("select nvendor,kodev from tb_vendor ");
                      while ($kv = mysql_fetch_array($sqlvendor)) {
                        if ($asl == $kv['nvendor']) {
                      ?>

                                        <option value="<?php echo $kv['nvendor']; ?>" selected>
                                            <?php echo $kv['nvendor']; ?></option>

                                        <?php
                        } else {

                        ?>
                                        <option value="<?php echo $kv['nvendor']; ?>"><?php echo $kv['nvendor']; ?>
                                        </option>
                                        <?php

                        }
                      }
                      ?>
                                    </select>
                                    <!-- <input type="text" class="form-control" name="asl" id="asl" value="<?php echo $asl; ?>"> -->
                                    <input type="text" class="form-control" name="nkar" id="nkar"
                                        value="<?php echo $nkar; ?>">

                                    <select class="form-control select2" name="bag" id="bag">
                                        <?php
                      $sqlbag = mysql_query("select namab from tb_bagian ");
                      while ($bg = mysql_fetch_array($sqlbag)) {
                        if ($bg['namab'] == $bag) { ?>
                                        <option value="<?php echo $bg['namab'] ?>" selected><?php echo  $bg['namab'] ?>
                                        </option>
                                        <?php
                        } else {
                        ?>
                                        <option value="<?php echo $bg['namab']; ?>"><?php echo $bg['namab']; ?></option>
                                        <?php
                        }
                      }
                      ?>
                                    </select>
                                    <select name="grup" id="grup">
                                        <option value="<?php echo $grup; ?>"><?php echo $grup; ?></option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="R">R</option>
                                        <option value="S">S</option>
                                        <option value="T">T</option>
                                        <option value="K">K</option>
                                        <option value="L">L</option>
                                        <option value="NS">NS</option>
                                    </select>

                                    <!-- <select name="grup_t" id="grup_t">
                      <option value="<?php echo $grup_t; ?>"><?php echo $grup_t; ?></option>
                    </select> -->
                                    <input type="date" class="form-control" name="tmt" id="tmt"
                                        value="<?php echo $tmt; ?>">
                                    <select name="rs" id="rs">
                                        <option value="<?php echo $rs; ?>"><?php echo $rs; ?></option>
                                        <option value="0">0</option>
                                        <option value="1">1</option>

                                    </select>
                                    <span class="input-group-append">
                                        <button type="submit" name="submit3" id="submit3"
                                            class="btn btn-primary btn-flat">SIMPAN!</button>
                                    </span>
                                </div>
                            </form>
                            <br>
                            <?php
              }
              ?>
                            <?php
              if (isset($_GET['baru'])) {
                $badgenumber = $_GET['badgenumber'];
                $sqlbaru = mysql_query("select * from userinfo where Badgenumber='$badgenumber' ");
                while ($br = mysql_fetch_array($sqlbaru)) {
                  $badgenumberbr = $br['Badgenumber'];
                  $namebr = $br['Name'];
                  $defaultdi = $br['DEFAULTDEPTID'];
                }

                // if ($defaultdi == 1) {
                //   $defaultdeptid = "Belum Diketahui";
                // } elseif ($defaultdi == 2) {
                //   $defaultdeptid = "EMAA";
                // } elseif ($defaultdi == 3) {
                //   $defaultdeptid = "MHS";
                // } elseif ($defaultdi == 4) {
                //   $defaultdeptid = "HMN";
                // } elseif ($defaultdi == 5) {
                //   $defaultdeptid = "SKA";
                // } elseif ($defaultdi == 6) {
                //   $defaultdeptid = "AJG";
                // } elseif ($defaultdi == 7) {
                //   $defaultdeptid = "PEG";
                // } elseif ($defaultdi == 8) {
                //   $defaultdeptid = "SAKTI";
                // }

              ?>
                            <form method="POST" action="datakaryawan.php" id="form">


                                <div class="input-group input-group">


                                </div><!-- /.form-group -->

                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" name="idkar" id="idkar"
                                        value="<?php echo $badgenumberbr; ?>">
                                    <select name="vendor" id="vendor">

                                        <?php
                      $sqlvendor = mysql_query("select nvendor,kodev from tb_vendor ");
                      while ($kv = mysql_fetch_array($sqlvendor)) {
                        if ($defaultdi == $kv['kodev']) {
                      ?>

                                        <option value="<?php echo $kv['nvendor']; ?>" selected>
                                            <?php echo $kv['nvendor']; ?></option>

                                        <?php
                        } else {

                        ?>
                                        <option value="<?php echo $kv['nvendor']; ?>"><?php echo $kv['nvendor']; ?>
                                        </option>
                                        <?php

                        }
                      }
                      ?>
                                    </select>
                                    <input type="text" class="form-control" name="nama" id="nama"
                                        value="<?php echo $namebr; ?>">

                                    <select class="form-control" name="bagian" id="bagian">
                                        <?php
                      $sqlbag = mysql_query("select namab from tb_bagian ");
                      while ($bg = mysql_fetch_array($sqlbag)) { ?>
                                        <option value="<?php echo $bg['namab']; ?>"><?php echo $bg['namab']; ?></option>
                                        <?php
                      }
                      ?>
                                    </select>
                                    <input type="text" class="form-control" name="grup" id="grup"
                                        placeholder="Grup Kerja">

                                    <input type="date" class="form-control" name="tmt" id="tmt" value="">
                                    <select name="rs" id="rs" disabled>
                                        <option value="0" selected>0</option>
                                        <option value="1">1</option>

                                    </select>
                                    <span class="input-group-append">
                                        <button type="submit" name="submit4" id="submit4"
                                            class="btn btn-primary btn-flat">SIMPAN!</button>
                                    </span>
                                </div>
                            </form>
                            <br>
                            <?php
              }
              ?>

                            <?php

              $tampil = mysql_query("SELECT * from tb_karyawan
ORDER BY seq DESC;");                ?>
                            <table id="example3" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>SEQ</th>
                                        <th>NOMOR ID</th>
                                        <th>VENDOR</th>
                                        <th>NAMA</th>
                                        <th>BAGIAN</th>
                                        <th>GROUP</th>
                                        <th>TMT</th>
                                        <th>GRUP TAGIHAN</th>
                                        <th>RESIGN</th>
                                        <th>ACT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($dt2 = mysql_fetch_array($tampil)) {
                  ?>
                                    <tr>
                                        <td><?php
                          echo $dt2['seq'];
                          ?></td>
                                        <td><?php echo $dt2['idkar']; ?></td>
                                        <td><?php echo $dt2['asal']; ?></td>
                                        <td><?php echo $dt2['nama']; ?></td>
                                        <td><?php echo $dt2['bagian']; ?></td>
                                        <td><?php echo $dt2['grup']; ?></td>
                                        <td><?php echo $dt2['tmt']; ?></td>
                                        <td><?php echo $dt2['grup_t']; ?></td>
                                        <td><?php echo $dt2['resign']; ?></td>
                                        <td nowrap>
                                            <!-- <a href="datakaryawan.php?edit&seq=<?php echo $dt2['seq']; ?>"> -->
                                            <!-- <a class="btn bg-olive margin btn-edit" data-idkar="<?= $dt2['idkar2']; ?>"> <i class="fa fa-edit"></i> Edit</a> -->
                                            <!-- </a> -->
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <br>
                            <h2>
                                Data Karyawan Baru
                            </h2>

                            <?php
              $karyawanbaru = mysql_query("select badgenumber, name, defaultdeptid from tb_karyawan
                  right join userinfo on userinfo.`Badgenumber`=tb_karyawan.`idkar2`
                  where tb_karyawan.`idkar2` is null");
              ?>
                            <?php


              ?>
                            <table id="example2" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>NOMOR ID</th>
                                        <th>VENDOR</th>
                                        <th>NAMA</th>
                                        <th>ACT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($dt3 = mysql_fetch_array($karyawanbaru)) {
                  ?>
                                    <tr>
                                        <td><?php echo $dt3['badgenumber']; ?></td>
                                        <?php
                      $kodevendor = mysql_query("select * from tb_vendor where kodev=" . $dt3['defaultdeptid'] . "");
                      $kodevendor2 = mysql_fetch_array($kodevendor);
                      ?>
                                        <td><?php echo $kodevendor2['nvendor'] ?></td>
                                        <td><?php echo $dt3['name']; ?></td>
                                        <!-- <td nowrap><a href="datakaryawan.php?edit&seq=<?php echo $dt2['seq']; ?>">
                          
                        </a></td> -->
                                        <td>
                                            <!-- <a href="datakaryawan.php?edit&seq=<?php echo $dt2['seq']; ?>">
                          <button class="btn bg-olive margin"> <i class="fa  fa-edit"></i> Edit</button>
                        </a> -->
                                            <a href="datakaryawan.php?baru&badgenumber=<?= $dt3['badgenumber']; ?>"
                                                class="btn bg-olive margin btn-edit">
                                                <button class="btn bg-olive margin"> <i class="fa  fa-edit"></i>
                                                    Edit</button>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div><!-- /.container-fluid -->
                    </section>
                    <!-- /.content -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <div class="modal fade" id="datakaryawanmodaledit" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="proseskaryawan.php?action=editdatakaryawan" class="editdatakaryawan"
                            id="form">

                            <div class="form-group row">
                                <label for="input" class="col-sm-2 col-form-label">ID Karyawan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="idkar" id="idkar" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama" id="namakaryawan">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">bagian</label>
                                <select class="form-control col-sm-10" name="bagian" id="bagian">
                                </select>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Asal</label>
                                <select class="form-control col-sm-10" name="asal" id="asal">
                                </select>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Grup</label>
                                <select class="form-control col-sm-10" name="grup" id="grup">
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="input" class="col-sm-2 col-form-label">Grup Tagian kerja</label>
                                <select class="form-control col-sm-10" name="grup_t" id="grup_t">
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="input" class="col-sm-2 col-form-label">Jabatan</label>
                                <select class="form-control col-sm-10" name="jabatan" id="jabatan">
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="input" class="col-sm-2 col-form-label">Golongan</label>
                                <select class="form-control col-sm-10" name="golongan" id="golongan">
                                </select>
                            </div>
                            <!-- <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="keterangan" id="keterangan">
                    </div>
                  </div> -->
                            <div class="form-group row">
                                <label for="input" class="col-sm-2 col-form-label">TMT</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="tmt" id="tmt">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input" class="col-sm-2 col-form-label">Resign</label>
                                <select class="form-control col-sm-10" name="resign" id="resign">
                                </select>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info float-right">Ubah</button>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div> -->

                </div>
            </div>
        </div>

        <div class="modal fade" id="datakaryawanbarumodaledit" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="proseskaryawan.php?action=tambahdatakaryawan"
                            class="tambahbarudatakaryawan" id="form">

                            <div class="form-group row">
                                <label for="input" class="col-sm-2 col-form-label">ID Karyawan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="idkar" id="idkarb" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="nama" id="namakaryawanb">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">bagian</label>
                                <select class="form-control col-sm-10" name="bagian" id="bagianb">
                                </select>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Asal</label>
                                <select class="form-control col-sm-10" name="asal" id="asalb">
                                </select>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Grup</label>
                                <select class="form-control col-sm-10" name="grup" id="grupb">
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="input" class="col-sm-2 col-form-label">Grup Tagian kerja</label>
                                <select class="form-control col-sm-10" name="grup_t" id="grup_tb">
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="input" class="col-sm-2 col-form-label">Jabatan</label>
                                <select class="form-control col-sm-10" name="jabatan" id="jabatanb">
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="input" class="col-sm-2 col-form-label">Golongan</label>
                                <select class="form-control col-sm-10" name="golongan" id="golonganb">
                                </select>
                            </div>
                            <!-- <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="keterangan" id="keterangan">
                    </div>
                  </div> -->
                            <div class="form-group row">
                                <label for="input" class="col-sm-2 col-form-label">TMT</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="tmt" id="tmtb">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="input" class="col-sm-2 col-form-label">Resign</label>
                                <select class="form-control col-sm-10" name="resign" id="resignb">
                                </select>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info float-right">Ubah</button>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div> -->

                </div>
            </div>
        </div>

        <?php
    include "foo.php";
    ?>
    </div>

    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="plugins/daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css"
        href="//cdn.jsdelivr.net/bootstrap.daterangepicker/1/daterangepicker-bs3.css" />
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

    <script>
    $(function() {
        $('input[name="bulan"]').daterangepicker({
            minDate: new Date(),
            singleDatePicker: true,
            format: 'MM/YYYY',
            locale: {
                format: 'MM/YYYY'
            }
        }).on('hide.daterangepicker', function(ev, picker) {
            $('.table-condensed tbody tr:nth-child(2) td').click();
        });
    });

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 9000
    });

    $(document).ready(function() {
        $('#example').DataTable();
    });

    $('#example10').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "nilaikerja.php?action=table_data",
            "type": "POST"
        },

        //optional
        "lengthMenu": [
            [5, 10, 25, 100],
            [5, 10, 25, 100]
        ],
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],
    });

    $(document).ready(function() {

        $("#grupnilaikerja").change(function() {
            var grup = $(this).val();

            $.ajax({
                url: 'nilaikerja.php',
                type: 'post',
                data: {
                    grup: grup
                },
                dataType: 'json',
                success: function(response) {


                    var hkmk = response.hk_maxtagihan;
                    var hk = response.hk_kalender;
                    console.log(hkmk);

                    $("#sel_user").empty();

                    $("#mtagihan").val(hkmk);
                    $("#kkerja").val(hk);

                    // }
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n\n\n" + thrownError);
                }
            });
        });

        $("#grup").change(function() {
            var grup = $(this).val();

            $.ajax({
                url: 'proseskaryawan.php?action=grupnilai',
                type: 'post',
                data: {
                    grupn: grup
                },
                dataType: 'json',
                success: function(response) {

                    $("#grup_t").empty();
                    $grupk_t = response.length;
                    for (i = 0; i < $grupk_t; i++) {
                        $gruptagihankaryawan = response[i]['grup_t'];

                        if ($gruptagihankaryawan == "NS1") {
                            $('#grup_t').append("<option value='" + $gruptagihankaryawan +
                                "' selected>NS (21 HARI KERJA)</option>");
                        } else if ($gruptagihankaryawan == "NS2") {
                            $('#grup_t').append("<option value='" + $gruptagihankaryawan +
                                "' selected>NS (25 HARI KERJA)</option>");
                        } else {
                            $('#grup_t').append("<option value='" + $gruptagihankaryawan +
                                "' selected>" + $gruptagihankaryawan + "</option>");
                        }
                    }
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n\n\n" + thrownError);
                }
            });
        });

        $('.insertnilaikaryawan').submit(function(e) {
            e.preventDefault();

            let form = $('.insertnilaikaryawan')[0];

            let data = new FormData(form);

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('.btn-inkerja').attr('disable', 'disabled');
                    $('.btn-inkerja').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btn-inkerja').removeAttr('disable');
                    $('.btn-inkerja').html('SIMPAN !');
                },
                success: function(response) {
                    // console.log(Response);
                    if (response.sukses) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Berhasil'
                        });
                        $('#example10').DataTable().ajax.reload();
                    }
                },
            })
        });

        $('.editdatakaryawan').submit(function(e) {
            e.preventDefault();

            let form = $('.editdatakaryawan')[0];

            let data = new FormData(form);

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('.btn-inkerja').attr('disable', 'disabled');
                    $('.btn-inkerja').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btn-inkerja').removeAttr('disable');
                    $('.btn-inkerja').html('SIMPAN !');
                },
                success: function(response) {
                    // console.log(Response);
                    if (response.sukses) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Berhasil'
                        });
                        $('#datakaryawanmodaledit').modal('hide');
                        $('#example3').DataTable().ajax.reload();
                        $('#example2').DataTable().ajax.reload();
                    }
                },
            })
        });
        $('.tambahbarudatakaryawan').submit(function(e) {
            e.preventDefault();

            let form = $('.tambahbarudatakaryawan')[0];

            let data = new FormData(form);

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    $('.btn-inkerja').attr('disable', 'disabled');
                    $('.btn-inkerja').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btn-inkerja').removeAttr('disable');
                    $('.btn-inkerja').html('SIMPAN !');
                },
                success: function(response) {
                    // console.log(Response);
                    if (response.sukses) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Berhasil'
                        });
                        $('#datakaryawanbarumodaledit').modal('hide');
                        $('#example3').DataTable().ajax.reload();
                        $('#example2').DataTable().ajax.reload();
                    }
                },
            })
        });

    });
    $(document).ready(function() {
        $('#example3').DataTable({
            "autoWidth": true,
            "scrollX": true,
            "fixedHeader": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "proseskaryawan.php?action=datatable",
                "type": "POST"
            },

            //optional
            "lengthMenu": [
                [5, 10, 25, 100],
                [5, 10, 25, 100]
            ],
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });

        $('#example3 tbody').on('click', '.btn-edit', function(e) {
            const id = $(this).data('idkar');

            $.ajax({
                url: 'proseskaryawan.php?action=editkaryawan',
                data: {
                    idkaryawan: id
                },
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    var semua = data;
                    console.log(semua);
                    $('#datakaryawanmodaledit').modal('show');
                    $('#idkar').val(data.idkar);
                    $('#namakaryawan').val(data.nama);
                    $('#asal').empty();
                    $('#bagian').empty();
                    $('#grup').empty();
                    $('#grup_t').empty();
                    $('#jabatan').empty();
                    $('#golongan').empty();
                    $('#resign').empty();
                    <?php
            $sqlvendor = mysql_query("select nvendor,kodev from tb_vendor ");
            while ($kv = mysql_fetch_array($sqlvendor)) {
            ?>

                    if (data.asal == "<?= $kv['nvendor'] ?>") {

                        $('#asal').append(
                            "<option value='<?= $kv['nvendor'] ?>' selected> <?= $kv['nvendor'] ?> </option>"
                            );

                    } else {

                        $('#asal').append(
                            "<option value='<?= $kv['nvendor'] ?>'> <?= $kv['nvendor'] ?> </option>"
                            );

                    }


                    <?php
            }

            $sqlbag = mysql_query("select namab from tb_bagian ");
            while ($bg = mysql_fetch_array($sqlbag)) {

            ?>

                    if (data.bagian == "<?= $bg['namab'] ?>") {

                        $('#bagian').append(
                            "<option value='<?= $bg['namab'] ?>' selected> <?= $bg['namab'] ?> </option>"
                            );

                    } else {

                        $('#bagian').append(
                            "<option value='<?= $bg['namab'] ?>'> <?= $bg['namab'] ?> </option>"
                            );

                    }

                    <?php
            }
            ?>
                    <?php
            $sqlgrup = mysql_query("select grup from tb_karyawan GROUP BY grup ");
            while ($gr = mysql_fetch_array($sqlgrup)) {
            ?>

                    if (data.grup == "<?= $gr['grup'] ?>") {

                        $('#grup').append(
                            "<option value='<?= $gr['grup'] ?>' selected> <?= $gr['grup'] ?> </option>"
                            );

                    } else {

                        $('#grup').append(
                            "<option value='<?= $gr['grup'] ?>'> <?= $gr['grup'] ?> </option>"
                            );

                    }


                    <?php
            }
            $sqljabatan = mysql_query("SELECT jabatan FROM tb_karyawan GROUP BY jabatan ");
            while ($jbt = mysql_fetch_array($sqljabatan)) {
            ?>

                    if (data.jabatan == "<?= $jbt['jabatan'] ?>") {

                        $('#jabatan').append(
                            "<option value='<?= $jbt['jabatan'] ?>' selected><?= $jbt['jabatan'] ?></option>"
                            );

                    } else {

                        $('#jabatan').append(
                            "<option value='<?= $jbt['jabatan'] ?>'><?= $jbt['jabatan'] ?></option>"
                            );

                    }

                    <?php
            }
            $sqlgolongan = mysql_query("SELECT id_golongan, tagihan FROM tb_golongan");
            while ($gl = mysql_fetch_array($sqlgolongan)) {
            ?>
                    console.log(data.id_golongan);

                    if (data.id_golongan == "<?= $gl['id_golongan'] ?>") {

                        $('#golongan').append(
                            "<option value='<?= $gl['id_golongan'] ?>' selected><?= $gl['id_golongan'] ?> <?= $gl['tagihan'] ?></option>"
                            );

                    } else {

                        $('#golongan').append(
                            "<option value='<?= $gl['id_golongan'] ?>'><?= $gl['id_golongan'] ?> <?= $gl['tagihan'] ?></option>"
                            );

                    }

                    <?php
            }



            ?>
                    // $('#grup').empty();
                    // $('#grup').append("<option value='" + data.grup + "' selected>" + data.grup + "</option>");
                    if (data.grup_t == "NS1") {

                        $('#grup_t').append("<option value='" + data.grup_t +
                            "' selected>NS (21 HARI KERJA)</option>");

                    } else if (data.grup_t == "NS2") {

                        $('#grup_t').append("<option value='" + data.grup_t +
                            "' selected>NS (25 HARI KERJA)</option>");

                    } else if (data.grup == "NS") {

                        <?php

              $sqlgrup_t = mysql_query("select grup from tb_nilaikerja where grup like '%NS%' group by grup");
              while ($gr = mysql_fetch_array($sqlgrup_t)) {

              ?>

                        $('#grup_t').append(
                            "<option value='<?= $gr['grup'] ?>' selected> <?= $gr['grup'] ?> </option>"
                            );

                        <?php } ?>

                    } else if (data.grup == "A") {

                        <?php

              $sqlgrup_ti = mysql_query("select grup from tb_nilaikerja  where grup='A' group by grup");
              while ($gri = mysql_fetch_array($sqlgrup_ti)) {

              ?>

                        $('#grup_t').append(
                            "<option value='<?= $gri['grup'] ?>'> <?= $gri['grup'] ?> </option>"
                            );

                        <?php } ?>
                    } else if (data.grup == "B") {

                        <?php

              $sqlgrup_ti = mysql_query("select grup from tb_nilaikerja  where grup='B' group by grup");
              while ($gri = mysql_fetch_array($sqlgrup_ti)) {

              ?>

                        $('#grup_t').append(
                            "<option value='<?= $gri['grup'] ?>'> <?= $gri['grup'] ?> </option>"
                            );

                        <?php } ?>
                    } else if (data.grup == "C") {

                        <?php

              $sqlgrup_ti = mysql_query("select grup from tb_nilaikerja  where grup='C' group by grup");
              while ($gri = mysql_fetch_array($sqlgrup_ti)) {

              ?>

                        $('#grup_t').append(
                            "<option value='<?= $gri['grup'] ?>'> <?= $gri['grup'] ?> </option>"
                            );

                        <?php } ?>
                    } else if (data.grup == "D") {

                        <?php

              $sqlgrup_ti = mysql_query("select grup from tb_nilaikerja  where grup='D' group by grup");
              while ($gri = mysql_fetch_array($sqlgrup_ti)) {

              ?>

                        $('#grup_t').append(
                            "<option value='<?= $gri['grup'] ?>'> <?= $gri['grup'] ?> </option>"
                            );

                        <?php } ?>
                    } else if (data.grup == "K") {

                        <?php

              $sqlgrup_ti = mysql_query("select grup from tb_nilaikerja  where grup='K' group by grup");
              while ($gri = mysql_fetch_array($sqlgrup_ti)) {

              ?>

                        $('#grup_t').append(
                            "<option value='<?= $gri['grup'] ?>'> <?= $gri['grup'] ?> </option>"
                            );

                        <?php } ?>
                    } else if (data.grup == "L") {

                        <?php

              $sqlgrup_ti = mysql_query("select grup from tb_nilaikerja  where grup='L' group by grup");
              while ($gri = mysql_fetch_array($sqlgrup_ti)) {

              ?>

                        $('#grup_t').append(
                            "<option value='<?= $gri['grup'] ?>'> <?= $gri['grup'] ?> </option>"
                            );

                        <?php } ?>
                    } else if (data.grup == "R") {

                        <?php

              $sqlgrup_ti = mysql_query("select grup from tb_nilaikerja  where grup='R' group by grup");
              while ($gri = mysql_fetch_array($sqlgrup_ti)) {

              ?>

                        $('#grup_t').append(
                            "<option value='<?= $gri['grup'] ?>'> <?= $gri['grup'] ?> </option>"
                            );

                        <?php } ?>
                    } else if (data.grup == "S") {

                        <?php

              $sqlgrup_ti = mysql_query("select grup from tb_nilaikerja  where grup='S' group by grup");
              while ($gri = mysql_fetch_array($sqlgrup_ti)) {

              ?>

                        $('#grup_t').append(
                            "<option value='<?= $gri['grup'] ?>'> <?= $gri['grup'] ?> </option>"
                            );

                        <?php } ?>
                    } else if (data.grup == "T") {

                        <?php

              $sqlgrup_ti = mysql_query("select grup from tb_nilaikerja  where grup='T' group by grup");
              while ($gri = mysql_fetch_array($sqlgrup_ti)) {

              ?>

                        $('#grup_t').append(
                            "<option value='<?= $gri['grup'] ?>'> <?= $gri['grup'] ?> </option>"
                            );

                        <?php } ?>

                    } else {

                        $('#grup_t').append("<option value='" + data.grup_t +
                            "' selected>" + data.grup_t + "</option>");

                    }

                    <?php



            ?>

                    $('#tmt').val(data.tmt);
                    <?php
            $sqlresign = mysql_query("SELECT resign FROM tb_karyawan GROUP BY resign");
            while ($en = mysql_fetch_array($sqlresign)) {
            ?>

                    if (data.resign == "<?= $en['resign'] ?>") {

                        $('#resign').append(
                            "<option value='<?= $en['resign'] ?>' selected> <?= $en['resign'] ?> </option>"
                            );

                    } else {

                        $('#resign').append(
                            "<option value='<?= $en['resign'] ?>'> <?= $en['resign'] ?> </option>"
                            );

                    }


                    <?php
            }
            ?>
                    $('#resign').val(data.resign);

                }

            })

        });

        $('#example2').DataTable({
            "autoWidth": true,
            "scrollX": true,
            "fixedHeader": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "proseskaryawan.php?action=kbdatatable",
                "type": "POST"
            },
            //optional
            "lengthMenu": [
                [5, 10, 25, 100],
                [5, 10, 25, 100]
            ],
            "columnDefs": [{
                "targets": [],
                "orderable": false,
            }, ],
        });

        $('#example2 tbody').on('click', '.btn-edit', function(e) {
            const id = $(this).data('badgenumber');

            $.ajax({
                url: 'proseskaryawan.php?action=editkaryawanbaru',
                data: {
                    idkaryawan: id
                },
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    var semua = data;
                    console.log(semua);
                    $('#datakaryawanbarumodaledit').modal('show');
                    $('#idkarb').val(data.idkar);
                    $('#namakaryawanb').val(data.nama);
                    $('#asalb').empty();
                    $('#bagianb').empty();
                    $('#grupb').empty();
                    $('#grup_tb').empty();
                    $('#jabatanb').empty();
                    $('#golonganb').empty();
                    $('#resignb').empty();
                    <?php
            $sqlvendor = mysql_query("select nvendor,kodev from tb_vendor ");
            while ($kv = mysql_fetch_array($sqlvendor)) {
            ?>

                    if (data.asal == "<?= $kv['nvendor'] ?>") {

                        $('#asalb').append(
                            "<option value='<?= $kv['nvendor'] ?>' selected> <?= $kv['nvendor'] ?> </option>"
                            );

                    } else {

                        $('#asalb').append(
                            "<option value='<?= $kv['nvendor'] ?>'> <?= $kv['nvendor'] ?> </option>"
                            );

                    }


                    <?php
            }

            $sqlbag = mysql_query("select namab from tb_bagian ");
            while ($bg = mysql_fetch_array($sqlbag)) {

            ?>

                    if (data.bagian == "<?= $bg['namab'] ?>") {

                        $('#bagianb').append(
                            "<option value='<?= $bg['namab'] ?>' selected> <?= $bg['namab'] ?> </option>"
                            );

                    } else {

                        $('#bagianb').append(
                            "<option value='<?= $bg['namab'] ?>'> <?= $bg['namab'] ?> </option>"
                            );

                    }

                    <?php
            }
            $sqlgrup = mysql_query("select grup from tb_karyawan GROUP BY grup ");
            while ($gr = mysql_fetch_array($sqlgrup)) {
            ?>

                    if (data.grup == "<?= $gr['grup'] ?>") {

                        $('#grupb').append(
                            "<option value='<?= $gr['grup'] ?>' selected> <?= $gr['grup'] ?> </option>"
                            );

                    } else {

                        $('#grupb').append(
                            "<option value='<?= $gr['grup'] ?>'> <?= $gr['grup'] ?> </option>"
                            );

                    }


                    <?php
            }
            $sqljabatan = mysql_query("SELECT jabatan FROM tb_karyawan GROUP BY jabatan ");
            while ($jbt = mysql_fetch_array($sqljabatan)) {
            ?>

                    if (data.jabatan == "<?= $jbt['jabatan'] ?>") {

                        $('#jabatanb').append(
                            "<option value='<?= $jbt['jabatan'] ?>' selected><?= $jbt['jabatan'] ?></option>"
                            );

                    } else {

                        $('#jabatanb').append(
                            "<option value='<?= $jbt['jabatan'] ?>'><?= $jbt['jabatan'] ?></option>"
                            );

                    }

                    <?php
            }
            $sqlgolongan = mysql_query("SELECT id_golongan, tagihan FROM tb_golongan");
            while ($gl = mysql_fetch_array($sqlgolongan)) {
            ?>
                    console.log(data.id_golongan);

                    if (data.id_golongan == "<?= $gl['id_golongan'] ?>") {

                        $('#golonganb').append(
                            "<option value='<?= $gl['id_golongan'] ?>' selected><?= $gl['id_golongan'] ?> <?= $gl['tagihan'] ?></option>"
                            );

                    } else {

                        // $('#golongan').append("<option value=''> pilih golongan</option>");
                        $('#golonganb').append(
                            "<option value='<?= $gl['id_golongan'] ?>'><?= $gl['id_golongan'] ?> <?= $gl['tagihan'] ?></option>"
                            );

                    }

                    <?php
            }



            ?>
                    // $('#grup').empty();
                    // $('#grup').append("<option value='" + data.grup + "' selected>" + data.grup + "</option>");
                    if (data.grup_t == "NS1") {

                        $('#grup_tb').append("<option value='" + data.grup_t +
                            "' selected>NS (21 HARI KERJA)</option>");

                    } else if (data.grup_t == "NS2") {

                        $('#grup_tb').append("<option value='" + data.grup_t +
                            "' selected>NS (25 HARI KERJA)</option>");

                    } else if (data.grup == "NS") {

                        <?php

              $sqlgrup_t = mysql_query("select grup from tb_nilaikerja where grup like '%NS%' group by grup");
              while ($gr = mysql_fetch_array($sqlgrup_t)) {

              ?>

                        $('#grup_tb').append(
                            "<option value='<?= $gr['grup'] ?>' selected> <?= $gr['grup'] ?> </option>"
                            );

                        <?php } ?>

                    } else {

                        $('#grup_tb').append("<option value='' selected>" + data.grup_t +
                            "</option>");

                    }

                    <?php



            ?>

                    $('#tmt').val(data.tmt);
                    <?php
            $sqlresign = mysql_query("SELECT resign FROM tb_karyawan GROUP BY resign");
            while ($en = mysql_fetch_array($sqlresign)) {
            ?>

                    if (data.resign == "<?= $en['resign'] ?>") {

                        $('#resignb').append(
                            "<option value='<?= $en['resign'] ?>' selected> <?= $en['resign'] ?> </option>"
                            );

                    } else {

                        $('#resignb').append(
                            "<option value='<?= $en['resign'] ?>'> <?= $en['resign'] ?> </option>"
                            );

                    }


                    <?php
            }
            ?>
                    $('#resignb').val(data.resign);

                }

            })

        });

    });



    $('#example9').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "lengthMenu": [
            [5, 10, 20, 50],
            [5, 10, 20, 50]
        ],
        "autoWidth": true,
        "scrollX": true,
        "fixedHeader": true
    });

    $('#example4').DataTable({
        "paging": false,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "scrollX": true,
        "fixedHeader": true
    });
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        // $('#datemask').inputmask('dd/mm/yyyy', {
        //   'placeholder': 'dd/mm/yyyy'
        // })
        //Datemask2 mm/dd/yyyy
        // $('#datemask2').inputmask('mm/dd/yyyy', {
        //   'placeholder': 'mm/dd/yyyy'
        // })
        //Money Euro
        // $('[data-mask]').inputmask()
        //test
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') +
                    ' to ' + end.format('YYYY-MM-DD'));
            });
        });
        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#ptgl').daterangepicker({
            timePicker: false,
            timePickerIncrement: 30,
            locale: {
                format: 'YYYY-MM-DD'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'))
            }
        )

        $(function($) {

            $.each(data1, function(idx, itm) {
                $("#sel2").append("<option value='" + itm.code + "'>" + itm.country +
                    "</option>");

            });
            $("#sel2").select2(sel2Options);
        });

        //Timepicker
        // $('#timepicker').datetimepicker({
        //   format: 'LT'
        // })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        });

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

    })
    </script>
</body>

</html>