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
                        <label for="inputItem">Kode Referensi</label>
                        <input type="text" class="form-control" name="kodereferensi"
                            value="<?= $edit['kode_referensi'] ?>" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Tgl</label>
                        <input type="date" class="form-control" name="tgl" value="<?= $edit['tgl'] ?>" required>
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
                        <label for="inputItem">Nilai Jurnal Pembelian</label>
                        <div class="nilai">
                            <?php foreach ($editdetail as $ed) : ?>
                            <input type="text" class="form-control" name="nilai[]" value="<?= $ed['debit'] ?>">
                            <?php endforeach ?>
                        </div>
                        <!-- <input type="text" class="form-control" id="nilai" name="nilai" placeholder="nilai" required> -->
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai Kredit</label>
                        <div class="nilaiu">
                            <?php foreach ($editdetail as $ed) : ?>
                            <input type="text" class="form-control" name="nilaiu[]" value="<?= $ed['kredit'] ?>"
                                required>
                            <?php endforeach ?>
                        </div>
                        <!-- <input type="text" class="form-control" id="nilaiu" name="nilaiu" placeholder="nilaiu" required> -->
                    </div>
                </div>
                <button type="submit" class="btnsave btn btn-primary">Input</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
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