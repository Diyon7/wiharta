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
                    SALDO AWAL
                </h3>
                <br>
                <button type="button" class="btn btn-primary col-sm-1" data-toggle="modal" data-target="#gantishift">
                    TAMBAH <i class=" fas fa-plus"></i>
                </button>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="saldoawaltabel" class="w-100 table table-sm table-bordered table-striped">
                                    <thead class="text-sm">
                                        <th>SEC</th>
                                        <th>KODE ITEM</th>
                                        <th>NAMA</th>
                                        <th>QTY</th>
                                        <th>NETTO</th>
                                        <th>TGL</th>
                                        <th>AJU</th>
                                        <th>AKSI</th>
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

<div class="modal fade" id="gantishift" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ganti Shift</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/barangjadi/addsaldoawal', ['class' => 'addsaldoawal']) ?>
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputItem">Item</label>
                        <select name="itemdes" id="namaitem" class="form-control pilihnamaitem" required>
                            <option selected>Choose...</option>
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="kode_item" id="kodeitem" placeholder="kodeitem"
                            readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">Qty</label>
                        <input type="number" class="form-control" name="qty_awal" placeholder="qty" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Netto</label>
                        <input type="number" class="form-control" name="netto_awal" placeholder="netto" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Lokasi Asal</label>
                        <select name="lokasal" id="lok" class="form-control pilihlok" required>
                            <option selected>Choose...</option>
                            <?php foreach ($lok as $la) : ?>
                            <option value="<?= $la['analyst_code'] ?>"><?= $la['analyst_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Lokasi Tujuan</label>
                        <select name="loktujuan" id="lok" class="form-control pilihlok" required>
                            <option selected>Choose...</option>
                            <?php foreach ($lok as $lt) : ?>
                            <option value="<?= $lt['analyst_code'] ?>"><?= $lt['analyst_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputItem">Tgl</label>
                        <input type="date" class="form-control" name="tgl" placeholder="tgl" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Aju</label>
                        <select id="inputItem" name="aju" class="form-control" required>
                            <option value="" selected>Choose...</option>
                            <?php foreach ($aju as $aj) : ?>
                            <option value="<?= $aj['aju'] ?>"><?= $aj['aju'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Input</button>
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
        // $.ajax({
        //     url: '<?= site_url('admin/exim/ajax/carikodeitem') ?>',
        //     type: 'post',
        //     dataType: 'json',
        //     data: {
        //         namaitem: namaitem
        //     },
        //     success: function(response) {

        //         var kodeitem = response.kodeitem;

        //         console.log(kodeitem);

        //         $("#kodeitem").val(kodeitem);
        //     },

        //     error: function(xhr, ajaxOption, thrownError) {
        //         alert(xhr.status + "\n\n\n" + thrownError);
        //     }
        // });
    });


    var tajp3 = $('#saldoawaltabel').DataTable({
        // dom": 'Blfrtip',
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "buttons": ["copy", "csv", "excel"],
        "ajax": {
            "url": "<?= site_url('admin/barangjadi/saldoawal/datatables') ?>",
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
});

$(document).ready(function() {

    const Toasts = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 15000
    });

    $('.addsaldoawal').submit(function(e) {
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
                    $("#saldoawaltabel").DataTable().ajax.reload();
                } else {
                    $('#gantishift').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('#saldoawaltabel tbody').on('click', '.btn-delete', function(e) {
        const idgantishift = $(this).data('idgantishift');

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
                    url: "<?= site_url('admin/exim/deletesaldoawal') ?>",
                    method: "post",
                    data: {
                        idgantishift: idgantishift
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            $('#gantishifttabel').DataTable().ajax.reload();
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

    $('#namakaryawan').select2({
        width: '500px'
    });

});
</script>

<?= $this->endSection() ?>