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
                    satuan
                </h3>
            </div><!-- /.card-header -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#satuan">
                TAMBAH
            </button>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="satuantabel" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>Kode</th>
                                        <th class="col-lg-9">satuan</th>
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

<div class="modal fade" id="satuan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">satuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/exim/satuan/addsatuan', ['class' => 'satuan']) ?>
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="formGroupInput">Kode</label>
                    <input type="text" class="form-control" id="formGroupInput" name="kode">
                </div>
                <div class="form-group">
                    <label for="input" class="col-form-label">satuan</label>
                    <input type="text" class="form-control" name="satuan" id="satuan">
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

        var tajp3 = $('#satuantabel').DataTable({
            // dom": 'Blfrtip',
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "buttons": ["copy", "csv", "excel"],
            "ajax": {
                "url": "<?= site_url('admin/exim/satuan/datatables') ?>",
                "type": "POST",
            },
            "lengthMenu": [
                [5, 10, 25, 100],
                [5, 10, 25, 100]
            ],
            "columnDefs": [{
                "targets": 2,
                "orderable": false,
            }],
        })

        // $("#akjjp3").on('click', function(event) {
        //     $('#karyawanjp3a').DataTable().ajax.reload()
        // })

    });

    $(document).ready(function() {

        const Toasts = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 15000
        });

        $('.satuan').submit(function(e) {
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
                        $('#satuan').modal('hide');
                        Toasts.fire({
                            icon: 'success',
                            title: 'Data Berhasil',
                            type: 'success',
                        });
                        $("#satuantabel").DataTable().ajax.reload();
                    } else {
                        $('#satuan').modal('show');
                    }
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })

        $('#satuantabel tbody').on('click', '.btn-delete', function(e) {
            const idsatuan = $(this).data('deletesatuan');

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
                        url: "<?= site_url('admin/satuan/deletesatuan') ?>",
                        method: "post",
                        data: {
                            idsatuan: idsatuan
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.sukses) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                );
                                $('#satuantabel').DataTable().ajax.reload();
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

    })
</script>

<?= $this->endSection() ?>