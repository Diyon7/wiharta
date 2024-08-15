<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('admin/jurnal/jurnalpembelian/savetambahjurnalpembelian', ['class' => 'savepembelian']) ?>
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">BAPB</label>
                        <input type="text" class="form-control" name="bapb" value="<?= $edit['bapb'] ?>" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Tgl BAPB</label>
                        <input type="date" class="form-control" name="tglbapb" value="<?= $edit['tgl_bapb'] ?>"
                            required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Bukti</label>
                        <input type="text" class="form-control" name="bukti"
                            value="BPB/WH/<?= $tahun ?>/<?= $bulan ?>/<?= $maxid['bjpmaxid'] ?>" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">AJU</label>
                        <input type="text" class="form-control" name="aju" value="<?= $edit['aju'] ?>" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputItem">Item</label>
                        <select name="item" id="item" class="form-control pilihitem">
                            <option value="<?= $edit['rec_item'] ?>" selected><?= $edit['rec_item'] ?> ||
                                <?= $edit['item_description'] ?></option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">PO</label>
                        <input type="text" class="form-control" name="po" value="<?= $edit['po'] ?>" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Supplyer</label>
                        <input type="text" class="form-control" name="supplyer" value="<?= $edit['supplyer'] ?>"
                            required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Fasilitas</label>
                        <select name="fasilitas" id="fasilitas" class="form-control pilihfasilitas">
                            <option value="<?= $edit['fasilitas'] ?>" selected><?= $edit['fasilitas'] ?></option>
                            <option value="fk">FK</option>
                            <option value="fnk">FNK</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">QTY</label>
                        <input type="text" class="form-control qty" id="qty" name="qty" value="<?= $edit['qt'] ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">KGM</label>
                        <input type="text" class="form-control kgm" id="kgm" value="<?= $edit['kg'] ?>" name="kgm"
                            required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">SATUAN</label>
                        <input type="text" class="form-control stn" id="stn" value="<?= $edit['stn'] ?>" name="stn"
                            required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai</label>
                        <input type="text" class="form-control nilai" id="nilai" value="<?= $edit['nilai'] ?>"
                            name="nilai" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Kurs</label>
                        <input type="text" class="form-control kurs" onkeyup="kursn()" id="kurs"
                            value="<?= $edit['kurs'] == '' || $edit['kurs'] == '0' ? '0' : $edit['kurs'] ?>"
                            name="kurs">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Mata Uang</label>
                        <select name="mu" id="mu" class="form-control pilihmu">
                            <option value="<?= $edit['mu'] ?>" selected><?= $edit['mu'] ?></option>
                            <?php foreach ($kurs as $kr) : ?>
                            <option value="<?= $kr['kode'] ?>"><?= $kr['name'] ?>(<?= $kr['kode'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Rupiah</label>
                        <input type="text" class="form-control rupiah" id="rupiah"
                            value="<?= $edit['nilai'] * $edit['kurs'] ?>" name="rupiah" readonly>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-save">Input</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
function kursn() {
    var nilai = $(".nilai").val();
    var kurs = $('#kurs').val();
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'IDR',
    });
    console.log(formatter.format(nilai * kurs));
    $(".rupiah").val(formatter.format(nilai * kurs));
}
$(document).ready(function() {
    // let kurs = $('.kurs');
    // kurs.bind('keyup', function() {
    //     var nilai = $(".nilai").val();
    //     var kurs = $(this).val();
    //     console.log(nilai * kurs);
    //     $(".rupiah").val(nilai * kurs);
    // });

    $(".pilihaju").change(function() {
        var aju = $(this).val();;
        $.ajax({
            url: "<?= site_url('admin/jurnal/jurnalpengeluaranbank/serversideaju') ?>",
            type: 'POST',
            dataType: 'json',
            data: {
                aju: aju
            },
            success: function(response) {
                console.log(response.bapb);
                $(".bapb").val(response.bapb);
                $(".tglbapb").val(response.tglbapb);
                $(".supplier").val(response.vendor);
                $(".nilai").val(response.nilai);
                $(".nilaiu").val(response.nilai);
            },

            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n\n\n" + thrownError);
            }
        });
    });

    $("#tgldari").change(function() {
        tajp3.draw();
    });
    $("#tglke").change(function() {
        tajp3.draw();
    });
});

$(document).ready(function() {

    const Toasts = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        timer: 15000
    });

    $('.savepembelian').submit(function(e) {
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
                    $("#belumjurnalpembeliantabel").DataTable().ajax.reload();
                } else {
                    $('#editdata').modal('show');
                }
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

    $('#namakaryawan').select2({
        width: '500px'
    });

});
</script>