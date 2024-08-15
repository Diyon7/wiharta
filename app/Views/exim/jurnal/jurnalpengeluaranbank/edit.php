<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('admin/jurnal/jurnalpengeluaranbank/saveeditjurnalpengeluaranbank', ['class' => 'saveeditjurnalpenerimaanbank']) ?>
                <?= csrf_field() ?>
                <input type="hidden" class="form-control" name="kode" value="<?= $edit['kode'] ?>" required>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">BANK</label>
                        <select name="bank" id="bank" class="form-control pilihbank">
                            <option value="<?= $edit['kode_bank'] ?>" selected><?= $edit['nama'] ?></option>
                            <?php foreach ($bank as $bk) : ?>
                            <option value="<?= $bk['kode_bank'] ?>"><?= $bk['nama'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Bank Charge</label>
                        <input type="text" class="form-control" name="bankcharge" value="<?= $edit['biayabank'] ?>"
                            placeholder="bankcharge">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Kode Referensi</label>
                        <input type="text" class="form-control" name="kodereferensi"
                            value="<?= $edit['kode_referensi'] ?>" placeholder="kode referensi" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Tgl</label>
                        <div class="tgl">
                            <?php foreach ($editdetail as $ed) : ?>
                            <input type="date" class="form-control" name="tgl[]" value="<?= $ed['tgl'] ?>"
                                placeholder="tgl" required>
                            <?php endforeach ?>
                        </div>
                        <div id="tgljp"></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Asuransi</label>
                        <input type="text" class="form-control" name="asuransi" value="<?= $edit['biayaasuransi'] ?>"
                            placeholder="asuransi">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Ongkos Angkut</label>
                        <input type="text" class="form-control" name="ongkosangkut"
                            value="<?= $edit['biayatransport'] ?>" placeholder="ongkosangkut">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai</label>
                        <input type="text" class="form-control" name="nilai2" value="<?= $edit['nilai2'] ?>"
                            placeholder="nilai">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">Aju</label>
                        <select name="aju" id="aju" class="form-control memilihaju">
                            <option value="<?= $edit['aju'] ?>" selected><?= $edit['aju'] ?></option>
                            <?php foreach ($aju as $aj) : ?>
                            <option value="<?= $aj['aju'] ?>">
                                <?= $aj['aju'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Invoice</label>
                        <select name="inv" id="inv" class="form-control pilihinv">
                            <option value="<?= $edit['inv'] ?>" selected><?= $edit['inv'] ?></option>
                            <?php foreach ($inv as $i) : ?>
                            <option value="<?= $i['inv'] ?>">
                                <?= $i['inv'] . " | " . number_format($i['kgm'], 2, ',', '.'); ?>
                            </option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Supplier</label>
                        <input type="text" class="form-control supplier" id="supplier" name="supplier"
                            value="<?= $edit['supplier'] ?>" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">TGL BAPB</label>
                        <input type="date" class="form-control tglbapb" id="tglbapb" value="<?= $edit['tgl_bapb'] ?>"
                            name="tglbapb" required readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">BAPB</label>
                        <input type="text" class="form-control bapb" id="bapb" value="<?= $edit['bapb'] ?>" name="bapb"
                            required readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai PEB</label>
                        <div class="nilapeb">
                            <?php foreach ($editpeb as $ed) : ?>
                            <input type="text" class="form-control" name="nilaiinv[]" id="nilaiinv"
                                value="<?= $ed['nilai_peb'] ?>" placeholder="inv">
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai Jurnal Pembelian</label>
                        <div class="nilai">
                            <?php foreach ($editdetail as $ed) : ?>
                            <input type="text" class="form-control" name="nilai[]" value="<?= $ed['debit'] ?>">
                            <?php endforeach ?>
                        </div>
                        <!-- <input type="text" class="form-control" id="nilai" name="nilai" placeholder="nilai" required> -->
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai Kredit</label><input type="button" value="+ Cicil"
                            onClick="addInput();">
                        <div class="nilaiu">
                            <?php foreach ($editdetail as $ed) : ?>
                            <input type="text" class="form-control" name="nilaiu[]" value="<?= $ed['kredit'] ?>"
                                required>
                            <?php endforeach ?>
                        </div>
                        <div id="nilaiu"></div>
                        <!-- <input type="text" class="form-control" id="nilaiu" name="nilaiu" placeholder="nilaiu" required> -->
                    </div>
                </div>
                <button type="submit" class="btnsave btn btn-primary">Input</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
function addInput() {
    var newdiv = document.getElementById('nilaiu');
    var newtgl = document.getElementById('tgljp');
    // newdiv.id = dynamicInput[counter];
    newdiv.innerHTML = '<input type="text" class="form-control" name="nilaiu[]" value="" required>';
    newtgl.innerHTML = '<input type="date" class="form-control" name="tgl[]" value="" required>';
    console.log(newtgl);
    document.getElementById('nilaiu').append(newdiv);
    document.getElementById('tgljp').append(newtgl);
}
$(document).ready(function() {
    const Toasts = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 15000
    });

    $('.tanggalinput').daterangepicker();

    $('.pilihnamaitem').select2({
        width: '290px'
    });

    $(".pilihinv").change(function() {
        var inv = $(this).val();
        console.log(inv);
        $.ajax({
            url: "<?= base_url('admin/jurnal/jurnalpengeluaranbank/serversideinv') ?>",
            method: "post",
            data: {
                inv: inv
            },
            dataType: "json",
            success: function(response) {
                $(".nilapeb").empty();
                $.each(response.nilai, function(index, val) {
                    var ninv =
                        '<input type="text" class="form-control" name="nilaiinv[]" id="nilaiinv" value="' +
                        val +
                        '" placeholder="inv" required>';
                    $(".nilapeb").append(ninv);

                });
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $(".memilihaju").change(function() {
        var aju = $(this).val();
        $.ajax({
            url: "<?= site_url('admin/jurnal/jurnalpengeluaranbank/serversideaju') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                aju: aju
            },
            success: function(response) {
                $(".nilai").empty();
                $(".nilaiu").empty();
                $.each(response.nilai, function(index, val) {
                    var ni =
                        '<input type="text" class="form-control" name="nilai[]" id="nilai" value="' +
                        val + '" required>';
                    $(".nilai").append(ni);
                });
                $.each(response.nilai, function(index, val) {
                    var niu =
                        '<input type="text" class="form-control" name="nilaiu[]" placeholder="nilaiu" value="' +
                        val + '" required>';
                    $(".nilaiu").append(niu);
                });
                $("#bapb").val(response.bapb);
                $("#tglbapb").val(response.tglbapb);
                $("#supplier").val(response.vendor);
                // $("#nilai").val(response.nilai);
                // $("#nilaiu").val(response.nilai);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    $('.saveeditjurnalpenerimaanbank').submit(function(e) {
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
                    $('#jurnalpengeluaranbank').DataTable().ajax.reload()
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