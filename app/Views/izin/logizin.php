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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-1"></i>
                    Daftar Log Izin
                </h3>

                <div class="card-tools">
                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                        <button type="button" id="refresh" class="btn btn-outline-success">
                            <i class="fas fa-spinner"></i> Segarkan</button>
                    </div>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane downloaddata active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="logizin" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>NIP</th>
                                        <th>NAMA</th>
                                        <th>JAM</th>
                                        <th>IZIN</th>
                                        <th>IZIN DIBUAT</th>
                                        <th>STATUS</th>
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
<?php if (in_groups('vendor')) {
    $vendor = user()->username;
} else {
    $vendor = "%";
} ?>
<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
$(document).ready(function() {

    // group = "<?= in_groups('vendor') ?>";

    // if (group == "vendor") {
    //     var vendor = "<?= user()->username ?>";
    // } else {
    //     var vendor = "%";
    // }

    var tkjp3 = $('#logizin').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('admin/logizin/datatables') ?>",
            "type": "POST",
            "data": {
                "vendor": "<?= $vendor ?>",
            },
        },
        "lengthMenu": [
            [10, 25, 100],
            [10, 25, 100]
        ],
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }],
    })
    $('#logizin tbody').on('click', '.btn-delete', function(e) {
        const idizin = $(this).data('deleteizin');

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
                    url: "<?= site_url('admin/izin/delete') ?>",
                    method: "post",
                    data: {
                        idizin: idizin
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            $('#logizin').DataTable().ajax.reload();
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
    $('#refresh').click(function(e) {
        $('#logizin').DataTable().ajax.reload()
    });
});
</script>

<?= $this->endSection() ?>