<?php


if(isset($_POST['fnama'])){ 


            $tanggalalfa 	= isset($_POST['tanggalalfa']) ? $_POST['tanggalalfa'] : NULL;
			$tanggal	 	= isset($_POST['fnama']) ? $_POST['fnama'] : NULL;
            $nipalfa 		= isset($_POST['nipalfa']) ? $_POST['nipalfa'] : NULL;
			$namaalfa 		= isset($_POST['namaalfa']) ? $_POST['namaalfa'] : NULL;
       
 

            }   
//--------------------------------------------------------------------
if(isset($_GET['fnama']))
{
$fnama = $_GET['fnama'];
$fnama2 = $fnama;
$now = strtotime(date($fnama));
$now2 = strtotime($fnama);

$fnama3 = date('Y-m-d', strtotime('-1 day', $now));

echo "Tanggal : ".$fnama."<br/> ".$lalamat;
}			
$tgl_skrg=date("Y-m-d");
$tb_act 		= isset($_POST['tb_act']) ? $_POST['tb_act'] : NULL;			
$p_tanggal  	= isset($_POST['fnama']) ? $_POST['fnama'] : NULL;
$ptgl1 = isset($_POST['ptgl1']) ? $_POST['ptgl1'] : NULL;
$ptgl2 = isset($_POST['ptgl2']) ? $_POST['ptgl2'] : NULL;
$pid1 = isset($_POST['pid1']) ? $_POST['pid1'] : NULL;
?>


<div class="col-xs-12 col-sm-6 widget-container-col">
    <div class="widget-box widget-color-orange">
        <div class="widget-header widget-header-small">
            <h6 class="widget-title">
                <i class="ace-icon fa fa-sort"></i>
                REKAPITULASI BERDASARKAN TANGGAL ABSENSI
            </h6>

            <div class="widget-toolbar">
                Klik disini

                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up" data-icon-show="fa fa-chevron-down"
                        data-icon-hide="fa fa-chevron-up"></i>
                </a>

                <a href="#" data-action="close">
                    <i class="ace-icon fa fa-times"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main">


                <div class="widget-main">
                    <ul class="list-unstyled spaced2">
                        <form class="form-horizontal" action="" method="post" role="form">
                            <p></p>
                            <p></p>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for=""><b
                                        align="center">Tanggal</b></label>

                                <div class="col-xs-12 col-sm-5">
                                    <div class="input-group">
                                        <input class="form-control date-picker" name="fnama"
                                            value="<?php echo $p_tanggal; ?>" id="fnama" type="text"
                                            data-date-format="yyyy-mm-dd" required />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>

                            </div>




                            <div class="form-group" align="center">

                                <div class="col-xs-12 col-sm-11">

                                    <input type="submit" class="btn btn-info" name="tb_act" id="tampilkan"
                                        value="Tampil" />
                                    <a href="pegawai/absrekap.php?fnama=<?php echo $p_tanggal;?>" class="btn btn-danger"
                                        target="_blank">Cetak</a>
                                </div>

                            </div>

                        </form>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-sm-6 widget-container-col">
    <div class="widget-box widget-color-orange">
        <div class="widget-header widget-header-small">
            <h6 class="widget-title">
                <i class="ace-icon fa fa-sort"></i>
                REKAPITULASI ABSEN PER KARYAWAN
            </h6>

            <div class="widget-toolbar">
                Klik disini

                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up" data-icon-show="fa fa-chevron-down"
                        data-icon-hide="fa fa-chevron-up"></i>
                </a>

                <a href="#" data-action="close">
                    <i class="ace-icon fa fa-times"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main">


                <div class="widget-main">
                    <ul class="list-unstyled spaced2">
                        <form class="form-horizontal" action="" method="post" role="form">

                            <div class="form-group">
                                <div class="col-xs-12 col-sm-6">

                                    <b align="center">Dari Tanggal</b>
                                    <div class="input-group">

                                        <input class="form-control date-picker" name="ptgl1"
                                            value="<?php echo $ptgl1; ?>" id="fnama" type="text"
                                            data-date-format="yyyy-mm-dd" required />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6">
                                    <b align="center">Sampai Tanggal</b>
                                    <div class="input-group">
                                        <input class="form-control date-picker" name="ptgl2"
                                            value="<?php echo $ptgl2; ?>" id="fnama" type="text"
                                            data-date-format="yyyy-mm-dd" required />
                                        <span class="input-group-addon">
                                            <i class="fa fa-calendar bigger-110"></i>
                                        </span>

                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-6">
                                    <?php
							$db2=mysqli_query($mysqli3,"select kartu, nama from tb_karyawan where resign='0'
									order by kartu ASC");
									?>
                                    <b align="center">Nomor Kartu</b>
                                    <select class="form-control select2" name="pid1" id="pid1" style="width: 100%;">
                                        <option selected="<?php echo $pid1; ?>"><?php echo $pid1; ?></option>
                                        <?php  while($data2=mysqli_fetch_array($db2))
                    { ?>
                                        <option value="<?php echo $data2['kartu']; ?>"><?php echo $data2['kartu']; ?> /
                                            <?php echo $data2['nama']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                </br><label class="col-sm-3 control-label no-padding-right" for=""></label>
                                <div class="col-xs-12 col-sm-6" align="center">
                                    <input type="submit" class="btn btn-info" name="tb_act" id="proses"
                                        value="Proses" />
                                    <a href="pegawai/abskar.php?pid1=<?php echo $pid1;?>&ptgl1=<?php echo $ptgl1;?>&ptgl2=<?php echo $ptgl2;?>"
                                        class="btn btn-danger" target="_blank">Cetak</a>

                                </div>
                            </div>





                        </form>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$sesi_username			= isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$sesi_level				= isset($_SESSION['leveluser']) ? $_SESSION['leveluser'] : NULL;
if ($sesi_level !='1' && $sesi_level !='2'){
    header('location:../index.php');

} 

	$tb_act 		= isset($_POST['tb_act']) ? $_POST['tb_act'] : NULL;			
    $p_tanggal  	= isset($_POST['fnama']) ? $_POST['fnama'] : NULL;
	$ptgl1 = isset($_POST['ptgl1']) ? $_POST['ptgl1'] : NULL;
	$ptgl2 = isset($_POST['ptgl2']) ? $_POST['ptgl2'] : NULL;
	$pid1 = isset($_POST['pid1']) ? $_POST['pid1'] : NULL;
  function getDayIndonesia($date)
    {
        if($date != '0000-00-00'){
            $data = hari(date('D', strtotime($date)));
        }else{
            $data = '-';
        }
 
        return $data;
    }
 
 
    function hari($day) {
        $hari = $day;
 
        switch ($hari) {
            case "Sun":
                $hari = "Minggu";
                break;
            case "Mon":
                $hari = "Senin";
                break;
            case "Tue":
                $hari = "Selasa";
                break;
            case "Wed":
                $hari = "Rabu";
                break;
            case "Thu":
                $hari = "Kamis";
                break;
            case "Fri":
                $hari = "Jum'at";
                break;
            case "Sat":
                $hari = "Sabtu";
                break;
        }
        return $hari;
    }
 
    // Menampilkan nama hari format Bahasa Indonesia
    $hari_ini   = date($p_tanggal);
    


	if ($tb_act=="Tampil")
		{
			 ?>
<div class="col-xs-12 col-sm-12 widget-container-col">
    <div class="widget-box widget-color-orange">
        <div class="widget-header widget-header-small">
            <h5 class="widget-title">REKAP ABSEN TANGGAL <?php echo $p_tanggal; ?> </h5>

            <div class="widget-toolbar">

                <!--<a  href="#dialog" id="0" class="btn btn-success" data-toggle="modal" >
                     Lihat Tabel
                     <span class="badge badge-warning badge-right"></span>
                    </a>-->

                <a href="#" data-action="fullscreen" class="blue">
                    <i class="ace-icon fa fa-expand"></i>
                </a>

                <a href="#" data-action="reload">
                    <i class="ace-icon fa fa-refresh"></i>
                </a>

                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-up"></i>
                </a>

                <a href="#" data-action="close">
                    <i class="ace-icon fa fa-times"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main">
                <div class="table-responsive">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                        <th>GROUP</th>
                        <th>JUMLAH</th>
                        <th>HADIR</th>
                        <th>DEV</th>
                        <?php


$grup='GK02';
$hari_skrg=date('Y-m-d');
$now = strtotime(date($p_tanggal));
$now2 = strtotime($p_tanggal);
$fnama3 = date('Y-m-d', strtotime('-1 day', $now));
$fnama5 = date('Y-m-d', strtotime('-2 day', $now));
$tampils=mysqli_query($mysqli3,"SELECT count(*) as jumlah FROM tb_karyawan where resign=0 and grup='GK02' and MID(kartu,1,1) not in ('K')");
$tampilsb=mysqli_query($mysqli3,"SELECT count(*) as jumlahb FROM tb_karyawan 
left join sub_unit2 on tb_karyawan.sub_unit=sub_unit2.kode_sub_unit
where resign=0 and grup='GK02' and sub_unit2.lokasi in ('1a','1b','1c','1d','1e','1f','1g') ");
$tampilsc=mysqli_query("SELECT count(*) as jumlahc FROM tb_karyawan 
left join sub_unit2 on tb_karyawan.sub_unit=sub_unit2.kode_sub_unit
where resign=0 and grup='GK02' and sub_unit2.lokasi in ('2a','2b') ");
while($datasb=mysqli_fetch_array($tampilsb))
                    { $jmlsb=$datasb['jumlahb']; }?>
                        <?php while($datasc=mysqli_fetch_array($tampilsc))
                    { $jmlsc=$datasc['jumlahc']; }?>
                        <?php while($datas=mysqli_fetch_array($tampils))
                    { ?>

                        <?php  $datas2b=$datas['jumlah']; }
$tampils2=mysqli_query($mysqli3,"select count(kartu) as jumlah2 from tb_karyawan where resign=0 and grup='".$grup."' and MID(kartu,1,1) not in ('K') and id_mesin not in
(SELECT h.id from tb_karyawan g, log h
WHERE g.id_mesin=h.id and g.id_mesin  and g.resign=0 and g.grup='".$grup."' and h.waktu between '".$p_tanggal." 05:00:00' and '".$p_tanggal." 13:00:00')"); 
while($datas2=mysqli_fetch_array($tampils2))
                    { 
                    $hsl1=$datas2['jumlah2'];
                    $hsl2=$datas2b-$datas2['jumlah2'];
                    ?>


                        <?php }
$tampils1=mysqli_query($mysqli3,"SELECT count(*) as jumlah1 FROM tb_karyawan where resign=0 and grup in ('GK01','GKNS') and MID(kartu,1,1) not in ('K')");
$tampils1b=mysqli_query($mysqli3,"SELECT count(*) as jumlah1b FROM tb_karyawan 
left join sub_unit2 on tb_karyawan.sub_unit=sub_unit2.kode_sub_unit 
where resign=0 and grup in ('GK01','GKNS') and sub_unit2.lokasi in ('1a','1b','1c','1d','1e','1f','1g')");
$tampils1c=mysqli_query($mysqli3,"SELECT count(*) as jumlah1c FROM tb_karyawan 
left join sub_unit2 on tb_karyawan.sub_unit=sub_unit2.kode_sub_unit 
where resign=0 and grup in ('GK01','GKNS') and sub_unit2.lokasi in ('2a','2b')");
                ?>
                        <?php while($datas1b=mysqli_fetch_array($tampils1b))
                    { $jml1b=$datas1b['jumlah1b'];}?>
                        <?php while($datas1c=mysqli_fetch_array($tampils1c))
                    { $jml1c=$datas1c['jumlah1c'];}?>
                        <?php while($datas1=mysqli_fetch_array($tampils1))
                    { ?>
                        <tr>
                            <td>
                                Non Shift :</td>
                            <td> <?php 
				  $datadevsm1=$datas1['jumlah1'];
					$nonshift=$datas2b+$datadevsm1;
					if (getDayIndonesia($hari_ini)=="Minggu") {?>
                                <b class="red"><?php echo  $nonshift; ?></b>
                                <?php } else {
					?><?php 
					echo  $nonshift; }?>
                            </td>
                            <?php 
             $datadevsm1=$datas1['jumlah1'];
             }
$tampils3=mysqli_query($mysqli3,"SELECT count(DISTINCT a.kartu) as jumlah3 FROM `tb_karyawan` a, log b WHERE a.id_mesin=b.id and a.resign=0 and a.grup in ('GK01','GKNS') and MID(a.kartu,1,1) not in ('K') and b.waktu between '".$p_tanggal." 05:00:00' and '".$p_tanggal." 11:50:00'");
while($datas3=mysqli_fetch_array($tampils3))
                    { 
                    $hsm1=$datas3['jumlah3'];
                    $hsm2=$datadevsm1-$datas3['jumlah3'];
                    ?>
                            <td><?php 
					$hns1=$hsl2+$hsm1;
					$hns2=$hsl1+$hsm2;
					echo  $hns1; ?></td>
                            <td><?php 
					if (getDayIndonesia($hari_ini)=="Minggu") {?>
                                <b class="red"><?php echo  $hns2; ?></b>
                                <?php } else {
					?><?php echo  $hns2; }?>
                            </td>
                            <td class="hidden"><?php echo  $jml1b;?></td>
                            <td class="hidden"><?php echo  $jml1c;?></td>
                        </tr>
                        <?php }
$tampils1=mysqli_query($mysqli3,"SELECT count(a.kartu) as total 
                                from tb_karyawan a, 
                                     tb_jadwal1 b 
                                            where 
                                            a.grup=b.grup 
                                            and b.tgl='".$p_tanggal."' 
                                            and  b.shift=1
                                            and resign=0                                            
                                            and MID(a.kartu,1,1) not in ('K')
											and a.grup not in ('GK02','GK01','GKNS')");

	while($datas1=mysqli_fetch_array($tampils1))
                    { ?>
                        <tr>
                            <td>
                                Shift I :</td>
                            <td> <?php if (getDayIndonesia($hari_ini)=="Senin") { ?><?php echo  $datas1['total']; ?>
                                <b class='red' hidden><?php $tampils1r=mysqli_query($mysqli3,"SELECT count(a.kartu) as total 
                                from tb_karyawan a, 
                                     tb_jadwal1 b 
                                            where 
                                            a.grup=b.grup 
                                            and b.tgl='".$fnama3."' 
                                            and  b.shift=1
                                            and resign=0                                            
                                            and a.grup not in ('GK02','GK01','GKNS')");											
				  while($datas1r=mysqli_fetch_array($tampils1r)){ echo  $datas1r['total']; $datadevsi1r=$datas1r['total'];}?></b> <?php } 
				  else if (getDayIndonesia($hari_ini)=="Minggu") { ?>
                                <?php echo  $datas1['total']; ?>
                                (<b class='red'><?php $tampils1r=mysqli_query($mysqli3,"SELECT count(a.kartu) as total 
                                from tb_karyawan a, 
                                     tb_jadwal1 b 
                                            where 
                                            a.grup=b.grup 
                                            and b.tgl='".$fnama3."' 
                                            and  b.shift=1
                                            and resign=0 
                                            and a.grup not in ('GK02','GK01','GKNS')");											
				  while($datas1r=mysqli_fetch_array($tampils1r)){ echo  $datas1r['total']; $datadevsi1r=$datas1r['total'];}?></b>)
                                <?php }else{ ?>
                                <?php echo  $datas1['total']; }?>
                            </td>
                            <?php 
             $datadevsi1=$datas1['total'];
} 			
$tampils3=mysqli_query($mysqli3," select count(*) as total2 
                            from 
                            (select 
                                d.kartu as kartuz, 
                                d.nama as namaz,
                                d.sub_unit as unitx, 
                                d.grup as grupz 
                                    from `tb_jadwal1` as a, 
                                          tb_grup as b, 
                                          tb_shift as c, 
                                          tb_karyawan as d, 
                                          log as e 
                                                where a.grup=b.kode 
                                                and a.shift=c.kode 
                                                and a.grup=d.grup 
                                                and d.id_mesin=e.id 
                                                and resign=0 
                                                and a.shift=1
                                                and a.grup not in ('GK02','GK01','GKNS')
                                                and a.tgl='".$p_tanggal."' and id_mesin not in
                    (
                    SELECT d.id_mesin FROM `tb_jadwal1` as a, tb_grup as b, tb_shift as c, tb_karyawan as d, log as e where a.grup=b.kode and a.shift=c.kode and a.grup=d.grup and d.id_mesin=e.id and d.resign=0 and a.tgl='".$p_tanggal."' and a.shift=1 and e.waktu between '".$p_tanggal." 05:00:00' and '".$p_tanggal." 11:51:00' group by d.kartu
                    ) group by d.kartu) as jmll");
while($datas3=mysqli_fetch_array($tampils3))
                    { 
                    $hsi1=$datas3['total2'];
                    $hsi2=$datadevsi1-$hsi1;
                    ?>
                            <td><?php echo  $hsi2;?></td>
                            <td><?php echo  $hsi1; ?></td>
                        </tr>
                        <?php }
$tampils1=mysqli_query($mysqli3,"SELECT count(a.kartu) as totala3 from tb_karyawan a, tb_jadwal1 b where a.grup=b.grup and b.tgl='".$fnama3."' and a.resign=0 and MID(a.kartu,1,1) not in ('K') and b.shift=2");
while($datas12=mysqli_fetch_array($tampils1))
                    { ?>
                        <tr>
                            <td>
                                Shift II :</td>
                            <td><?php if (getDayIndonesia($hari_ini)=="Senin") { ?>
                                <?php echo  $datas12['totala3']; ?> / <b class='red'>Minggu</b>
                                <?php }else if (getDayIndonesia($hari_ini)=="Minggu") { ?>
                                <?php echo  $datas12['totala3']; ?> / <b class='red'>Sabtu</b>
                                <?php }else{?> <?php echo  $datas12['totala3']; }?></td>
                            <?php $datadevsii1=$datas12['totala3'];
             }
$tampils32=mysqli_query($mysqli3," select count(*) as totala3a from (select d.kartu as kartuz, d.nama as namaz,d.sub_unit as unitx, d.grup as grupz from `tb_jadwal1` as a, tb_grup as b, tb_shift as c, tb_karyawan as d, log as e where a.grup=b.kode and a.shift=c.kode and a.grup=d.grup and d.id_mesin=e.id and resign=0 and a.shift=2 and a.tgl='".$fnama3."' and id_mesin not in
                    (
                    SELECT d.id_mesin FROM `tb_jadwal1` as a, tb_grup as b, tb_shift as c, tb_karyawan as d, log as e where a.grup=b.kode and a.shift=c.kode and a.grup=d.grup and d.id_mesin=e.id and d.resign=0 and a.tgl='".$fnama3."' and a.shift=2 and e.waktu between '".$fnama3." 13:00:00' and '".$fnama3." 17:51:00' group by d.kartu
                    ) group by d.kartu) as jmll");
                    ?>
                            <?php while($datas32=mysqli_fetch_array($tampils32))
                    { 
                    $hsii1=$datas32['totala3a'];
                    $hsii2=$datadevsii1-$hsii1;
                    ?>
                            <td><?php echo  $hsii2;?></td>
                            <td><?php echo  $hsii1; ?></td>
                        </tr>
                        <?php }
$tampils1=mysqli_query($mysqli3,"SELECT count(a.kartu) as totala3 from tb_karyawan a, tb_jadwal1 b where a.grup=b.grup and b.tgl='".$fnama3."'and a.resign=0 and  b.shift=3 and MID(a.kartu,1,1) not in ('K')");
while($datas12=mysqli_fetch_array($tampils1))
                    { ?>
                        <tr>
                            <td>
                                Shift III :</td>
                            <td><?php if (getDayIndonesia($hari_ini)=="Senin") { ?>
                                <?php echo  $datas12['totala3']; ?> / <b class='red'>Minggu</b>
                                <?php }else if (getDayIndonesia($hari_ini)=="Minggu") { ?>
                                <?php echo  $datas12['totala3']; ?> / <b class='red'>Sabtu</b>
                                <?php } else {?> <?php echo  $datas12['totala3']; }?></td>
                            <?php 
             $datadevsiii1=$datas12['totala3'];
             }

$tampils32=mysqli_query($mysqli3," select count(*) as totala3a from (select d.kartu as kartuz, d.nama as namaz,d.sub_unit as unitx, d.grup as grupz from `tb_jadwal1` as a, tb_grup as b, tb_shift as c, tb_karyawan as d, log as e where a.grup=b.kode and a.shift=c.kode and a.grup=d.grup and d.id_mesin=e.id and resign=0 and a.shift=3 and a.tgl='".$fnama3."' and id_mesin not in
                    (SELECT d.id_mesin FROM `tb_jadwal1` as a, tb_grup as b, tb_shift as c, tb_karyawan as d, log as e where a.grup=b.kode and a.shift=c.kode and a.grup=d.grup and d.id_mesin=e.id and d.resign=0 and a.tgl='".$fnama3."' and a.shift=3 and e.waktu between '".$fnama3." 20:00:00' and '".$fnama3." 23:51:00' group by d.kartu)  
                    group by d.kartu) as jmll");
                     
while($datas32=mysqli_fetch_array($tampils32))
                    { 
                    $hsiii1=$datas32['totala3a'];
                    $hsiii2=$datadevsiii1-$hsiii1;
                    ?>
                            <td><?php echo  $hsiii2;?></td>
                            <td><?php echo  $hsiii1; ?></td>
                        </tr>
                        <tr>
                            <td><b>TOTAL I</b></td>
                            <td><?php if (getDayIndonesia($hari_ini)=="Senin") { ?>
                                <b><?php $jmlk=$datas2b+$datadevsm1+$datadevsi1+$datadevsii1+$datadevsiii1; echo $jmlk; ?></b>
                                <b class='red'
                                    hidden><?php $jmlk2=$datas2b+$datadevsm1+$datadevsi1r+$datadevsii1+$datadevsiii1; echo $jmlk2; ?></b>
                                <?php } else if (getDayIndonesia($hari_ini)=="Minggu") { ?>
                                <b><?php $jmlk=$datas2b+$datadevsm1+$datadevsi1+$datadevsii1+$datadevsiii1; echo $jmlk; ?>
                                </b>
                                (<b
                                    class='red'><?php $jmlk2=$datas2b+$datadevsm1+$datadevsi1r+$datadevsii1+$datadevsiii1; echo $jmlk2; ?></b>)
                                <?php } else if (getDayIndonesia($hari_ini)=="Sabtu"){ ?>
                                <b><?php $jmlk=$datas2b+$datadevsm1+$datadevsi1+$datadevsii1+$datadevsiii1; echo $jmlk; ?></b>
                                <?php }else{ ?>
                                <b><?php $jmlk=$datas2b+$datadevsm1+$datadevsi1+$datadevsii1+$datadevsiii1; echo $jmlk; }?></b>
                            </td>
                            <td><b><?php $jmlk2=$hsl2+$hsm1+$hsi2+$hsii2+$hsiii2; echo $jmlk2; ?></b></td>
                            <td><?php if (getDayIndonesia($hari_ini)=="Minggu") { ?>
                                <b><?php $jmlk3=$hsi1+$hsii1+$hsiii1; echo $jmlk3; ?></b>
                                <?php }else if (getDayIndonesia($hari_ini)=="Sabtu") { ?>
                                <b><?php $jmlk3=$hsl1+$hsm2+$hsi1+$hsii1+$hsiii1; echo $jmlk3; ?></b>
                                <?php } else { ?>
                                <b><?php $jmlk3=$hsl1+$hsm2+$hsi1+$hsii1+$hsiii1; echo $jmlk3; }?></b>
                            </td>
                        </tr>
                        <?php }
$tampils0=mysqli_query($mysqli3,"SELECT count(a.kartu) as totala0, a.grup from tb_karyawan a, tb_jadwal1 b where a.grup=b.grup and b.tgl='".$fnama3."'and a.resign=0 and  b.shift=0 and a.grup not in ('GK02','GK01','GKNS')");
while($datas13=mysqli_fetch_array($tampils0))
                    { ?>
                        <tr>
                            <td>
                                Shift Off :</td>
                            <td><?php if (getDayIndonesia($hari_ini)!=="Senin") { ?>
                                <?php echo  $datas13['totala0']; ?> (<?php echo $datas13['grup']; ?>)
                                <?php }else {?> <?php echo  $datas13['totala0']; ?> / <b class='red'>Minggu</b></td>
                            <?php }
             $datadevsiii0=$datas13['totala0'];
             }

$tampils33=mysqli_query($mysqli3," select count(*) as totala0a from (select d.kartu as kartuz, d.nama as namaz,d.sub_unit as unitx, d.grup as grupz from `tb_jadwal1` as a, tb_grup as b, tb_shift as c, tb_karyawan as d, log as e where a.grup=b.kode and a.shift=c.kode and a.grup=d.grup and d.id_mesin=e.id and resign=0 and a.shift=0 and a.tgl='".$fnama3."' and id_mesin not in
                    (SELECT d.id_mesin FROM `tb_jadwal1` as a, tb_grup as b, tb_shift as c, tb_karyawan as d, log as e where a.grup=b.kode and a.shift=c.kode and a.grup=d.grup and d.id_mesin=e.id and d.resign=0 and a.tgl='".$fnama3."' group by d.kartu)  
                    group by d.kartu) as jmll");
                     
while($datas33=mysqli_fetch_array($tampils33))
                    { 
                    $hsiii10=$datas33['totala0a'];
                    $hsiii20=$datadevsiii0-$hsiii10;
                    ?>
                            <td>-</td>
                            <td>-</td>

                        </tr>
                        <?php }
?>
                        <tr>
                            <td><b>TOTAL II</b></td>
                            <td><?php if (getDayIndonesia($hari_ini)=="Senin") { ?>
                                <b><?php $jmlk3=$datas2b+$datadevsm1+$datadevsi1r+$datadevsii1+$datadevsiii1+$datadevsiii0; echo $jmlk3; ?></b>
                                <?php } else if (getDayIndonesia($hari_ini)=="Minggu") { ?>
                                <b><?php $jmlk3=$datas2b+$datadevsm1+$datadevsi1r+$datadevsii1+$datadevsiii1+$datadevsiii0; echo $jmlk3; ?></b>
                                <?php } else if (getDayIndonesia($hari_ini)=="Sabtu") { ?>
                                <b><?php $jmlk=$datas2b+$datadevsm1+$datadevsi1+$datadevsii1+$datadevsiii1+$datadevsiii0; echo $jmlk; ?></b>
                                <?php }	else { ?><b><?php $jmlk=$datas2b+$datadevsm1+$datadevsi1+$datadevsii1+$datadevsiii1+$datadevsiii0; echo $jmlk; ?></b>
                                <?php } ?>
                            </td>
                            <td><b><?php $jmlk2=$hsl2+$hsm1+$hsi2+$hsii2+$hsiii2; echo $jmlk2; ?></b></td>
                            <td><?php if (getDayIndonesia($hari_ini)=="Minggu") { ?>
                                <b><?php $jmlk3=$hsi1+$hsii1+$hsiii1; echo $jmlk3; ?></b>
                                <?php }else if (getDayIndonesia($hari_ini)=="Sabtu"){ ?>
                                <b><?php $jmlk3=$hsl1+$hsm2+$hsi1+$hsii1+$hsiii1; echo $jmlk3; ?></b>
                                <?php }else{ ?>
                                <b><?php $jmlk3=$hsl1+$hsm2+$hsi1+$hsii1+$hsiii1; echo $jmlk3; }?></b>
                            </td>
                        </tr>
                        <?php 
$tampilpkwt=mysqli_query($mysqli3,"SELECT count(*) as jumlahspkwt FROM tb_karyawan where resign=0 and MID(kartu,1,1) in ('K')");
while($datapkwt=mysqli_fetch_array($tampilpkwt))
                    { ?>
                        <tr>
                            <td>
                                <b> PKWT </b>
                            </td>
                            <td><b> <?php echo  $datapkwt['jumlahspkwt']; ?></b></td>
                            <?php 
             $datadevsiiipkwt=$datapkwt['jumlahspkwt'];
             }

$tampilspkwt=mysqli_query($mysqli3,"SELECT count(DISTINCT a.kartu) as totalpkwt FROM `tb_karyawan` a, log b WHERE a.id_mesin=b.id and a.resign=0 and MID(a.kartu,1,1) in ('K') and b.waktu between '".$p_tanggal." 05:00:00' and '".$p_tanggal." 11:50:00'");
                     
while($dataspkwt=mysqli_fetch_array($tampilspkwt))
                    { 
                    $hsiii10=$dataspkwt['totalpkwt'];
                    $hsiii20=$datadevsiiipkwt-$hsiii10;
                    ?>
                            <td><b><?php echo $hsiii10; ?></b></td>
                            <td><b><?php echo $hsiii20; ?></b></td>

                        </tr>
                        <?php }
              ?>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="col-xs-12 col-sm-12 widget-container-col">
    <div class="widget-box widget-color-orange">
        <div class="widget-header widget-header-small">
            <h5 class="widget-title">
                <i class="ace-icon fa fa-sort"></i>
                STATISTIK JUMLAH PEGAWAI PER GROUP
            </h5>

            <div class="widget-toolbar">
                Klik disini
                <a href="#" data-action="fullscreen" class="blue">
                    <i class="ace-icon fa fa-expand"></i>
                </a>

                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-plus" data-icon-show="fa-plus" data-icon-hide="fa-minus"></i>
                </a>

                <a href="#" data-action="close">
                    <i class="ace-icon fa fa-times"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main">

                <div class="table-responsive">
                    <div id="container"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-6 widget-container-col">
    <div class="widget-box widget-color-orange collapsed">
        <div class="widget-header widget-hea1der-small">
            <h5 class="widget-title"><i class="fa fa-gift"></i> PEGAWAI BERULANG TAHUN MINGGU INI</h5>

            <div class="widget-toolbar">
                Klik disini
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-down" data-icon-show="fa fa-chevron-down"
                        data-icon-hide="fa fa-chevron-up"></i>
                </a>

                <a href="#" data-action="close">
                    <i class="ace-icon fa fa-times"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main padding-4">
                <div class="scrollable" data-height="125">
                    <div class="content">
                        <?php
                            $data = mysqli_query($mysqli2,"SELECT karyawan.NOMOR_ID,(year(curdate()) - year(TANGGAL_LAHIR)) AS t_lahir,TANGGAL_LAHIR,JENIS_KELAMIN,PHOTO,NAMA,TANGGAL_LAHIR FROM karyawan WHERE DATE_FORMAT(TANGGAL_LAHIR,'%m %d') BETWEEN DATE_FORMAT((CURDATE()),'%m %d') 
                            AND DATE_FORMAT((INTERVAL 7 DAY + CURDATE()),'%m %d') ORDER BY DATE_FORMAT(TANGGAL_LAHIR,'%m %d')");
                            while($b = mysqli_fetch_array($data)) {
                                ?>
                        <div class="itemdiv dialogdiv">
                            <div class="user"><?php 
								 if (empty($b['PHOTO']) && $b['JENIS_KELAMIN'] == 'P') {
                            echo "<img src='assets/avatars/avatar008.jpg'/>";
                        } else if (empty($b['PHOTO']) && $b['JENIS_KELAMIN'] == 'L') {
                            echo "<img src='assets/avatars/avatar212.png'/>";
                        } else {
                            echo "<img src='" . $b['PHOTO'] . "'/>";
                        } ?>
                                <img src="<?php echo $b['PHOTO']; ?>" />
                            </div>

                            <div class="body">

                                <div class="name">
                                    <a href="?id=vwprofil&id_n=<?php echo $b['NOMOR_ID']; ?>"
                                        title="Klik Untuk View Profile"><?php echo $b['NAMA']; ?></a>
                                </div>
                                <div class="text">Ultah Ke-<?php echo tgl_indo($b['t_lahir']);?></div>
                                <div class="text">Lahir pada Tanggal <?php echo tgl_indo($b['TANGGAL_LAHIR']);?></div>

                                <div class="tools">
                                    <a data-toggle="modal" data-target="#<?php echo $b['NOMOR_ID']; ?>" href="#"
                                        class="btn btn-minier btn-info" title="Kirim Pesan Ucapan Ultah">
                                        <i class="icon-only ace-icon fa fa-envelope-o"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div id="<?php echo $b['NOMOR_ID']; ?>" class="modal fade" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header no-padding">
                                        <div class="table-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                <span class="white">&times;</span>
                                            </button>
                                            <i id="myModalLabel3">Kirim Pesan Ucapan Ulang Tahun </i>
                                        </div>
                                    </div>

                                    <div class="modal-body">


                                        <form action="?id=msg" id="form-inbox" method="POST">

                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Kepada:</label>
                                                <input type="text" class="form-control col-sm-1" placeholder="Username"
                                                    name="username" value="<?php echo $b['username'] ?>" id="username"
                                                    required>
                                                <div id="status"></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="control-label">Subject:</label>
                                                <input type="text" class="form-control" name="subject"
                                                    placeholder="subject" value="Ucapan Selamat Ulang Tahun"
                                                    id="subject" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="control-label">Pesan:</label>
                                                <textarea class="form-control" name="pesan" placeholder="Isi Pesan"
                                                    id="pesan" required></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" name="kirim" class="btn btn-primary" VALUE="KIRIM">
                                            </div>
                                        </form>


                                    </div>

                                </div>
                            </div>
                        </div>

                        <?php
                                }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-6 widget-container-col">
    <div class="widget-box widget-color-orange collapsed">
        <div class="widget-header widget-hea1der-small">
            <h5 class="widget-title"><i class="fa fa-users"></i> PEGAWAI RESIGN BARU-BARU INI</h5>

            <div class="widget-toolbar">
                Klik disini
                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-chevron-down" data-icon-show="fa fa-chevron-down"
                        data-icon-hide="fa fa-chevron-up"></i>
                </a>

                <a href="#" data-action="close">
                    <i class="ace-icon fa fa-times"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main padding-4">
                <div class="scrollable" data-height="125">
                    <div class="content">
                        <?php
                            $data = mysqli_query($mysqli3,"SELECT NOMOR_ID,NAMA,TANGGAL_LAHIR,(year(curdate()) - year(TANGGAL_LAHIR)) AS t_usia,(year(curdate()) - year(TANGGAL_MASUK)) AS t_masuk,PHOTO,JENIS_KELAMIN,TANGGAL_MASUK,tgl_resign FROM karyawan WHERE Resign='1' ORDER BY tgl_resign DESC LIMIT 10");
                            while($b = mysqli_fetch_array($data)) {
                                ?>
                        <div class="itemdiv dialogdiv">
                            <div class="user"><?php 
								 if (empty($b['PHOTO']) && $b['JENIS_KELAMIN'] == 'P') {
                            echo "<img src='assets/avatars/avatar008.jpg'/>";
                        } else if (empty($b['PHOTO']) && $b['JENIS_KELAMIN'] == 'L') {
                            echo "<img src='assets/avatars/avatar212.png'/>";
                        } else {
                            echo "<img src='" . $b['PHOTO'] . "'/>";
                        } ?>
                                <img src="<?php echo $b['PHOTO']; ?>" />
                            </div>

                            <div class="body">

                                <div class="name">
                                    <a href="?id=vwprofil&id_n=<?php echo $b['NOMOR_ID']; ?>"
                                        title="Klik Untuk View Profile"><?php echo $b['NAMA']; ?></a>
                                </div>
                                <div class="text">Usia : <?php echo tgl_indo($b['t_usia']);?></div>
                                <div class="text">Masa Kerja : <?php echo tgl_indo($b['t_masuk']);?></div>
                                <div class="text">Tanggal Lahir : <?php echo tgl_indo($b['TANGGAL_LAHIR']);?></div>
                                <div class="text">Tanggal Masuk : <?php echo tgl_indo($b['TANGGAL_MASUK']);?></div>
                                <div class="text">Tanggal Resign : <?php echo tgl_indo($b['tgl_resign']);?></div>

                            </div>
                        </div>

                        <?php
                                }
                            ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xs-12 col-sm-12 widget-container-col">
    <div class="widget-box widget-color-orange">
        <div class="widget-header widget-header-small">
            <h5 class="widget-title">
                <i class="ace-icon fa fa-sort"></i>
                TIDAK ABSEN
            </h5>

            <div class="widget-toolbar">

                <a href="#dialog" id="0" class="btn btn-info" data-toggle="modal">
                    View More
                    <span class="badge badge-warning badge-right"></span>
                </a>

                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-plus" data-icon-show="fa-plus" data-icon-hide="fa-minus"></i>
                </a>

                <a href="#" data-action="close">
                    <i class="ace-icon fa fa-times"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main">

                <div class="table-responsive">


                    <?php
$tampil3=mysqli_query($mysqli3,"select id, kartu, nama, sub_unit,grup from tb_karyawan where resign=0 and grup='$grup' and kode_golongan not in ('DIR') and id_mesin not in
(SELECT h.id from tb_karyawan g, log h
WHERE g.id_mesin=h.id and g.id_mesin  and g.resign=0 and g.grup='$grup' and h.waktu between '".$p_tanggal." 05:00:00' and '".$p_tanggal." 13:00:00')");
                  ?>
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                        <tr>


                        <tr bgcolor='#7fafd8'>
                            <th align="center">NO</th>
                            <th align="center">NO KARTU</th>
                            <th align="center">NAMA KARYAWAN</th>
                            <th align="center">UNIT</th>
                            <th align="center">GROUP</th>
                            <th align="center">KET</th>

                        </tr>
                        <tr>
                            <td colspan='6'>
                                <h3 class="panel-title"><b> Karyawan Sabtu Libur
                                    </b><?php echo "Tanggal : ".$p_tanggal."<br/> ".$lalamat; ?></h3>
                            </td>
                        </tr>

                        <?php $q_libur=mysqli_query($mysqli,"SELECT * FROM tbl_libur WHERE tgllibur = '".$p_tanggal."' ");
						$j_libur = mysqli_fetch_array($q_libur);
						$nmlibur=$j_libur['nmlibur'];
					if (getDayIndonesia($hari_ini)=="Sabtu") {
					?>
                        <tr>
                            <td colspan='6' align='center' class='red'> ~~Tidak Ada Data/Libur/Off~~ </td>
                        </tr>
                        <?php
					} else if (getDayIndonesia($hari_ini)=="Minggu"){
					?>
                        <tr>
                            <td colspan='6' align='center' class='red'> ~~Tidak Ada Data/Libur/Off~~ </td>
                        </tr>
                        <?php
					} else if ($j_libur > 0) { 
					?>
                        <tr>
                            <td colspan='6' align='center' class='red'> <b>~~<?php echo $nmlibur; ?>~~</b></td>
                        </tr>
                        <?php }else {
					$n=0;
					 while($data=mysqli_fetch_array($tampil3))
                    { $idn=$data['id'];
					  $idn0=sprintf("%06d", $idn);
					  $n++ ?>
                        <tr>
                            <td><?php echo $n; ?><b hidden><?php echo $idn0; ?></b></td>
                            <td><?php echo $data['kartu']; ?></td>
                            <td><a href="?id=formcuti&mod=add&id_n=<?php echo $idn0;?>" target="_blank"
                                    title="Lihat Detail"><?php echo $data['nama']; ?></a></td>
                            <td><?php echo $data['sub_unit']; ?></td>
                            <td><?php echo $data['grup']; ?></td>
                            <td><?php
					$tampilcut2=mysqli_query($mysqli2,"SELECT * FROM karyawan_cuti WHERE NOMOR_ID='".$idn0."' AND (DARI_TANGGAL='".$p_tanggal."' OR SAMPAI_TANGGAL='".$p_tanggal."')");
					$tampilcut=mysqli_query($mysqli2,"SELECT * FROM karyawan_cuti WHERE NOMOR_ID='".$idn0."' AND (DARI_TANGGAL <= '".$p_tanggal."' AND SAMPAI_TANGGAL >= '".$p_tanggal."')");
					while($datac=mysqli_fetch_array($tampilcut)){
					$ket=$datac['KODE_CUTI'];
					$tgl_a=$datac['DARI_TANGGAL'];
					$tgl_z=$datac['SAMPAI_TANGGAL'];
					if (($p_tanggal >= $tgl_a) && ($p_tanggal <= $tgl_z)){
					echo $ket; 
					}else {
					
					$datac2=mysqli_fetch_array($tampilcut2);
					$ket2=$datac2['KODE_CUTI'];
					echo $ket2;
					
					}
					}?></td>

                        </tr>

                        <?php   
					}
					}
              ?>






                        <?php
                    $tampil3=mysqli_query($mysqli3,"select id, kartu, nama, sub_unit,grup from tb_karyawan where resign=0 and grup in ('GK01','GKNS') and id_mesin not in
(SELECT h.id from tb_karyawan g, log h
WHERE g.id_mesin=h.id and g.id_mesin  and g.resign=0 and g.grup in ('GK01','GKNS') and h.waktu between '".$p_tanggal." 05:00:00' and '".$p_tanggal." 10:00:00')");
                  ?>
                        <tr>
                            <td colspan='6'>
                                <h3 class="panel-title"><b> Karyawan Sabtu Masuk
                                    </b><?php echo "Tanggal : ".$p_tanggal."<br/> ".$lalamat; ?></h3>
                            </td>
                        </tr>

                        <?php 
				  $q_libur=mysqli_query($mysqli,"SELECT * FROM tbl_libur WHERE tgllibur = '".$p_tanggal."' ");
						$j_libur = mysqli_fetch_array($q_libur);
						$nmlibur=$j_libur['nmlibur'];
					if (getDayIndonesia($hari_ini)=="Minggu") {
					?>
                        <tr>
                            <td colspan='6' align='center' class='red'> ~~Tidak Ada Data/Libur/Off~~ </td>
                        </tr>
                        <?php
					} else if ($j_libur > 0) { 
					?>
                        <tr>
                            <td colspan='6' align='center' class='red'> <b>~~<?php echo $nmlibur; ?>~~</b></td>
                        </tr>
                        <?php }else {
					$n=0; while($data=mysqli_fetch_array($tampil3))
                    {$idn=$data['id'];
					  $idn0=sprintf("%06d", $idn);
					  $n++ ?>
                        <tr>
                            <td><?php echo $n; ?><b hidden><?php echo $idn0; ?></b></td>
                            <td><?php echo $data['kartu']; ?></td>
                            <td><a href="?id=formcuti&mod=add&id_n=<?php echo $idn0;?>" target="_blank"
                                    title="Lihat Detail"><?php echo $data['nama']; ?></a></td>
                            <td><?php echo $data['sub_unit']; ?></td>
                            <td><?php echo $data['grup']; ?></td>
                            <td><?php
					$tampilcut2=mysqli_query($mysqli2,"SELECT * FROM karyawan_cuti WHERE NOMOR_ID='".$idn0."' AND (DARI_TANGGAL='".$p_tanggal."' OR SAMPAI_TANGGAL='".$p_tanggal."')");
					$tampilcut=mysqli_query($mysqli2,"SELECT * FROM karyawan_cuti WHERE NOMOR_ID='".$idn0."' AND (DARI_TANGGAL <= '".$p_tanggal."' AND SAMPAI_TANGGAL >= '".$p_tanggal."')");
					while($datac=mysqli_fetch_array($tampilcut)){
					$ket=$datac['KODE_CUTI'];
					$tgl_a=$datac['DARI_TANGGAL'];
					$tgl_z=$datac['SAMPAI_TANGGAL'];
					if (($p_tanggal >= $tgl_a) && ($p_tanggal <= $tgl_z)){
					echo $ket; 
					}else {
					
					$datac2=mysqli_fetch_array($tampilcut2);
					$ket2=$datac2['KODE_CUTI'];
					echo $ket2;
					
					}
					}?> </td>
                        </tr>
                        <?php   }
					}
$tampil3=mysqli_query($mysqli3,"select d.id as idn, d.kartu as kartuz, 
												 d.nama as namaz,
												 d.sub_unit as unitx, 
												 d.grup as grupz 
														from `tb_jadwal1` as a, 
															  tb_grup as b, 
															  tb_shift as c, 
															  tb_karyawan as d, 
															  log as e 
																	where   a.grup=b.kode 
																		and a.shift=c.kode 
																		and a.grup=d.grup 
																		and d.id_mesin=e.id 
																		and resign=0 
																		and a.shift=1
																		and a.grup not in ('GK02','GK01','GKNS')																		
																		and a.tgl='".$p_tanggal."' 
																		and id_mesin not in
					(
					SELECT d.id_mesin FROM `tb_jadwal1` as a, 
					tb_grup as b, tb_shift as c, tb_karyawan as d, 
					log as e where a.grup=b.kode and a.shift=c.kode and a.grup=d.grup 
					and d.id_mesin=e.id and d.resign=0 and a.tgl='".$p_tanggal."' 
					and a.shift=1 and e.waktu between '".$p_tanggal." 05:00:00' and '".$p_tanggal." 11:51:00' group by d.kartu
					)  
					group by d.kartu order by d.sub_unit");
					
                   
					
                  ?>
                        <tr>
                            <td colspan='6'>
                                <h3 class="panel-title"><b> Group Shift 1
                                    </b><?php echo "Tanggal : ".$p_tanggal."<br/> ".$lalamat; ?></h3>
                            </td>
                        </tr>
                        <?php 
						$q_libur=mysqli_query($mysqli,"SELECT * FROM tbl_libur WHERE tgllibur = '".$p_tanggal."' ");
						$j_libur = mysqli_fetch_array($q_libur);
						$nmlibur=$j_libur['nmlibur'];
					if ($j_libur > 0) {
						?>
                        <tr>
                            <td colspan='6' align='center' class='red'> <b>~~<?php echo $nmlibur; ?>~~</b></td>
                        </tr>
                        <?php
					} else { $n=0; while($data=mysqli_fetch_array($tampil3))
                    {$idn=$data['idn'];
					  $idn0=sprintf("%06d", $idn);
					  $n++ ?>
                        <tr>
                            <td><?php echo $n; ?><b hidden><?php echo $idn0; ?></b></td>
                            <td><?php echo $data['kartuz']; ?></td>
                            <td><a href="?id=formcuti&mod=add&id_n=<?php echo $idn0;?>" target="_blank"
                                    title="Lihat Detail"><?php echo $data['namaz']; ?></a></td>
                            <td><?php echo $data['unitx']; ?></td>
                            <td><?php echo $data['grupz']; ?></td>
                            <td><?php
					$tampilcut2=mysqli_query($mysqli2,"SELECT * FROM karyawan_cuti WHERE NOMOR_ID='".$idn0."' AND (DARI_TANGGAL='".$p_tanggal."' OR SAMPAI_TANGGAL='".$p_tanggal."')");
					$tampilcut=mysqli_query($mysqli2,"SELECT * FROM karyawan_cuti WHERE NOMOR_ID='".$idn0."' AND (DARI_TANGGAL <= '".$p_tanggal."' AND SAMPAI_TANGGAL >= '".$p_tanggal."')");					
					while($datac=mysqli_fetch_array($tampilcut)){
					$ket=$datac['KODE_CUTI'];
					$tgl_a=$datac['DARI_TANGGAL'];
					$tgl_z=$datac['SAMPAI_TANGGAL'];
					if (($p_tanggal >= $tgl_a) && ($p_tanggal <= $tgl_z)){
					echo $ket; 
					}else {
					
					$datac2=mysqli_fetch_array($tampilcut2);
					$ket2=$datac2['KODE_CUTI'];
					echo $ket2;
					
					}
					}?> </td>


                        </tr>

                        <?php   
					}}
              ?>


                        <?php
                    $tampil3=mysqli_query($mysqli3,"select d.id as idn, d.kartu as kartuz, d.nama as namaz, d.sub_unit as unitx,d.grup as grupz from `tb_jadwal1` as a, tb_grup as b, tb_shift as c, tb_karyawan as d, log as e where a.grup=b.kode and a.shift=c.kode and a.grup=d.grup and d.id_mesin=e.id and resign=0 and a.shift=2 and a.tgl=('".$fnama3."') and id_mesin not in
					(
					SELECT d.id_mesin FROM `tb_jadwal1` as a, tb_grup as b, tb_shift as c, tb_karyawan as d, log as e where a.grup=b.kode and a.shift=c.kode and a.grup=d.grup and d.id_mesin=e.id and d.resign=0 and a.tgl=('".$fnama3."') and a.shift=2 and e.waktu between ('".$fnama3." 13:00:00') and ('".$fnama3." 19:51:00') group by d.kartu
					)  
					group by d.kartu order by d.sub_unit
					");
             ?>


                        <tr>
                            <td colspan='6'>
                                <h3 class="panel-title"><b> Group Shift 2
                                    </b><?php echo "Tanggal : ".$fnama3."<br/> ".$lalamat; ?></h3>
                            </td>
                        </tr>

                        <?php 
						$q_libur=mysqli_query($mysqli,"SELECT * FROM tbl_libur WHERE tgllibur = '".$fnama3."' ");
						$j_libur = mysqli_fetch_array($q_libur);
						$nmlibur=$j_libur['nmlibur'];
					if ($j_libur > 0) {
					?>
                        <tr>
                            <td colspan='6' align='center' class='red'> <b>~~<?php echo $nmlibur; ?>~~</b></td>
                        </tr>
                        <?php
					} else {
					?>
                        <?php $n=0; while($data=mysqli_fetch_array($tampil3))
                    {  $idn=$data['idn'];
					  $idn0=sprintf("%06d", $idn);
					  $n++ ?>
                        <tr>
                            <td><?php echo $n; ?><b hidden><?php echo $idn0; ?></b></td>
                            <td><?php echo $data['kartuz']; ?></td>
                            <td><a href="?id=formcuti&mod=add&id_n=<?php echo $idn0;?>" target="_blank"
                                    title="Lihat Detail"><?php echo $data['namaz']; ?></a></td>
                            <td><?php echo $data['unitx']; ?></td>
                            <td><?php echo $data['grupz']; ?></td>
                            <td><?php
					$tampilcut2=mysqli_query($mysqli2,"SELECT * FROM karyawan_cuti WHERE NOMOR_ID='".$idn0."' AND (DARI_TANGGAL='".$fnama3."' OR SAMPAI_TANGGAL='".$fnama3."')");
					$tampilcut=mysqli_query($mysqli2,"SELECT * FROM karyawan_cuti WHERE NOMOR_ID='".$idn0."' AND (DARI_TANGGAL <= '".$fnama3."' AND SAMPAI_TANGGAL >= '".$fnama3."')");					
					while($datac=mysqli_fetch_array($tampilcut)){
					$ket=$datac['KODE_CUTI'];
					$tgl_a=$datac['DARI_TANGGAL'];
					$tgl_z=$datac['SAMPAI_TANGGAL'];
					if (($fnama3 >= $tgl_a) && ($fnama3 <= $tgl_z)){
					echo $ket; 
					}else {
					
					$datac2=mysqli_fetch_array($tampilcut2);
					$ket2=$datac2['KODE_CUTI'];
					echo $ket2;
					
					}
					}?></td>
                        </tr>
                        <?php   
					}
					}
					  ?>


                        <?php  $tampil3=mysqli_query($mysqli3,"select d.id as idn, d.kartu as kartuz, d.nama as namaz,d.sub_unit as unitx, d.grup as grupz from `tb_jadwal1` as a, tb_grup as b, tb_shift as c, tb_karyawan as d, log as e where a.grup=b.kode and a.shift=c.kode and a.grup=d.grup and d.id_mesin=e.id and resign=0 and a.shift=3 and a.tgl='".$fnama3."' and id_mesin not in
					(
					SELECT d.id_mesin FROM `tb_jadwal1` as a, tb_grup as b, tb_shift as c, tb_karyawan as d, log as e where a.grup=b.kode and a.shift=c.kode and a.grup=d.grup and d.id_mesin=e.id and d.resign=0 and a.tgl='".$fnama3."' and a.shift=3 and e.waktu between '".$fnama3." 21:00:00' and '".$fnama3." 23:59:00' group by d.kartu
					)  
					group by d.kartu order by d.sub_unit");
                  ?>
                        <tr>
                            <td colspan='6'>
                                <h3 class="panel-title"><b> Group Shift 3
                                    </b><?php echo "Tanggal : ".$fnama3."<br/> ".$lalamat; ?></h3>
                            </td>
                        </tr>
                        <?php 
						$q_libur=mysqli_query($mysqli,"SELECT * FROM tbl_libur WHERE tgllibur = '".$fnama3."' ");
						$j_libur = mysqli_fetch_array($q_libur);
						$nmlibur=$j_libur['nmlibur'];
					if ($j_libur > 0) {
						?>
                        <tr>
                            <td colspan='6' align='center' class='red'> <b>~~<?php echo $nmlibur; ?>~~</b></td>
                        </tr>
                        <?php
					} else {
					$ca=0;
					$n=0;
					 while($data=mysqli_fetch_array($tampil3))
                    { $idn=$data['idn'];
					  $idn0=sprintf("%06d", $idn);
					  $n++ ?>
                        <tr>
                            <td><?php echo $n; ?><b hidden><?php echo $idn0; ?></b></td>
                            <td><?php echo $data['kartuz']; ?></td>
                            <td><a href="?id=formcuti&mod=add&id_n=<?php echo $idn0;?>" target="_blank"
                                    title="Lihat Detail"><?php echo $data['namaz']; ?></a></td>
                            <td><?php echo $data['unitx']; ?></td>
                            <td><?php echo $data['grupz']; ?></td>
                            <td><?php
					$tampilcut2=mysqli_query($mysqli2,"SELECT * FROM karyawan_cuti WHERE NOMOR_ID='".$idn0."' AND (DARI_TANGGAL='".$fnama3."' OR SAMPAI_TANGGAL='".$fnama3."')");
					$tampilcut=mysqli_query($mysqli2,"SELECT * FROM karyawan_cuti WHERE NOMOR_ID='".$idn0."' AND (DARI_TANGGAL <= '".$fnama3."' AND SAMPAI_TANGGAL >= '".$fnama3."')");
					while($datac=mysqli_fetch_array($tampilcut)){
					$ket=$datac['KODE_CUTI'];
					$tgl_a=$datac['DARI_TANGGAL'];
					$tgl_z=$datac['SAMPAI_TANGGAL'];
					if (($fnama3 >= $tgl_a) && ($fnama3 <= $tgl_z)){
					echo $ket; 
					}else {
					
					$datac2=mysqli_fetch_array($tampilcut2);
					$ket2=$datac2['KODE_CUTI'];
					echo $ket2;
					
					}
					}?></td>


                        </tr>

                        <?php 
				if ( $data['grupz'] == 'GK0A')
				{
				$ca++;}
					} }
			  
              ?>

                        </tbody>

                        </tr>
                    </table>


                </div>

            </div>

        </div>
    </div>
</div>
<div id="dialog" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header no-padding">
                <div class="table-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <span class="white">&times;</span>
                    </button>
                    <i id="myModalLabel3">TIDAK ABSEN LEBIH DARI 3 HARI </i>
                </div>
            </div>

            <div class="modal-body">
                <div class="modal-content">
                    <div class="table-responsive">
                        <?php

$tampil3=mysqli_query($mysqli3,"SELECT COUNT(*),kartu, tb_karyawan.nama, tb_karyawan.sub_unit, tb_karyawan.grup, shift from tb_karyawan LEFT JOIN tb_jadwal1 ON tb_jadwal1.`grup`=tb_karyawan.`grup` LEFT JOIN tb_shift ON tb_shift.`nama`=tb_jadwal1.`shift` 
					where resign=0 AND kode_golongan!='DIR' AND kartu!='B.3424' AND tgl BETWEEN '".$fnama5."' AND '".$p_tanggal."' AND shift!=0 AND id_mesin not in (SELECT h.id from tb_karyawan g, log h WHERE g.id_mesin=h.id and g.id_mesin and g.resign=0 and h.waktu between '".$fnama5." 05:00:00' and '".$p_tanggal." 23:59:00') GROUP BY kartu HAVING COUNT(*) >= 3 ORDER BY shift ASC");
?>

                        <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">

                            <tr>
                                <th align="center">NO</th>
                                <th align="center">NO KARTU</th>
                                <th align="center">NAMA KARYAWAN</th>
                                <th align="center">UNIT</th>
                                <th align="center">GROUP</th>
                                <th align="center">SHIFT</th>

                            </tr>

                            <?php $n=0;
					 while($data=mysqli_fetch_array($tampil3))
                    { $idn=$data['id'];
					  //$idm=$data['id_mesin'];
					  $kartu=$data['kartu'];
					  $idn0=sprintf("%06d", $idn);
					  $n++ ?>
                            <tr>
                                <td><?php echo $n; ?><b hidden><?php echo $idn0; ?></b></td>
                                <td><?php echo $kartu; ?>
                                </td>
                                <td><a href="?id=formcuti&mod=add&id_n=<?php echo $idn0;?>" target="_blank"
                                        title="Lihat Detail"><?php echo $data['nama']; ?></a></td>
                                <td><?php echo $data['sub_unit']; ?></td>
                                <td><?php echo $data['grup']; ?></td>
                                <td><?php echo $data['shift']; ?></td>
                            </tr>

                            <?php   
					
					}
              ?>

                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <center><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </center>
                </div>
            </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<div class="col-xs-12 col-sm-12 widget-container-col">
    <div class="widget-box widget-color-orange">
        <div class="widget-header widget-header-small">
            <h6 class="widget-title">
                <i class="ace-icon fa fa-sort"></i>
                ABSEN TERLAMBAT
            </h6>

            <div class="widget-toolbar">
                Klik disini

                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-plus" data-icon-show="fa-plus" data-icon-hide="fa-minus"></i>
                </a>

                <a href="#" data-action="close">
                    <i class="ace-icon fa fa-times"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main">
                <div class="table-responsive">
                    <?php
$tampil1=mysqli_query($mysqli3,"SELECT a.kartu AS kar, 
												 a.nama as nam, 
												 b.waktu as time,
												 a.sub_unit as unitx, 
												 a.grup as grupx, 
												 TIMEDIFF(time('07:51:00'),
												 time(b.waktu)) as selisih 
													FROM `tb_karyawan` a, log b 
													WHERE a.id_mesin=b.id 
														and a.resign=0 
														and a.grup='GK02' 
														and b.waktu between '".$p_tanggal." 07:52:00' and '".$p_tanggal." 13:00:00'  
														group by a.kartu order by a.sub_unit");
?>


                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                        <tr>


                        <tr bgcolor='#7fafd8'>
                            <th align="center">NO</th>
                            <th align="center">NO KARTU</th>
                            <th align="center">NAMA KARYAWAN</th>
                            <th align="center">UNIT</th>
                            <th align="center">GROUP</th>
                            <th align="center">CHECK</th>
                            <th align="center">SELISIH</th>
                        </tr>
                        <tr>
                            <td colspan='7'>
                                <h3 class="panel-title"><b> Karyawan Sabtu Libur
                                    </b><?php echo "Tanggal : ".$p_tanggal."<br/> ".$lalamat; ?></h3>
                            </td>
                        </tr>
                        <?php $n=0; while($data=mysqli_fetch_array($tampil1))
                    { $n++  ?>
                        <tr>
                            <td><?php echo $n; ?></td>
                            <td><?php echo $data['kar']; ?></td>
                            <td><?php echo $data['nam']; ?></td>
                            <td><?php echo $data['unitx']; ?></td>
                            <td><?php echo $data['grupx']; ?></td>
                            <td><?php echo $data['time']; ?></td>
                            <td><?php echo $data['selisih']; ?></td>


                        </tr>
                        <?php   
              }

                    $tampil1=mysqli_query($mysqli3,"SELECT a.kartu AS kar, a.nama as nam,a.sub_unit as unitx,a.grup as grupx, b.waktu as time, TIMEDIFF(time('07:52:00'),time(b.waktu)) as selisih FROM `tb_karyawan` a, log b WHERE a.id_mesin=b.id and a.resign=0 and a.grup in ('GK01','GKNS') and b.waktu between '".$fnama." 07:51:00' and '".$fnama." 10:00:00'  group by a.kartu order by a.sub_unit");
                  ?>
                        <tr>
                            <td colspan='7'>
                                <h3 class="panel-title"><b> Karyawan Sabtu Masuk
                                    </b><?php echo "Tanggal : ".$p_tanggal."<br/> ".$lalamat; ?></h3>
                            </td>
                        </tr>


                        <?php $n=0; while($data=mysqli_fetch_array($tampil1))
                    { $n++  ?>
                        <tr>
                            <td><?php echo $n; ?></td>
                            <td><?php echo $data['kar']; ?></td>
                            <td><?php echo $data['nam']; ?></td>
                            <td><?php echo $data['unitx']; ?></td>
                            <td><?php echo $data['grupx']; ?></td>
                            <td><?php echo $data['time']; ?></td>
                            <td><?php echo $data['selisih']; ?></td>


                        </tr>

                        <?php   
              }
              ?>

                        <?php
                    $tampil=mysqli_query($mysqli3,"SELECT d.kartu as kartux,
												d.nama as namax ,
												d.grup as grupx,
												e.waktu as waktux, 
												d.sub_unit as unitx, 
												TIMEDIFF(time('06:51:00'),
												time(e.waktu)) as selisih 
													FROM `tb_jadwal1` as a, 
														  tb_grup as b, 
														  tb_shift as c, 
														  tb_karyawan as d, 
														  log as e 
																where a.grup=b.kode 
																  and a.shift=c.kode 
																  and a.grup=d.grup 
																  and d.id_mesin=e.id 
																  and d.resign=0 
																  and a.tgl='".$p_tanggal."' 
																  and a.shift=1
																  and a.grup not in ('GK02','GK01','GKNS')
																  and e.waktu between '".$p_tanggal." 06:52:00' and '".$p_tanggal." 11:52:00' 
																  group by d.kartu order by d.sub_unit");
                  ?>
                        <tr>
                            <td colspan='7'>
                                <h3 class="panel-title"><b> Group Shift 1
                                    </b><?php echo "Tanggal : ".$p_tanggal."<br/> ".$lalamat; ?></h3>
                            </td>
                        </tr>

                        <?php $n=0; while($data=mysqli_fetch_array($tampil))
                    { $n++  ?>

                        <tr>
                            <td><?php echo $n; ?></td>
                            <td><?php echo $data['kartux']; ?></td>
                            <td><?php echo $data['namax']; ?></td>
                            <td><?php echo $data['unitx']; ?></td>
                            <td><?php echo $data['grupx']; ?></td>
                            <td><?php echo $data['waktux']; ?></td>
                            <td><?php echo $data['selisih']; ?></td>


                        </tr>

                        <?php   
              }
              ?>

                        <?php
                    $tampil=mysqli_query($mysqli3,"SELECT d.kartu as kartux,d.nama as namax ,d.grup as grupx,e.waktu as waktux, d.sub_unit as unitx, TIMEDIFF(time('14:51:00'),time(e.waktu)) as selisih FROM `tb_jadwal1` as a, tb_grup as b, tb_shift as c, tb_karyawan as d, log as e where a.grup=b.kode and a.shift=c.kode and a.grup=d.grup and d.id_mesin=e.id and d.resign=0 and a.tgl='".$fnama3."' and a.shift=2 and e.waktu between '".$fnama3." 14:51:00' and '".$fnama3." 19:51:00' group by d.kartu order by d.sub_unit");
                  ?>
                        <tr>
                            <td colspan='7'>
                                <h3 class="panel-title"><b> Group Shift 2
                                    </b><?php echo "Tanggal : ".$fnama3."<br/> ".$lalamat; ?></h3>
                            </td>
                        </tr>

                        <?php $n=0; while($data=mysqli_fetch_array($tampil))
                    { $n++  ?>

                        <tr>
                            <td><?php echo $n; ?></td>
                            <td><?php echo $data['kartux']; ?></td>
                            <td><?php echo $data['namax']; ?></td>
                            <td><?php echo $data['unitx']; ?></td>
                            <td><?php echo $data['grupx']; ?></td>
                            <td><?php echo $data['waktux']; ?></td>
                            <td><?php echo $data['selisih']; ?></td>


                        </tr>

                        <?php   
              }
              ?>

                        <?php
                    $tampil=mysqli_query($mysqli3,"SELECT d.kartu as kartux,d.nama as namax ,d.sub_unit as unitx,d.grup as grupx,e.waktu as waktux,TIMEDIFF(time('22:51:00'),time(e.waktu)) as selisih FROM `tb_jadwal1` as a, tb_grup as b, tb_shift as c, tb_karyawan as d, log as e where a.grup=b.kode and a.shift=c.kode and a.grup=d.grup and d.id_mesin=e.id and d.resign=0 and a.tgl='".$fnama3."' and a.shift=3 and e.waktu between '".$fnama3." 22:51:00' and '".$fnama3." 23:51:00' group by d.kartu order by d.sub_unit");
                  ?>
                        <tr>
                            <td colspan='7'>
                                <h3 class="panel-title"><b> Group Shift 3
                                    </b><?php echo "Tanggal : ".$fnama3."<br/> ".$lalamat; ?></h3>
                            </td>
                        </tr>

                        <?php $n=0; while($data=mysqli_fetch_array($tampil))
                    { $n++  ?>

                        <tr>
                            <td><?php echo $n; ?></td>
                            <td><?php echo $data['kartux']; ?></td>
                            <td><?php echo $data['namax']; ?></td>
                            <td><?php echo $data['unitx']; ?></td>
                            <td><?php echo $data['grupx']; ?></td>
                            <td><?php echo $data['waktux']; ?></td>
                            <td><?php echo $data['selisih']; ?></td>


                        </tr>

                        <?php   
              }
              ?>
                        </tbody>



                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xs-12 col-sm-12 widget-container-col">
    <div class="widget-box widget-color-orange">
        <div class="widget-header widget-header-small">
            <h6 class="widget-title">
                <i class="ace-icon fa fa-sort"></i>
                ABSEN IJIN
            </h6>

            <div class="widget-toolbar">
                Klik disini

                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-plus" data-icon-show="fa-plus" data-icon-hide="fa-minus"></i>
                </a>

                <a href="#" data-action="close">
                    <i class="ace-icon fa fa-times"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main">
                <div class="table-responsive">

                    <?php
$tampilai=mysqli_query($mysqli2,"SELECT a.nomor_kartu AS kar, 
												 b.NAMA as nama, 
												 b.KODE_GROUP_KERJA as grup,
												 a.tanggal as tgl,
												 a.tgl_awal as awal, 
												 a.tgl_akhir as akhir, 
												 a.selisih as selisih,
												 a.ket as keterangan
													FROM `absenijin` a, karyawan b 
													WHERE a.nomor_kartu=b.NOMOR_KARTU  
														and a.tanggal between '".$fnama3."' and '".$p_tanggal."' ORDER BY a.tanggal DESC
														");
?>


                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
                        <tr>

                        <tr bgcolor='#7fafd8'>
                            <th align="center">NO</th>
                            <th align="center">NO KARTU</th>
                            <th align="center">NAMA</th>
                            <th align="center">GROUP</th>
                            <th align="center">TANGGAL</th>
                            <th align="center">AWAL</th>
                            <th align="center">AKHIR</th>
                            <th align="center">SELISIH</th>
                            <th align="center">KETERANGAN</th>
                        </tr>
                        <?php $n=0; while($data=mysqli_fetch_array($tampilai))
                    { $n++  ?>
                        <tr>
                            <td><?php echo $n; ?></td>
                            <td><?php echo $data['kar']; ?></td>
                            <td><?php echo $data['nama']; ?></td>
                            <td><?php echo $data['grup']; ?></td>
                            <td><?php echo $data['tgl']; ?></td>
                            <td><?php echo $data['awal']; ?></td>
                            <td><?php echo $data['akhir']; ?></td>
                            <td><?php echo $data['selisih']; ?></td>
                            <td><?php echo $data['keterangan']; ?></td>

                        </tr>
                        <?php   
              }
                  ?>

                        </tbody>


                        </tr>
                    </table>
                    <!-- /table-responsive -->
                </div>


            </div>
        </div>
    </div>
</div>
<?php	
	}else if ($tb_act=="Proses")
	{ ?>
<div class="col-xs-12 col-sm-12 widget-container-col">
    <div class="widget-box widget-color-orange">
        <div class="widget-header widget-header-small">
            <h6 class="widget-title">
                <i class="ace-icon fa fa-sort"></i>
                REKAPITULASI ABSEN PER KARYAWAN
            </h6>

            <div class="widget-toolbar">
                Klik disini

                <a href="#" data-action="collapse">
                    <i class="ace-icon fa fa-plus" data-icon-show="fa-plus" data-icon-hide="fa-minus"></i>
                </a>

                <a href="#" data-action="close">
                    <i class="ace-icon fa fa-times"></i>
                </a>
            </div>
        </div>

        <div class="widget-body">
            <div class="widget-main">
                <?php
$tampil2=mysqli_query($mysqli3,"SELECT nama,kartu,grup,id_mesin,unit FROM tb_karyawan WHERE kartu='".$pid1."'");
$tampil3=mysqli_query($mysqli3,"SELECT kartu,tb_karyawan.nama,tb_karyawan.grup as grupk,id_mesin,DATE_FORMAT(tgl,'%W') as hari,
tgl,shift,masuk,pulang FROM tb_karyawan
LEFT JOIN tb_jadwal1 ON tb_jadwal1.`grup`=tb_karyawan.`grup`
LEFT JOIN tb_shift ON tb_shift.`nama`=tb_jadwal1.`shift`
WHERE tgl BETWEEN '".$ptgl1."' and '".$ptgl2."' AND kartu='".$pid1."'
ORDER BY tgl ");
while($data2=mysqli_fetch_array($tampil2))
{
                  ?>
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
                    width="20%">
                    <tr>
                        <td>
                            <label>PERIODE </label>
                        </td>
                        <td>:
                            <?php echo $ptgl1.' s/d '.$ptgl2; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>NAMA </label>
                        </td>
                        <td>:
                            <?php echo $data2['nama']; ?> / <?php echo $data2['kartu']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>UNIT </label>
                        </td>
                        <td>:
                            <?php echo $data2['unit']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>GROUP </label>
                        </td>
                        <td>:
                            <?php echo $data2['grup']; ?>
                        </td>
                    </tr>
                </table>
                <?php 
}
?>
                <br>
                <div class="table-responsive">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">

                        <tr>
                            <th align="center" nowrap>NO</th>
                            <th align="center" nowrap>HARI</th>
                            <th align="center" nowrap>TANGGAL</th>
                            <th align="center" nowrap>SHIFT</th>
                            <th align="center" nowrap>JADWAL MASUK</th>
                            <th align="center" nowrap>JADWAL PULANG</th>
                            <th align="center" nowrap>CHECK MASUK</th>
                            <th align="center" nowrap>CHECK PULANG</th>
                            <th align="center" nowrap>TERLAMBAT</th>
                        </tr>
                        <?php $n=0;
					 while($data=mysqli_fetch_array($tampil3))
                    { $n++ ;
					$idmes=$data['id_mesin'];
					if($data['hari']=='Monday'){$hari='Senin';}
					elseif($data['hari']=='Tuesday'){$hari='Selasa';}
					elseif($data['hari']=='Wednesday'){$hari='Rabu';}
					elseif($data['hari']=='Thursday'){$hari='Kamis';}
					elseif($data['hari']=='Friday'){$hari='Jumat';}
					elseif($data['hari']=='Saturday'){$hari='Sabtu';}
					elseif($data['hari']=='Sunday'){$hari='Minggu';}
					
					?>
                        <tr <?php if ($data['shift']==0){echo "bgcolor='grey'";} ?>>
                            <td><?php echo $n; ?></td>
                            <td><?php echo $hari; ?></td>
                            <td align="center"><?php $dtd=$data['tgl']; echo $dtd; ?></td>
                            <td align="center"><?php $sf=$data['shift']; echo $data['shift']; ?></td>
                            <td align="center"><?php if($gr=='GK02'){echo '07:50:00';}else{ echo $data['masuk'];} ?>
                            </td>
                            <td align="center"><?php if($gr=='GK02'){echo '17:00:00';}else{ echo $data['pulang'];} ?>
                            </td>
                            <td align="center"><?php if ($sf==1){ $sr1=mysqli_query($mysqli3,"SELECT MIN(DATE_FORMAT(waktu,'%H:%i:%s')) as timedat FROM LOG WHERE id='".$idmes."'
					AND DATE_FORMAT(waktu,'%Y-%m-%d') ='".$dtd."' AND DATE_FORMAT(waktu,'%H:%i:%s') <= '14:00:00';");
					while($datg1=mysqli_fetch_array($sr1))
                    {echo $datg1['timedat'];}
					}if($sf==2){ $sr2=mysqli_query($mysqli3,"SELECT MIN(DATE_FORMAT(waktu,'%H:%i:%s')) as timedat FROM LOG WHERE id='".$idmes."'
					AND DATE_FORMAT(waktu,'%Y-%m-%d') ='".$dtd."' AND DATE_FORMAT(waktu,'%H:%i:%s') <= '19:00:00';");
					while($datg2=mysqli_fetch_array($sr2))
                    {echo $datg2['timedat'];}
					}if($sf==3){ $sr3=mysqli_query($mysqli3,"SELECT max(DATE_FORMAT(waktu,'%H:%i:%s')) as timedat FROM LOG WHERE id='".$idmes."'
					AND DATE_FORMAT(waktu,'%Y-%m-%d') ='".$dtd."' AND DATE_FORMAT(waktu,'%H:%i:%s') <= '23:59:59';");
					while($datg3=mysqli_fetch_array($sr3))
                    {echo $datg3['timedat'];}
					}
					?>
                            </td>
                            <td>
                                <?php if ($sf==1){ $sr4=mysqli_query($mysqli3,"SELECT MAX(DATE_FORMAT(waktu,'%H:%i:%s')) as timedat FROM LOG WHERE id='".$idmes."'
					AND DATE_FORMAT(waktu,'%Y-%m-%d') ='".$dtd."' AND DATE_FORMAT(waktu,'%H:%i:%s') > '12:00:00';");
					while($datg4=mysqli_fetch_array($sr4))
                    {echo $datg4['timedat'];}
					}if($sf==2){ $sr5=mysqli_query($mysqli3,"SELECT MAX(DATE_FORMAT(waktu,'%H:%i:%s')) as timedat FROM LOG WHERE id='".$idmes."'
					AND DATE_FORMAT(waktu,'%Y-%m-%d') ='".$dtd."' AND DATE_FORMAT(waktu,'%H:%i:%s') > '19:00:00';");
					while($datg5=mysqli_fetch_array($sr5))
                    {echo $datg5['timedat'];}
					}if($sf==3){ $sr6=mysqli_query($mysqli3,"SELECT MIN(DATE_FORMAT(waktu,'%H:%i:%s')) as timedat FROM LOG WHERE id='".$idmes."'
					AND DATE_FORMAT(waktu,'%Y-%m-%d') =DATE_ADD('".$dtd."', INTERVAL 1 DAY) AND DATE_FORMAT(waktu,'%H:%i:%s') > '03:00:00';");
					while($datg6=mysqli_fetch_array($sr6))
                    {echo $datg6['timedat'];}
					}
					?>
                            </td>

                            <td align="center">
                                <?php if ($sf==1){ 
                        if($gr=='GK02'){
                            $grk1=mysqli_query($mysqli3,"SELECT TIMEDIFF(time('07:51:00'),
                                                 time(waktu)) as selisih FROM LOG WHERE id='".$idmes."' AND DATE_FORMAT(waktu,'%Y-%m-%d') ='".$dtd."' AND waktu between '".$dtd." 07:52:00' and '".$dtd." 13:00:00' ORDER BY selisih DESC LIMIT 1");
                    while($datgrk1=mysql_fetch_array($grk1))
                    {echo "Y <span class='badge badge-danger'>".$datgrk1['selisih']."</span>";}
               } else if(($gr=='GK01') OR ($gr=='GKNS')){
                            $grk2=mysqli_query($mysqli3,"SELECT TIMEDIFF(time('07:52:00'),
                                                 time(waktu)) as selisih FROM LOG WHERE id='".$idmes."' AND DATE_FORMAT(waktu,'%Y-%m-%d') ='".$dtd."' AND waktu between '".$dtd." 07:51:00' and '".$dtd." 10:00:00' ORDER BY selisih DESC LIMIT 1");
                    while($datgrk2=mysqli_fetch_array($grk2))
                    {echo "Y <span class='badge badge-danger'>".$datgrk2['selisih']."</span>";}
               } else {
                    $grk3=mysqli_query($mysqli3,"SELECT TIMEDIFF(time('06:51:00'),
                                                 time(waktu)) as selisih FROM LOG WHERE id='".$idmes."' AND DATE_FORMAT(waktu,'%Y-%m-%d') ='".$dtd."' AND waktu between '".$dtd." 06:52:00' and '".$dtd." 11:52:00' ORDER BY selisih DESC LIMIT 1");
                    while($datgrk3=mysqli_fetch_array($grk3))
                    {echo "Y <span class='badge badge-danger'>".$datgrk3['selisih']."</span>";}
                }
                    } elseif($sf==2){ $gr2=mysqli_query($mysqli3,"SELECT TIMEDIFF(time('14:51:00'),
                                                 time(waktu)) as selisih FROM LOG WHERE id='".$idmes."' AND DATE_FORMAT(waktu,'%Y-%m-%d') ='".$dtd."' AND waktu between '".$dtd." 14:51:00' and '".$dtd." 19:51:00' ORDER BY selisih DESC LIMIT 1");
                    while($datgr2=mysqli_fetch_array($gr2))
                    {echo "Y <span class='badge badge-danger'>".$datgr2['selisih']."</span>";}
                    } elseif($sf==3){ $gr3=mysqli_query($mysqli3,"SELECT TIMEDIFF(time('22:51:00'),
                                                 time(waktu)) as selisih FROM LOG WHERE id='".$idmes."' AND DATE_FORMAT(waktu,'%Y-%m-%d') ='".$dtd."' AND waktu between '".$dtd." 22:51:00' and '".$dtd." 23:51:00' ORDER BY selisih DESC LIMIT 1");
                    while($datgr3=mysqli_fetch_array($gr3))
                    {echo "Y <span class='badge badge-danger'>".$datgr3['selisih']."</span>";}
                    }
                    ?>
                            </td>

                        </tr>

                        <?php   
              }
              ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }
?>