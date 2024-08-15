<div class="modal fade" id="detaildata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="proseskaryawan.php?action=editdatakaryawan" class="editdatakaryawan"
                    id="form">

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Asal</label>
                        <h3></h3>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">ID Karyawan</label>
                        <h3><?= $idkar ?></h3>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">ID Finger</label>
                        <h3><?= $idfinger ?></h3>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Nama</label>
                        <h3></h3>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                        <h3></h3>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Jabatan</label>
                        <h3></h3>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Alamat</label>
                        <h3></h3>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Pendidikan</label>
                        <h3></h3>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Divisi</label>
                        <h3></h3>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Unit</label>
                        <h3></h3>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Sub Unit</label>
                        <h3></h3>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Grup</label>
                        <h1></h1>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Grup Tagian kerja</label>
                        <h3></h3>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Jabatan</label>
                        <h3></h3>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">Golongan</label>
                        <h3></h3>
                    </div>
                    <div class="form-group row">
                        <label for="input" class="col-sm-2 col-form-label">TMT</label>
                        <h3></h3>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

</script>