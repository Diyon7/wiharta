<?= $this->extend('layouts/main_master') ?>

<?= $this->section('isi') ?>
<!-- Small boxes (Stat box) -->
<div class="row">

    <!-- ./col -->
</div>
<!-- /.row -->
<!-- Main row -->
<div class="row">
    <button type="button" class="btn btn-primary col-sm-3" data-toggle="modal" data-target="#tambahrcn">
        TAMBAH Rencana SPP <i class=" fas fa-plus"></i>
    </button>
</div>
<?= form_open('admin/potong/carircn', ['class' => 'carircn']) ?>
<?= csrf_field() ?>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="inputItem">Rencana</label>
        <select name="norcn" id="norcn" class="form-control pilihdataspp" required>
            <option selected>Choose...</option>
            <?php foreach ($allspp as $spp) : ?>
            <option value="<?= $spp['norcn'] ?>"><?= $spp['spp'] ?> || <?= $spp['namatipe'] ?> || <?= $spp['tgl'] ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<button type="submit" class="btn btn-primary">Cari</button>
<?= form_close() ?>
<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-1"></i>
                    Rcn Produksi
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="outer">
                    <div class="inner datarencana">
                        <!-- <div class="datarencana" style="display: none;"></div> -->
                    </div>
                </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
</div>

<div class="modal fade" id="tambahrcn" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nambah Rencana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/potong/tambahrcn', ['class' => 'addspppotong']) ?>
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">No SPP</label>
                        <input type="text" class="form-control" name="nospp" placeholder="nospp" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Tanggal</label>
                        <input type="date" class="form-control" name="tgl" placeholder="tgl" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputItem">Tipe</label>
                        <select name="tipe" id="tipe" class="form-control pilihnamatipe" required>
                            <option selected>Choose...</option>
                            <?php foreach ($tipe as $tp) : ?>
                            <option value="<?= $tp['kodetipe'] ?>"><?= $tp['namatipe'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">Order</label>
                        <input type="number" class="form-control" name="order" placeholder="order" required>
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

    $('#tipeitem').DataTable({
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
    $('.pilihdataspp').select2();

    $('.addspppotong').submit(function(e) {
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
                if (response.sukses) {
                    $('#tambahrcn').modal('hide');
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                    $('.datarencana').html(response.sukses);
                } else {
                    $('#tambahrcn').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
    $('.carircn').submit(function(e) {
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
                $('.datarencana').html(response.sukses);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('#tipeitem tbody').on('click', '.btn-edit', function(e) {
        const id = $(this).data('seq');

        $.ajax({
            url: "<?= base_url('admin/potong/item/edit') ?>",
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