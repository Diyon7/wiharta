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
                    useritv
                </h3>
            </div>
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="useritvtabel" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>No</th>
                                        <th>user</th>
                                        <th>waktu</th>
                                        <th>ip address</th>
                                        <th>sistem operasi</th>
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

        var tajp3 = $('#useritvtabel').DataTable({
            // dom": 'Blfrtip',
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "buttons": ["copy", "csv", "excel"],
            "ajax": {
                "url": "<?= site_url('admin/exim/userloginbc/datatables') ?>",
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
</script>

<?= $this->endSection() ?>