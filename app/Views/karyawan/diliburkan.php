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
                    Diliburkan
                </h3>
            </div><!-- /.card-header -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#diliburkan">
                TAMBAH
            </button>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="diliburkantabel" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>TANGGAL</th>
                                        <th>UNIT</th>
                                        <th>JUMLAH ORANG</th>
                                        <th>DIBUAT TANGGAL</th>
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

<div class="modal fade" id="diliburkan" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">UNIT DILIBURKAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/adddiliburkan', ['class' => 'diliburkan']) ?>
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="formGroupInput">Tanggal</label>
                    <input type="text" class="form-control tanggalinput" id="formGroupInput" name="tgl">
                </div>
                <div class="form-group">
                    <label class="col-sm-1 col-form-label">Unit</label>
                    <select class="form-control pilihkaryawan" name="unit">
                        <?php foreach ($unit as $unt) : ?>
                        <option value="<?= $unt['pembagian4_id'] ?>"><?= $unt['pembagian4_nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="input" class="col-form-label">Jumlah Orang</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="jorang" id="jorang">
                    </div>
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
    

    var tajp3 = $('#diliburkantabel').DataTable({
        // dom": 'Blfrtip',
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "buttons": ["copy", "csv", "excel"],
        "ajax": {
            "url": "<?= site_url('admin/diliburkan/datatables') ?>",
            "type": "POST",
        },
        "lengthMenu": [
            [5, 10, 25, 100],
            [5, 10, 25, 100]
        ],
        "columnDefs": [{
            "targets": 4,
            "orderable": false,
        }],
    })

    // $("#akjjp3").on('click', function(event) {
    //     $('#karyawanjp3a').DataTable().ajax.reload()
    // })

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

    $('.diliburkan').submit(function(e) {
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
                console.log(response.coba);
                if (response.success) {
                    $('#diliburkan').modal('hide');
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                    $("#diliburkantabel").DataTable().ajax.reload();
                } else {
                    $('#diliburkan').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('#diliburkantabel tbody').on('click', '.btn-delete', function(e) {
        const iddiliburkan = $(this).data('deletediliburkan');

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
                    url: "<?= site_url('admin/deletediliburkan') ?>",
                    method: "post",
                    data: {
                        iddiliburkan: iddiliburkan
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            $('#diliburkantabel').DataTable().ajax.reload();
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
    
    $('.pilihkaryawan').select2({width: '250px'});

})
</script>

<?= $this->endSection() ?>