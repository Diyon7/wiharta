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
                    FORM ABSEN
                </h3>
                <div class="card-tools">
                    <div class="btn-group mb-3" role="group" aria-label="Basic example">
                    </div>
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#vath" id="akjhjp3" data-toggle="tab">Belum Verifikasi(Human Err)</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#vat" id="akjjp3" data-toggle="tab">Belum Verifikasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#svat" id="kkjjp3" data-toggle="tab">Sudah Verifikasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#gvat" id="ktjjp3" data-toggle="tab">Verifikasi Ditolak</a>
                        </li>
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0" id='izin'>
                    <div class="tab-pane active" id="vath" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="formizinh" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>NIP</th>
                                        <th>NAMA</th>
                                        <th>JAM</th>
                                        <th>VENDOR</th>
                                        <th>IZIN</th>
                                        <th>IZIN DIBUAT</th>
                                        <th>ACTION</th>
                                    </thead>
                                    <tbody class="text-sm">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="vat" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="formizin" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>NIP</th>
                                        <th>NAMA</th>
                                        <th>JAM MASUK</th>
                                        <th>JAM PULANG</th>
                                        <th>JAM KERJA</th>
                                        <th>VENDOR</th>
                                        <th>IZIN</th>
                                        <th>IZIN DIBUAT</th>
                                        <th>ACTION</th>
                                    </thead>
                                    <tbody class="text-sm">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="chart tab-pane" id="svat" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="formsudahizin" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>NIP</th>
                                        <th>NAMA</th>
                                        <th>JAM MASUK</th>
                                        <th>JAM PULANG</th>
                                        <th>JAM KERJA</th>
                                        <th>VENDOR</th>
                                        <th>IZIN</th>
                                        <th>IZIN DIBUAT</th>
                                        <th>ACTION</th>
                                    </thead>
                                    <tbody class="text-sm">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="chart tab-pane" id="gvat" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="formditolakizin" class="w-100 table table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>NIP</th>
                                        <th>NAMA</th>
                                        <th>JAM</th>
                                        <th>VENDOR</th>
                                        <th>IZIN</th>
                                        <th>IZIN DIBUAT</th>
                                        <th>ACTION</th>
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
    $('#formizin').DataTable({
        // "destroy": true,
        // "processing": true,
        // "serverSide": true,
        // "order": [],
        // "ajax": {
        //     "url": "<?= site_url('') ?>",
        //     "type": "POST",
        // },
        // "lengthMenu": [
        //     [5, 10, 25, 100],
        //     [5, 10, 25, 100]
        // ],
        // "columnDefs": [{
        //     "targets": 0,
        //     "orderable": false,
        // }],
    })
    $('#formsudahizin').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('admin/formizin/datatables') ?>",
            "type": "POST",
        },
        "lengthMenu": [
            [5, 10, 25, 100],
            [5, 10, 25, 100]
        ],
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }],
    });
    $('#formsudahizin tbody').on('click', '.btn-delete', function(e) {
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
                            $('#formsudahizin').DataTable().ajax.reload();
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

    $("#akjjp3").on('click', function(event) {
        $('#formizin').DataTable().ajax.reload()
    });
    $("#akjhjp3").on('click', function(event) {
        $('#formizinh').DataTable().ajax.reload()
    });
    $("#kkjjp3").on('click', function(event) {
        $('#formsudahizin').DataTable().ajax.reload()
    });
    $("#ktjjp3").on('click', function(event) {
        $('#formditolakizin').DataTable().ajax.reload()
    });

    
    
    $('#formizin').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('admin/formpizin/datatables') ?>",
            "type": "POST",
        },
        "lengthMenu": [
            [5, 10, 25, 100],
            [5, 10, 25, 100]
        ],
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }],
    });
    
    $('#formizinh').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('admin/formphizin/datatables') ?>",
            "type": "POST",
        },
        "lengthMenu": [
            [5, 10, 25, 100],
            [5, 10, 25, 100]
        ],
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }],
    });
    
    $('#formizin tbody').on('click', '.btn-ubahbs', function(e) {
        const idizin = $(this).data('ubahbsizin');

        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/izin/ubahbs') ?>",
                    method: "post",
                    data: {
                        idizin: idizin
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Change!',
                                'success'
                            );
                            $('#formizin').DataTable().ajax.reload();
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
    $('#formizin tbody').on('click', '.btn-ubahbt', function(e) {
        const idizin = $(this).data('ubahbtizin');

        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/izin/ubahbt') ?>",
                    method: "post",
                    data: {
                        idizin: idizin
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Change!',
                                'success'
                            );
                            $('#formizin').DataTable().ajax.reload();
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
    $('#formizinh tbody').on('click', '.btn-ubahbs', function(e) {
        const idizin = $(this).data('ubahbsizin');

        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/izin/ubahbs') ?>",
                    method: "post",
                    data: {
                        idizin: idizin
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Change!',
                                'success'
                            );
                            $('#formizinh').DataTable().ajax.reload();
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
    $('#formizinh tbody').on('click', '.btn-ubahbt', function(e) {
        const idizin = $(this).data('ubahbtizin');

        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/izin/ubahbt') ?>",
                    method: "post",
                    data: {
                        idizin: idizin
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Change!',
                                'success'
                            );
                            $('#formizinh').DataTable().ajax.reload();
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
    $('#formditolakizin').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?= site_url('admin/formtizin/datatables') ?>",
            "type": "POST",
        },
        "lengthMenu": [
            [5, 10, 25, 100],
            [5, 10, 25, 100]
        ],
        "columnDefs": [{
            "targets": 0,
            "orderable": false,
        }],
    });
    $('#formditolakizin tbody').on('click', '.btn-ubahbs', function(e) {
        const idizin = $(this).data('ubahbsizin');

        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/izin/ubahbs') ?>",
                    method: "post",
                    data: {
                        idizin: idizin
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Change!',
                                'success'
                            );
                            $('#formditolakizin').DataTable().ajax.reload();
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
    $('#formditolakizin tbody').on('click', '.btn-delete', function(e) {
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
                            $('#formditolakizin').DataTable().ajax.reload();
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
    $('#formsudahizin tbody').on('click', '.btn-izinm', function(e) {
        const idizin = $(this).data('izinm');

        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, change it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('admin/izin/izinm') ?>",
                    method: "post",
                    data: {
                        idizin: idizin
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Change!',
                                'success'
                            );
                            $('#formditolakizin').DataTable().ajax.reload();
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