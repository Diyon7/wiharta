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
                    Tambah Karyawan
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <form method="POST" action="proseskaryawan.php?action=editdatakaryawan" class="editdatakaryawan"
                    id="form">

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Asal</label>
                        <select class="form-control col-sm-10" name="asal" id="asal">
                            <option value="" selected required>pilih</option>
                            <?php foreach ($vendor as $vd) : ?>
                            <option value=""><?= $vd['pembagian3_nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">ID Karyawan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="idkar" id="idkar" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama" id="namakaryawan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tgllahir" id="tgllahir">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="alamat" id="alamat">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Pendidikan</label>
                        <select class="form-control col-sm-10" name="bagian" id="bagian">
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Divisi</label>
                        <select class="form-control col-sm-10" name="bagian" id="bagian">
                            <?php foreach ($divisi as $dvs) : ?>
                            <option value=""><?= $dvs['pembagian2_nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Unit</label>
                        <select class="form-control col-sm-10" name="unit" id="unit">
                            <?php foreach ($unit as $unt) : ?>
                            <option value=""><?= $unt['pembagian4_nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Sub Unit</label>
                        <select class="form-control col-sm-10" name="subunit" id="subunit">
                            <?php foreach ($subunit as $sbunt) : ?>
                            <option value=""><?= $sbunt['pembagian5_nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Grup</label>
                        <select class="form-control col-sm-10" name="grup" id="grup">
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Grup Tagian kerja</label>
                        <select class="form-control col-sm-10" name="grup_t" id="grup_t">
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Jabatan</label>
                        <select class="form-control col-sm-10" name="jabatan" id="jabatan">
                            <?php foreach ($jabatan as $jbn) : ?>
                            <option value=""><?= $jbn['pembagian1_nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Golongan</label>
                        <select class="form-control col-sm-10" name="golongan" id="golongan">
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">TMT</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tmt" id="tmt">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-right">Simpan</button>
                    </div>
                </form>
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
    $("#kkjjp3").on('click', function(event) {
        // tkjp3.destroy();
        var tajp3 = $('#karyawanjp3k').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= site_url('admin/karyawanjp3k/datatables') ?>",
                "type": "POST",
            },
            "lengthMenu": [
                [5, 10, 25, 100],
                [5, 10, 25, 100]
            ],
            "columnDefs": [{
                "targets": 6,
                "orderable": false,
            }],
        })
    })
    // tajp3.destroy();
    var tkjp3 = $('#karyawanjp3a').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('admin/karyawanjp3a/datatables') ?>",
            "type": "POST",
        },
        "lengthMenu": [
            [5, 10, 25, 100],
            [5, 10, 25, 100]
        ],
        "columnDefs": [{
            "targets": 6,
            "orderable": false,
        }],
    })
    $("#akjjp3").on('click', function(event) {
        $('#karyawanjp3a').DataTable().ajax.reload()
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

    $('#karyawanjp3a tbody').on('click', '.btn-keluar', function(e) {
        const id = $(this).data('keluarid');

        $('#hapuskaryawanmodal').modal('show');

        $("#iidkar").val(id);

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

})
</script>

<?= $this->endSection() ?>