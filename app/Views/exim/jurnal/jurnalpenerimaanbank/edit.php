<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('admin/jurnal/jurnalpenerimaanbank/saveeditjurnalpenerimaanbank', ['class' => 'save']) ?>
                <?= csrf_field() ?>
                <div class="form-row">
                    <input type="hidden" name="kode" value="<?= $edit['kode'] ?>">
                    <div class="form-group col-md-3">
                        <label for="inputItem">BANK</label>
                        <select name="bank" id="bank" class="form-control pilihbank" required>
                            <option value="<?= $edit['kode_bank'] ?>"><?= $edit['nama'] ?></option>
                            <?php foreach ($bank as $bk) : ?>
                            <option value="<?= $bk['kode_bank'] ?>"><?= $bk['nama'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Kode Referensi</label>
                        <input type="text" class="form-control" name="kodereferensi"
                            value="<?= $edit['kode_referensi'] ?>" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Invoice</label>
                        <select name="inv" id="inv" class="form-control pilihinv" required>
                            <option value="<?= $edit['inv'] ?>" selected><?= $edit['inv'] ?></option>
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
                        <input type="date" class="form-control tglpeb" id="tglpeb" name="tglpeb"
                            value="<?= $edit['tgl_peb'] ?>" readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">Tgl</label>
                        <input type="date" class="form-control" name="tgl" value="<?= $edit['tgl'] ?>" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai Bank</label>
                        <input type="text" class="form-control" name="nilaibank" value="<?= $edit['biayabank'] ?>"
                            required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Biaya</label>
                        <input type="text" class="form-control" name="biaya" value="<?= $edit['nilai'] ?>" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Aju</label>
                        <select name="aju" id="aju" class="form-control pilihaju">
                            <option value="<?= $edit['aju'] ?>" selected><?= $edit['aju'] ?></option>
                            <?php foreach ($aju as $aj) : ?>
                            <option value="<?= $aj['aju'] ?>">
                                <?= $aj['aju'] . " | " . number_format($aj['nilai'], 2, ',', '.'); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">TGL AJU</label>
                        <input type="date" class="form-control tglpib" id="tglpib" name="tglaju"
                            value="<?= $edit['tgl_pib'] ?>" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Customer</label>
                        <input type="text" class="form-control customer" id="customer" name="customer"
                            value="<?= $edit['customer'] ?>" required readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">PEB</label>
                        <input type="text" class="form-control peb" id="peb" name="peb" value="<?= $edit['peb'] ?>"
                            required readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Hutang</label>
                        <div class="hutang" id="hutang">
                            <?php foreach ($editdetail as $ed) : ?>
                            <input type="text" class="form-control" name="hutang[]" placeholder="invoice"
                                value="<?= $ed['nilai_pib'] ?>">
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Piutang</label>
                        <div class="piutang" id="piutang">
                            <?php foreach ($editdetail as $ed) : ?>
                            <input type="text" class="form-control" name="piutang[]" placeholder="invoice"
                                value="<?= $ed['nilai_peb'] ?>" required>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="form-group col-md-3 kgm_peb" id="kgm_peb">
                        <?php foreach ($editdetail as $ed) : ?>
                        <input type="hidden" class="form-control" name="kgmpeb[]" id="kgmpeb"
                            value="<?= $ed['kgm_peb'] ?>" placeholder="kgm" required>
                        <?php endforeach ?>
                    </div>
                    <div class="form-group col-md-3 kgm_pib" id="kgm_pib">
                        <?php foreach ($editdetail as $ed) : ?>
                        <input type="hidden" class="form-control" name="kgmpib[]" id="kgmpib"
                            value="<?= $ed['kgm_pib'] ?>" placeholder="kgmpib">
                        <?php endforeach ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Input</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#no_aju').select2({
        width: '290px'
    });
    // $('#item').select2({
    //     width: '290px'
    // });

    const Toasts = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 15000
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
                    $('#jurnalpenerimaanbank').DataTable().ajax.reload()
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