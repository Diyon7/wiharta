<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('admin/mutasi/mutasiekspor/save', ['class' => 'save']) ?>
                <?= csrf_field() ?>
                <input type="hidden" class="form-control" name="seq" id="seq" value="<?= $edit['seq'] ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="col-sm-2 col-form-label">No Aju</label>
                        <select class="form-control col-sm-10 no_aju" name="no_aju" id="no_aju">
                            <option value="<?= $edit['aju'] ?>" selected>
                                <?= $edit['aju'] ?></option>
                            <?php foreach ($aju as $aj) : ?>
                                <option value="<?= $aj['aju'] ?>"><?= $aj['aju'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">PEB</label>
                        <input type="number" class="form-control" name="peb" value="<?= $edit['peb'] ?>" placeholder="peb" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">TGL PEB</label>
                        <input type="date" class="form-control" name="tglpeb" value="<?= $edit['tglpeb'] ?>" placeholder="tglpeb" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">INV</label>
                        <input type="text" class="form-control" name="inv" value="<?= $edit['inv'] ?>" placeholder="inv" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">TGL INV</label>
                        <input type="date" class="form-control" name="tglinv" value="<?= $edit['tglinv'] ?>" placeholder="tglinv" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">KG</label>
                        <input type="text" class="form-control" name="kgm" value="<?= $edit['kgm'] ?>" placeholder="kgm" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">QTY</label>
                        <input type="text" class="form-control" name="qty" value="<?= $edit['qty'] ?>" placeholder="qty" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai</label>
                        <input type="number" class="form-control" name="nilai" value="<?= $edit['nilai'] ?>" placeholder="nilai" required>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right btnsimpan">Simpan</button>
                </div>
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
        $('#item').select2({
            width: '290px'
        });

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
                    $('.btnsimpan').html('Submit');
                },
                success: function(response) {
                    console.log(response.success);
                    if (response.success) {
                        $('#editdata').modal('hide');
                        $('#mutasiexporttabel').DataTable().ajax.reload()
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