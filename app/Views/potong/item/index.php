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
                    FORM TIPE
                </h3>
                <br>
                <div class="row">
                    <button type="button" class="btn btn-primary col-sm-1" data-toggle="modal"
                        data-target="#tambahtipedtl">
                        Tambah Item Dtl <i class=" fas fa-plus"></i>
                    </button>
                </div>
                <div class="card-tools">
                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                    </div>
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#ti" id="akjhjp3" data-toggle="tab">Tipe Item</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#t" id="akjjp3" data-toggle="tab">Tipe</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#i" id="kkjjp3" data-toggle="tab">Item</a>
                        </li>
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0" id='izin'>
                    <div class="tab-pane active" id="ti" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="tipeitem" class="w-100 table table-bordered table-striped">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="inputItem">Tipe</label>
                                            <select name="tipe" id="tipe" class="form-control selecttipe" required>
                                                <option value="%" selected>All</option>
                                                <?php foreach ($tipe as $t) : ?>
                                                <option value="<?= $t['kodetipe'] ?>"><?= $t['namatipe'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <thead class="text-sm">
                                        <th>NO</th>
                                        <th>NAMA TIPE</th>
                                        <th>NAMA ITEM</th>
                                        <th>USE</th>
                                        <th>ACTION</th>
                                    </thead>
                                    <tbody class="text-sm">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="t" style="position: relative;">
                        <button type="button" class="btn btn-primary col-sm-1" data-toggle="modal"
                            data-target="#tambahtipe">
                            Tambah Tipe <i class=" fas fa-plus"></i>
                        </button>
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="tabeltipe" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>NO</th>
                                        <th>NAMA TIPE</th>
                                        <th>ACTION</th>
                                    </thead>
                                    <tbody class="text-sm">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="chart tab-pane" id="i" style="position: relative;">
                        <button type="button" class="btn btn-primary col-sm-1" data-toggle="modal"
                            data-target="#tambahitem">
                            Tambah Item <i class=" fas fa-plus"></i>
                        </button>
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="item" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>NO</th>
                                        <th>NAMA ITEM</th>
                                        <th>ACTION</th>
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

<div class="modal fade" id="tambahtipedtl" aria-labelledby="exampleModalLabel" style="overflow:hidden;"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nambah Tipeitem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/potong/tambahtipedtl', ['class' => 'addtipepotong']) ?>
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputItem">Tipe</label>
                        <select name="tipe" id="tipe" class="form-control pilihnamatipe select2" required>
                            <option selected>Choose...</option>
                            <?php foreach ($tipe as $tp) : ?>
                            <option value="<?= $tp['kodetipe'] ?>"><?= $tp['namatipe'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputItem">Item</label>
                        <select name="item" id="item" class="form-control pilihitem select2" required>
                            <option selected>Choose...</option>
                            <?php foreach ($item as $it) : ?>
                            <option value="<?= $it['kodeitem'] ?>"><?= $it['namaitem'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">Use</label>
                        <input type="number" class="form-control" name="use" placeholder="use" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Input</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahtipe" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nambah Tipe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/potong/tambahtipe', ['class' => 'addtipe']) ?>
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputItem">Nama Tipe</label>
                        <input type="text" name="namatipe" class="form-control" placeholder="Masukkan Nama Tipe">
                        <small class="form-text text-muted">Pastikan Nama Sama Seperti Nama Dari TI (Lebih Baik Copy
                            Paste Dari TI) Dengan Huruf Kapital</small>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btntampil">Input</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahitem" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nambah Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/potong/tambahitem', ['class' => 'additem']) ?>
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="inputItem">Nama Item</label>
                        <input type="text" name="namaitem" class="form-control" placeholder="Masukkan Nama Item">
                        <small class="form-text text-muted">Pastikan Nama Sama Seperti Nama Dari TI (Lebih Baik Copy
                            Paste Dari TI) Dengan Huruf Kapital</small>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btntampil">Input</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
$(document).ready(function() {
    const Toasts = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 15000
    });

    var tipeitem = $('#tipeitem').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('admin/potong/tipeitem/datatables') ?>",
            "type": "POST",
            "data": function(data) {
                data.tipe = $('#tipe').val();
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
    });

    var tipe = $('#tabeltipe').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('admin/potong/tipe/datatables') ?>",
            "type": "POST",
        },
        "lengthMenu": [
            [5, 10, 25, 100],
            [5, 10, 25, 100]
        ],
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }],
    });

    var item = $('#item').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('admin/potong/item/datatables') ?>",
            "type": "POST",
        },
        "lengthMenu": [
            [5, 10, 25, 100],
            [5, 10, 25, 100]
        ],
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }],
    });

    // $("#tipe").change(function() {
    //     var tipeitem = $(this).val();
    //     console.log(tipeitem);
    //     tipeitem.draw();
    // });

    $('.select2').select2({
        width: '250px'
    });
    $('.selecttipe').select2({
        width: '250px'
    });

    $('.addtipepotong').submit(function(e) {
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
                    $('#tambahtipedtl').modal('hide');
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                    $("#tipeitem").DataTable().ajax.reload();
                } else {
                    $('#tambahtipedtl').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('.addtipe').submit(function(e) {
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
                    $('#tambahtipe').modal('hide');
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                    $("#tabeltipe").DataTable().ajax.reload();
                } else {
                    $('#tambahtipe').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('.additem').submit(function(e) {
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
                    $('#tambahitem').modal('hide');
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                    $("#item").DataTable().ajax.reload();
                } else {
                    $('#tambahitem').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('#tipeitem tbody').on('click', '.btn-edit', function(e) {
        const id = $(this).data('seq');

        $.ajax({
            url: "<?= base_url('admin/potong/tipeitem/edit') ?>",
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
    $('#tabeltipe tbody').on('click', '.btn-edit', function(e) {
        const id = $(this).data('seq');

        $.ajax({
            url: "<?= base_url('admin/potong/tipe/edit') ?>",
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
});
</script>

<?= $this->endSection() ?>