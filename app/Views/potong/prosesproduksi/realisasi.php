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

        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#rcn" id="akjjp3" data-toggle="tab">Realisasi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#kum" id="kkjjp3" data-toggle="tab">Balance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#sa" id="sarealisasi" data-toggle="tab">SA</a>
                </li>
            </ul>
        </div>
    </div><!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="card" style="width: 18rem;">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">SPP : <?= $tampildata['spp'] ?></li>
                    <li class="list-group-item">Tipe : <?= $namadtipedata['namatipe'] ?></li>
                    <li class="list-group-item"><button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#tambahrealisasidetailpotong">
                            Tambah Realisasi <i class=" fas fa-plus"></i>
                        </button></li>
                    <li class="list-group-item"><button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#tambahrealisasisaldopotong">
                            Tambah Saldo Awal Realisasi <i class=" fas fa-plus"></i>
                        </button></li>
                </ul>
            </div>
        </div>
        <div class="tab-content p-0">
            <div class="tab-pane active" id="rcn" style="position: relative;">
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label for="">Item</label>
                        <select name="cariitem" id="cariitem" class="form-control cariitem">
                            <option value="%" selected>All</option>
                            <?php foreach ($tampildtipedata as $tdpd) : ?>
                            <option value="<?= $tdpd['kodeitem'] ?>"><?= $tdpd['namaitem'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Vendor</label>
                        <select name="carivendor" id="carivendor" class="form-control carivendor">
                            <option value="%" selected>All</option>
                            <option value="HMN">HMN</option>
                            <option value="RJM">RJM</option>
                            <option value="SKA">SKA</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="">Grup</label>
                        <select name="carigrup" id="carigrup" class="form-control carigrup">
                            <option value="%" selected>All</option>
                            <option value="R">R</option>
                            <option value="S">S</option>
                            <option value="T">T</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputItem">Dari TGL</label>
                        <input type="date" class="form-control" id="tgldarir" name="tgldarir" placeholder="qty">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputItem">Ke TGL</label>
                        <input type="date" class="form-control" id="tglker" name="tglker" placeholder="qty">
                    </div>
                </div>
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table id="tabel1" class="w-100 table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Item</th>
                                    <th>USE</th>
                                    <th>Tgl</th>
                                    <th>Qty</th>
                                    <th>Kgm</th>
                                    <th>Grup</th>
                                    <th>Vendor</th>
                                    <th>Mesin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <th colspan="4">Total</th>
                                <th id="totalqty"></th>
                                <th id="totalkgm"></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="kum" style="position: relative;">
                <div class="table-responsive">
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="inputItem">TGL Dari</label>
                            <input type="date" class="form-control" id="tgldari" name="tgldari" placeholder="qty">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="inputItem">TGL Ke</label>
                            <input type="date" class="form-control" id="tglke" name="tglke" placeholder="qty">
                        </div>
                    </div>
                    <table id="tabel2" class="w-100 table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th rowspan="2">NAMA ITEM</th>
                                <th rowspan="2">USE</th>
                                <th rowspan="2">KEBUTUHAN</th>
                                <th rowspan="2">BALANCE RA</th>
                                <th rowspan="2">RA</th>
                                <th rowspan="2">RI</th>
                                <th rowspan="2">RI TGL</th>
                                <th rowspan="2">DEV KOM</th>
                                <th rowspan="2">KGM KOM</th>
                                <th colspan="2">RJM</th>
                                <th colspan="2">SKA</th>
                                <th colspan="2">HMN</th>
                            </tr>
                            <tr>
                                <th>RI</th>
                                <th>RI TGL</th>
                                <th>RI</th>
                                <th>RI TGL</th>
                                <th>RI</th>
                                <th>RI TGL</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="sa" style="position: relative;">
                <div class="table-responsive">
                    <table id="tabel3" class="w-100 table table-bordered table-striped">
                        <thead>
                            <th>Nama</th>
                            <th>Bulan</th>
                            <th>Periode</th>
                            <th>Nama</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.card-body -->
</div>

<div class="modal fade" id="tambahrealisasidetailpotong" role="dialog" aria-labelledby="exampleModalLabel"
    style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nambah Realisasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/potong/tambahdetailri', ['class' => 'addtipepotong']) ?>
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
                    <div class="form-group col-md-6">
                        <label for="inputItem">Item</label>
                        <select name="item" id="item" class="form-control pilihnamatipe" required>
                            <option value="" selected>Choose...</option>
                            <?php foreach ($tampildtipedata as $tdpd) : ?>
                            <option value="<?= $tdpd['kodeitem'] ?>"><?= $tdpd['namaitem'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputItem">Mesin</label>
                        <select name="jmesin" id="jmesin" class="form-control pilihnamatipe" required>
                            <option value="" selected>Choose...</option>
                            <option value="l">Lama</option>
                            <option value="b">Baru</option>
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
                    <div class="form-group col-md-3">
                        <label for="inputItem">KGM</label>
                        <input type="text" class="form-control" name="kgm" placeholder="kgm" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">No Rak</label>
                        <input type="number" class="form-control" name="rak" placeholder="rak" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btnproses">Input</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="tambahrealisasisaldopotong" role="dialog" aria-labelledby="exampleModalLabel"
    style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Saldo Realisasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/potong/tambahsaldori', ['class' => 'saldotipepotong']) ?>
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
                    <div class="form-group col-md-6">
                        <label for="inputItem">Item</label>
                        <select name="item" id="item" class="form-control pilihnamatipe" required>
                            <option value="" selected>Choose...</option>
                            <?php foreach ($tampildtipedata as $tdpd) : ?>
                            <option value="<?= $tdpd['kodeitem'] ?>"><?= $tdpd['namaitem'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputItem">Mesin</label>
                        <select name="jmesin" id="jmesin" class="form-control pilihnamatipe" required>
                            <option value="" selected>Choose...</option>
                            <option value="l">Lama</option>
                            <option value="b">Baru</option>
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
                <button type="submit" class="btn btn-primary btnproses">Input</button>
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
                $('.btnproses').attr('disable', 'disabled');
                $('.btnproses').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btnproses').removeAttr('disable');
                $('.btnproses').html('Submit');
            },
            success: function(response) {
                console.log(response.success);
                if (response.success) {
                    $('#tambahrealisasidetailpotong').modal('hide');
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                    $("#tabel1").DataTable().ajax.reload();
                } else {
                    $('#tambahrealisasidetailpotong').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('.saldotipepotong').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('.btnproses').attr('disable', 'disabled');
                $('.btnproses').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btnproses').removeAttr('disable');
                $('.btnproses').html('Submit');
            },
            success: function(response) {
                console.log(response.success);
                if (response.success) {
                    $('#tambahrealisasisaldopotong').modal('hide');
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                    $("#tabel1").DataTable().ajax.reload();
                } else {
                    $('#tambahrealisasisaldopotong').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

})


$(document).ready(function() {
    var tabel1 = $('#tabel1').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('admin/potong/realisasi/datatables') ?>",
            "type": "POST",
            "data": function(data) {
                data.norcn = $('#norcn').val();
                data.cariitem = $('#cariitem').val();
                data.carivendor = $('#carivendor').val();
                data.carigrup = $('#carigrup').val();
                data.tgldarir = $('#tgldarir').val();
                data.tglker = $('#tglker').val();
            },
        },
        drawCallback: function(settings) {
            $('#totalqty').html(settings.json.totalqty);
            $('#totalkgm').html(settings.json.totalkgm);
            $('#rendered').html(settings.json.rendered);
        },
        "lengthMenu": [
            [5, 10, 25, 100, 500, -1],
            [5, 10, 25, 100, 500, "All"]
        ],
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }],
    });

    $("#cariitem").change(function() {
        tabel1.draw();
    });
    $("#carivendor").change(function() {
        tabel1.draw();
    });
    $("#carigrup").change(function() {
        tabel1.draw();
    });
    $("#tgldarir").change(function() {
        tabel1.draw();
    });
    $("#tglker").change(function() {
        tabel1.draw();
    });

    var tabel2 = $('#tabel2').DataTable({
        "dom": 'Bfrtip',
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('admin/potong/realisasi/datatablesbalance') ?>",
            "type": "POST",
            "data": function(data) {
                data.norcn = $('#norcn').val();
                data.tgldari = $('#tgldari').val();
                data.tglke = $('#tglke').val();
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
                    url: "<?= site_url('admin/potong/realisasi/delete') ?>",
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

        $.ajax({
            url: "<?= base_url('admin/potong/realisasi/edit') ?>",
            method: "post",
            data: {
                seq: seq
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