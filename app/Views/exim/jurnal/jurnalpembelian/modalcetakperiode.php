<style>
    .pdfobject-container {
        height: 500px;
        border: 1px solid #ccc;
    }
</style>
<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <?= form_open('admin/jurnal/bjurnalpembelian/tampilcetakperiode', ['class' => 'formcetak']) ?>
                <div class="input-group input-group-sm mb-3">
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label for="inputItem">TGL Dari</label>
                            <input type="date" class="form-control" id="tgldari" name="tgldari" placeholder="qty">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="inputItem">TGL Ke</label>
                            <input type="date" class="form-control" id="tglke" name="tglke" placeholder="qty">
                        </div>
                        <button type="submit" class="btn btn-primary btntampil">TAMPIL !</button>
                    </div>
                </div>
                <?= form_close() ?>
            </div>
            <div class="modal-body">
                <button class="btn btn-primary" onclick="printData()">Print</button>
                <div class="card">
                    <div class="card-body">
                        <div class="outer">
                            <div id="my-pdf"></div>
                            <div id="printableArea">
                                <div class="inner listcetak">
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