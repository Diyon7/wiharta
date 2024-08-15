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
                    Daftar Log Karyawan dalam 1 bulan
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
                    <div class="tab-pane active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="karyawanjp3a" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>IDKAR</th>
                                        <th>VENDOR</th>
                                        <th>NAMA</th>
                                        <th>BAGIAN</th>
                                        <th>TMT</th>
                                        <th>GRUP_T</th>
                                        <th>AKSI</th>
                                    </thead>
                                    <tbody class="text-sm">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="chart tab-pane" id="kjp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="karyawanjp3k" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th class="text-sm">IDKAR</th>
                                        <th>VENDOR</th>
                                        <th>NAMA</th>
                                        <th>BAGIAN</th>
                                        <th>TMT</th>
                                        <th>GRUP_T</th>
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
<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
$(document).ready(function() {
    $("#kkjjp3").on('click', function(event) {
        // tkjp3.destroy();
        var tajp3 = $('#karyawanjp3k').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?= site_url('ajax/logkaryawan/datatables') ?>",
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
    })
    // tajp3.destroy();
    var tkjp3 = $('#karyawanjp3a').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('ajax/karyawanjp3a/datatables') ?>",
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
    // $("#akjjp3").on('click', function(event) {
    //     $('#karyawanjp3a').DataTable().ajax.reload()
    // })
    $('#refresh').click(function(e) {
        $('#karyawanjp3a').DataTable().ajax.reload()
    });

    $('.detailkaryawan').on('click', function(event) {

    });
});

function detailkaryawana(id) {
    $.ajax({
        url: "<?= site_url('ajax/karyawanjp3a/detaila') ?>",
        type: "POST",
        data: {
            idnip: id
        },
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                $('.vieweditdata').html(response.sukses).show();
                $('#detaildata').modal('show');
            }
            $('input[name=csrf_test_name]').val(response.csrf_test_name);
        },
        error: function(xhr, ajaxOption, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}
</script>

<?= $this->endSection() ?>