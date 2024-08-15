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

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-1"></i>
                    Tampilan Laporan
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tabper" id="akjjp3" data-toggle="tab">Periode</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tabdiv" id="kkjjp3" data-toggle="tab">Divisi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tabtan" id="kkjjp3" data-toggle="tab">Tanggal</a>
                        </li>
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="tabper" style="position: relative;">
                        <div class="card-tools">
                            <?= form_open('admin/laporan/tabellaporanbulanan', ['class' => 'formtabelkaryawantabper']) ?>
                            <div class="input-group input-group-sm mb-3">
                                <input type="month" name="tgl" id="tgl" placeholder="Tanggal">
                                <select name="vendor" id="vendor">
                                    <!--<option value="%">Pilih Vendor</option>-->
                                    <?php if (in_groups('vendor') != 'vendor') { ?>
                                        <option value="%">All</option>
                                    <?php } ?>
                                    <?php foreach ($vendor as $vd) : ?>
                                        <?php if (in_groups('vendor')) { ?>
                                            <?php if (user()->username == $vd['pembagian3_nama']) : ?>
                                                <option value="<?= user()->username ?>"><?= user()->username ?></option>
                                            <?php endif ?>
                                        <?php } else { ?>
                                            <option value="<?= $vd['pembagian3_nama'] ?>"><?= $vd['pembagian3_nama'] ?></option>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary btntampil">TAMPIL !</button>
                            </div>
                            <?= form_close() ?>
                        </div>

                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card-body">
                            <div class="outer">
                                <div class="inner listtabelkaryawantabper">
                                    <!-- <div class="listtabelkaryawan" style="display: none;"></div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chart tab-pane" id="tabdiv" style="position: relative;">
                        <div class="card-tools">
                            <?= form_open('admin/laporan/tabeldivlaporanbulanan', ['class' => 'formtabelkaryawantabdiv']) ?>
                            <div class="input-group input-group-sm mb-3">
                                <input type="month" name="tgl" id="tgl" placeholder="Tanggal">
                                <select name="vendor" id="vendor">
                                    <!--<option value="%">Pilih Vendor</option>-->
                                    <?php if (in_groups('vendor') != 'vendor') { ?>
                                        <option value="%">All</option>
                                    <?php } ?>
                                    <?php foreach ($vendor as $vd) : ?>
                                        <?php if (in_groups('vendor')) { ?>
                                            <?php if (user()->username == $vd['pembagian3_nama']) : ?>
                                                <option value="<?= user()->username ?>"><?= user()->username ?></option>
                                            <?php endif ?>
                                        <?php } else { ?>
                                            <option value="<?= $vd['pembagian3_nama'] ?>"><?= $vd['pembagian3_nama'] ?></option>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </select>
                                <select name="divisi" id="divisi" required>
                                    <!-- <option value="">Pilih Vendor</option> -->
                                    <option value="" selected>Divisi</option>
                                    <?php foreach ($divisi as $ds) : ?>
                                        <option value="<?= $ds['pembagian2_nama'] ?>"><?= $ds['pembagian2_nama'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary btntampil">TAMPIL !</button>
                            </div>
                            <?= form_close() ?>
                        </div>

                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card-body">
                            <div class="outer">
                                <div class="inner listtabelkaryawantabdiv">
                                    <!-- <div class="listtabelkaryawan" style="display: none;"></div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabtan" style="position: relative;">
                        <div class="card-tools">
                            <?= form_open('admin/laporan/tabeltanlaporanbulanan', ['class' => 'formtabelkaryawantabtan']) ?>
                            <div class="input-group input-group-sm mb-3">
                                <input type="date" name="tgl" id="tgl" placeholder="Tanggal" required>
                                <input type="date" name="tgl2" id="tgl" placeholder="Tanggal" required>
                                <select name="vendor" id="vendor">
                                    <!--<option value="%">Pilih Vendor</option>-->
                                    <?php if (in_groups('vendor') != 'vendor') { ?>
                                        <option value="%">All</option>
                                    <?php } ?>
                                    <?php foreach ($vendor as $vd) : ?>
                                        <?php if (in_groups('vendor')) { ?>
                                            <?php if (user()->username == $vd['pembagian3_nama']) : ?>
                                                <option value="<?= user()->username ?>"><?= user()->username ?></option>
                                            <?php endif ?>
                                        <?php } else { ?>
                                            <option value="<?= $vd['pembagian3_nama'] ?>"><?= $vd['pembagian3_nama'] ?></option>
                                        <?php } ?>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary btntampil">TAMPIL !</button>
                            </div>
                            <?= form_close() ?>
                        </div>

                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card-body">
                            <div class="outer">
                                <div class="inner listtabelkaryawantabtan">
                                    <!-- <div class="listtabelkaryawan" style="display: none;"></div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.card-body -->
        </div>


        <!-- /.card -->
    </section>
</div>

<script>
    $(function() {
        // $('#tgl').daterangepicker({
        //     singleDatePicker: true,
        //     format: 'MM/YYYY',
        //     locale: {
        //         format: 'MM/YYYY'
        //     }
        // }).on('hide.daterangepicker', function(ev, picker) {
        //     $('.table-condensed tbody tr:nth-child(2) td').click();
        // });
    });

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
    $('.formtabelkaryawantabper').submit(function(e) {
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
                $('.listtabelkaryawantabper').html(response.sukses);
                // $('.tabel1').show();
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
    $('.formtabelkaryawantabdiv').submit(function(e) {
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
                $('.listtabelkaryawantabdiv').html(response.sukses);
                // $('.tabel1').show();
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
    $('.formtabelkaryawantabtan').submit(function(e) {
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
                $('.listtabelkaryawantabtan').html(response.sukses);
                // $('.tabel1').show();
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })
</script>

<?= $this->endSection() ?>