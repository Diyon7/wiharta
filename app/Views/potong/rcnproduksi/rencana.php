<style>
.column {
    position: sticky;
    top: 0;
    left: 0;
    background: white;
}

/*thead th {
    position: sticky;
    top: 0;
    background: white;
}*/
</style>
<div class="card">
    <div class="card-header">
        <div class="card" style="width: 18rem;">

        </div>
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#rcn" id="akjjp3" data-toggle="tab">Rencana</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#kum" id="kkjjp3" data-toggle="tab">Balance</a>
                </li>
            </ul>
        </div>
    </div><!-- /.card-header -->
    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">SPP <?= $tampildata['spp'] ?></li>
            <input type="hidden" name="norcn" value="<?= $tampildata['norcn'] ?>">
            <input type="hidden" name="idtipe" value="<?= $tampildata['idtipe'] ?>">
            <li class="list-group-item"><button type="button" class="btn btn-primary" data-toggle="modal"
                    data-target="#tambahdetailpotong">
                    TAMBAH Rencana <i class=" fas fa-plus"></i>
                </button></li>
        </ul>
        <div class="tab-content p-0">
            <div class="tab-pane active" id="rcn" style="position: relative;">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table id="tabel1" class="w-100 table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>SPP</th>
                                    <th>Nama Tipe</th>
                                    <th>Tgl</th>
                                    <th>qty</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="kum" style="position: relative;">
                <div class="table-responsive">
                    <table id="tabel2" class="w-100 table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>USE SPP</th>
                                <th>KEBUTUHAN</th>
                                <th>ITEM</th>
                                <th>BALANCE</th>
                                <th>RA</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.card-body -->
</div>

<div class="modal fade" id="tambahdetailpotong" aria-labelledby="exampleModalLabel" style="overflow:hidden;"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nambah Rencana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/potong/tambahdetailrcn', ['class' => 'addtipepotong']) ?>
                <?= csrf_field() ?>
                <input type="hidden" name="norcn" value="<?= $tampildata['norcn'] ?>">
                <input type="hidden" name="idtipe" value="<?= $tampildata['idtipe'] ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputItem">Vendor</label>
                        <select name="ven" id="ven" class="form-control pilihnamatipe" required>
                            <option value="" selected>Choose...</option>
                            <option value="HMN">HMN</option>
                            <option value="SKA">SKA</option>
                            <option value="RJM">RJM</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputItem">Grup</label>
                        <select name="grup" id="grup" class="form-control pilihnamatipe" required>
                            <option selected>Choose...</option>
                            <option value="R">R</option>
                            <option value="S">S</option>
                            <option value="T">T</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Tanggal</label>
                        <input type="date" class="form-control" name="tgl" placeholder="tgl" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">QTY</label>
                        <input type="number" class="form-control" name="qty" placeholder="qty" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btntampil">Input</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<div class="vieweditdata" style="display: none;"></div>

<script type="text/javascript">
$(document).ready(function() {
    const Toasts = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 15000
    });

    $('#table-dkp tbody').on('click', '.unit', function(e) {
        const unit = $(this).data('unit');
        const tanggal = $(this).data('tanggal');
        const status = $(this).data('status');

        $.ajax({
            url: "<?= site_url('admin/rekap/detailunit') ?>",
            method: "post",
            data: {
                unit: unit,
                tanggal: tanggal,
                status: status
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
                    $("#tabel1").DataTable().ajax.reload();
                    $('#tambahdetailpotong').modal('hide');
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                } else {
                    $('#tipeitem').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
})


$(document).ready(function() {
    $('#tabel1').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('admin/potong/rencana/datatables') ?>",
            "type": "POST",
            "data": function(data) {
                data.norcn = $('#norcn').val();
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

    $('#tabel2').DataTable({
        "dom": 'Bfrtip',
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('admin/potong/rencana/datatablesbalance') ?>",
            "type": "POST",
            "data": function(data) {
                data.norcn = $('#norcn').val();
            },
        },
        "lengthMenu": [
            [-1],
            ["All"]
        ],
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }],
    });

    $('#tabel1 tbody').on('click', '.btn-delete', function(e) {
        const seq = $(this).data('seq');

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
                    url: "<?= site_url('admin/potong/rencana/delete') ?>",
                    method: "post",
                    data: {
                        seq: seq,

                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            $('#tabel1').DataTable().ajax.reload();
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

    $('#tabel1 tbody').on('click', '.btn-edit', function(e) {
        const seq = $(this).data('seq');
        const norcn = $('#norcn').val();
        const idtipe = $('#idtipe').val();

        $.ajax({
            url: "<?= base_url('admin/potong/rencana/edit') ?>",
            method: "post",
            data: {
                seq: seq,
                norcn: norcn,
                idtipe: idtipe,
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