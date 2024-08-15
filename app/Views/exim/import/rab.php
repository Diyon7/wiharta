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
                    Import
                </h3>
                <br>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="bc" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="importtabel" class="w-100 table table-sm table-bordered table-striped">
                                    <thead class="text-sm">
                                        <tr>
                                            <th align='center'>item</th>
                                            <th align='center'>desk</th>
                                            <th align='center'>tgl</th>
                                            <th align='center'>harga</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-sm">
                                        <?php foreach ($rab as $ra) : ?>
                                            <tr>
                                                <td><?= $ra['item'] ?></td>
                                                <td><?= $ra['item_description'] ?></td>
                                                <td><?= $ra['tgl'] ?></td>
                                                <td><?= $ra['harga'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
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

        $('.pilihnamaitem').select2({
            width: '290px',
            minimumInputLength: 2,
            // allowClear: true,
            placeholder: 'Ketik Kode Item',
            ajax: {
                url: '<?= site_url('admin/exim/searchitem') ?>',
                dataType: "json",
                // type: "GET",
                data: function(params) {

                    var queryParameters = {
                        search: params.term
                    }
                    return queryParameters;
                },
                processResults: function(data, page) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.item_description,
                                id: item.item
                            }
                        })
                    };
                }
            }
        });
        $("#namaitem").change(function() {
            var namaitem = $(this).val();
            console.log(namaitem);
            $("#kodeitem").val(namaitem);
        });


        var tajp3 = $('#importtabel').DataTable({
            "buttons": ["copy", "csv", "excel"],
        });
        $('#dtwkajkt').on('click', function(e) {
            var tajp3 = $('#importtabeljkt').DataTable({
                "dom": 'Blfrtip',
                "destroy": true,
                "processing": true,
                "serverSide": true,
                "order": [],
                "buttons": ["copy", "csv", "excel"],
                "ajax": {
                    "url": "<?= site_url('admin/exim/importbahanbaku/datatablesjkt') ?>",
                    "type": "POST",
                    "data": function(data) {
                        data.tgldari = $('#tgldari').val();
                        data.tglke = $('#tglke').val();
                        // data.itemfilter = $('#itemfilter').val();
                    },
                },
                drawCallback: function(settings) {
                    $('#totalkgm').html(settings.json.totalkgm);
                },
                "lengthMenu": [
                    [5, 10, 25, 100, -1],
                    [5, 10, 25, 100, "All"]
                ],
                "columnDefs": [{
                    "targets": 22,
                    "orderable": false,
                }],
            });
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
                        $("#importtabel").DataTable().ajax.reload();
                    } else {
                        $('#gantishift').modal('show');
                    }
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })

        $('#importtabel tbody').on('click', '.btn-delete', function(e) {
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
                                $('#importtabel').DataTable().ajax.reload();
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

        $('#dtbc').on('click', function(e) {
            $('#importtabel').DataTable().ajax.reload();
        });

        $('#importtabeljkt tbody').on('click', '.btn-edit', function(e) {
            const id = $(this).data('seq');

            $.ajax({
                url: "<?= base_url('admin/exim/importbahanbaku/edit') ?>",
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

        $('#importtabel tbody').on('click', '.btn-editi', function(e) {
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