<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">Edit Nama</div>
            <div class="modal-body">
                <?= form_open('admin/potong/tipe/save', ['class' => 'save']) ?>
                <?= csrf_field() ?>
                <input type="hidden" name="seq" value="<?= $tipe[0]["seq"] ?>" readonly>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kode Tipe</label>
                    <input type="text" name="kodetipe" value="<?= $tipe[0]["kodetipe"] ?>" readonly>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Tipe</label>
                    <input type="text" name="namatipe" value="<?= $tipe[0]["namatipe"] ?>">
                </div>
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
    $('.item').select2({
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
                    $('#tipe').DataTable().ajax.reload()
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