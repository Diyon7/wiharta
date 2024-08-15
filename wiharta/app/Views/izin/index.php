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
                    IZIN KARYAWAN
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#jp3" id="akjjp3" data-toggle="tab">JP3</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#pkw" id="kkjjp3" data-toggle="tab">PKWT/PKWTT</a>
                        </li>
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="jp3" style="position: relative;">
                        <?= form_open('admin/izin/tambahizin', ['class' => 'formtambahizin']) ?>
                        <?= csrf_field() ?>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama</label>
                            <select class="form-control col-sm-10" name="nama" id="nama"
                                aria-placeholder="Pilih Karyawan">
                                <?php foreach ($daftarkaryawanjp3 as $dkjp3) : ?>
                                <option value="<?= $dkjp3['idkar'] ?>"><?= $dkjp3['nama'] ?> ||
                                    <?= $dkjp3['vendor'] ?></option>
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
                            <label class="col-sm-2 col-form-label">Unit</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="unit" id="unit" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Sub Unit</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="subunit" id="subunit" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name="tgl" id="tgl">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jam In</label>
                            <div class="col-sm-10">
                                <input type="time" class="form-control" name="in" id="in">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jam Out</label>
                            <div class="col-sm-10">
                                <input type="time" class="form-control" name="out" id="out">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Grup</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="grup" id="grup" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Izin</label>
                            <select class="form-control col-sm-10" name="izin" id="izin">
                                <?php foreach ($jnsizin as $jn) : ?>
                                <option value="<?= $jn['izin_jenis_name'] ?>"><?= $jn['izin_jenis_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Cetak</button>
                        </div>
                        </form>
                        <?= form_close() ?>
                    </div>
                    <div class="chart tab-pane" id="pkw" style="position: relative;">
                        <h1>Under Maintenance <h5 style="font-weight: bold;">IT :)</h5>
                        </h1>
                    </div>
                </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
</div>
<div class="inner listtabelkaryawan">
</div>
<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
$(document).ready(function() {

    $("#nama").change(function() {
        var idkar = $(this).val();

        $.ajax({
            url: '<?= site_url('ajax/izin/datanamaform') ?>',
            type: 'post',
            data: {
                idkar: idkar
            },
            dataType: 'json',
            success: function(response) {

                var grup = response.grup;
                var unit = response.unit;
                var subunit = response.subunit;

                $("#idkar").val(idkar);
                $("#grup").val(grup);
                $("#unit").val(unit);
                $("#subunit").val(subunit);
                // }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n\n\n" + thrownError);
            }
        });
    });

    $("#kkjjp3").on('click', function(event) {

    })

    $('#addkaryawan').click(function(e) {
        $.ajax({
            url: "<?= site_url('ajax/karyawanjp3a/add') ?>",
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

    $('.formtambahizin').submit(function(e) {
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
                w = window.open(window.location.href, "_blank");
                w.document.open();
                w.document.write(response.sukses);
                w.document.close();
                // w.window.print();
                // $('.listtabelkaryawan').html(response.sukses);
                // $('.tabel1').show();
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('.detailkaryawan').on('click', function(event) {

    });
});

function detailkaryawana(id) {
    $.ajax({
        url: "<?= site_url('ajax/karyawanjp3a/detaila') ?>",
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