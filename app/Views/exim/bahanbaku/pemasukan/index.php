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
                    <i class="fas fa-book"></i>
                    <!-- <form method="get" action="pemasukan.php" id="form">
                        <section class="content-header">

                            <label>Kelompok :</label>
                            <select name="fnama3" id="fnama3">
                                <option selected="selected" value='FK'>Impor Fasilitas KITE</option>
                                <option value='FNK'>Impor Fasilitas Non-KITE</option>
                                <option value='NF'>Impor NON Fasilitas</option>
                                <option value='ALL'>Impor All</option>
                            </select>

                            <label>Periode :</label>

                            <input type="date" name="fnama" id="fnama" />
                            <label>Hingga :</label>
                            <input type="date" name="fnama2" id="fnama2" />

                            <input type="submit" name="submit" id="submit" value="Submit">
                        </section>
                    </form> -->
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
                                <table id="pemasukanbahanbakutabel" class="w-100 table table-sm table-bordered table-striped">
                                    <thead class="text-sm">
                                        <tr>
                                            <th rowspan='2' align='center'>Dok</th>
                                            <th colspan='4' align='center'>Dokumen Pabean</th>
                                            <th colspan='2' align='center'>Bukti Penerimaan</th>
                                            <th colspan='7' align='center'>Barang</th>
                                            <th rowspan='2' align='center'>Gudang</th>
                                            <th rowspan='2' align='center'>Sub</th>
                                            <th rowspan='2' align='center'>Negara</th>
                                            <th rowspan='2' align='center'>ACTION</th>
                                        </tr>
                                        <tr>
                                            <th>aju</th>
                                            <th>no </th>
                                            <th> tgl</th>
                                            <th>seri</th>
                                            <th>no</th>
                                            <th>tgl</th>
                                            <th>kode</th>
                                            <th>nama</th>
                                            <th>stn</th>
                                            <th>jml</th>
                                            <th>kgm</th>
                                            <th>mu</th>
                                            <th>nilai</th>
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

<div class="modal fade" id="gantishift" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Pemasukan Bahan Baku</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/barangjadi/addpemasukanbahanbaku', ['class' => 'addpemasukanbahanbaku']) ?>
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">BAPB</label>
                        <select name="bapb" id="bapb" class="form-control pilihbapb" required>
                            <option selected>Choose...</option>
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">TGL. BAPB</label>
                        <input type="date" class="form-control" name="tgl_bapb" id="tgl_bapb" placeholder="tgl bapb">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">AJU</label>
                        <input type="text" class="form-control" name="aju" id="aju" placeholder="aju">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">TGL AJU</label>
                        <input type="date" class="form-control" name="aju" id="aju" placeholder="aju">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">Item</label>
                        <select name="itemdes" id="namaitem" class="form-control pilihnamaitem" required>
                            <option selected>Choose...</option>
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Kode item</label>
                        <input type="text" class="form-control" name="kode_item" id="kodeitem" placeholder="kodeitem" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Qty</label>
                        <input type="number" class="form-control" name="qty_awal" placeholder="qty" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Netto</label>
                        <input type="number" class="form-control" name="netto_awal" placeholder="netto" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">No PIB</label>
                        <input type="number" class="form-control" name="qty_awal" placeholder="qty" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">TGL. PIB</label>
                        <input type="number" class="form-control" name="netto_awal" placeholder="netto" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Mata Uang</label>
                        <input type="text" class="form-control" name="netto_awal" value="USD" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Nilai</label>
                        <input type="text" class="form-control" name="netto_awal">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputItem">Supplier</label>
                        <select name="supplier" id="namasupplier" class="form-control pilihsupplier" required>
                            <option selected>Choose...</option>
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Negara</label>
                        <input type="text" class="form-control" name="country" id="country" readonly>
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

        $('.pilihbapb').select2({
            width: '200px',
            minimumInputLength: 2,
            // allowClear: true,
            placeholder: 'Ketik Kode Item',
            ajax: {
                url: '<?= site_url('admin/exim/searchbapb') ?>',
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
                        results: $.map(data, function(bapb) {
                            return {
                                text: bapb.receiver,
                                id: bapb.receiver,
                            }
                            // $("#aju").val(bapb.rec_hdr_freight_bill)
                        })
                    };
                }
            }
        });

        $('.pilihsupplier').select2({
            width: '200px',
            minimumInputLength: 2,
            // allowClear: true,
            placeholder: 'Ketik supplier',
            ajax: {
                url: '<?= site_url('admin/exim/searchsupplier') ?>',
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
                        results: $.map(data, function(supplier) {
                            return {
                                text: supplier.suplier,
                                id: supplier.suplier,
                            }
                            // $("#aju").val(bapb.rec_hdr_freight_bill)
                        })
                    };
                }
            }
        });

        $("#bapb").change(function() {
            var bapb = $(this).val();
            console.log(bapb);
            // $("#kodeitem").val(bapb);
            $.ajax({
                url: '<?= site_url('admin/exim/searchajufrombapb') ?>',
                type: 'post',
                dataType: 'json',
                data: {
                    bapb: bapb
                },
                success: function(response) {
                    $("#aju").val(response.rec_hdr_freight_bill);
                    $("#tgl_bapb").val(response.rec_hdr_rec_date);
                },

                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n\n\n" + thrownError);
                }
            });
        });
        $("#namasupplier").change(function() {
            var supplier = $(this).val();
            console.log(bapb);
            // $("#kodeitem").val(bapb);
            $.ajax({
                url: '<?= site_url('admin/exim/searchcountryfromsupplier') ?>',
                type: 'post',
                dataType: 'json',
                data: {
                    supplier: supplier
                },
                success: function(response) {

                    $("#country").val(response.kode);
                },

                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n\n\n" + thrownError);
                }
            });
        });

        $('.pilihnamaitem').select2({
            width: '200px',
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


        var tajp3 = $('#pemasukanbahanbakutabel').DataTable({
            // "dom": 'Blfrtip',
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "buttons": ["copy", "csv", "excel"],
            "ajax": {
                "url": "<?= site_url('admin/bahanbaku/pemasukan/datatables') ?>",
                "type": "POST",
            },
            "lengthMenu": [
                [3, 5, 10, 25, 100],
                [3, 5, 10, 25, 100]
            ],
            "columnDefs": [{
                "targets": 17,
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

        $('.addpemasukanbahanbaku').submit(function(e) {
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
                        $("#pemasukanbahanbakutabel").DataTable().ajax.reload();
                    } else {
                        $('#gantishift').modal('show');
                    }
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })

        $('#pemasukanbahanbakutabel tbody').on('click', '.btn-editp', function(e) {
            const editpemasukan = $(this).data('editpemasukan');
            $.ajax({
                url: "<?= site_url('admin/bahanbaku/pemasukan/edit') ?>",
                method: "post",
                data: {
                    editpemasukan: editpemasukan
                },
                dataType: "json",
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