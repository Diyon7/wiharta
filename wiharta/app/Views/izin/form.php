<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Html Generated</title>
    <link href="https://fonts.googleapis.com/css?family=Inter&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url() ?>/assets/styles.css">

    <style>
    body {
        background: #FFFF;
    }

    .e41_64 {
        width: 28px;
        height: 41px;
        position: absolute;
        left: 27px;
        top: 12px;
        background-image: url(<?= base_url() ?>/assets/dist/img/WIHARTA.png);
        background-repeat: no-repeat;
        background-size: cover;
    }

    @page {
        size: A6;
        margin: 0mm;
        orientation: lanscape;
    }
    </style>

</head>

<body id="formprint">
    <div class=e50_2>
        <div class="e41_64"></div><span class="e50_4">FORM ABSENSI WKA</span><span class="e50_5">NAMA
            KARYAWAN</span><span class="e65_3"><?= $grup ?></span><span class="e56_50"><?= $izin ?></span><span
            class="e56_51"><?= $ket ?></span><span class="e50_34">DIBUAT OLEH</span><span class="e51_42">KORLAP
            VENDOR</span><span class="e50_37">KARYAWAN</span><span class="e51_44">SDM</span><span class="e51_43">KA.
            UNIT</span><span class="e50_36">MENYETUJUI</span><span class="e50_35">MENGETAHUI</span><span
            class="e50_27">JAM
            IN</span><span class="e50_29">JAM OUT</span><span class="e50_20">GRUP KERJA</span><span
            class="e50_16"><?= $nama ?></span><span class="e50_17"><?= $unit ?> / <?= $subunit ?></span><span
            class="e50_18"><?= $idkar ?></span><span class="e50_19"><?= $tgl ?></span><span
            class="e50_33"><?= $out ?></span><span class="e50_32"><?= $in ?></span><span class="e50_11">:</span><span
            class="e50_31">:</span><span class="e50_30">:</span><span class="e50_25">:</span><span
            class="e50_12">:</span><span class="e50_13">:</span><span class="e50_14">:</span><span
            class="e50_15">:</span><span class="e50_6">UNIT/SUB UNIT</span><span class="e50_7">ID KARYAWAN</span><span
            class="e50_8">TANGGAL</span><span class="e50_9">KETERANGAN</span><span class="e51_45">IT</span>
    </div>
</body>

<script>
$(document).ready(function() {
    var printContents = document.getElementById('formprint').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
});
</script>

</html>