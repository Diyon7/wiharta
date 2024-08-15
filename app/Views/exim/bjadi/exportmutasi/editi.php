<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-xs modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('admin/mutasi/mutasiekspor/savei', ['class' => 'save']) ?>
                <?= csrf_field() ?>
                <input type="hidden" class="form-control" name="seq" id="seq" value="<?= $edit['seq'] ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label class="col-sm-2 col-form-label">Item</label>
                        <select class="form-control col-sm-10 item" name="item" id="item">
                            <option value="<?= $edit['kode_item'] ?>" selected>
                                <?= $edit['kode_item'] ?></option>
                            <?php foreach ($item as $it) : ?>
                            <option value="<?= $it['item'] ?>"><?= $it['item'] ?>||<?= $it['item_description'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
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
        // $('#no_aju').select2({
        //     width: '290px'
        // });
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