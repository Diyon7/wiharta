<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('admin/mutasi/mutasiproduksi/savei', ['class' => 'save']) ?>
                <?= csrf_field() ?>
                <input type="hidden" class="form-control" name="sec" id="sec" value="<?= $edit['sec'] ?>">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Item</label>
                    <select class="form-control col-sm-10 item pilihnamaitem" name="item" id="item">
                        <option value="<?= $edit['item'] ?>" selected>
                            <?= $edit['item'] ?> || <?= $edit['item_description'] ?></option>

                    </select>
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
    $('.pilihnamaitem').select2({
        width: '350px',
        minimumInputLength: 2,
        // allowClear: true,
        placeholder: 'Ketik Kode Item',
        ajax: {
            url: '<?= site_url('admin/mutasi/mutasiproduksi/searchitem') ?>',
            dataType: "json",
            // type: "GET",
            data: function(params) {

                var queryParameters = {
                    search: params.term
                }
                return queryParameters;
            },
            processResults: function(data, page) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.item + ' || ' + item.status + ' || ' + item
                                .item_description,
                            id: item.item,
                        }
                    })
                };
            },
        }
    });
    // $('#item').select2({
    //     width: '290px'
    // });
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