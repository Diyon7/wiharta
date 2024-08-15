<?= $this->extend('layouts/main_master') ?>

<?= $this->section('isi') ?>

<!-- Small boxes (Stat box) -->
<div class="row">

</div>

<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-1"></i>
                    Export
                </h3>
                <br>
                <button type="button" class="btn btn-primary btn-add col-sm-1" id="add" data-toggle="modal">
                    <i class="fas fa-file"></i> Cetak
                </button>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="mutasiexporttabel" class="w-100 table table-sm table-bordered table-striped">
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="inputItem">TGL PEB Dari</label>
                                            <input type="date" class="form-control" id="tgldari" name="tgldari" placeholder="qty">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputItem">TGL PEB Ke</label>
                                            <input type="date" class="form-control" id="tglke" name="tglke" placeholder="qty">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputItem">Item</label>
                                            <select name="itemfilter" id="itemfilter" class="form-control pilihnamaitem" required>
                                                <option value="%" selected>Choose...</option>
                                                <?php foreach ($item as $it) : ?>
                                                    <option value="<?= $it['item'] ?>">
                                                        <?= $it['item'] ?>||<?= $it['item_description'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputItem">PEB</label>
                                            <select name="pebfilter" id="pebfilter" class="form-control pilihnamaitem" required>
                                                <option value="%" selected>Choose...</option>
                                                <?php foreach ($peb as $pe) : ?>
                                                    <option value="<?= $pe['peb'] ?>">
                                                        <?= $pe['peb'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <thead class="text-sm">
                                        <tr>
                                            <th colspan='2' align='center'>PEB</th>
                                            <th colspan='7' align='center'>Barang</th>
                                            <th colspan='2' align='center'>INV</th>
                                            <th colspan='2' align='center'>Bukti Pengeluaran Barang</th>
                                            <th rowspan='2' align='center'>Pembeli / Penerima</th>
                                            <th rowspan='2' align='center'>Negara</th>
                                            <th rowspan='2' align='center'>User</th>
                                            <th rowspan='2' align='center'>TGL Rekam</th>
                                            <th rowspan='2' align='center'>Aksi</th>

                                        </tr>
                                        <tr>

                                            <th>No</th>
                                            <th>tgl</th>

                                            <th>Kode Brg</th>
                                            <th>nama</th>
                                            <th>desk</th>
                                            <th>jml</th>
                                            <th>KGM</th>
                                            <th>AJU</th>
                                            <th>nilai FOB</th>

                                            <th>No</th>
                                            <th>tgl</th>

                                            <th>No</th>
                                            <th>tgl</th>


                                        </tr>
                                    </thead>
                                    <tbody class="text-sm">

                                    </tbody>
                                    <tfoot>
                                        <th colspan="6">Total</th>
                                        <th id="totalkgm"></th>
                                        <th colspan="10"></th>
                                    </tfoot>
                                </table>
                                <div id="rendered"></div>
                            </div>
                        </div>
                    </div>
                </div>
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

        $('.tanggalinput').daterangepicker();

        $('.pilihnamaitem').select2({
            width: '290px'
        });
        $("#namaitem").change(function() {
            var namaitem = $(this).val();
            console.log(namaitem);
            $("#kodeitem").val(namaitem);
        });


        var tajp3 = $('#mutasiexporttabel').DataTable({
            // dom": 'Blfrtip',
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "buttons": ["copy", "csv", "excel"],
            "ajax": {
                "url": "<?= site_url('admin/mutasi/mutasiekspor/datatables') ?>",
                "type": "POST",
                "data": function(data) {
                    data.tgldari = $('#tgldari').val();
                    data.tglke = $('#tglke').val();
                    data.itemfilter = $('#itemfilter').val();
                    data.pebfilter = $('#pebfilter').val();
                },
            },
            drawCallback: function(settings) {
                $('#totalkgm').html(settings.json.totalkgm);
                $('#rendered').html(settings.json.rendered);
            },
            "lengthMenu": [
                [5, 10, 25, 100, -1],
                [5, 10, 25, 100, "All"]
            ],
            "columnDefs": [{
                "targets": 17,
                "orderable": false,
            }],
        });
        $("#tgldari").change(function() {
            tajp3.draw();
        });
        $("#tglke").change(function() {
            tajp3.draw();
        });
        $("#itemfilter").change(function() {
            tajp3.draw();
        });
        $("#pebfilter").change(function() {
            tajp3.draw();
        });
    });

    $(document).ready(function() {

        const Toasts = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 15000
        });

        $('#add').on('click', function(e) {
            $.ajax({
                url: "<?= base_url('admin/mutasi/mutasiekspor/modalcetak') ?>",
                method: "post",
                dataType: "json",
                beforeSend: function() {
                    $('.btn-add').attr('disable', 'disabled');
                    $('.btn-add').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btn-add').removeAttr('disable');
                    $('.btn-add').html('<i class=\"fas fa-file\"></i> Cetak');
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

        $('.addmutasiproduksi').submit(function(e) {
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
                        $('#gantishift').modal('hide');
                        Toasts.fire({
                            icon: 'success',
                            title: 'Data Berhasil',
                            type: 'success',
                        });
                        $("#mutasiexporttabel").DataTable().ajax.reload();
                    } else {
                        $('#gantishift').modal('show');
                    }
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })

        $('#mutasiexporttabel tbody').on('click', '.btn-delete', function(e) {
            const seq = $(this).data('seq');

            Swal.fire({
                title: 'Yakin hapus ?',
                text: "Apakah yakin menghapus data export ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('admin/mutasi/mutasiekspor/deleteekspormutasi') ?>",
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
                                $('#mutasiexporttabel').DataTable().ajax.reload();
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

        $('#mutasiexporttabel tbody').on('click', '.btn-edit', function(e) {
            const id = $(this).data('seq');

            $.ajax({
                url: "<?= base_url('admin/mutasi/mutasiekspor/edit') ?>",
                method: "post",
                data: {
                    id: id
                },
                cache: true,
                dataType: "json",
                beforeSend: function() {
                    $('.btn-edit').attr('disable', 'disabled');
                    $('.btn-edit').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btn-edit').removeAttr('disable');
                    $('.btn-edit').html('<i class=\"fas fa-edit\"></i>');
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

        $('#mutasiexporttabel tbody').on('click', '.btn-nambah', function(e) {
            const id = $(this).data('seq');

            $.ajax({
                url: "<?= base_url('admin/mutasi/mutasiekspor/nambahaju') ?>",
                method: "post",
                data: {
                    id: id
                },
                dataType: "json",
                beforeSend: function() {
                    $('.btn-nambah').attr('disable', 'disabled');
                    $('.btn-nambah').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btn-nambah').removeAttr('disable');
                    $('.btn-nambah').html('<i class=\"fas fa-plus\"></i>');
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

        $('#mutasiexporttabel tbody').on('click', '.btn-editi', function(e) {
            const id = $(this).data('seq');

            $.ajax({
                url: "<?= base_url('admin/mutasi/mutasiekspor/editi') ?>",
                method: "post",
                data: {
                    id: id
                },
                cache: true,
                dataType: "json",
                beforeSend: function() {
                    $('.btn-editi').attr('disable', 'disabled');
                    $('.btn-editi').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btn-editi').removeAttr('disable');
                    $('.btn-editi').html('<i class=\"fas fa-edit\"></i> Item');
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

        $('#namakaryawan').select2({
            width: '500px'
        });

    });
</script>

<?= $this->endSection() ?>