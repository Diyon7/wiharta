<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-xs modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('admin/mutasi/mutasiekspor/saveaju', ['class' => 'save']) ?>
                <?= csrf_field() ?>
                <div class="form-group row">
                    <input type="hidden" class="form-control" name="seq" id="seq" value="<?= $add['seq'] ?>">
                    <label class="col-sm-2 col-form-label">No Aju</label>
                    <select class="form-control col-sm-10 aju" name="aju" id="aju">
                        <option value="<?= $add['aju'] ?>" selected>
                            <?= $add['aju'] ?></option>
                        <?php foreach ($aju as $aj) : ?>
                            <option value="<?= $aj['aju'] ?>"><?= $aj['aju'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Qty</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="qty" id="qty" value="<?= $add['qty'] ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Kgm</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?= $add['kgm'] ?>" name="kgm" id="kgm">
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

        $('.aju').select2({
            width: '290px'
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