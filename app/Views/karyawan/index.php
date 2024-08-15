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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-1"></i>
                    Data Karyawan JP3
                </h3>
                <div class="card-tools">
                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                        <a id="addkaryawan" href="<?= base_url() ?>/admin/karyawan/tambahkaryawan"
                            class="btn btn-outline-success"><i class="fa fa-plus"></i>Tambah</a>
                        <!--<div class="btn-group" role="group">-->
                        <!--    <button type="button" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown"-->
                        <!--        aria-expanded="false">-->
                        <!--        Fingerprint-->
                        <!--    </button>-->
                        <!--    <div class="dropdown-menu">-->
                        <!--        <a class="dropdown-item" href="#bfp">Belum</a>-->
                        <!--    </div>-->
                        <!--</div>-->

                    </div>
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#ajp3" id="akjjp3" data-toggle="tab">Aktif</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#kjp3" id="kkjjp3" data-toggle="tab">Keluar</a>
                        </li>
                        <!--<li class="nav-item">-->
                        <!--    <a class="nav-link" href="#bfp" id="kdfkjjp3" data-toggle="tab">Tambah Karyawan</a>-->
                        <!--</li>-->
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="karyawanjp3a" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>IDKAR</th>
                                        <th>VENDOR</th>
                                        <th>NAMA</th>
                                        <th>BAGIAN</th>
                                        <th>UNIT</th>
                                        <th>GOLONGAN</th>
                                        <th>TMT</th>
                                        <th>GRUP_T</th>
                                        <th>AKSI</th>
                                    </thead>
                                    <tbody class="text-sm">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="chart tab-pane" id="kjp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="karyawanjp3k" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th class="text-sm">IDKAR</th>
                                        <th>VENDOR</th>
                                        <th>NAMA</th>
                                        <th>BAGIAN</th>
                                        <th>UNIT</th>
                                        <th>SUB UNIT</th>
                                        <th>TMT</th>
                                        <th>TANGGAL RESIGN</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody class="text-sm">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="bfp" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="karyawanfp" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>IDKAR</th>
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

<div class="modal fade" id="hapuskaryawanmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Karyawan Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/karyawan/keluar', ['class' => 'idsg']) ?>
                <?= csrf_field() ?>
                <input type="hidden" name="iidkar" id="iidkar">
                <div class="form-group">
                    <label for="formGroupInput">Tanggal Keluar</label>
                    <input type="date" class="form-control" id="formGroupInput" name="tglresign"
                        placeholder="Masukkan Tanggal Keluar">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right">Konfirmasi</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="masukkaryawanmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/karyawan/karyawankerja', ['class' => 'idms']) ?>
                <?= csrf_field() ?>
                <input type="hidden" name="aktifidkar" id="aktifidkar">
                <div class="form-group">
                    <label for="formGroupInput">Tanggal Tmt</label>
                    <input type="date" class="form-control" id="aktiftmt" name="aktiftmt">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right">Konfirmasi</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
const flashDataa = "<?= session()->getFlashdata('success') ?>";

$(document).ready(function() {

    $("#kkjjp3").on('click', function(event) {
        // tkjp3.destroy();
        var tajp3 = $('#karyawanjp3k').DataTable({
            "destroy": true,
            "dom": 'Blfrtip',
            "processing": true,
            "serverSide": true,
            "order": [],
            "buttons": ["copy", "csv", "excel"],
            "ajax": {
                "url": "<?= site_url('admin/karyawanjp3k/datatables') ?>",
                "type": "POST",
            },
            "lengthMenu": [
                [5, 10, 25, 100, -1],
                [5, 10, 25, 100, "All"]
            ],
            "columnDefs": [{
                "targets": 7,
                "orderable": false,
            }],
        })
    })
    // tajp3.destroy();
    var tkjp3 = $('#karyawanjp3a').DataTable({
        "dom": 'Blfrtip',
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "buttons": ["copy", "csv", "excel"],
        "ajax": {
            "url": "<?= site_url('admin/karyawanjp3a/datatables') ?>",
            "type": "POST",
        },
        "lengthMenu": [
            [5, 10, 25, 100, -1],
            [5, 10, 25, 100, "All"]
        ],
        "columnDefs": [{
            "targets": 7,
            "orderable": false,
        }],
    })

    var tkjp3 = $('#karyawanfp').DataTable({
        "dom": 'Blfrtip',
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "buttons": ["copy", "csv", "excel"],
        "ajax": {
            "url": "<?= site_url('admin/karyawanjp3kf/datatables') ?>",
            "type": "POST",
        },
        "lengthMenu": [
            [5, 10, 25, 100, -1],
            [5, 10, 25, 100, "All"]
        ],
        "columnDefs": [{
            "targets": 1,
            "orderable": false,
        }],
    })
    $("#akjjp3").on('click', function(event) {
        $('#karyawanjp3a').DataTable().ajax.reload()
    })
    $("#kdfkjjp3").on('click', function(event) {
        $('#karyawanfp').DataTable().ajax.reload()
    })
    $("#bfp").on('click', function(event) {
        $('#karyawanfp').DataTable().ajax.reload()
    })
    $('#addkaryawan').click(function(e) {
        $.ajax({
            url: "<?= site_url('admin/karyawanjp3a/add') ?>",
            type: "POST",
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.vieweditdata').html(response.sukses).show();
                    $('#tambahdata').modal('show');
                }
                $('input[name=csrf_test_name]').val(response.csrf_test_name);
            },
        });
    });

    $('.detailkaryawan').on('click', function(event) {

    });
});

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

$(document).ready(function() {
    $('#karyawanjp3a tbody').on('click', '.btn-edit', function(e) {
        const id = $(this).data('editkarid');

        $.ajax({
            url: "<?= site_url('admin/karyawan/edit') ?>",
            method: "post",
            data: {
                idnip: id
            },
            dataType: "json",
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

    $('#karyawanfp tbody').on('click', '.btn-karyawanbaru', function(e) {
        const id = $(this).data('pkarid');

        $.ajax({
            url: "<?= site_url('admin/karyawan/karyawanbaru') ?>",
            method: "post",
            data: {
                idpin: id
            },
            dataType: "json",
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

    $('#karyawanjp3a tbody').on('click', '.btn-keluar', function(e) {
        const id = $(this).data('keluarid');

        $('#hapuskaryawanmodal').modal('show');

        $("#iidkar").val(id);

    });

    $('#karyawanjp3k tbody').on('click', '.btn-aktif', function(e) {
        const id = $(this).data('aktifid');
        const tmt = $(this).data('tmt');

        $('#masukkaryawanmodal').modal('show');

        $("#aktifidkar").val(id);
        $("#aktiftmt").val(tmt);

    });

    $('.idsg').submit(function(e) {
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
                if (response.success) {
                    $('#hapuskaryawanmodal').modal('hide');
                    $('#karyawanjp3a').DataTable().ajax.reload();
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                } else {
                    $('#hapuskaryawanmodal').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('.idms').submit(function(e) {
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
                if (response.success) {
                    $('#masukkaryawanmodal').modal('hide');
                    $('#karyawanjp3k').DataTable().ajax.reload();
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                } else {
                    $('#masukkaryawanmodal').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

})
</script>

<?= $this->endSection() ?>