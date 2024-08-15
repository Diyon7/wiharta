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
                                            <table id="example3" class="table table-bordered table-striped" border='1px'
                                                style="border-collapse: collapse;">
                                                <thead>
                                                    <tr bgcolor="LightGray">
                                                        <th colspan="7">
                                                            <center>
                                                                PT WIHARTA KARYA AGUNG<br>
                                                                JURNAL PENGELUARAN BANK<br>
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
                                                            AJU
                                                        </th>
                                                        <th>
                                                            VENDOR
                                                        </th>
                                                        <th>DESCRIPTION
                                                        </th>
                                                        <th>
                                                            DEBIT
                                                        </th>
                                                        <th>
                                                            KREDIT
                                                        </th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php
                                                    $jt1 = 0;
                                                    $jt2 = 0;
                                                    foreach ($datajurnal as $jur) :
                                                        $jt1 += $jur['kredit'];
                                                        $jt2 += $jur['debit'];
                                                    ?>
                                                    <?php if ($jur['kredit'] != '0') { ?>
                                                    <tr>
                                                        <td><?php echo $jur['tgl']; ?>
                                                        </td>
                                                        <td><?php echo $jur['kode']; ?>
                                                        </td>
                                                        <td><?php echo $jur['aju']; ?>
                                                        </td>
                                                        <td><?php echo $jur['supplier']; ?>
                                                        </td>
                                                        <td>Hutang
                                                        </td>
                                                        </td>
                                                        <td><?php echo 'USD ' . number_format($jur['kredit'], 2, ',', '.'); ?>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php if ($jur['biayabank'] != '0') { ?>
                                                    <tr>
                                                        <td><?php echo $jur['tgl']; ?>
                                                        </td>
                                                        <td><?php echo $jur['kode']; ?>
                                                        </td>
                                                        <td><?php echo $jur['aju']; ?>
                                                        </td>
                                                        <td><?php echo $jur['supplier']; ?>
                                                        </td>
                                                        <td>Bank Charge
                                                        </td>
                                                        <td><?php echo 'USD ' . number_format($jur['biayabank'], 2, ',', '.'); ?>
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php if ($jur['biayaasuransi'] != '0') { ?>
                                                    <tr>
                                                        <td><?php echo $jur['tgl']; ?>
                                                        </td>
                                                        <td><?php echo $jur['kode']; ?>
                                                        </td>
                                                        <td><?php echo $jur['aju']; ?>
                                                        </td>
                                                        <td><?php echo $jur['supplier']; ?>
                                                        </td>
                                                        <td>Asuransi
                                                        </td>
                                                        <td><?php echo 'USD ' . number_format($jur['biayaasuransi'], 2, ',', '.'); ?>
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php if ($jur['biayatransport'] != '0') { ?>
                                                    <tr>
                                                        <td><?php echo $jur['tgl']; ?>
                                                        </td>
                                                        <td><?php echo $jur['kode']; ?>
                                                        </td>
                                                        <td><?php echo $jur['aju']; ?>
                                                        </td>
                                                        <td><?php echo $jur['supplier']; ?>
                                                        </td>
                                                        <td>Transportasi
                                                        </td>
                                                        <td><?php echo 'USD ' . number_format($jur['biayatransport'], 2, ',', '.'); ?>
                                                        </td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php if ($jur['debit'] != '0') { ?>
                                                    <tr>
                                                        <td><?php echo $jur['tgl']; ?>
                                                        </td>
                                                        <td><?php echo $jur['kode']; ?>
                                                        </td>
                                                        <td><?php echo $jur['aju']; ?>
                                                        </td>
                                                        <td><?php echo $jur['supplier']; ?>
                                                        </td>
                                                        <td>Bank
                                                        </td>
                                                        <td>
                                                        </td>
                                                        <td><?php echo 'USD ' . number_format($jur['debit'], 2, ',', '.'); ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                    <?php endforeach; ?>
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

                                                        <th><?php echo 'USD ' . number_format($jt1, 2, ',', '.'); ?>
                                                        </th>
                                                        <th><?php echo 'USD ' . number_format($jt2, 2, ',', '.'); ?>
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