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
                    JURNAL PENJUALAN
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
                                <table id="belumjurnalpenjualantabel"
                                    class="w-100 table table-sm table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>No</th>
                                        <th>BPB</th>
                                        <th>TGL BPB</th>
                                        <th>PEB</th>
                                        <th>TGL PEB</th>
                                        <th>INVOICE</th>
                                        <th>CUSTOMER</th>
                                        <th>ITEM</th>
                                        <th>NAMA ITEM</th>
                                        <th>SATUAN</th>
                                        <th>QTY</th>
                                        <th>KGM</th>
                                        <th>NILAI</th>
                                        <th>MU</th>
                                        <th>UPDATED AT</th>
                                        <th>AKSI</th>
                                    </thead>
                                    <tbody class="text-sm">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="sedb" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="semuajurnalpenjualantabel"
                                    class="w-100 table table-sm table-bordered table-striped">
                                    <button type="button" class="btn btn-primary btn-add col-sm-1" id="add"
                                        data-toggle="modal">
                                        <i class="fas fa-print"></i> Periode
                                    </button>
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="inputItem">TGL Dari</label>
                                            <input type="date" class="form-control" id="tgldari" name="tgldari"
                                                placeholder="qty">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputItem">TGL Ke</label>
                                            <input type="date" class="form-control" id="tglke" name="tglke"
                                                placeholder="qty">
                                        </div>
                                    </div>
                                    <thead class="text-sm">
                                        <th>No</th>
                                        <th>BPB</th>
                                        <th>TGL BPB</th>
                                        <th>PEB</th>
                                        <th>TGL PEB</th>
                                        <th>INVOICE</th>
                                        <th>CUSTOMER</th>
                                        <th>ITEM</th>
                                        <th>NAMA ITEM</th>
                                        <th>SATUAN</th>
                                        <th>QTY</th>
                                        <th>KGM</th>
                                        <th>NILAI</th>
                                        <th>MU</th>
                                        <th>KURS</th>
                                        <th>UPDATED AT</th>
                                        <th>AKSI</th>
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

<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
const flashDataa = "<?= session()->getFlashdata('success') ?>";

$(document).ready(function() {

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

    $('#add').on('click', function(e) {
        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpenjualan/modalcetakperiode') ?>",
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

    $('#dsedb').on('click', function(event) {
        var tajp3 = $('#semuajurnalpenjualantabel').DataTable({
            "dom": 'Blfrtip',
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "buttons": ["copy", "csv", "excel"],
            'language': {
                'loadingRecords': '&nbsp;',
                'processing': '<div class="spinner">Data Diproses</div>'
            },
            "ajax": {
                "url": "<?= site_url('admin/jurnal/semuajurnalpenjualan/datatables') ?>",
                "type": "POST",
                "data": function(data) {
                    // data.pilihtujuan = $('#pilihtujuan').val();
                    data.tgldari = $('#tgldari').val();
                    data.tglke = $('#tglke').val();
                    // data.itemfilter = $('#itemfilter').val();
                },
            },
            drawCallback: function(settings) {
                // $('#totalqty').html(settings.json.totalqty);
                $('#totalkgm').html(settings.json.totalkgm);
            },
            "lengthMenu": [
                [5, 10, 25, 100, 500, -1],
                [5, 10, 25, 100, 500, "All"]
            ],
            "columnDefs": [{
                "targets": 15,
                "orderable": false,
            }],
        });
    });

    var tajp3 = $('#belumjurnalpenjualantabel').DataTable({
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
            "url": "<?= site_url('admin/jurnal/belumjurnalpenjualan/datatables') ?>",
            "type": "POST",
            "data": function(data) {
                // data.pilihtujuan = $('#pilihtujuan').val();
                data.tgldari = $('#tgldari').val();
                data.tglke = $('#tglke').val();
                // data.itemfilter = $('#itemfilter').val();
            },
        },
        drawCallback: function(settings) {
            // $('#totalqty').html(settings.json.totalqty);
            $('#totalkgm').html(settings.json.totalkgm);
        },
        "lengthMenu": [
            [5, 10, 25, 100, 500, -1],
            [5, 10, 25, 100, 500, "All"]
        ],
        "columnDefs": [{
            "targets": 15,
            "orderable": false,
        }],
    });

    $("#tgldari").change(function() {
        tajp3.draw();
    });
    $("#tglke").change(function() {
        tajp3.draw();
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

    $('.addjurnalpembelian').submit(function(e) {
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
                console.log(response.success);
                if (response.success) {
                    $('#gantishift').modal('hide');
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                    $("#semuajurnalpenjualantabel").DataTable().ajax.reload();
                } else {
                    $('#gantishift').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('#semuajurnalpenjualantabel tbody').on('click', '.btn-delete', function(e) {
        const sec = $(this).data('sec');

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
                    url: "<?= site_url('admin/mutasi/jurnalpembelian/deletejurnalpembelian') ?>",
                    method: "post",
                    data: {
                        sec: sec,

                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            $('#semuajurnalpenjualantabel').DataTable().ajax
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

    $('#semuajurnalpenjualantabel tbody').on('click', '.btn-print', function(e) {
        const id = $(this).data('id');
        console.log(id);

        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpenjualan/tampilcetakkode') ?>",
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
                $('.btn-print').html('<i class="fas fa-print"></i>');
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

    $('#semuajurnalpenjualantabel tbody').on('click', '.btn-edit', function(e) {
        const id = $(this).data('sec');

        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpenjualan/edit') ?>",
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
                $('.btn-edit').html('<i class="fas fa-edit"></i>');
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

    $('#dbdb').on('click', function(e) {
        $('#belumjurnalpenjualantabel').DataTable().ajax.reload();
    });

    $('#belumjurnalpenjualantabel tbody').on('click', '.btn-add', function(e) {
        const id = $(this).data('id');

        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpenjualan/nambahjurnal') ?>",
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

    $('#namakaryawan').select2({
        width: '500px'
    });

});
</script>

<?= $this->endSection() ?>