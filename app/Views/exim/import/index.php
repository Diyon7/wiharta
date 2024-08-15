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
                <!-- <a href="<?= base_url() ?>/admin/exim/tambahimportbahanbaku"><button type="button"
                        class="btn btn-primary col-sm-1" data-toggle="modal" data-target="#">
                        TAMBAH <i class=" fas fa-plus"></i>
                    </button></a> -->
                <button type="button" class="btn btn-primary col-sm-1" data-toggle="modal" data-target="#gantishift">
                    TAMBAH <i class=" fas fa-plus"></i>
                </button>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#bc" id="dtbc" data-toggle="tab">BEACUKAI</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#wkajkt" id="dtwkajkt" data-toggle="tab">WKAJAKARTA</a>
                        </li>
                    </ul>
                </div>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="bc" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table id="importtabel" class="w-100 table table-sm table-bordered table-striped">
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="inputItem">TGL BAPB Dari</label>
                                            <input type="date" class="form-control" id="tgldarik" name="tgldari" placeholder="qty">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputItem">TGL BAPB Ke</label>
                                            <input type="date" class="form-control" id="tglkek" name="tglke" placeholder="qty">
                                        </div>
                                    </div>
                                    <thead class="text-sm">
                                        <tr>
                                            <th rowspan='2' align='center'>Dok</th>
                                            <th rowspan='2' align='center'>TGL Rekam</th>
                                            <th colspan='5' align='center'>Dokumen Pabean</th>
                                            <th colspan='2' align='center'>Bukti Penerimaan</th>
                                            <th colspan='9' align='center'>Barang</th>
                                            <th rowspan='2' align='center'>Gudang</th>
                                            <th rowspan='2' align='center'>Sub</th>
                                            <th rowspan='2' align='center'>Penjual</th>
                                            <th rowspan='2' align='center'>Negara</th>
                                            <th rowspan='2' align='center'>Aksi</th>

                                        </tr>
                                        <tr>

                                            <th>AJU</th>
                                            <th>No</th>
                                            <th>Tgl</th>
                                            <th>Seri</th>
                                            <th>Hscode</th>

                                            <th>No</th>
                                            <th>Tgl</th>

                                            <th>Kode</th>
                                            <th>Item</th>
                                            <th>Nama</th>
                                            <th>Deskripsi</th>
                                            <th>Stn</th>
                                            <th>Jml</th>
                                            <th>Kgm</th>
                                            <th>Mu</th>
                                            <th>Nilai</th>


                                        </tr>
                                    </thead>
                                    <tbody class="text-sm">

                                    </tbody>
                                    <tfoot>
                                        <th colspan="15">Total</th>
                                        <th id="totalkgm"></th>
                                        <th colspan="7"></th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="wkajkt" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive" style="height: 500px;  overflow-x: scroll; overflow-y: scroll;">
                                <table id="importtabeljkt" class="w-100 table table-sm table-bordered table-striped">
                                    <div class="form-row">
                                        <div class="form-group col-md-2">
                                            <label for="inputItem">TGL BAPB Dari</label>
                                            <input type="date" class="form-control" id="tgldari" name="tgldari" placeholder="qty">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputItem">TGL BAPB Ke</label>
                                            <input type="date" class="form-control" id="tglke" name="tglke" placeholder="qty">
                                        </div>
                                    </div>
                                    <thead class="text-sm" style="position: sticky; top:0; border: 1px;  z-index: 10; background:white;">
                                        <tr>
                                            <th rowspan='2' align='center'>No</th>
                                            <th rowspan='2' align='center'>No AJU</th>
                                            <th rowspan='2' align='center'>PENGIRIM</th>
                                            <th rowspan='2' align='center'>HS CODE</th>
                                            <th rowspan='2' align='center'>PENJUAL</th>
                                            <th rowspan='2' align='center'>PIB No.</th>
                                            <th rowspan='2' align='center'>TGL</th>
                                            <th rowspan='2' align='center'>Netto</th>
                                            <th rowspan='2' align='center'>DESCRIPTION</th>
                                            <th rowspan='2' align='center'>bukti penerimaan jaminan (Nomor COO)</th>
                                            <th rowspan='2' align='center'>TGL</th>
                                            <th rowspan='2' align='center'>EMKL/PJT</th>
                                            <th rowspan='2' align='center'>BL</th>
                                            <th rowspan='2' align='center'>NEGARA ASAL</th>
                                            <th rowspan='2' align='center'>PARTY</th>
                                            <th rowspan='2' align='center'>ETD</th>
                                            <th rowspan='2' align='center'>ETA</th>
                                            <th rowspan='2' align='center'>ETA WKA</th>
                                            <th rowspan='2' align='center'>FASILITAS</th>
                                            <th rowspan='2' align='center'>TERMS</th>
                                            <th rowspan='2' align='center'>INV</th>
                                            <th rowspan='2' align='center'>RATE/$</th>
                                            <th rowspan='2' align='center'>Nilai PIB (USD)</th>
                                            <th rowspan='2' align='center'>Nilai PIB (IDR)</th>
                                            <th colspan='4' align='center'>DIBAYAR</th>
                                            <th rowspan='2' align='center'>remark</th>
                                            <th colspan='3' align='center'>DIBEBASKAN/TIDAK DIPUNGUT</th>
                                            <th rowspan='2' align='center'>TOTAL PAYMENT PIB (Rp.)</th>
                                            <th rowspan='2' align='center'>Aksi</th>

                                        </tr>
                                        <tr>

                                            <th>BM</th>
                                            <th>BMT/BMAD/BMI/BMTP*</th>
                                            <th>PPN (Rp.)</th>
                                            <th>PPH (Rp.)</th>

                                            <th>BM (Rp.) dibebaskan</th>
                                            <th>PPN (Rp.) tidak dipungut</th>
                                            <th></th>

                                        </tr>
                                    </thead>
                                    <tbody class="text-sm">

                                    </tbody>
                                    <tfoot>
                                        <th colspan="7">Total</th>
                                        <th id="totalkgm"></th>
                                        <th colspan="26"></th>
                                    </tfoot>
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
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nambah Mutasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/exim/saveimport', ['class' => 'saveimport']) ?>
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputItem">Item</label>
                        <select name="kodeitem" id="kodeitem" data-source="" class="form-control nambahpilihnamaitem" required>
                            <option selected>Choose...</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Fasilitas</label>
                        <select name="fasilitas" id="fasilitas" class="form-control pilihfasilitas" required>
                            <option selected>Choose...</option>
                            <option value="FK">KITE</option>
                            <option value="FNK">NON KITE</option>
                            <option value="NF">NON FASILITAS</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputItem">Penjual || Pengirim || negara</label>
                        <select name="penjual" id="penjual" class="form-control pilihpenjual" required>
                            <option selected>Choose...</option>
                            <?php foreach ($penjual as $pjl) : ?>
                                <option value="<?= $pjl['seq'] ?>">
                                    <?= $pjl['penjual'] ?> || <?= $pjl['pengirim'] ?> || <?= $pjl['negara'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Aju</label>
                        <input type="text" class="form-control" name="aju" placeholder="no aju" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">EMKL PTJ</label>
                        <select name="emklptj" id="emklptj" class="form-control pilihemklptj" required>
                            <option selected>Choose...</option>
                            <option value="FIN">FIN</option>
                            <option value="DUNEX">DUNEX</option>
                            <option value="DHL">DHL</option>
                            <option value="FEDEX">FEDEX</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="">Nomor COO</label>
                        <input type="text" class="form-control" name="nocoo" placeholder="nocoo">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">TGL COO</label>
                        <input type="date" class="form-control" name="tglcoo" placeholder="tglcoo">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">PIB</label>
                        <input type="text" class="form-control" name="pib" placeholder="pib" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">TGL PIB</label>
                        <input type="date" class="form-control" name="tglpib" placeholder="tglpib" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Qty</label>
                        <input type="number" class="form-control" name="qty" placeholder="qty" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">KGM</label>
                        <input type="text" class="form-control" name="kgm" placeholder="kgm" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="">NILAI</label>
                        <input type="text" class="form-control" name="nilai" placeholder="nilai" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">HS CODE</label>
                        <input type="text" class="form-control" name="hscode" placeholder="hscode" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">BL</label>
                        <input type="text" class="form-control" name="bl" placeholder="bl" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">PARTY</label>
                        <input type="text" class="form-control" name="party" placeholder="party" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">ETD</label>
                        <input type="date" class="form-control" name="etd" placeholder="etd" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">ETA</label>
                        <input type="date" class="form-control" name="eta" placeholder="eta" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">ETA WKA</label>
                        <input type="date" class="form-control" name="etawka" placeholder="etawka">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">TERM</label>
                        <input type="text" class="form-control" name="term" placeholder="term" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">INVOICE</label>
                        <input type="text" class="form-control" name="inv" placeholder="inv" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">MU</label>
                        <input type="text" class="form-control" name="mu" placeholder="mu" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">NILAI PIB (USD)</label>
                        <input type="text" class="form-control" name="nilaipibusd" placeholder="nilaipibusd" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">NILAI PIB (IDR)</label>
                        <input type="text" class="form-control" name="nilaipibidr" placeholder="nilaipibidr" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">BM</label>
                        <input type="text" class="form-control" name="bm" placeholder="bm">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">BMT BMAD BMI BMPT</label>
                        <input type="text" class="form-control" name="bmtbmadbmibmpt" placeholder="bmtbmadbmibmpt">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">PPN</label>
                        <input type="text" class="form-control" name="ppn" placeholder="ppn">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">PPH</label>
                        <input type="text" class="form-control" name="pph" placeholder="pph">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">REMARK</label>
                        <input type="text" class="form-control" name="remark" placeholder="remark">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">BM DIBEBASKAN</label>
                        <input type="text" class="form-control" name="bmdibebaskan" placeholder="bmdibebaskan">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">PPN TIDAK DIPUNGUT</label>
                        <input type="text" class="form-control" name="ppntidakdipungut" placeholder="ppntidakdipungut">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">TOTAL PAYMENT PIB</label>
                        <input type="text" class="form-control" name="totalpaymentpib" placeholder="totalpaymentpib" required>
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

        $('.nambahpilihnamaitem').select2({
            minimumInputLength: 2,
            width: '350px',
            // allowClear: true,
            placeholder: 'Ketik Kode Item',
            ajax: {
                url: '<?= site_url('admin/exim/import/searchitem') ?>',
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
                                text: item.item + ' || ' + item.item_description + ' || ' + item
                                    .klp_beacukai + ' || ' + item.status,
                                id: item.item,
                            }
                        })
                    };
                },
            }
        });
        $("#kodeitem").change(function() {
            var namaitem = $(this).html();
            console.log(namaitem);
            // $("#kodeitem").val(namaitem);
        });
        $("#namaitem").change(function() {
            var namaitem = $(this).val();
            console.log(namaitem);
            $("#kodeitem").val(namaitem);
        });


        var tajp3 = $('#importtabel').DataTable({
            // dom": 'Blfrtip',
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "buttons": ["copy", "csv", "excel"],
            "ajax": {
                "url": "<?= site_url('admin/exim/importbahanbaku/datatables') ?>",
                "type": "POST",
                "data": function(data) {
                    data.tgldari = $('#tgldarik').val();
                    data.tglke = $('#tglkek').val();
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
        $("#tgldarik").change(function() {
            tajp3.draw();
        });
        $("#tglkek").change(function() {
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

        $('.saveimport').submit(function(e) {
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
                        // $('#gantishift').modal('hide');
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
                text: "Apakah yakin menghapus data ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= site_url('admin/exim/importbahanbaku/deletedata') ?>",
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

        $('#importtabeljkt tbody').on('click', '.btn-deletejkt', function(e) {
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
                        url: "<?= site_url('admin/exim/importbahanbaku/deletedata') ?>",
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
                                $('#importtabeljkt').DataTable().ajax.reload();
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
                url: "<?= base_url('admin/mutasi/importbahanbaku/editi') ?>",
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