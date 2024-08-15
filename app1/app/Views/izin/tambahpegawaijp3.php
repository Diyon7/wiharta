<div class="modal fade" id="tambahdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="proseskaryawan.php?action=editdatakaryawan" class="editdatakaryawan" id="form">

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Asal</label>
                        <select class="form-control col-sm-10" name="asal" id="asal">
                            <option value="" selected required>pilih</option>
                            <?php foreach ($vendor as $vd) : ?>
                                <option value=""><?= $vd['pembagian3_nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">ID Karyawan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="idkar" id="idkar" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nama" id="namakaryawan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tgllahir" id="tgllahir">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="alamat" id="alamat">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Pendidikan</label>
                        <select class="form-control col-sm-10" name="bagian" id="bagian">
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Divisi</label>
                        <select class="form-control col-sm-10" name="bagian" id="bagian">
                            <?php foreach ($divisi as $dvs) : ?>
                                <option value=""><?= $dvs['pembagian2_nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Unit</label>
                        <select class="form-control col-sm-10" name="unit" id="unit">
                            <?php foreach ($unit as $unt) : ?>
                                <option value=""><?= $unt['pembagian4_nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Sub Unit</label>
                        <select class="form-control col-sm-10" name="subunit" id="subunit">
                            <?php foreach ($subunit as $sbunt) : ?>
                                <option value=""><?= $sbunt['pembagian5_nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Grup</label>
                        <select class="form-control col-sm-10" name="grup" id="grup">
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Grup Tagian kerja</label>
                        <select class="form-control col-sm-10" name="grup_t" id="grup_t">
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Jabatan</label>
                        <select class="form-control col-sm-10" name="jabatan" id="jabatan">
                            <?php foreach ($jabatan as $jbn) : ?>
                                <option value=""><?= $jbn['pembagian1_nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Golongan</label>
                        <select class="form-control col-sm-10" name="golongan" id="golongan">
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">TMT</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" name="tmt" id="tmt">
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info float-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

</script>