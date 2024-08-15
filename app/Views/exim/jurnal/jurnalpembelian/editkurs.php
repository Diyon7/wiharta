<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('admin/jurnal/sejurnalpembelian/saveedit', ['class' => 'savek']) ?>
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= $edit['id'] ?>">
                <div class="form-row">
                    <div class="form-group">
                        <label for="inputItem">Kurs</label>
                        <input type="text" class="form-control kurs" id="kurs" value="<?= $edit['kurs'] ?>" name="kurs"
                            required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-save">Save</button>
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

    $('.savek').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('.btn-save').attr('disable', 'disabled');
                $('.btn-save').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btn-save').removeAttr('disable');
                $('.btn-save').html('Submit');
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
                    $("#semuajurnalpembeliantabel").DataTable().ajax.reload();
                } else {
                    $('#editdata').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

});
</script>