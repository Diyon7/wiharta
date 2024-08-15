<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pemasukan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/karyawan/save', ['class' => 'save']) ?>
                <?= csrf_field() ?>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">No PIB</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nip" id="nip"
                            value="<?= $editkaryawanall['no_pib'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Tgl PIB</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" value="<?= $editkaryawanall['tgl_pib'] ?>" name="nama"
                            id="namakaryawan">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Nilai</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="tgllahir" value="<?= $editkaryawanall['usd'] ?>"
                            id="tgllahir">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info float-right">Simpan</button>
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

    $('.save').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('.btntampil').attr('disable', 'disabled');
                $('.btntampil').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btntampil').removeAttr('disable');
                $('.btntampil').html('Submit');
            },
            success: function(response) {
                console.log(response.success);
                if (response.success) {
                    $('#editdata').modal('hide');
                    $('#karyawanjp3a').DataTable().ajax.reload()
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
    })

    $('.hapus').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function() {
                $('.btntampil').attr('disable', 'disabled');
                $('.btntampil').html('<i class="fa fa-spin fa-spinner"></i>');
            },
            complete: function() {
                $('.btntampil').removeAttr('disable');
                $('.btntampil').html('Submit');
            },
            success: function(response) {
                console.log(response);
                if (response.success) {
                    $('#editdata').modal('hide');
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timerProgressBar: true,
                        timer: 15000
                    });
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
    })

    // $("#subunit").change(function() {
    //     var subunit = $(this).val();

    //     $.ajax({
    //         url: '<?= site_url('admin/karyawan/idpembagian') ?>',
    //         type: 'post',
    //         data: {
    //             subunit: subunit
    //         },
    //         dataType: 'json',
    //         success: function(response) {

    //             var namadivisi = response.namadivisi;
    //             var pembagian2id = response.pembagian2id;
    //             var namaunit = response.namaunit;
    //             var pembagian4id = response.pembagian4id;
    //             var namasubunit = response.namasubunit;
    //             var pembagian5id = response.pembagian5id;

    //             $("#divisi").val(pembagian2id);
    //             $("#divisi").html(namadivisi);
    //             $("#unit").val(pembagian4id);
    //             $("#unit").html(namaunit);

    //         },
    //         error: function(xhr, ajaxOption, thrownError) {
    //             alert(xhr.status + "\n\n\n" + thrownError);
    //         }
    //     });
    // });
    $('.pilihkaryawan').select2({
        width: '250px'
    });
});
</script>