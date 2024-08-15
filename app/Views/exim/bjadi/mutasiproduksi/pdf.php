<style>
.pdfobject-container {
    height: 500px;
    border: 1px solid #ccc;
}
</style>
<div class="box-header">
    <h3 class="box-title"><strong><u>PT. WIHARTA KARYA AGUNG</u></strong></h3>
    <br>
    <h3>
        <center><strong><u>BUKTI PENYERAHAN BARANG</u></strong></center>
    </h3>
    <br>
    <?php if ($header == '') { ?>
    Data kosong atau kode salah
    <?php } else { ?>
    <div class="row">
        <table width="100%">
            <tr>
                <td>
                    <div class="col-xs-3">
                        <h3 class="box-title">
                            <table>
                                <tr>
                                    <td>Kepada</td>
                                    <td>: <?= $header['tujuan'] ?></td>
                                </tr>
                                <tr>
                                    <td>Dari</td>
                                    <td>: <?= $header['asal'] ?></td>
                                </tr>
                            </table>
                        </h3>
                    </div>
                </td>
                <td>
                    <div class="col-xs-3">
                        <h3 class="box-title">
                            <table
                                style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px solid;">
                                <tr>
                                    <td>Kode</td>
                                    <td>: <?= $header['kode2'] ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal</td>
                                    <td>: <?= $header['tgl'] ?></td>
                                </tr>
                            </table>
                        </h3>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    </h3>
    <div class="box-body">
        <table id="example1" border='1px' style="border-collapse: collapse;" width="100%">
            <thead>
                <tr>

                    <th align='center'>No.</th>
                    <th align='center'>Kode Item</th>
                    <th align='center'>Nama & Spesifikasi Barang</th>
                    <th align='center'>AJU (Nama Bahan)</th>
                    <th align='center'>Satuan</th>
                    <th align='center'>Banyaknya</th>
                    <th align='center'>Kgm Aju</th>
                    <?php if ($header['asal'] == 'Hasil Produksi Unit Finishing' && $header['tujuan'] == 'Gudang Utama Barang Jadi') { ?>
                    <th align='center'>Kgm</th>
                    <?php } else {
                        } ?>


                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    $totalqty = 0;
                    $totalkgm = 0;
                    foreach ($listitem as $lte) :

                    ?>
                <tr>
                    <?php if ($lte['code'] == 1) { ?>
                    <td nowrap><?= $no ?></td>
                    <td nowrap><?= $lte['item'] ?></td>
                    <td><?= $lte['item_description'] ?></td>
                    <?php
                                $no += 1;
                            } else { ?>
                    <td colspan="3" nowrap></td>
                    <?php } ?>
                    <td nowrap><?= $lte['no_aju'] . ' (' . $lte['desk'] . ') ' ?></td>
                    <?php if ($lte['code'] == 1) { ?>
                    <td nowrap><?= $lte['satuan'] ?></td>
                    <td nowrap><?= $lte['alltotalqty'] ?></td>
                    <?php } else {
                            ?>
                    <td colspan="2" nowrap></td>
                    <?php } ?>
                    <td nowrap><?= number_format($lte['kgm'], 2, ',', '.') ?></td>
                    <?php if ($header['asal'] == 'Hasil Produksi Unit Finishing' && $header['tujuan'] == 'Gudang Utama Barang Jadi') { ?>
                    <?php if ($lte['code'] == 1) { ?>
                    <td nowrap><?= $lte['totalkg'] ?></td>
                    <?php } else {
                                ?>
                    <td colspan="2" nowrap></td>
                    <?php } ?>
                    <?php } else {
                            } ?>
                </tr>
                <?php
                        if ($lte['code'] == 1) {
                            $totalqty += $lte['alltotalqty'];
                        }
                        $totalkgm += $lte['kgm'];
                        ?>
                <?php
                    endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">Total</td>
                    <td><?= $totalqty ?></td>
                    <td><?= number_format($totalkgm, 2, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>

    </div>
    <br>


    <br>
    <?php if ($ttd == '') { ?>
    Tanda tangan kosong
    <?php } else { ?>

    <table border='1' width='100%' style="border-collapse: collapse;" align='center'>
        <tr>
            <td colspan='2'>
                <center><strong>Diserahkan Oleh</strong></center>
            </td>
            <td colspan='2'>
                <center><strong>Diterima Oleh</strong></center>
            </td>
        </tr>
        <tr>
            <td>
                <center>Mengetahui</center>
            </td>
            <td>
                <center>Yang Menyerahkan</center>
            </td>
            <td>
                <center>Mengetahui</center>
            </td>
            <td>
                <center>Penerima</center>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <br>
                <br>
                <br>
                <br>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
        </tr>
        <tr>
            <td>
                <center><strong><?= $ttd['dkm'] ?></strong></center>
            </td>
            <td>
                <center><strong><?= $ttd['dkym'] ?></strong></center>
            </td>
            <td>
                <center><strong><?= $ttd['dim'] ?></strong></center>
            </td>
            <td>
                <center><strong><?= $ttd['dipm'] ?></strong></center>
            </td>
        </tr>
    </table>

    <br>
    <center>Diisi Oleh Akuntansi</center>
    <table border='1' width='100%' style="border-collapse: collapse;" align='center'>

        <tr>
            <td>
                <center>D/K</center>
            </td>
            <td>
                <center>Kode Perkiraan</center>
            </td>
            <td>
                <center>Jumlah</center>
            </td>
            <td>
                <center>Diinput Oleh</center>
            </td>
        </tr>
        <tr>
            <td>
                <br>
                <br>
                <br>
                <br>
                <br>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>Tanggal :
                <br>
                <br>
                <br>
                <br>
                <br>
            </td>
        </tr>
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                <center><strong>YOSEPH ST</strong></center>
            </td>
        </tr>

    </table>
    <?php   } ?>
    <?php } ?>

</div>
<!-- <script src="https://unpkg.com/pdfobject"></script>
<script>
PDFObject.embed("<?= base_url('Pdf/htmlToPDF') ?>", "#my-pdf");
</script> -->