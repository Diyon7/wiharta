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
                    Ganti Shift
                </h3>
            </div><!-- /.card-header -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#gantishift">
                TAMBAH
            </button>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="gantishifttabel" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>NAMA</th>
                                        <th>TANGGAL AWAL</th>
                                        <th>TANGGAL AKHIR</th>
                                        <th>SHIFT</th>
                                        <th>KETERANGAN</th>
                                        <th>STATUS</th>
                                        <th>AKSI</th>
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

<div class="modal fade" id="gantishift" aria-labelledby="exampleModalLabel"  style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ganti Shift</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/tambahgantishift', ['class' => 'gantishift']) ?>
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="formGroupInput">Tanggal</label>
                    <input type="text" class="form-control tanggalinput" id="formGroupInput" name="tgl" required>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 col-form-label">Nama</label>
                    <select class="form-control" name="nama" id="namakaryawan">
                        <option value="" selected>Pilih Karyawan</option>
                        <?php foreach($nama as $nm) : ?>'
                            <option value="<?= $nm['idkar'] ?>"><?= $nm['idkar'] . " | " . $nm['vendor'] . " | " . $nm['nama'] . " | " . $nm['grup_t'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="col-sm-1 col-form-label">Shift</label>
                    <select class="form-control" name="shift" required>
                        <option value="">Pilih Shift</option>
                        <?php foreach($jamkerja as $jmk) : ?>
                        <option value="<?= $jmk['jk_id'] ?>"><?= $jmk['jk_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="formGroupInput">Keterangan</label>
                    <textarea class="form-control" id="formGroupInput" name="keterangan" required></textarea>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right">Konfirmasi</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
const flashDataa = "<?= session()->getFlashdata('success') ?>";

$(document).ready(function() {
    
    $('.tanggalinput').daterangepicker();
    

    var tajp3 = $('#gantishifttabel').DataTable({
        // dom": 'Blfrtip',
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "buttons": ["copy", "csv", "excel"],
        "ajax": {
            "url": "<?= site_url('admin/gantishift/datatables') ?>",
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

    $('.detailkaryawan').on('click', function(event) {

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

    $('.gantishift').submit(function(e) {
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
                    $("#gantishifttabel").DataTable().ajax.reload();
                } else {
                    $('#gantishift').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('#gantishifttabel tbody').on('click', '.btn-delete', function(e) {
        const idgantishift = $(this).data('idgantishift');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/deletegantishift') ?>",
                    method: "post",
                    data: {
                        idgantishift: idgantishift
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            $('#gantishifttabel').DataTable().ajax.reload();
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
    
    $('#namakaryawan').select2({width: '500px'});

});
</script>

<?= $this->endSection() ?>