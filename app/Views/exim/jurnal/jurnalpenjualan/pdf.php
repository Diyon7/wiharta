<div class="box">
    <div class="box-body">
        <table id="example3" class="table table-responsive table-bordered table-striped" border='1px'
            style="border-collapse: collapse;">
            <thead>
                <tr bgcolor="LightGray">
                    <th colspan="11">
                        <center>
                            PT WIHARTA KARYA AGUNG<br>
                            JURNAL PENJUALAN<br>
                            PERIODE : <?= $tgl['tgldari'] ?> SAMPAI <?= $tgl['tglke'] ?>
                        </center>
                    </th>
                </tr>
                <tr bgcolor="LightGray">
                    <th rowspan="2">
                        TANGGAL
                    </th>
                    <th rowspan="2">
                        BPB
                    </th>
                    <th rowspan="2">
                        INVOICE
                    </th>
                    <th rowspan="2">
                        PEB
                    </th>
                    <th rowspan="2">
                        CUSTOMER
                    </th>
                    <th rowspan="2">
                        MU
                    </th>
                    <th rowspan="2">
                        KURS
                    </th>
                    <th colspan="2">
                        DEBIT
                    </th>
                    <th colspan="2">
                        KREDIT
                    </th>
                </tr>
                <tr bgcolor="LightGray">
                    <th>
                        PIUTANG DAGANG
                    </th>
                    <th>
                        RUPIAH
                    </th>
                    <th>
                        PENJUALAN
                    </th>
                    <th>
                        RUPIAH
                    </th>
                </tr>
            </thead>

            <tbody>
                <?php
                $jt1 = 0;
                $jt2 = 0;
                $jt3 = 0;
                $jt4 = 0;
                ?>
                <?php foreach ($datajurnal as $jur) : ?>
                <tr>
                    <td><?php echo $jur['tgl']; ?>
                    </td>
                    <td><?php echo $jur['bukti']; ?>
                    </td>
                    <td><?php echo $jur['inv']; ?>
                    </td>
                    <td><?php echo $jur['peb']; ?>
                    </td>
                    <td><?php echo $jur['cus']; ?>
                    </td>
                    <td><?php echo $jur['mu']; ?>
                    </td>
                    <td><?php echo number_format($jur['kurs'], 2, ',', '.'); ?>
                    </td>
                    <td><?php echo 'USD ' . number_format($jur['debit'], 2, ',', '.'); ?>
                    </td>
                    <td><?php echo 'IDR ' . number_format($jur['debit'] * $jur['kurs'], 2, ',', '.'); ?>
                    </td>
                    <td><?php echo 'USD ' . number_format($jur['kredit'], 2, ',', '.'); ?>
                    </td>
                    <td><?php echo 'IDR ' . number_format($jur['kredit'] * $jur['kurs'], 2, ',', '.'); ?>
                    </td>
                </tr>
                <?php
                    $jt1 += $jur['debit'];
                    $jt3 += $jur['debit'] * $jur['kurs'];
                    $jt2 += $jur['kredit'];
                    $jt4 += $jur['kredit'] * $jur['kurs'];
                    ?>
                <?php endforeach ?>
            </tbody>
            <tfoot bgcolor="LightGray">
                <tr>
                    <th>
                    </th>
                    <th>
                    </th>
                    <th>
                    </th>
                    <th>
                    </th>
                    <th>
                    </th>
                    <th colspan="2" rowspan="2"> TOTAL SALDO
                    </th>
                    <th colspan="2">
                        <center>TOTAL DEBIT</center>
                    </th>
                    <th colspan="2">
                        <center>TOTAL KREDIT</center>
                    </th>
                </tr>
                <tr>
                    <th>
                    </th>
                    <th>
                    </th>
                    <th>
                    </th>
                    <th>
                    </th>
                    <th>
                    </th>

                    <th><?php echo 'USD ' . number_format($jt1, 2, ',', '.'); ?>
                    </th>
                    <th><?php echo 'IDR ' . number_format($jt3, 2, ',', '.'); ?>
                    </th>
                    <th><?php echo 'USD ' . number_format($jt2, 2, ',', '.'); ?>
                    </th>
                    <th><?php echo 'IDR ' . number_format($jt4, 2, ',', '.'); ?>
                    </th>
                </tr>

            </tfoot>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->