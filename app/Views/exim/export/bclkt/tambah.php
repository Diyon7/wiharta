<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Laporkan PEB</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/exim/bclktitv/laporkanbclkt', ['class' => 'save']) ?>
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputItem">PEB</label>
                        <select name="peb" id="peb" class="form-control pilihpeb" required>
                            <option selected>Choose...</option>
                            <?php foreach ($blbclkt as $bb) : ?>
                                <option value="<?= $bb['peb'] ?>"><?= $bb['peb'] ?>||<?= $bb['tglpeb'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btnsimpan btn-primary">Input</button>
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
                        Toasts.fire({
                            icon: 'success',
                            title: 'Edit Berhasil',
                            type: 'success',
                        });
                        $('#bclkttabel').DataTable().ajax.reload()
                    }
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        });
    });
</script>