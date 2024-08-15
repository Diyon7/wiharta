<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('admin/exim/wkaitv/save', ['class' => 'save']) ?>
                <?= csrf_field() ?>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">PEB</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="peb" id="peb" value="<?= $add['nopeb'] ?>"
                            required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">TGL PEB</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="tglpeb" id="tglpeb" value="<?= $add['tgpeb'] ?>"
                            required>
                    </div>
                </div>
                <input type="hidden" class="form-control" name="seq" id="seq" value="<?= $add['seq'] ?>" required>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">SURAT JALAN</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="sj" id="sj" value="<?= $add['nobpb'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">TGL SURAT JALAN</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="tglsj" id="tglsj" value="<?= $add['tgbpb'] ?>"
                            required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Invoice</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="inv" id="inv" value="<?= $add['inv'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">TGL invoice</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="tglinv" id="tglinv" value="<?= $add['tglinv'] ?>"
                            required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Item</label>
                    <select class="form-control col-sm-10 item" name="item" id="item" required>
                        <option value="<?= $add['kodeitem'] ?>" selected>
                            <?= $add['kodeitem'] ?> || <?= $add['item_description'] ?></option>
                        <?php foreach ($item as $it) : ?>
                        <option value="<?= $it['item'] ?>"><?= $it['item'] ?>||<?= $it['item_description'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">AJU</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="aju" id="aju" value="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Biaya</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nilai" id="nilai" value="<?= $add['fob'] ?>"
                            required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Customer</label>
                    <select class="form-control col-sm-10 customer" name="customer" id="customer" required>
                        <option data-negara="<?= $add['negara']; ?>" value="<?= $add['namacus'] ?>" selected>
                            <?= $add['namacus'] ?></option>
                        <?php foreach ($customer as $cs) : ?>
                        <option data-negara="<?= $cs['negara']; ?>" value="<?= $cs['customer'] ?>">
                            <?= $cs['customer'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Negara</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="negara" id="negara" value="<?= $add['negara'] ?>"
                            readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">QTY</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="qty" id="qty" value="<?= $add['qty'] ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Kgm</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="kgm" id="kgm" required>
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
    const Toasts = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 15000
    });
    $('#item').select2({
        width: '290px'
    });
    $('#customer').on('click', function(e) {
        var negara = $("#customer option:selected").attr('data-negara');
        console.log(negara);
        $("#negara").val(negara);
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
                $('.btnsimpan').html('Save');
            },
            success: function(response) {
                console.log(response.success);
                if (response.success) {
                    Toasts.fire({
                        icon: 'success',
                        title: 'Berhasil Ditambahkan',
                        type: 'success',
                    });
                    // $('#editdata').modal('hide');
                    $('#updateitv').DataTable().ajax.reload()
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    });
});
</script>