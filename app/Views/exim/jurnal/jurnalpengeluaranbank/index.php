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
                    JURNAL PENGELUARAN BANK
                </h3>
                <br>
                <button type="button" class="btn-add btn btn-primary col-sm-1" id="add" data-toggle="modal">
                    TAMBAH <i class=" fas fa-plus"></i>
                </button>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="jurnalpengeluaranbank"
                                    class="w-100 table table-sm table-bordered table-striped">
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="inputItem">TGL Dari</label>
                                            <input type="date" class="form-control" id="tgldari" name="tgldari"
                                                placeholder="qty">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputItem">TGL Ke</label>
                                            <input type="date" class="form-control" id="tglke" name="tglke"
                                                placeholder="qty">
                                        </div>
                                    </div>
                                    <thead class="text-sm">
                                        <th>No</th>
                                        <th>BANK</th>
                                        <th>TGL</th>
                                        <th>AJU</th>
                                        <th>BAPB</th>
                                        <th>TGL BAPB</th>
                                        <th>SUPPLIER</th>
                                        <th>KETERANGAN</th>
                                        <!-- <th>NILAI</th> -->
                                        <th>REKAM</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody class="text-sm">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
</div>
<!-- 
<div class="modal fade" id="gantishift" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nambah Pengeluaran Bank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/jurnal/jurnalpengeluaranbank/addjurnalpengeluaranbank', ['class' => 'addjurnalpengeluaranbank']) ?>
                <?= csrf_field() ?>
                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="inputItem">BANK</label>
                        <select name="bank" id="bank" class="form-control pilihbank" required>
                            <option selected>Choose...</option>
                            <?php foreach ($bank as $bk) : ?>
                            <option value="<?= $bk['kode_bank'] ?>"><?= $bk['nama'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Kode Referensi</label>
                        <input type="text" class="form-control" name="kodereferensi" placeholder="kode referensi"
                            required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Tgl</label>
                        <input type="date" class="form-control" name="tgl" placeholder="tgl" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">Aju</label>
                        <select name="aju" id="aju" class="form-control pilihaju">
                            <option selected>Choose...</option>
                            <?php foreach ($aju as $aj) : ?>
                            <option value="<?= $aj['aju'] ?>">
                                <?= $aj['aju'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Supplier</label>
                        <input type="text" class="form-control" id="supplier" name="supplier" placeholder="supplier"
                            readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">TGL BAPB</label>
                        <input type="date" class="form-control" id="tglbapb" name="tglbapb" placeholder="tglbapb"
                            required readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">BAPB</label>
                        <input type="text" class="form-control" id="bapb" name="bapb" placeholder="bapb" required
                            readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai Jurnal Pembelian</label>
                        <input type="text" class="form-control" id="nilai" name="nilai" placeholder="nilai" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai Kredit</label>
                        <input type="text" class="form-control" id="nilaiu" name="nilaiu" placeholder="nilaiu" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Input</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div> -->

<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
const flashDataa = "<?= session()->getFlashdata('success') ?>";

$(document).ready(function() {

    $('.tanggalinput').daterangepicker();

    $('.pilihnamaitem').select2({
        width: '290px'
    });

    $('.aju').select2({
        width: '290px'
    });

    $('#add').on('click', function(e) {
        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpengeluaranbank/tambah') ?>",
            method: "post",
            dataType: "json",
            beforeSend: function() {
                $('.btn-add').attr('disable', 'disabled');
                $('.btn-add').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-add').removeAttr('disable');
                $('.btn-add').html('<i class=\"fas fa-plus\"></i>');
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

    var tajp3 = $('#jurnalpengeluaranbank').DataTable({
        "dom": 'Blfrtip',
        // "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "buttons": ["copy", "csv", "excel"],
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': '<div class="spinner">Data Diproses</div>'
        },
        "ajax": {
            "url": "<?= site_url('admin/jurnal/jurnalpengeluaranbank/datatables') ?>",
            "type": "POST",
            "data": function(data) {
                // data.pilihtujuan = $('#pilihtujuan').val();
                data.tgldari = $('#tgldari').val();
                data.tglke = $('#tglke').val();
                // data.itemfilter = $('#itemfilter').val();
            },
        },
        drawCallback: function(settings) {
            $('#totalqty').html(settings.json.totalqty);
            $('#totalkgm').html(settings.json.totalkgm);
        },
        "lengthMenu": [
            [5, 10, 25, 100, 500, -1],
            [5, 10, 25, 100, 500, "All"]
        ],
        "columnDefs": [{
            "targets": 9,
            "orderable": false,
        }],
    });

    $("#tgldari").change(function() {
        tajp3.draw();
    });
    $("#tglke").change(function() {
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



    $('#jurnalpengeluaranbank tbody').on('click', '.btn-delete', function(e) {
        const kode = $(this).data('kode');

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
                    url: "<?= site_url('admin/jurnal/jurnalpengeluaranbank/deletejurnal') ?>",
                    method: "post",
                    data: {
                        kode: kode,

                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            $('#jurnalpengeluaranbank').DataTable().ajax
                                .reload();
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

    $('#jurnalpengeluaranbank tbody').on('click', '.btn-print', function(e) {
        const id = $(this).data('kode');

        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpengeluaranbank/tampilcetakkode') ?>",
            method: "post",
            data: {
                id: id,
                data: 'hahahahah'
            },
            dataType: "json",
            beforeSend: function() {
                $('.btn-print').attr('disable', 'disabled');
                $('.btn-print').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-print').removeAttr('disable');
                $('.btn-print').html('<i class="fas fa-print"></i>');
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

    $('#jurnalpengeluaranbank tbody').on('click', '.btn-edit', function(e) {
        const id = $(this).data('kode');

        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpengeluaranbank/edit') ?>",
            method: "post",
            data: {
                id: id,
                data: 'hahahahah'
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

    $('#jurnalpengeluaranbank tbody').on('click', '.btn-editm', function(e) {
        const id = $(this).data('sec');

        $.ajax({
            url: "<?= base_url('admin/mutasi/jurnalpembelian/editm') ?>",
            method: "post",
            data: {
                id: id
            },
            dataType: "json",
            beforeSend: function() {
                $('.btn-editm').attr('disable', 'disabled');
                $('.btn-editm').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-editm').removeAttr('disable');
                $('.btn-editm').html('<i class="fas fa-edit"></i> Kode');
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

    $('#jurnalpengeluaranbank tbody').on('click', '.btn-editi', function(e) {
        const id = $(this).data('sec');

        $.ajax({
            url: "<?= base_url('admin/mutasi/jurnalpembelian/editi') ?>",
            method: "post",
            data: {
                id: id
            },
            dataType: "json",
            beforeSend: function() {
                $('.btn-editi').attr('disable', 'disabled');
                $('.btn-editi').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-editi').removeAttr('disable');
                $('.btn-editi').html('<i class="fas fa-edit"></i> Item');
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