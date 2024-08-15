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
                    EXIM WKA KE ITV
                </h3>
                <br>
                <button type="button" class="btn btn-primary col-sm-1 btn-update" data-toggle="modal"
                    data-target="#gantishift">
                    UPDATE <i class=" fas fa-plus"></i>
                </button>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="updateitv" class="w-100 table table-sm table-bordered table-striped">
                                    <thead class="text-sm">
                                        <tr>

                                            <th colspan='2' align='center'>PEB</th>
                                            <th colspan='2' align='center'>Bukti Pengeluaran Barang</th>
                                            <th rowspan='2' align='center'>Pembeli / Penerima</th>
                                            <th rowspan='2' align='center'>Negara</th>
                                            <th colspan='5' align='center'>Barang</th>
                                            <th rowspan='2' align='center'>Invoice</th>
                                            <th rowspan='2' align='center'>Aksi</th>

                                        </tr>
                                        <tr>

                                            <th>No</th>
                                            <th>tgl</th>
                                            <th>No</th>
                                            <th>tgl</th>

                                            <th>Kode Brg</th>
                                            <th>desk</th>
                                            <th>jml</th>
                                            <th>KGM</th>
                                            <th>nilai FOB</th>

                                        </tr>
                                    </thead>
                                    <tbody class="text-sm">

                                    </tbody>
                                    <div id="rendered"></div>
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

    var tajp3 = $('#updateitv').DataTable({
        // "dom": 'Blfrtip',
        "processing": true,
        "serverSide": true,
        "order": [],
        "buttons": ["copy", "csv", "excel"],
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': '<div class="spinner">Data Diproses</div>'
        },
        "ajax": {
            "url": "<?= site_url('admin/exim/wkaitv/datatables') ?>",
            "type": "POST",
            "data": function(data) {
                data.pilihtujuan = $('#pilihtujuan').val();
                data.tgldari = $('#tgldari').val();
                data.tglke = $('#tglke').val();
                data.itemfilter = $('#itemfilter').val();
            },
        },
        drawCallback: function(settings) {
            $('#totalqty').html(settings.json.totalqty);
            $('#totalkgm').html(settings.json.totalkgm);
            $('#rendered').html(settings.json.rendered);
        },
        "lengthMenu": [
            [5, 10, 25, 100, 500, -1],
            [5, 10, 25, 100, 500, "All"]
        ],
        "columnDefs": [{
            "targets": 10,
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

    $('.btn-update').on('click', function(e) {
        const id = $(this).data('sec');

        $.ajax({
            url: "<?= base_url('admin/exim/wkaitv/update') ?>",
            method: "post",
            data: {
                id: id
            },
            dataType: "json",
            beforeSend: function() {
                $('.btn-update').attr('disable', 'disabled');
                $('.btn-update').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-update').removeAttr('disable');
                $('.btn-update').html('<i class="fas fa-edit"></i>');
            },
            success: function(response) {
                if (response.sukses) {
                    $('#updateitv').DataTable().ajax.reload();
                    Toasts.fire({
                        icon: 'success',
                        title: 'Update Berhasil',
                        type: 'success',
                    });
                }
                if (response.error) {
                    Toasts.fire({
                        icon: 'error',
                        title: response.error,
                        type: 'error',
                    });
                }
                $('input[name=csrf_test_name]').val(response.csrf_test_name);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
    $('#updateitv tbody').on('click', '.btn-delete', function(e) {
        const seq = $(this).data('seq');

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
                    url: "<?= site_url('admin/exim/wkaitv/delete') ?>",
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
                            $('#updateitv').DataTable().ajax.reload();
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

    $('#updateitv tbody').on('click', '.btn-add', function(e) {
        const id = $(this).data('seq');

        $.ajax({
            url: "<?= base_url('admin/exim/wkaitv/add') ?>",
            method: "post",
            data: {
                id: id
            },
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

    $('#namakaryawan').select2({
        width: '500px'
    });

});
</script>

<?= $this->endSection() ?>