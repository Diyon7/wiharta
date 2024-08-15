<style>
    .pdfobject-container {
        height: 500px;
        border: 1px solid #ccc;
    }
</style>
<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <button class="btn btn-primary" onclick="printData()">Print</button>
                <div class="card">
                    <div class="card-body">
                        <div class="outer">
                            <div id="my-pdf"></div>
                            <div id="printableArea">
                                <div class="inner listcetak">
                                    <div class="box">
                                        <div class="box-body">
                                            <table id="example3" class="table table-bordered table-striped" border='1px' style="border-collapse: collapse;">
                                                <thead>
                                                    <tr bgcolor="LightGray">
                                                        <th colspan="7">
                                                            <center>
                                                                PT WIHARTA KARYA AGUNG<br>
                                                                JURNAL PENERIMAAN BANK<br>
                                                            </center>
                                                        </th>
                                                    </tr>
                                                    <tr bgcolor="LightGray">
                                                        <th>
                                                            TANGGAL
                                                        </th>
                                                        <th>
                                                            BUKTI
                                                        </th>
                                                        <th>
                                                            PEB
                                                        </th>
                                                        <th>
                                                            CUSTOMER
                                                        </th>
                                                        <th>DESCRIPTION
                                                        </th>
                                                        <th>
                                                            DEBIT
                                                        </th>
                                                        <th>
                                                            KREDIT

                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $jur['tgl']; ?>
                                                        </td>
                                                        <td><?php echo $jur['kode']; ?>
                                                        </td>
                                                        <td><?php echo $jur['peb']; ?>
                                                        </td>
                                                        <td><?php echo $jur['customer']; ?>
                                                        </td>
                                                        <td><?php echo $jur['nama']; ?>
                                                        </td>
                                                        <?php $fn = $jur['biayabank']; ?>
                                                        <td><?php echo 'USD ' . number_format($jur['biayabank'], 2, ',', '.'); ?>
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $jur['tgl']; ?>
                                                        </td>
                                                        <td><?php echo $jur['kode']; ?>
                                                        </td>
                                                        <td><?php echo $jur['peb']; ?>
                                                        </td>
                                                        <td><?php echo $jur['customer']; ?>
                                                        </td>
                                                        <td>Hutang
                                                        </td>
                                                        <td>
                                                            <table>
                                                                <?php
                                                                $npi = 0;
                                                                foreach ($datapib as $dpib) :
                                                                    if ($dpib['nilai_pib'] != 0) {
                                                                        $npi += $dpib['nilai_pib'];
                                                                ?>
                                                                        <tr>
                                                                            <td><?php echo 'USD ' . number_format($dpib['nilai_pib'], 2, ',', '.') ?>
                                                                            </td>
                                                                        </tr>
                                                                <?php
                                                                    } else {
                                                                    }
                                                                endforeach; ?>
                                                            </table>
                                                        </td>
                                                        <td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $jur['tgl']; ?>
                                                        </td>
                                                        <td><?php echo $jur['kode']; ?>
                                                        </td>
                                                        <td><?php echo $jur['peb']; ?>
                                                        </td>
                                                        <td><?php echo $jur['customer']; ?>
                                                        </td>
                                                        <td>Biaya
                                                        </td>
                                                        <?php $fjur = $jur['nilai']; ?>
                                                        <td><?php echo 'USD ' . number_format($jur['nilai'], 2, ',', '.'); ?>
                                                        </td>
                                                        <td>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $jur['tgl']; ?>
                                                        </td>
                                                        <td><?php echo $jur['kode']; ?>
                                                        </td>
                                                        <td><?php echo $jur['peb']; ?>
                                                        </td>
                                                        <td><?php echo $jur['customer']; ?>
                                                        </td>
                                                        <td>Piutang
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $kd2 = 0;
                                                            foreach ($datapeb as $dpeb) :
                                                                if ($dpeb['nilai_peb'] != 0) {
                                                                    $kd2 += $dpeb['nilai_peb'];
                                                            ?>

                                                                    <?php echo 'USD ' . number_format($dpeb['nilai_peb'], 2, ',', '.') ?><br>

                                                            <?php
                                                                }
                                                            endforeach; ?>
                                                        </td>
                                                    </tr>

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
                                                        <th rowspan="2">TOTAL SALDO
                                                        </th>
                                                        <th>TOTAL DEBIT
                                                        </th>
                                                        <th>TOTAL KREDIT
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
                                                            <?= 'USD ' . number_format(($fjur + $fn + $npi), 2, ',', '.'); ?>
                                                        </th>
                                                        <th>
                                                            <?= 'USD ' . number_format($kd2, 2, ',', '.'); ?>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/pdfobject"></script>
<script>
    function printData() {
        var divToPrint = document.getElementById('printableArea');
        var htmlToPrint = '' +
            '<style type="text/css">' +
            'table th, table td {' +
            'padding:0 em;' +
            '}' +
            '</style>';
        htmlToPrint += divToPrint.outerHTML;
        newWin = window.open("");
        newWin.document.write(htmlToPrint);
        newWin.print();
        newWin.close();
    }
    $(document).ready(function() {

        $('#no_aju').select2({
            width: '290px'
        });
        $('.formcetak').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btntampil').attr('disable', 'disabled');
                    $('.btntampil').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btntampil').removeAttr('disable');
                    $('.btntampil').html('Submit');
                },
                success: function(response) {
                    console.log(response.sukses);
                    $('.listcetak').html(response.sukses);
                    // $('.tabel1').show();
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })
    });
</script>