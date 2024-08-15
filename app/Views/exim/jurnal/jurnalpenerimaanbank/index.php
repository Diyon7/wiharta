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
                    JURNAL PENERIMAAN BANK
                </h3>
                <br>
                <button type="button" class="btn btn-primary btn-add col-sm-1" id="add" data-toggle="modal">
                    TAMBAH <i class=" fas fa-plus"></i>
                </button>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="jurnalpenerimaanbank"
                                    class="w-100 table table-sm table-bordered table-striped">
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
                                        <th>BANK</th>
                                        <th>TGL</th>
                                        <th>PEB</th>
                                        <th>TGL PEB</th>
                                        <th>INVOICE</th>
                                        <th>KONSUMEN</th>
                                        <th>NILAI</th>
                                        <th>MATA UANG</th>
                                        <th>REKAM</th>
                                        <th>Aksi</th>
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



    var tajp3 = $('#jurnalpenerimaanbank').DataTable({
        "dom": 'Blfrtip',
        // "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "buttons": ["copy", "csv", "excel", "print"],
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': '<div class="spinner">Data Diproses</div>'
        },
        "ajax": {
            "url": "<?= site_url('admin/jurnal/jurnalpenerimaanbank/datatables') ?>",
            "type": "POST",
            "data": function(data) {
                // data.pilihtujuan = $('#pilihtujuan').val();
                data.tgldari = $('#tgldari').val();
                data.tglke = $('#tglke').val();
                // data.itemfilter = $('#itemfilter').val();
            },
        },
        drawCallback: function(settings) {
            $('#totalqty').html(settings.json.totalqty);
            $('#totalkgm').html(settings.json.totalkgm);
        },
        "lengthMenu": [
            [5, 10, 25, 100, 500, -1],
            [5, 10, 25, 100, 500, "All"]
        ],
        "columnDefs": [{
            "targets": 10,
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

    $('#jurnalpenerimaanbank tbody').on('click', '.btn-delete', function(e) {
        const kode = $(this).data('kode');

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
                    url: "<?= site_url('admin/jurnal/jurnalpenerimaanbank/deletejurnal') ?>",
                    method: "post",
                    data: {
                        kode: kode,

                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            $('#jurnalpenerimaanbank').DataTable().ajax
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
                // alert("sek bentar");

            }
        })
    });

    $('#jurnalpenerimaanbank tbody').on('click', '.btn-print', function(e) {
        const id = $(this).data('kode');

        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpenerimaanbank/tampilcetakkode') ?>",
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

    $('#jurnalpenerimaanbank tbody').on('click', '.btn-edit', function(e) {
        const id = $(this).data('kode');

        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpenerimaanbank/edit') ?>",
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

    $('#jurnalpenerimaanbank tbody').on('click', '.btn-editm', function(e) {
        const id = $(this).data('sec');

        $.ajax({
            url: "<?= base_url('admin/mutasi/jurnalpembelian/editm') ?>",
            method: "post",
            data: {
                id: id
            },
            dataType: "json",
            beforeSend: function() {
                $('.btn-editm').attr('disable', 'disabled');
                $('.btn-editm').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-editm').removeAttr('disable');
                $('.btn-editm').html('<i class="fas fa-edit"></i> Kode');
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

    $('#jurnalpenerimaanbank tbody').on('click', '.btn-editi', function(e) {
        const id = $(this).data('sec');

        $.ajax({
            url: "<?= base_url('admin/mutasi/jurnalpembelian/editi') ?>",
            method: "post",
            data: {
                id: id
            },
            dataType: "json",
            beforeSend: function() {
                $('.btn-editi').attr('disable', 'disabled');
                $('.btn-editi').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-editi').removeAttr('disable');
                $('.btn-editi').html('<i class="fas fa-edit"></i> Item');
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

    $('#add').on('click', function(e) {

        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpenerimaanbank/tambah') ?>",
            method: "post",
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