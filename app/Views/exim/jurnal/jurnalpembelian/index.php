<?= $this->extend('layouts/main_master') ?>

<?= $this->section('isi') ?>
<!-- Small boxes (Stat box) -->
<div class="row">

</div>

<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-1"></i>
                    JURNAL PEMBELIAN
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#bdb" id="dbdb" data-toggle="tab">BELUM DI JURNAL</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sedb" id="dsedb" data-toggle="tab">SEMUA JURNAL</a>
                        </li>
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="bdb" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="belumjurnalpembeliantabel"
                                    class="w-100 table table-sm table-bordered table-striped">
                                    <div class="form-row">
                                    </div>
                                    <thead class="text-sm">
                                        <th>No</th>
                                        <th>BAPB</th>
                                        <th>Tanggal BAPB</th>
                                        <th>AJU</th>
                                        <th>PO</th>
                                        <th>Suppliyer</th>
                                        <th>Item</th>
                                        <th>Nama Item</th>
                                        <th>Satuan</th>
                                        <th>QTY</th>
                                        <th>KGM</th>
                                        <th>NILAI</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody class="text-sm">

                                    </tbody>
                                </table>
                                <div id="rendered"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="sedb" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="semuajurnalpembeliantabel"
                                    class="w-100 table table-sm table-bordered table-striped">
                                    <button type="button" class="btn btn-primary btn-add col-sm-1" id="add"
                                        data-toggle="modal">
                                        <i class="fas fa-print"></i> Periode
                                    </button>
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="inputItem">TGL Dari</label>
                                            <input type="date" class="form-control" id="tgldarijp" name="tgldari"
                                                placeholder="qty">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputItem">TGL Ke</label>
                                            <input type="date" class="form-control" id="tglkejp" name="tglke"
                                                placeholder="qty">
                                        </div>
                                    </div>
                                    <thead class="text-sm">
                                        <th>No</th>
                                        <th>BAPB</th>
                                        <th>Tanggal BAPB</th>
                                        <th>AJU</th>
                                        <th>PO</th>
                                        <th>Suppliyer</th>
                                        <th>Item</th>
                                        <th>Nama Item</th>
                                        <th>Satuan</th>
                                        <th>QTY</th>
                                        <th>KGM</th>
                                        <th>NILAI</th>
                                        <th>KURS</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody class="text-sm">

                                    </tbody>
                                </table>
                                <div id="rendered2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
</div>

<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
const flashDataa = "<?= session()->getFlashdata('success') ?>";

$(document).ready(function() {

    const Toasts = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 15000
    });

    let kurs = $('.kurs');
    kurs.bind('keyup', function() {
        var nilai = $(".nilai").val();
        var kurs = $(this).val();
        console.log(nilai * kurs);
        $(".rupiah").val(nilai * kurs);
    });

    $('#add').on('click', function(e) {
        $.ajax({
            url: "<?= base_url('admin/jurnal/bjurnalpembelian/modalcetakperiode') ?>",
            method: "post",
            dataType: "json",
            beforeSend: function() {
                $('.btn-add').attr('disable', 'disabled');
                $('.btn-add').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-add').removeAttr('disable');
                $('.btn-add').html('<i class=\"fas fa-print\"></i> Periode');
            },
            success: function(response) {
                if (response.sukses) {
                    $('.vieweditdata').html(response.sukses).show();
                    $('#editdata').modal('show');
                }
                $('input[name=csrf_test_name]').val(response.csrf_test_name);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $('#semuajurnalpembeliantabel tbody').on('click', '.btn-delete', function(e) {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Yakin hapus ?',
            text: "Apakah yakin menghapus data ini !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/jurnal/sejurnalpembelian/delete') ?>",
                    method: "post",
                    data: {
                        id: id,

                    },
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        if (response.sukses) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            $('#semuajurnalpembeliantabel').DataTable().ajax
                                .reload();
                        }
                        $('input[name=csrf_test_name]').val(response
                            .csrf_test_name);
                    },
                    error: function(xhr, ajaxOption, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
                    }
                });

            }
        })
    });

    $('.tanggalinput').daterangepicker();

    $('.pilihnamaitem').select2({
        width: '290px'
    });

    $('.aju').select2({
        width: '290px'
    });


    $(".pilihnamaitem").change(function() {
        var namatujuan = $(this).val();
        console.log(namatujuan);
        $("#kodeitem").val(namatujuan);
    });

    $('#dsedb').on('click', function(event) {
        var tajp3a = $('#semuajurnalpembeliantabel').DataTable({
            "destroy": true,
            "dom": 'Blfrtip',
            "processing": true,
            "serverSide": true,
            "order": [],
            "buttons": ["copy", "csv", "excel"],
            'language': {
                'loadingRecords': '&nbsp;',
                'processing': '<div class="spinner">Data Diproses</div>'
            },
            "ajax": {
                "url": "<?= site_url('admin/jurnal/sejurnalpembelian/datatables') ?>",
                "type": "POST",
                "data": function(data) {
                    data.tgldari = $('#tgldarijp').val();
                    data.tglke = $('#tglkejp').val();
                },
            },
            drawCallback: function(settings) {
                $('#rendered2').html(settings.json.rendered);
                console.log(settings.json.datafilter);
            },
            "lengthMenu": [
                [5, 10, 25, 100, -1],
                [5, 10, 25, 100, "All"]
            ],
            "columnDefs": [{
                "targets": 13,
                "orderable": false,
            }],
        });
        $("#tgldarijp").change(function() {
            tajp3a.draw();
        });
        $("#tglkejp").change(function() {
            tajp3a.draw();
        });
    });

    var tajp3 = $('#belumjurnalpembeliantabel').DataTable({
        // "dom": 'Blfrtip',
        // "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "buttons": ["copy", "csv", "excel"],
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': '<div class="spinner">Data Diproses</div>'
        },
        "ajax": {
            "url": "<?= site_url('admin/jurnal/bjurnalpembelian/datatables') ?>",
            "type": "POST",
            "data": function(data) {},
        },
        drawCallback: function(settings) {
            $('#rendered').html(settings.json.rendered);
        },
        "lengthMenu": [
            [5, 10, 25, 100, 500, -1],
            [5, 10, 25, 100, 500, "All"]
        ],
        "columnDefs": [{
            "targets": 12,
            "orderable": false,
        }],
    });


    $("#pilihtujuan").change(function() {
        var namatujuan = $(this).val();
        console.log(namatujuan);
        tajp3.draw();
    });
    $("#itemfilter").change(function() {
        tajp3.draw();
    });

    $('#belumjurnalpembeliantabel tbody').on('click', '.btn-add', function(e) {
        const id = $(this).data('seq');

        $.ajax({
            url: "<?= base_url('admin/jurnal/bjurnalpembelian/add') ?>",
            method: "post",
            data: {
                id: id
            },
            dataType: "json",
            beforeSend: function() {
                $('.btn-add').attr('disable', 'disabled');
                $('.btn-add').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-add').removeAttr('disable');
                $('.btn-add').html('<i class=\"fas fa-plus\"></i>');
            },
            success: function(response) {
                if (response.sukses) {
                    $('.vieweditdata').html(response.sukses).show();
                    $('#editdata').modal('show');
                }
                $('input[name=csrf_test_name]').val(response.csrf_test_name);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $('#semuajurnalpembeliantabel tbody').on('click', '.btn-print', function(e) {
        const id = $(this).data('id');

        $.ajax({
            url: "<?= base_url('admin/jurnal/bjurnalpembelian/tampilcetakkode') ?>",
            method: "post",
            data: {
                id: id
            },
            dataType: "json",
            beforeSend: function() {
                $('.btn-print').attr('disable', 'disabled');
                $('.btn-print').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-print').removeAttr('disable');
                $('.btn-print').html('<i class=\"fas fa-print\"></i>');
            },
            success: function(response) {
                if (response.sukses) {
                    $('.vieweditdata').html(response.sukses).show();
                    $('#editdata').modal('show');
                }
                $('input[name=csrf_test_name]').val(response.csrf_test_name);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $('#semuajurnalpembeliantabel tbody').on('click', '.btn-edit', function(e) {
        const id = $(this).data('id');

        $.ajax({
            url: "<?= base_url('admin/jurnal/sejurnalpembelian/edit') ?>",
            method: "post",
            data: {
                id: id
            },
            dataType: "json",
            beforeSend: function() {
                $('.btn-edit').attr('disable', 'disabled');
                $('.btn-edit').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-edit').removeAttr('disable');
                $('.btn-edit').html('<i class=\"fas fa-edit\"></i>');
            },
            success: function(response) {
                if (response.sukses) {
                    $('.vieweditdata').html(response.sukses).show();
                    $('#editdata').modal('show');
                }
                $('input[name=csrf_test_name]').val(response.csrf_test_name);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

});

$(document).ready(function() {

    const Toasts = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 15000
    });

    $('#dbdb').on('click', function(e) {
        $('#belumjurnalpembeliantabel').DataTable().ajax.reload();
    });

    $('#namakaryawan').select2({
        width: '500px'
    });

});
</script>

<?= $this->endSection() ?>