<?= $this->extend('layouts/main_master') ?>

<?= $this->section('isi') ?>
<!-- Small boxes (Stat box) -->
<div class="row">
    <?php foreach ($jumlahpervendor as $datavendor) :  ?>
    <div class="col-md-2 row-1">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <p>Jumlah Karyawan
                <h3><?= $datavendor['jumlah'] ?></h3>
                </p>
            </div>
            <div class="icon">
                <h3><?= $datavendor['pembagian3_nama'] ?></h3>
            </div>
            <a class="small-box-footer moreinfovendor" data-namavendor="<?= $datavendor['pembagian3_nama'] ?>">More info
                <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <?php endforeach; ?>
    <!-- ./col -->
</div>
<!-- /.row -->
<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-7 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Sales
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                        </li>
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <!-- Morris chart - Sales -->
                    <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                        <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                    </div>
                    <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                        <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    <section class="col-lg-5 connectedSortable">

        <!-- Map card -->
        <div class="card bg-gradient-primary">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-map-marker-alt mr-1"></i>
                    Visitors
                </h3>
                <!-- card tools -->
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                        <i class="far fa-calendar-alt"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <div class="card-body">
                <div id="world-map" style="height: 250px; width: 100%;"></div>
            </div>
            <!-- /.card-body-->
            <div class="card-footer bg-transparent">
                <div class="row">
                    <div class="col-4 text-center">
                        <div id="sparkline-1"></div>
                        <div class="text-white">Visitors</div>
                    </div>
                    <!-- ./col -->
                    <div class="col-4 text-center">
                        <div id="sparkline-2"></div>
                        <div class="text-white">Online</div>
                    </div>
                    <!-- ./col -->
                    <div class="col-4 text-center">
                        <div id="sparkline-3"></div>
                        <div class="text-white">Sales</div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.card -->

    </section>
    <!-- right col -->
</div>
<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
$(document).ready(function() {
    $(".moreinfovendor").on('click', function(event) {
        const nama = $(this).data('namavendor');
        $.ajax({
            url: "<?= site_url('ajax/dashboard/moreinfo') ?>",
            type: "POST",
            data: {
                namavendor: nama
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.vieweditdata').html(response.sukses).show();
                    $('#detaildatavendor').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    })
});
</script>

<?= $this->endSection() ?>