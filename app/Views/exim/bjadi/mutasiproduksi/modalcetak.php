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
                <?= form_open('admin/mutasi/mutasiproduksi/tampilcetak', ['class' => 'formcetak']) ?>
                <div class="input-group input-group-sm mb-3">
                    <!-- <select name="kode2" id="kode2" class="kode2 col-sm-5" required>
                        <option value="">Pilih</option>
                    </select> -->
                    <input type="text" name="kode2" class="col-sm-5">
                    <button type="submit" class="btn btn-primary btntampil">TAMPIL !</button>
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

    $('.kode2').select2({
        width: '350px',
        minimumInputLength: 10,
        // allowClear: true,
        placeholder: 'Ketik Kode Item',
        ajax: {
            url: '<?= site_url('admin/mutasi/mutasiproduksi/searchkode2') ?>',
            dataType: "json",
            // type: "GET",
            data: function(params) {

                var queryParameters = {
                    search: params.term
                }
                return queryParameters;
            },
            processResults: function(data, page) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.item + ' || ' + item.status + ' || ' + item
                                .item_description,
                            id: item.item,
                        }
                    })
                };
            },
        }
    });
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