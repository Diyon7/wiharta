<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('admin/jurnal/jurnalpenjualan/savetambahjurnalpenjualan', ['class' => 'save']) ?>
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">BPB</label>
                        <input type="text" class="form-control" name="bpb" value="<?= $edit['nobpb'] ?>" required
                            readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Tgl BPB</label>
                        <input type="date" class="form-control" name="tglbpb" value="<?= $edit['tgbpb'] ?>" required
                            readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Bukti</label>
                        <input type="text" class="form-control" name="bukti"
                            value="BPJ/WH/<?= $tahun ?>/<?= $bulan ?>/<?= $maxid['bjpmaxid'] ?>" required readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">PEB</label>
                        <input type="text" class="form-control" name="peb" value="<?= $edit['nopeb'] ?>" required
                            readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Tgl PEB</label>
                        <input type="date" class="form-control" name="tglpeb" value="<?= $edit['tgpeb'] ?>" required
                            readonly>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">INVOICE</label>
                        <input type="text" class="form-control" name="inv" value="<?= $edit['inv'] ?>" required
                            readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">NO ORDER</label>
                        <input type="text" class="form-control" name="nospp" value="<?= $edit['nospp'] ?>" required
                            readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">CUSTOMER</label>
                        <input type="text" class="form-control" name="namacus" value="<?= $edit['namacus'] ?>" required
                            readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputItem">ITEM</label>
                        <select name="item" id="item" class="form-control pilihitem">
                            <option value="<?= $edit['kodeitem'] ?>" selected><?= $edit['kodeitem'] ?> ||
                                <?= $edit['desk'] ?></option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Satuan</label>
                        <input type="text" class="form-control" name="satuan" value="<?= $edit['satuan'] ?>" required
                            readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">QTY</label>
                        <input type="text" class="form-control" name="qty" value="<?= $edit['qty'] ?>" required
                            readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">KGM</label>
                        <input type="text" class="form-control" name="kgm" value="<?= $edit['kgm'] ?>" required
                            readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">MATA UANG</label>
                        <input type="text" class="form-control mu" id="mu" value="<?= $edit['mu'] ?>" name="mu"
                            required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai</label>
                        <input type="text" class="form-control nilai" id="nilai" value="<?= $edit['fob'] ?>"
                            name="nilai" required readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Kurs</label>
                        <input type="text" class="form-control kurs" onkeyup="kursn()" id="kurs"
                            value="<?= $edit['kurs'] == '' || $edit['kurs'] == '0' ? '0' : $edit['kurs'] ?>"
                            name="kurs">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Rupiah</label>
                        <input type="text" class="form-control rupiah" id="rupiah"
                            value="<?= $edit['fob'] * $edit['kurs'] ?>" name="rupiah" readonly>
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

    $('.save').submit(function(e) {
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
                    location.reload();
                    // $("#belumjurnalpembeliantabel").DataTable().ajax.reload();
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