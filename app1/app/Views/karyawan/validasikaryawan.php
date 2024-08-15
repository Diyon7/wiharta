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
                    Validasi Karyawan JP3
                </h3>
                <div class="card-tools">
                </div>
            </div><!-- /.card-header -->
            <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="karyawanfp" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>IDKAR</th>
                                        <th>USER</th>
                                        <th>AKSI</th>
                                    </thead>
                                    <tbody class="text-sm">
                                    </tbody>
                                </table>
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
    
    var vk = $('#karyawanfp').DataTable({
        "dom": 'Blfrtip',
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "buttons": ["copy", "csv", "excel"],
        "ajax": {
            "url": "<?= site_url('admin/karyawan/vkdatatables') ?>",
            "type": "POST",
        },
        "lengthMenu": [
            [5, 10, 25, 100, -1],
            [5, 10, 25, 100, "All"]
        ],
        "columnDefs": [{
            "targets": 1,
            "orderable": false,
        }],
    });
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
    
    $('#karyawanfp tbody').on('click', '.btn-karyawanbaru', function(e) {
        const id = $(this).data('pkarid');

        $.ajax({
            url: "<?= site_url('admin/karyawan/validasikaryawanedit') ?>",
            method: "post",
            data: {
                idpin: id
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

    $('#karyawanjp3k tbody').on('click', '.btn-aktif', function(e) {
        const id = $(this).data('aktifid');
        const tmt = $(this).data('tmt');

        $('#masukkaryawanmodal').modal('show');

        $("#aktifidkar").val(id);
        $("#aktiftmt").val(tmt);

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

    $('.idms').submit(function(e) {
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
                    $('#masukkaryawanmodal').modal('hide');
                    $('#karyawanjp3k').DataTable().ajax.reload();
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                } else {
                    $('#masukkaryawanmodal').modal('show');
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