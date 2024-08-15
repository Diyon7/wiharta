<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('admin/mutasi/mutasiproduksi/savem', ['class' => 'save']) ?>
                <?= csrf_field() ?>
                <input type="hidden" class="form-control" name="sec" id="sec" value="<?= $edit['sec'] ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputItem">Lokasi Asal</label>
                        <select name="lokasal" id="lok" class="form-control pilihlok" required>
                            <option value="<?= $edit['lokasi_asal'] ?>" selected>
                                <?= $edit['asal'] ?></option>
                            <?php foreach ($lok as $la) : ?>
                                <option value="<?= $la['analyst'] ?>"><?= $la['analyst_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputItem">Lokasi Tujuan</label>
                        <select name="loktujuan" id="lok" class="form-control pilihlok" required>
                            <option value="<?= $edit['lokasi_tujuan'] ?>" selected>
                                <?= $edit['tujuan'] ?></option>
                            <?php foreach ($lok as $lt) : ?>
                                <option value="<?= $lt['analyst'] ?>"><?= $lt['analyst_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputItem">Tgl</label>
                        <input type="date" class="form-control" name="tgl" placeholder="tgl" value="<?= $edit['tgl'] ?>" required>
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