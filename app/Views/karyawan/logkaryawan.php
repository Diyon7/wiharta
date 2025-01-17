<?= $this->extend('layouts/main_master') ?>

<?= $this->section('isi') ?>
<!-- Small boxes (Stat box) -->
<div class="row">

    <!-- ./col -->
</div>
<!-- /.row -->
<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <button id="printarea" onclick="printData()" class="btn btn-outline-success">PRINT
            AREA</button>
        <button class="btn btn-primary" onclick="ExportToExcel('xlsx')">EXPORT TO EXCEL</button>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-1"></i>
                    Daftar Log Karyawan dalam 1 bulan
                </h3>

                <div class="card-tools">
                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                        <button type="button" id="refresh" class="btn btn-outline-success">
                            <i class="fas fa-spinner"></i> Segarkan</button>
                    </div>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane downloaddata active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="logkaryawan" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>IDKAR</th>
                                        <th>VENDOR</th>
                                        <th>NAMA</th>
                                        <th>SUB UNIT</th>
                                        <th>DATA SCAN</th>
                                        <th>CEKTYPE</th>
                                    </thead>
                                    <tbody class="text-sm">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
</div>

<?php if (in_groups('vendor')) {
    $vendor = user()->username;
} else {
    $vendor = "%";
} ?>

<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
$(document).ready(function() {
    $("#kkjjp3").on('click', function(event) {
        // tkjp3.destroy();
        var tajp3 = $('#karyawanjp3k').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= site_url('admin/logkaryawan/datatables') ?>",
                "type": "POST",
            },
            "lengthMenu": [
                [5, 10, 25, 100],
                [5, 10, 25, 100]
            ],
            "columnDefs": [{
                "targets": [5, 6],
                "orderable": false,
            }],
        })
    })
    // tajp3.destroy();
    var tkjp3 = $('#logkaryawan').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('admin/logkaryawan/datatables') ?>",
            "type": "POST",
            "data": {
                "vendor": "<?= $vendor ?>"
            },
        },
        "lengthMenu": [
            [5, 10, 25, 100],
            [5, 10, 25, 100]
        ],
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }],
    })
    // $("#akjjp3").on('click', function(event) {
    //     $('#karyawanjp3a').DataTable().ajax.reload()
    // })
    $('#refresh').click(function(e) {
        $('#logkaryawan').DataTable().ajax.reload()
    });

    $('.detailkaryawan').on('click', function(event) {

    });
});

function ExportToExcel(type, fn, dl) {
    var elt = document.getElementById('ajp3');
    var wb = XLSX.utils.table_to_book(elt, {
        sheet: "sheet1"
    });
    return dl ?
        XLSX.write(wb, {
            bookType: type,
            bookSST: true,
            type: 'base64'
        }) :
        XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
}

function printData() {
    var divToPrint = document.getElementById('ajp3');
    var htmlToPrint = '' +
        '<style type="text/css">' +
        'table th, table td {' +
        'border:1px solid #000;' +
        'padding:0.5em;' +
        '}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
}

function detailkaryawana(id) {
    $.ajax({
        url: "<?= site_url('admin/karyawanjp3a/detaila') ?>",
        type: "POST",
        data: {
            idnip: id
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                $('.vieweditdata').html(response.sukses).show();
                $('#detaildata').modal('show');
            }
            $('input[name=csrf_test_name]').val(response.csrf_test_name);
        },
        error: function(xhr, ajaxOption, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}
</script>

<?= $this->endSection() ?>