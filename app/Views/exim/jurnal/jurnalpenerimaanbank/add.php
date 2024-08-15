<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nambah Penerimaan Bank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/jurnal/jurnalpenerimaanbank/addjurnalpenerimaanbank', ['class' => 'addjurnalpenerimaanbank']) ?>
                <?= csrf_field() ?>
                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="inputItem">BANK</label>
                        <select name="bank" id="bank" class="form-control pilihbank">
                            <option value="" selected>Choose...</option>
                            <?php foreach ($bank as $bk) : ?>
                            <option value="<?= $bk['kode_bank'] ?>"><?= $bk['nama'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Kode Referensi</label>
                        <input type="text" class="form-control" name="kodereferensi" placeholder="kode referensi"
                            required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Invoice</label>
                        <select name="inv" id="inv" class="form-control pilihinv" required>
                            <option value="" selected>Choose...</option>
                            <?php foreach ($inv as $i) : ?>
                            <option value="<?= $i['inv'] ?>">
                                <?= $i['inv'] . " | " . number_format($i['kgm'], 2, ',', '.'); ?>
                            </option>
                            <?php endforeach; ?>
                            <?php foreach ($invbl as $ib) : ?>
                            <option value="<?= $ib['inv'] ?>">
                                <?= $ib['inv'] . " | " . number_format($ib['kgm'], 2, ',', '.'); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Tgl PEB</label>
                        <input type="date" class="form-control" id="tglpeb" name="tglpeb" placeholder="tglpeb" required
                            readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">Tgl</label>
                        <input type="date" class="form-control" name="tgl" placeholder="tgl" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai Bank</label>
                        <input type="text" class="form-control" name="nilaibank" placeholder="nilaibank">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Biaya</label>
                        <input type="text" class="form-control" name="biaya" placeholder="biaya">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Aju</label>
                        <select name="aju" id="aju" class="form-control pilihaju">
                            <option value="" selected>Choose...</option>
                            <?php foreach ($aju as $aj) : ?>
                            <option value="<?= $aj['aju'] ?>">
                                <?= $aj['aju'] . " | " . number_format($aj['nilai'], 2, ',', '.'); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">TGL AJU</label>
                        <input type="date" class="form-control" id="tglpib" name="tglaju" placeholder="tglaju" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Customer</label>
                        <input type="text" class="form-control" id="customer" name="customer" placeholder="customer"
                            required readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">PEB</label>
                        <input type="text" class="form-control" id="peb" name="peb" placeholder="peb" required readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Hutang</label>
                        <div class="hutang"></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Piutang</label>
                        <div class="piutang"></div>
                    </div>
                    <div class="form-group col-md-3 kgm_peb">
                    </div>
                    <div class="form-group col-md-3 kgm_pib">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btntampil">Input</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    const Toasts = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 15000
    });

    $('#no_aju').select2({
        width: '290px'
    });

    $('.addjurnalpenerimaanbank').submit(function(e) {
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
                    console.log(response.success);
                    $('#editdata').modal('hide');
                    Toasts.fire({
                        icon: 'success',
                        title: 'Data Berhasil',
                        type: 'success',
                    });
                    $("#jurnalpenerimaanbank").DataTable().ajax.reload();
                } else {
                    console.log(response.error);
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('.aju').select2({
        width: '290px'
    });


    $("#inv").change(function() {
        var inv = $(this).val();
        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpenerimaanbank/serversideinv') ?>",
            method: "post",
            data: {
                inv: inv
            },
            dataType: "json",
            success: function(response) {
                $(".kgm_peb").empty();
                $(".piutang").empty();
                $.each(response.kgm, function(index, val) {
                    var kgmp =
                        '<input type="hidden" class="form-control" name="kgmpeb[]" id="kgmpeb" value="' +
                        val +
                        '" placeholder="kgm" required>';
                    $(".kgm_peb").append(kgmp);

                    // $("#nilai").val(response.nilai);
                    // console.log(val);
                });
                $.each(response.piutang, function(index, val) {
                    var piutang =
                        '<input type="text" class="form-control" name="piutang[]" placeholder="invoice" value="' +
                        val + '" required>';
                    $(".piutang").append(piutang);

                    // $("#nilai").val(response.nilai);
                    // console.log(val);
                });
                $("#invoice").val(response.inv);
                $("#tglpeb").val(response.tglpeb);
                $("#peb").val(response.peb);
                $("#customer").val(response.cus);
                // $("#nilaid").val(response.nilai);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $("#aju").change(function() {
        var aju = $(this).val();
        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpenerimaanbank/serversideaju') ?>",
            method: "post",
            data: {
                aju: aju
            },
            dataType: "json",
            success: function(response) {
                $(".kgm_pib").empty();
                $(".hutang").empty();
                $.each(response.kgm, function(index, val) {
                    var kgmp =
                        '<input type="hidden" class="form-control" name="kgmpib[]" id="kgmpib" value="' +
                        val +
                        '" placeholder="kgmpib">';
                    $(".kgm_pib").append(kgmp);
                });
                $.each(response.nilai, function(index, val) {
                    var hutang =
                        '<input type="text" class="form-control" name="hutang[]" placeholder="invoice" value="' +
                        val + '">';
                    $(".hutang").append(hutang);
                });
                console.log(response);
                $("#tglpib").val(response.tglbapb);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $(".pilihinv").change(function() {
        var inv = $(this).val();
        console.log(inv);
        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpenerimaanbank/serversideinv') ?>",
            method: "post",
            data: {
                inv: inv
            },
            dataType: "json",
            success: function(response) {
                $("#kgm_peb").empty();
                $("#piutang").empty();
                $.each(response.kgm, function(index, val) {
                    var kgmp =
                        '<input type="hidden" class="form-control" name="kgmpeb[]" id="kgmpeb" value="' +
                        val +
                        '" placeholder="kgm" required>';
                    $("#kgm_peb").append(kgmp);

                    // $("#nilai").val(response.nilai);
                    // console.log(val);
                });
                $.each(response.piutang, function(index, val) {
                    var piutang =
                        '<input type="text" class="form-control" name="piutang[]" placeholder="invoice" value="' +
                        val + '" required>';
                    $("#piutang").append(piutang);

                    // $("#nilai").val(response.nilai);
                    // console.log(val);
                });
                console.log(response.peb);
                $("#invoice").val(response.inv);
                $(".tglpeb").val(response.tglpeb);
                $("#peb").val(response.peb);
                $("#customer").val(response.cus);
                // $("#nilaid").val(response.nilai);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $(".pilihaju").change(function() {
        var aju = $(this).val();
        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpenerimaanbank/serversideaju') ?>",
            method: "post",
            data: {
                aju: aju
            },
            dataType: "json",
            success: function(response) {
                $("#kgm_pib").empty();
                $("#hutang").empty();
                $.each(response.kgm, function(index, val) {
                    var kgmp =
                        '<input type="hidden" class="form-control" name="kgmpib[]" id="kgmpib" value="' +
                        val +
                        '" placeholder="kgmpib">';
                    $("#kgm_pib").append(kgmp);
                });
                $.each(response.nilai, function(index, val) {
                    var hutang =
                        '<input type="text" class="form-control" name="hutang[]" id="hutang" placeholder="invoice" value="' +
                        val + '">';
                    $("#hutang").append(hutang);
                });
                console.log(response);
                $(".tglpib").val(response.tglbapb);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $('.save').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('.btnsimpan').attr('disable', 'disabled');
                $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btnsimpan').removeAttr('disable');
                $('.btnsimpan').html('<i class="fas fa-edit"></i>');
            },
            success: function(response) {
                console.log(response.success);
                if (response.success) {
                    $('#editdata').modal('hide');
                    $('#mutasiproduksitabel').DataTable().ajax.reload()
                    Toasts.fire({
                        icon: 'success',
                        title: 'Edit Berhasil',
                        type: 'success',
                    });
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    });
});
</script>