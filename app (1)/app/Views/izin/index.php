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
                        <?= form_open_multipart('admin/izin/tambahizin', ['class' => 'formtambahizin']) ?>
                        <?= csrf_field() ?>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nama</label>
                            <select class="form-control col-sm-10 pilihkaryawan" name="nama" id="nama"
                                aria-placeholder="Pilih Karyawan">
                                <option value="">Pilih Karyawan</option>
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
                            <label class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-10">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="radio1" name="Radio" required>
                                    <label for="radio1" class="custom-control-label">Salah Input Cek In dan Cek
                                        Out</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="radio2" name="Radio">
                                    <label for="radio2" class="custom-control-label">Izin Lainnya</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label id="ltanggal" class="col-sm-2 col-form-label" hidden>Tanggal</label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control cd" name="tgl" id="tanggal" hidden>
                            </div>
                            <label id="lshift" class="col-sm-2 col-form-label" hidden>Shift</label>
                            <div class="custom-file col-sm-3">
                                <select class="form-control cd" name="shift" id="shift" hidden>
                                    <option value="" require>Pilih shift</option>
                                    <?php foreach ($jam_kerja as $jkf) : ?>
                                    <option value="<?= $jkf['jk_id'] ?>"><?= $jkf['jk_name'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="validasiin" class="col-sm-2 col-form-label">Jam In</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="form-control" name="in" id="in"
                                    aria-describedby="validasiin" require>
                                <!-- <div id="validasiin" class="invalid-feedback">
                                </div> -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jam Out</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" class="form-control" name="out" id="out" require>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Grup</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="grup" id="grup" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label id="lizin" class="col-sm-2 col-form-label" hidden>Izin</label>
                            <div class="custom-file col-sm-10">
                                <!-- <input type="file" class="custom-file-input" id="fileizin" name="fileizin" hidden>
                                <label class="custom-file-label" id="labelizin" for="fileizin" hidden>Masukkan Gambar
                                    Screnshoot dari Log Karyawan</label> -->
                                <select class="form-control" name="izin" id="izin" hidden>
                                    <option value="" require>Pilih Izin</option>
                                    <?php foreach ($jnsizin as $jn) : ?>
                                    <option value="<?= $jn['izin_jenis_name'] ?>"><?= $jn['izin_jenis_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info btn-sm float-right">Cetak</button>
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

<script src="<?= base_url() ?>/assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script>
$(document).ready(function() {
    const Toasts = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 15000
    });
    $(".cd").change(function() {
        // $("#shift").change(function() {
        var tanggal = $('#tanggal').val();
        var shift = $('#shift').val();
        var idkar = $('#nama').val();

        console.log(tanggal);

        console.log(shift);

        $.ajax({
            url: '<?= site_url('admin/izin/fio') ?>',
            type: 'post',
            data: {
                tanggal: tanggal,
                shift: shift,
                idkar: idkar,
            },
            dataType: 'json',
            success: function(response) {

                var datain = response.in;

                var dataout = response.out;

                console.log(response.in);
                console.log(response.out);

                $("#in").val(datain);
                $("#out").val(dataout);
                // }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n\n\n" + thrownError);
            }
        });
        // });
    });

    $("#nama").change(function() {
        var idkar = $(this).val();

        $.ajax({
            url: '<?= site_url('admin/izin/datanamaform') ?>',
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

    $('#radio1').change(function() {
        $('#izin').attr('hidden', 'hidden');
        // $('#fileizin').removeAttr('hidden');
        // $('#labelizin').removeAttr('hidden');
        $('#izin').val("");
        $('#tanggal').val("");
        $('#shift').val("");
        $('#lizin').attr('hidden', 'hidden');
        $('#tanggal').attr('required', 'required');
        $('#in').attr('readonly', 'readonly');
        $('#out').attr('readonly', 'readonly');
        $('#shift').attr('required', 'required');
        // $('#fileizin').attr('required', 'required');
        $('#izin').removeAttr('required');
        $('#ltanggal').removeAttr('hidden');
        $('#lshift').removeAttr('hidden');
        $('#tanggal').removeAttr('hidden');
        $('#shift').removeAttr('hidden');
        // $('#labelizin').html("Masukkan Gambar Screnshoot dari Log Karyawan");
        // $('#fileizin').val("");
    });
    $('#radio2').change(function() {
        // $('#fileizin').attr('hidden', 'hidden');
        // $('#labelizin').attr('hidden', 'hidden');
        $('#izin').removeAttr('hidden');
        $('#izin').val("");
        $('#izin').attr('required', 'required');
        $('#ltanggal').attr('hidden', 'hidden');
        $('#tanggal').attr('hidden', 'hidden');
        $('#lshift').attr('hidden', 'hidden');
        $('#shift').attr('hidden', 'hidden');
        // $('#fileizin').removeAttr('required');
        $('#lizin').removeAttr('hidden');
        $('#in').removeAttr('readonly');
        $('#out').removeAttr('readonly');
        // $('#labelizin').html("Masukkan Gambar Screnshoot dari Log Karyawan");
        // $('#fileizin').val("");
    });

    $("#kkjjp3").on('click', function(event) {

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

    $('.formtambahizin').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            // data: $(this).serialize(),
            method: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
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
                    // w = window.open(window.location.href, "_blank");
                    var Pagelink = "about:blank";
                    var w = window.open(Pagelink, "_new");
                    // w.document.open();
                    w.open();
                    w.document.write(response.sukses);
                    setTimeout(function() {
                        w.print();
                        w.document.close();
                    }, 1000);
                    $("#idkar").val('');
                    $("#nama").val('');
                    $("#unit").val('');
                    $("#subunit").val('');
                    $("#in").val('');
                    $("#out").val('');
                    $("izin").val("")
                } else if (response.error) {
                    let dataerror = response.error;
                    $("#idkar").removeClass('is-invalid');
                    $("#nama").removeClass('is-invalid');
                    $("#unit").removeClass('is-invalid');
                    $("#subunit").removeClass('is-invalid');
                    $("#in").removeClass('is-invalid');
                    $("#out").removeClass('is-invalid');
                    $("#izin").removeClass('is-invalid');
                    if (dataerror.errorid) {
                        $("#idkar").addClass('is-invalid');
                        // $("#idkar").html(dataerror.errorid);
                    } else if (dataerror.errornama) {
                        $("#nama").addClass('is-invalid');
                        // $("#idkar").html(dataerror.errorid);
                    } else if (dataerror.errorunit) {
                        $("#unit").addClass('is-invalid');
                    } else if (dataerror.errorsubunit) {
                        $("#subunit").addClass('is-invalid');
                    } else if (dataerror.errorin) {
                        $("#in").addClass('is-invalid');
                    } else if (dataerror.errorout) {
                        $("#out").addClass('is-invalid');
                    } else if (dataerror.errorizin) {
                        $("#izin").addClass('is-invalid');
                    } else if (dataerror.errorwaktu) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'DITOLAK !!!',
                            text: dataerror.errorwaktu,
                        })
                    }
                } else if (response.suksest) {
                    Toasts.fire({
                        icon: 'success',
                        title: 'Izin Berhasil ditambahkan',
                        type: 'success',
                    });
                    document.querySelector('form').reset();
                    $('#labelizin').html("Masukkan Gambar Screnshoot dari Log Karyawan");
                    $('#fileizin').val("");

                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('.detailkaryawan').on('click', function(event) {

    });

    $('.pilihkaryawan').select2();
});

$(function() {
    bsCustomFileInput.init();
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
</script>

<?= $this->endSection() ?>