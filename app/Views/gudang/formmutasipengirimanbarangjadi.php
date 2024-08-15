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
    <section class="col-lg-12 connectedSortable text-sm form-control-sm">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-1"></i>
                    Mutasi Pengiriman Barang Jadi
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <?= form_open() ?>
                <?= csrf_field() ?>
                <div class="row">
                    <!-- <div class="col-sm-3">
                        <div class="form-group">
                            <label>Kode SPP</label>
                            <input type="text" class="form-control form-control-sm" name="kodespp" id="inputkodespp" placeholder="Enter ...">
                        </div>
                    </div> -->
                    <div class="col-sm-6">
                        <label>Kode SPP</label>
                        <div class="row">
                            <div class="col-sm-9">
                                <select class="form-control form-control-sm pilihkaryawan" name="nama" id="nama" aria-placeholder="Pilih Karyawan">
                                    <option value="">Pilih kode</option>
                                    <option value="#">gdfg</option>
                                </select>
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-sm btn-primary tambakkodespp"><i class="fas fa-plus-circle"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Tanggal SPP</label>
                            <input type="date" class="form-control form-control-sm" name="tglspp" id="inputkodespp" placeholder="Enter ...">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Tanggal Rencana Kirim SPP</label>
                            <input type="date" class="form-control form-control-sm" name="tglspp" id="inputkodespp" placeholder="Enter ...">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- text input -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Kode Item</label>
                            <div class="row">
                                <div class="col-sm-5">
                                    <select class="form-control form-control-sm pilihkaryawan" name="nama" id="nama" aria-placeholder="Pilih Karyawan">
                                        <option value="">Pilih kode</option>
                                        <option value="#">gdfg</option>
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control form-control-sm" name="kodespp" id="inputkodespp" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Tgl Penerimaan Barang Jadi</label>
                            <input type="date" class="form-control form-control-sm" name="tglspp" id="inputkodespp" placeholder="Enter ...">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <!-- text input -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Customer</label>
                            <div class="row">
                                <div class="col-sm-5">
                                    <select class="form-control form-control-sm pilihkaryawan" name="nama" id="nama" aria-placeholder="Pilih Karyawan">
                                        <option value="">Pilih Customer</option>
                                        <option value="#">gdfg</option>
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control form-control-sm" name="kodespp" id="inputkodespp" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Qty Jumlan Satuan</label>
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="number" class="form-control form-control-sm" name="kodespp" id="inputkodespp">
                                </div>
                                <div class="col-sm-5">
                                    <select class="form-control form-control-sm pilihkaryawan" name="nama" id="nama" aria-placeholder="Pilih Karyawan">
                                        <option value="">Pilih Satuan</option>
                                        <option value="#">KG</option>
                                        <option value="#">Pc's</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Qty Jumlah KG</label>
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="number" class="form-control form-control-sm" name="kodespp" id="inputkodespp">
                                </div>
                                <div class="col-sm-5">
                                    <select class="form-control form-control-sm pilihkaryawan" name="nama" id="nama" aria-placeholder="Pilih Karyawan">
                                        <option value="">Pilih Satuan</option>
                                        <option value="#">gdfg</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Qty Jumlah Packing</label>
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="number" class="form-control form-control-sm" name="kodespp" id="inputkodespp">
                                </div>
                                <div class="col-sm-5">
                                    <select class="form-control form-control-sm pilihkaryawan" name="nama" id="nama" aria-placeholder="Pilih Karyawan">
                                        <option value="">Pilih Satuan</option>
                                        <option value="#">Dus</option>
                                        <option value="#">Ball</option>
                                        <option value="#">Pallet</option>
                                        <option value="#">Jumbo Ball</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- text input -->

                    <!-- <div class="col-sm-6">
                        <div class="form-group">
                            <label>Tgl Penyerahan</label>
                            <input type="date" class="form-control form-control-sm" name="tglspp" id="inputkodespp" placeholder="Enter ...">
                        </div>
                    </div> -->
                </div>
                <?= form_close() ?>
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

        let inputkodespp = $('#inputkodespp');

        inputkodespp.bind('keyup', function(ev) {
            if (ev.which !== 8) {
                let input = inputkodespp.val();
                let out = input.replace(/\D/g, '');
                let len = out.length;

                if (len > 1 && len < 4) {
                    out = out.substring(0, 2) + '/' + out.substring(2, 3);
                } else if (len >= 4) {
                    out = out.substring(0, 2) + '/' + out.substring(2, 4) + '/' + out.substring(4, len);
                    out = out.substring(0, 10)
                }
                inputkodespp.val(out)
            }
        });

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