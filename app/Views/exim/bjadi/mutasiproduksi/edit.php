<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('admin/mutasi/mutasiproduksi/save', ['class' => 'save']) ?>
                <?= csrf_field() ?>
                <input type="hidden" class="form-control" name="sec" id="sec" value="<?= $edit['sec'] ?>">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No Aju</label>
                    <select class="form-control col-sm-10 no_aju" name="no_aju" id="no_aju">
                        <option value="<?= $edit['no_aju'] ?>" selected>
                            <?= $edit['no_aju'] ?></option>
                        <?php foreach ($aju as $aj) : ?>
                            <option value="<?= $aj['aju'] ?>"><?= $aj['aju'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Hitung QTY</label>
                    <select class="form-control col-sm-10 code" name="code" id="code">
                        <option value="<?= $edit['code'] ?>" selected><?php if ($edit['code'] == '1') { ?> Dijumlah
                                <?php } else { ?>Tidak Dijumlah <?php } ?></option>
                        <option value="1">Dijumlah</option>
                        <option value="2">Tidak Dijumlah</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Qty</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="qty" id="qty" value="<?= $edit['alltotalqty'] ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Kgm</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?= $edit['kgm'] ?>" name="kgm" id="kgm">
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