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
                <button type="button" class="btn btn-primary col-sm-1" id="gantishift" data-toggle="modal">
                    LAPORKAN <i class=" fas fa-plus"></i>
                </button>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="bclkttabel" class="w-100 table table-sm table-bordered table-striped">
                                    <div class="form-row">
                                    </div>
                                    <thead class="text-sm">
                                        <tr>
                                            <th align='center'>PEB</th>
                                            <th align='center'>Tgl PEB</th>
                                            <th align='center'>Belum BCLKT</th>
                                            <th align='center'>Tgl Rekam</th>
                                            <th align='center'>Aksi</th>
                                        </tr>
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



<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
const flashDataa = "<?= session()->getFlashdata('success') ?>";

$(document).ready(function() {

    $('.tanggalinput').daterangepicker();

    $('.pilihpeb').select2({
        width: '290px'
    });

    var tajp3 = $('#bclkttabel').DataTable({
        // dom": 'Blfrtip',
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "buttons": ["copy", "csv", "excel"],
        "ajax": {
            "url": "<?= site_url('admin/exim/bclktitv/datatables') ?>",
            "type": "POST",
        },
        "lengthMenu": [
            [5, 10, 25, 100, -1],
            [5, 10, 25, 100, "All"]
        ],
        "columnDefs": [{
            "targets": 4,
            "orderable": false,
        }],
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

    $('#bclkttabel tbody').on('click', '.btn-edit', function(e) {
        const peb = $(this).data('peb');

        $.ajax({
            url: "<?= base_url('admin/exim/bclktitv/laporkanbclkt') ?>",
            method: "post",
            data: {
                peb: peb
            },
            dataType: "json",
            beforeSend: function() {
                $('.btn-edit').attr('disable', 'disabled');
                $('.btn-edit').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-edit').removeAttr('disable');
                $('.btn-edit').html('<i class=\"fas fa-plus\"></i>');
            },
            success: function(response) {
                console.log(response.success);
                if (response.success) {
                    // $('#gantishift').modal('hide');
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                    $("#bclkttabel").DataTable().ajax.reload();
                } else {
                    $('#editdata').modal('hide');
                }
                $('input[name=csrf_test_name]').val(response.csrf_test_name);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $('#gantishift').on('click', function(e) {
        const id = $(this).data('seq');

        $.ajax({
            url: "<?= base_url('admin/exim/bclktitv/nambah') ?>",
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

    $('#bclkttabel tbody').on('click', '.btn-peb', function(e) {
        const peb = $(this).data('peb');

        Swal.fire({
            title: 'Yakin dibatalkan ?',
            text: "Apakah yakin dibatalkan ini !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Batalkan!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/exim/bclktitv/cancel') ?>",
                    method: "post",
                    data: {
                        peb: peb,

                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Cancel!',
                                'Your file has been Canceled.',
                                'success'
                            );
                            $('#bclkttabel').DataTable().ajax.reload();
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

});
</script>

<?= $this->endSection() ?>