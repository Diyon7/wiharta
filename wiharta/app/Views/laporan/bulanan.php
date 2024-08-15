http://154.100.100.220/wiharta/public

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
            <?= form_open('admin/laporan/tabellaporanbulanan', ['class' => 'formtabelkaryawan']) ?>
            <div class="input-group input-group-sm mb-3">
                <input type="date" name="tgl" id="tgl" placeholder="Tanggal">
                <select name="vendor" id="vendor">
                    <option value="%">Pilih Vendor</option>
                    <option value="%">All</option>
                    <?php foreach ($vendor as $vd) : ?>
                    <option value="<?= $vd['pembagian3_nama'] ?>"><?= $vd['pembagian3_nama'] ?></option>
                    <?php endforeach; ?>
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
$(document).ready(function() {
    // $('#tabel1').DataTable({
    //     "responsive": true,
    //     "lengthmenu": [
    //         [5, 10, 20, 50],
    //         [5, 10, 20, 50]
    //     ],
    //     "order": [
    //         [3, "asc"],
    //         [1, "asc"]
    //     ],
    //     "dom": 'Bfrtip',
    //     "select": true,
    //     "paging": true,
    //     "lengthChange": false,
    //     "searching": true,
    //     "ordering": true,
    //     "info": true,
    //     "autoWidth": true,
    //     "scrollX": true,
    //     "fixedHeader": true
    // });

})
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