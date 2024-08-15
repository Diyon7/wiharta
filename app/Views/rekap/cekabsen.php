<?= $this->extend('layouts/main_master') ?>

<?= $this->section('isi') ?>
<!-- Small boxes (Stat box) -->
<div class="row">

</div>
<!-- /.row -->
<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">

        <div class="card-tools">
            <?= form_open('admin/rekap/tabellaporanharian', ['class' => 'formtabelkaryawan']) ?>
            <div class="input-group input-group-sm mb-3">
                <input type="date" name="tgl" id="tgl" placeholder="Tanggal">
                <select name="divisi" id="divisi" class="col-sm-5">
                    <option value="%">SEMUA DIVISI</option>
                    <?php foreach ($divisi as $dv) : ?>
                    <option value="<?= $dv['pembagian2_nama'] ?>"><?= $dv['pembagian2_nama'] ?></option>
                    <?php endforeach ?>
                </select>
                <select name="status" id="status">
                    <option value="%">SEMUA KARYAWAN</option>
                    <option value="OS">OS</option>
                    <option value="WH">WIHARTA</option>
                </select>
                <button type="submit" class="btn btn-primary btntampil">TAMPIL !</button>
            </div>
            <?= form_close() ?>
        </div>

        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-1"></i>
                    Data Absen
                </h3>
                <!-- <div class="card-tools">
                </div> -->
            </div><!-- /.card-header -->
            <!-- <select name="list" id="list" class="col-sm-5">
                <option value="%">Pilih List</option>
                <option value="pembagian2">Devisi</option>
                <option value="pembagian4">Unit</option>
                <option value="pembagian5">Sub Unit</option>
            </select> -->
            <div class="card-body">
                <div class="outer">
                    <div class="inner listtabelkaryawan">
                        <!-- <div class="listtabelkaryawan" style="display: none;"></div> -->
                    </div>
                </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
</div>

<script>
$(document).ready(function() {
    $("#list").change(function() {
        var idkar = $(this).val();

        $.ajax({
            url: '<?= site_url('admin/rekap/tabellaporanharian') ?>',
            type: 'post',
            data: {
                idkar: idkar
            },
            dataType: 'json',
            success: function(response) {
                $('.listtabelkaryawan').html(response.sukses);
                // }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n\n\n" + thrownError);
            }
        });
    });
});
$('.formtabelkaryawan').submit(function(e) {
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
            $('.listtabelkaryawan').html(response.sukses);
            // $('.tabel1').show();
        },
        error: function(xhr, ajaxOption, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    })
})
</script>

<?= $this->endSection() ?>