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
                    MUTASI PRODUKSI
                </h3>
                <br>
                <button type="button" class="btn btn-primary col-sm-1" data-toggle="modal" data-target="#gantishift">
                    TAMBAH <i class=" fas fa-plus"></i>
                </button>
                <button type="button" class="btn btn-primary btn-add col-sm-1" id="add" data-toggle="modal">
                    <i class="fas fa-file"></i> Cetak
                </button>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="ajp3" style="position: relative;">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <?= form_open('admin/mutasi/mutasiproduksi/editselected', ['class' => 'edittglselected']) ?>
                                <?= csrf_field() ?>
                                <table id="mutasiproduksitabel"
                                    class="w-100 table table-sm table-bordered table-striped">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="inputItem">Asal</label>
                                            <select name="pilihasal" id="pilihasal" class="form-control pilihasal"
                                                required>
                                                <option value="%" selected>All</option>
                                                <?php foreach ($analyst as $ay) : ?>
                                                <option value="<?= $ay['analyst_code'] ?>"><?= $ay['analyst_name'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="inputItem">Tujuan</label>
                                            <select name="pilihtujuan" id="pilihtujuan" class="form-control pilihtujuan"
                                                required>
                                                <option value="%" selected>All</option>
                                                <?php foreach ($analyst as $ay) : ?>
                                                <option value="<?= $ay['analyst_code'] ?>"><?= $ay['analyst_name'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputItem">TGL Dari</label>
                                            <input type="date" class="form-control" id="tgldari" name="tgldari"
                                                placeholder="qty">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="inputItem">TGL Ke</label>
                                            <input type="date" class="form-control" id="tglke" name="tglke"
                                                placeholder="qty">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputItem">Item</label>
                                            <select name="itemfilter" id="itemfilter"
                                                class="form-control pilihnamaitemfilter" required>
                                                <option value="%" selected>Choose...</option>
                                                <?php foreach ($item as $it) : ?>
                                                <option value="<?= $it['item'] ?>">
                                                    <?= $it['item'] ?>||<?= $it['item_description'] ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <thead class="text-sm">
                                        <th><input type="checkbox" id="allchecklist"></th>
                                        <th>Kode</th>
                                        <th>Tgl</th>
                                        <th>No Aju</th>
                                        <th>Kode Item</th>
                                        <th>Asal</th>
                                        <th>Nama Barang</th>
                                        <th>Nama Item</th>
                                        <th>Qty</th>
                                        <th>Kgm</th>
                                        <th>User</th>
                                        <th>Tgl Rekam</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody class="text-sm">
                                    </tbody>
                                    <tfoot>
                                        <th colspan="7">Total</th>
                                        <th></th>
                                        <th id="totalqty"></th>
                                        <th id="totalkgm"></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tfoot>
                                    <div class="form-group col-md-5">
                                        <label for="inputItem">Tanggal Select</label>
                                        <input type="date" class="form-control" name="tglselected" id="tglselected"
                                            placeholder="qty" required>
                                        <button type="submit" class="btn btn-danger"><i
                                                class="fas fa-edit btnsimpanedit">
                                                Selected</i></button>
                                    </div>
                                    <div class="btn-tabelproses"></div>
                                </table>
                                <?= form_close() ?>
                                <div id="rendered"></div>
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
                <h5 class="modal-title" id="exampleModalLabel">Nambah Mutasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/mutasi/mutasiproduksi/addmutasiproduksi', ['class' => 'addmutasiproduksi']) ?>
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputItem">Item</label>
                        <select name="itemdes" id="namaitem" class="form-control pilihnamaitem" required>
                            <option selected>Choose...</option>

                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" class="form-control" name="kode_item" id="kodeitem" placeholder="kodeitem"
                            readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">Qty</label>
                        <input type="text" class="form-control" name="qty_awal" id="qty" onkeyup="jqty()"
                            placeholder="qty" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Netto</label>
                        <input type="text" class="form-control" name="netto_awal" id="netto" placeholder="netto"
                            required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Lokasi Asal</label>
                        <select name="lokasal" id="lok" class="form-control pilihlok" required>
                            <option selected>Choose...</option>
                            <?php foreach ($lok as $la) : ?>
                            <option value="<?= $la['analyst'] ?>"><?= $la['analyst_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Lokasi Tujuan</label>
                        <select name="loktujuan" id="lok" class="form-control pilihlok" required>
                            <option selected>Choose...</option>
                            <?php foreach ($lok as $lt) : ?>
                            <option value="<?= $lt['analyst'] ?>"><?= $lt['analyst_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">Tgl</label>
                        <input type="date" class="form-control" name="tgl" placeholder="tgl" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label class="">Hitung QTY</label>
                        <select class="form-control col-sm-10 code" name="code" id="code" require>
                            <option value="1">Dijumlah</option>
                            <option value="2">Tidak Dijumlah</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Aju</label>
                        <select id="inputItem" name="aju" class="form-control aju" required>
                            <option value="" selected>Choose...</option>
                            <?php foreach ($aju as $aj) : ?>
                            <option value="<?= $aj['aju'] ?>"><?= $aj['aju'] ?> || <?= $aj['item_description'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btntampil">Input</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
function jqty() {
    var qty = $('#qty').val();
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'IDR',
    });
    console.log(qty);
    $("#netto").val(qty);
}

const flashDataa = "<?= session()->getFlashdata('success') ?>";

$(document).ready(function() {

    $('.tanggalinput').daterangepicker();

    $('.pilihnamaitem').select2({
        width: '350px',
        minimumInputLength: 2,
        // allowClear: true,
        placeholder: 'Ketik Kode Item',
        ajax: {
            url: '<?= site_url('admin/mutasi/mutasiproduksi/searchitem') ?>',
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
                            text: item.item + ' || ' + item.status + ' || ' + item
                                .item_description,
                            id: item.item,
                        }
                    })
                };
            },
        }
    });

    $('.pilihnamaitemfilter').select2({
        width: '350px'
    });

    $('#allchecklist').click(function(e) {
        // e.preventDefault();

        if ($(this).is(':checked')) {
            $('.checklistseq').prop('checked', true);
        } else {
            $('.checklistseq').prop('checked', false);
        }
    })

    $('.aju').select2({
        width: '290px'
    });


    $(".pilihnamaitem").change(function() {
        var namatujuan = $(this).val();
        console.log(namatujuan);
        $("#kodeitem").val(namatujuan);
    });

    var tajp3 = $('#mutasiproduksitabel').DataTable({
        "dom": 'Blfrtip',
        // "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "buttons": ["copy", "csv", "excel"],
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': '<div class="spinner"><i class="fa fa-spin fa-spinner"></i> Data Diproses</div>'
        },
        "ajax": {
            "url": "<?= site_url('admin/mutasi/mutasiproduksi/datatables') ?>",
            "type": "POST",
            "data": function(data) {
                data.pilihasal = $('#pilihasal').val();
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
            "targets": 0,
            // 'checkboxes': {
            //     'selectRow': true
            // },
            "orderable": false,
        }],
        // "select": {
        //     "style": "multi"
        // },
    });

    tajp3.on('processing.dt', function(e, settings, processing) {
        if (processing) {
            $('.btn-tabelproses').attr('disable', 'disabled');
            $('.btn-tabelproses').html('<i class="fa fa-spin fa-spinner"></i> Table Memproses');
        } else {
            $('.btn-tabelproses').removeAttr('disable');
            $('.btn-tabelproses').html('');
        }
    });

    $('#frm-example').on('submit', function(e) {
        var form = this;

        var rows_selected = table.column(0).checkboxes.selected();

        // Iterate over all selected checkboxes
        $.each(rows_selected, function(index, rowId) {
            // Create a hidden element
            $(form).append(
                $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'id[]')
                .val(rowId)
            );
        });
    });

    $("#pilihtujuan").change(function() {
        var namatujuan = $(this).val();
        console.log(namatujuan);
        tajp3.draw();
    });
    $("#tgldari").change(function() {
        tajp3.draw();
    });
    $("#tglke").change(function() {
        tajp3.draw();
    });
    $("#itemfilter").change(function() {
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

    $('.edittglselected').submit(function(e) {
        e.preventDefault();

        let jmldata = $('.checklistseq:checked');
        console.log(jmldata.length);

        if (jmldata.length === 0) {

            Swal.fire({
                icon: 'error',
                title: 'perhatian',
                text: 'belum diceklist'
            });

        } else {
            Swal.fire({
                title: 'Yakin Edit ?',
                text: "Apakah yakin Edit " + jmldata.length + " data !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Edit!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        dataType: "json",
                        beforeSend: function() {
                            $('.btnsimpanedit').attr('disable', 'disabled');
                            $('.btnsimpanedit').html(
                                '<i class="fa fa-spin fa-spinner"></i>');
                        },
                        complete: function() {
                            $('.btnsimpanedit').removeAttr('disable');
                            $('.btnsimpanedit').html(
                                "<i class='fas fa-edit btnsimpanedit'> Selected</i>"
                            );
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                $('#mutasiproduksitabel').DataTable().ajax.reload();
                                Toasts.fire({
                                    icon: 'success',
                                    title: 'Edit Berhasil',
                                    type: 'success',
                                });
                            }
                        },
                        error: function(xhr, ajaxOption, thrownError) {
                            alert(xhr.status + "\n" + xhr.responseText + "\n" +
                                thrownError);
                        }
                    })
                }
            })

        }

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
                    // $('#gantishift').modal('hide');
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                    $("#mutasiproduksitabel").DataTable().ajax.reload();
                } else {
                    $('#gantishift').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('#add').on('click', function(e) {

        $.ajax({
            url: "<?= base_url('admin/mutasi/mutasiproduksi/modalcetak') ?>",
            method: "post",
            dataType: "json",
            beforeSend: function() {
                $('.btn-add').attr('disable', 'disabled');
                $('.btn-add').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-add').removeAttr('disable');
                $('.btn-add').html('<i class=\"fas fa-file\"></i> Cetak');
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

    $('#mutasiproduksitabel tbody').on('click', '.btn-delete', function(e) {
        const sec = $(this).data('sec');

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
                    url: "<?= site_url('admin/mutasi/mutasiproduksi/deletemutasiproduksi') ?>",
                    method: "post",
                    data: {
                        sec: sec,

                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            $('#mutasiproduksitabel').DataTable().ajax.reload();
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

    $('#mutasiproduksitabel tbody').on('click', '.btn-edit', function(e) {
        const id = $(this).data('sec');

        $.ajax({
            url: "<?= base_url('admin/mutasi/mutasiproduksi/edit') ?>",
            method: "post",
            data: {
                id: id
            },
            dataType: "json",
            beforeSend: function() {
                $('.btn-edit').attr('disable', 'disabled');
                $('.btn-edit').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-edit').removeAttr('disable');
                $('.btn-edit').html('<i class="fas fa-edit"></i>');
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

    $('#mutasiproduksitabel tbody').on('click', '.btn-editm', function(e) {
        const id = $(this).data('sec');

        $.ajax({
            url: "<?= base_url('admin/mutasi/mutasiproduksi/editm') ?>",
            method: "post",
            data: {
                id: id
            },
            dataType: "json",
            beforeSend: function() {
                $('.btn-editm').attr('disable', 'disabled');
                $('.btn-editm').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-editm').removeAttr('disable');
                $('.btn-editm').html('<i class="fas fa-edit"></i> Kode');
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

    $('#mutasiproduksitabel tbody').on('click', '.btn-editi', function(e) {
        const id = $(this).data('sec');

        $.ajax({
            url: "<?= base_url('admin/mutasi/mutasiproduksi/editi') ?>",
            method: "post",
            data: {
                id: id
            },
            dataType: "json",
            beforeSend: function() {
                $('.btn-editi').attr('disable', 'disabled');
                $('.btn-editi').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-editi').removeAttr('disable');
                $('.btn-editi').html('<i class="fas fa-edit"></i> Item');
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

    $('#mutasiproduksitabel tbody').on('click', '.btn-add', function(e) {
        const id = $(this).data('sec');

        $.ajax({
            url: "<?= base_url('admin/mutasi/mutasiproduksi/nambahaju') ?>",
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