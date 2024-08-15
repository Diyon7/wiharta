<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/karyawan/validasisave', ['class' => 'save']) ?>
                <?= csrf_field() ?>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Asal</label>
                    <select class="form-control col-sm-10" name="asal" id="asal">
                        <option value="<?= $editkaryawanall['pembagian3id'] ?>" selected>
                            <?= $editkaryawanall['asal'] ?></option>
                        <?php foreach ($vendor as $vd) : ?>
                        <option value="<?= $vd['pembagian3_id'] ?>"><?= $vd['pembagian3_nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">No Induk Karyawan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nip" id="nip"
                            value="<?= $editkaryawanall['nip'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?= $editkaryawanall['nama'] ?>" name="nama"
                            id="namakaryawan">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="tgllahir"
                            value="<?= $editkaryawanall['tgllahir'] ?>" id="tgllahir">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jk" id="laki-laki" value="1"
                                <?= ($editkaryawanall['gender'] == '1') ?  "checked" : "" ?>>
                            <label class="form-check-label" for="laki-laki">
                                Laki - laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jk" id="perempuan" value="2"
                                <?= ($editkaryawanall['gender'] == '2') ? "checked" : "" ?>>
                            <label class="form-check-label" for="perempuan">
                                Perempuan
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Telepon</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" value="<?= $editkaryawanall['telepon'] ?>"
                            name="telepon" id="telp">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <textarea type="date" class="form-control" value="<?= $editkaryawanall['alamat'] ?>"
                            name="alamat" id="alamat"></textarea>
                    </div>
                </div>
                <!-- <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pendidikan</label>
                    <select class="form-control col-sm-10" name="pendidikan" id="pend">
                        <?php foreach ($pend as $pn) : ?>
                        <option value="<?= $pn['pend_id'] ?>"><?= $pn['pend_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> -->
                <div class="form-group row">
                    <label class="col-sm-1 col-form-label">Kategoria</label>
                    <select class="form-control col-sm-3" name="kategori">
                        <option value="<?= $editkaryawanall['pembagian6id'] ?>" selected>
                            <?= $editkaryawanall['kategori'] ?></option>
                        <?php foreach ($kategori as $ktr) : ?>
                        <option value="<?= $ktr['pembagian6_id'] ?>"><?= $ktr['pembagian6_nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label class="col-sm-1 col-form-label">Divisi</label>
                    <select class="form-control col-sm-3" name="divisi" enabled='false'>
                        <option value="<?= $editkaryawanall['pembagian2id'] ?>" id="divisi" selected>
                            <?= $editkaryawanall['divisi'] ?></option>
                        <?php foreach ($divisi as $dvs) : ?>
                        <option value="<?= $dvs['pembagian2_id'] ?>"><?= $dvs['pembagian2_nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label class="col-sm-1 col-form-label">Unit</label>
                    <select class="form-control col-sm-3 pilihkaryawan" name="unit">
                        <option value="<?= $editkaryawanall['pembagian4id'] ?>" id="unit" selected>
                            <?= $editkaryawanall['unit'] ?></option>
                        <?php foreach ($unit as $unt) : ?>
                        <option value="<?= $unt['pembagian4_id'] ?>"><?= $unt['pembagian4_nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label class="col-sm-1 col-form-label">Sub Unit</label>
                    <select class="form-control col-sm-3 pilihkaryawan" name="subunit" id="subunit">
                        <option value="<?= $editkaryawanall['pembagian5id'] ?>" selected>
                            <?= $editkaryawanall['subunit'] ?></option>
                        <?php foreach ($subunit as $sbunt) : ?>
                        <option value="<?= $sbunt['pembagian5_id'] ?>"><?= $sbunt['pembagian5_nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group row">
   
                </div>
                <div class="form-group row">

                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Grup kerja</label>
                    <select class="form-control col-sm-10" name="grup_t" id="grup_t">
                        <option value="<?= $editkaryawanall['grupt'] ?>" selected><?= $editkaryawanall['grupt'] ?>
                        </option>
                        <?php foreach ($grup_t as $gp) : ?>
                        <option value="<?= $gp['grup_t'] ?>"><?= $gp['grup_t'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Jabatan</label>
                    <select class="form-control col-sm-10" name="jabatan" id="jabatan">
                        <option value="<?= $editkaryawanall['pembagian1id'] ?>" selected>
                            <?= $editkaryawanall['jabatan'] ?>
                            <?php foreach ($jabatan as $jbn) : ?>
                        <option value="<?= $jbn['pembagian1_id'] ?>"><?= $jbn['pembagian1_nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">Golongan</label>
                    <select class="form-control col-sm-10" name="golongan" id="golongan">
                        <option value="<?= $editkaryawanall['golongan'] ?>" selected>
                            <?= $editkaryawanall['golongan'] ?></option>
                        <?php foreach ($golongan as $go) : ?>
                        <option value="<?= $go['golongan'] ?>"><?= $go['golongan'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="input" class="col-sm-2 col-form-label">TMT</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" value="<?= $editkaryawanall['tmt'] ?>" name="tmt"
                            id="tmt">
                    </div>
                </div>
                <!-- /.card-body -->
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
    $('.pilihkaryawan').select2({width: '250px'});
});
</script>