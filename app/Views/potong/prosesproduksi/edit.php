<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('admin/potong/realisasi/saverealisasi', ['class' => 'save']) ?>
                <?= csrf_field() ?>
                <div class="form-row">
                    <input type="hidden" name="seq" value="<?= $editdata['seq'] ?>">
                    <div class="form-group col-md-6">
                        <label for="inputItem">Vendor</label>
                        <select name="vendor" id="vendor" class="form-control pilihnamatipe" required>
                            <option value="<?= $editdata['vendor'] ?>" selected><?= $editdata['vendor'] ?></option>
                            <option value="HMN">HMN</option>
                            <option value="SKA">SKA</option>
                            <option value="RJM">RJM</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputItem">Grup</label>
                        <select name="grup" id="grup" class="form-control pilihnamatipe" required>
                            <option value="<?= $editdata['grup'] ?>"><?= $editdata['grup'] ?></option>
                            <option value="R">R</option>
                            <option value="S">S</option>
                            <option value="T">T</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputItem">Item</label>
                        <select name="item" id="item" class="form-control pilihnamatipe" required>
                            <option value="<?= $editdata['kodeitem'] ?>" selected><?= $editdata['namaitem'] ?></option>
                            <?php foreach ($item as $tdpd) : ?>
                            <option value="<?= $tdpd['kodeitem'] ?>"><?= $tdpd['namaitem'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputItem">Mesin</label>
                        <select name="jmesin" id="jmesin" class="form-control pilihnamatipe" required>
                            <option value="<?= $editdata['jenismesin'] ?>" selected><?= $editdata['jenismesin'] ?>
                            </option>
                            <option value="l">Lama</option>
                            <option value="b">Baru</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Tanggal</label>
                        <input type="date" class="form-control" name="tgl" value="<?= $editdata['tgl'] ?>" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">QTY</label>
                        <input type="number" class="form-control" name="qty" value="<?= $editdata['qty'] ?>" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">KGM</label>
                        <input type="text" class="form-control" name="kgm" value="<?= $editdata['kgm'] ?>" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">No Rak</label>
                        <input type="number" class="form-control" name="rak" value="<?= $editdata['no'] ?>" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btnsimpan">Input</button>
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

    //     const Toasts = Swal.mixin({
    //         toast: true,
    //         position: 'top-end',
    //         showConfirmButton: false,
    //         timerProgressBar: true,
    //         timer: 15000
    //     });


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
                    $('#tabel1').DataTable().ajax.reload()
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