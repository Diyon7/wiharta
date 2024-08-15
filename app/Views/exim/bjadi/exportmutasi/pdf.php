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
        <center><strong><u>BUKTI EXPORT BARANG</u></strong></center>
    </h3>
    <br>
    <?php if ($header == '') { ?>
    Data kosong atau Salah input invoice
    <?php } else { ?>
    <div class="row">
        <table width="100%">
            <tr>
                <td style="width: 50%;">
                    <div class="col-xs-3">
                        <h3 class="box-title">
                            <table>
                                <tr>
                                    <td style="vertical-align: top;">Pembeli</td>
                                    <td style="vertical-align: top;">:</td>
                                    <td><?= $header['namacus'] ?></td>
                                </tr>
                                <tr>
                                    <td>Negara</td>
                                    <td style="vertical-align: top;">:</td>
                                    <td><?= $header['negara'] ?></td>
                                </tr>
                            </table>
                        </h3>
                    </div>
                </td>
                <td style="width: 10%;"></td>
                <td style="width: 40%;">
                    <div class="col-xs-3">
                        <h3 class="box-title">
                            <table
                                style="background-color: #ffffff; filter: alpha(opacity=40); opacity: 0.95;border:1px solid;">
                                <tr>
                                    <td>No Inv</td>
                                    <td>: <?= $header['inv'] ?></td>
                                </tr>
                                <tr>
                                    <td>No Surat Jalan</td>
                                    <td>: <?= $header['nobpb'] ?></td>
                                </tr>
                                <tr>
                                    <td>No Peb</td>
                                    <td>: <?= $header['peb'] ?></td>
                                </tr>
                                <tr>
                                    <td>Tgl Peb</td>
                                    <td>: <?= $header['tglpeb'] ?></td>
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
                    <th align='center'>Satuan</th>
                    <th align='center'>Banyaknya</th>
                    <th align='center'>AJU (Nama Bahan)</th>
                    <th align='center'>Kgm Aju</th>
                    <th align='center'>Kgm</th>


                </tr>
            </thead>
            <tbody>
                <?php
                    $no = 1;
                    $totalqty = 0;
                    $totalkgm = 0;
                    foreach ($listitem as $li) : ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= $li['kode_item'] ?></td>
                    <td nowrap><?= $li['item_description'] ?></td>
                    <td><?= $li['satuan'] ?></td>
                    <td><?= $li['qty'] ?></td>
                    <td>
                        <?php foreach ($listaju as $la) :
                                    if ($la['kode_item'] == $li['kode_item'] && $la['qtyperitem'] == $li['qty']) {
                                ?>
                        <table>
                            <tr>
                                <td nowrap><?= $la['aju'] . ' (' . $la['desk'] . ') ' ?></td>
                            </tr>
                        </table>
                        <?php
                                    }
                                endforeach ?>
                    </td>
                    <td>
                        <?php foreach ($listaju as $la) :
                                    if ($la['kode_item'] == $li['kode_item'] && $la['qtyperitem'] == $li['qty']) {
                                ?>
                        <table>
                            <tr>
                                <td><?= $la['kgm'] ?></td>
                            </tr>
                        </table>
                        <?php
                                    }
                                endforeach ?>
                    </td>
                    <td><?= $li['kgm'] ?></td>
                </tr>
                <?php
                        $no += 1;
                        $totalqty += $li['qty'];
                        $totalkgm += $li['kgm'];
                    endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">Total</td>
                    <td><?= $totalqty ?></td>
                    <td></td>
                    <td><?= number_format($totalkgm, 2, ',', '.') ?></td>
                    <td><?= number_format($totalkgm, 2, ',', '.') ?></td>
                </tr>
            </tfoot>
        </table>

    </div>
    <br>


    <br>
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
                <center><strong>PANDJI ROCKY PD</strong></center>
            </td>
            <td>
                <center><strong>M. JIHAD</strong></center>
            </td>
            <td>
                <center><strong></strong></center>
            </td>
            <td>
                <center><strong></strong></center>
            </td>
        </tr>
    </table>

    <?php } ?>

</div>
<!-- <script src="https://unpkg.com/pdfobject"></script>
<script>
PDFObject.embed("<?= base_url('Pdf/htmlToPDF') ?>", "#my-pdf");
</script> -->