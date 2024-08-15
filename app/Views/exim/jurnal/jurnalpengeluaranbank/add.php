<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nambah Pengeluaran Bank</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/jurnal/jurnalpengeluaranbank/addjurnalpengeluaranbank', ['class' => 'addjurnalpengeluaranbank']) ?>
                <?= csrf_field() ?>
                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="inputItem">BANK</label>
                        <select name="bank" id="bank" class="form-control pilihbank" required>
                            <option selected>Choose...</option>
                            <?php foreach ($bank as $bk) : ?>
                                <option value="<?= $bk['kode_bank'] ?>"><?= $bk['nama'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Bank Charge</label>
                        <input type="text" class="form-control" name="bankcharge" placeholder="bankcharge">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Kode Referensi</label>
                        <input type="text" class="form-control" name="kodereferensi" placeholder="kode referensi" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Tgl</label>
                        <input type="date" class="form-control" name="tgl" placeholder="tgl" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Asuransi</label>
                        <input type="text" class="form-control" name="asuransi" placeholder="asuransi">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Ongkos Angkut</label>
                        <input type="text" class="form-control" name="ongkosangkut" placeholder="ongkosangkut">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai</label>
                        <input type="text" class="form-control" name="nilai2" placeholder="nilai">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputItem">Aju</label>
                        <select name="aju" id="aju" class="form-control pilihaju">
                            <option selected>Choose...</option>
                            <?php foreach ($aju as $aj) : ?>
                                <option value="<?= $aj['aju'] ?>">
                                    <?= $aj['aju'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Invoice</label>
                        <select name="inv" id="inv" class="form-control pilihinv">
                            <option value="" selected>Choose...</option>
                            <?php foreach ($inv as $i) : ?>
                                <option value="<?= $i['inv'] ?>">
                                    <?= $i['inv'] . " | " . number_format($i['kgm'], 2, ',', '.'); ?>
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Supplier</label>
                        <input type="text" class="form-control" id="supplier" name="supplier" placeholder="supplier" readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">TGL BAPB</label>
                        <input type="date" class="form-control" id="tglbapb" name="tglbapb" placeholder="tglbapb" required readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">BAPB</label>
                        <input type="text" class="form-control" id="bapb" name="bapb" placeholder="bapb" required readonly>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai PEB</label>
                        <div class="nilapeb"></div>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai Jurnal Pembelian</label>
                        <div class="nilai"></div>
                        <!-- <input type="text" class="form-control" id="nilai" name="nilai" placeholder="nilai" required> -->
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Nilai Kredit</label>
                        <div class="nilaiu"></div>
                        <div id="nilaiu"></div>
                        <!-- <input type="text" class="form-control" id="nilaiu" name="nilaiu" placeholder="nilaiu" required> -->
                    </div>
                </div>
                <button type="submit" class="btnsimpan btn btn-primary">Input</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
    function addInput() {
        var newdiv = document.getElementById('nilaiu');
        //newdiv.id = dynamicInput[counter];
        newdiv.innerHTML =
            '<input type="text" class="form-control" name="nilaiu[]" value="" required>';
        document.getElementById('nilaiu').append(newdiv);
    }
    $(document).ready(function() {

        const Toasts = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 15000
        });

        $('.tanggalinput').daterangepicker();

        $('.pilihnamaitem').select2({
            width: '290px'
        });

        // $('.aju').select2({
        //     width: '290px'
        // });

        $("#inv").change(function() {
            var inv = $(this).val();
            console.log(inv);
            $.ajax({
                url: "<?= base_url('admin/jurnal/jurnalpengeluaranbank/serversideinv') ?>",
                method: "post",
                data: {
                    inv: inv
                },
                dataType: "json",
                success: function(response) {
                    $(".nilapeb").empty();
                    $.each(response.nilai, function(index, val) {
                        var ninv =
                            '<input type="text" class="form-control" name="nilaiinv[]" id="nilaiinv" value="' +
                            val +
                            '" placeholder="inv" required>';
                        $(".nilapeb").append(ninv);

                    });
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $("#aju").change(function() {
            var aju = $(this).val();
            $.ajax({
                url: "<?= site_url('admin/jurnal/jurnalpengeluaranbank/serversideaju') ?>",
                type: 'POST',
                dataType: 'json',
                data: {
                    aju: aju
                },
                success: function(response) {
                    $(".nilai").empty();
                    $(".nilaiu").empty();
                    $.each(response.nilai, function(index, val) {
                        var ni =
                            '<input type="text" class="form-control" name="nilai[]" id="nilai" value="' +
                            val + '" required>';

                        console.log(ni);
                        $(".nilai").append(ni);

                        // $("#nilai").val(response.nilai);
                        // console.log(val);
                    });
                    $.each(response.nilai, function(index, val) {
                        var niu =
                            '<input type="text" class="form-control" name="nilaiu[]" placeholder="nilaiu" value="' +
                            val + '" required>';
                        $(".nilaiu").append(niu);

                        // $("#nilai").val(response.nilai);
                        // console.log(val);
                    });
                    $("#bapb").val(response.bapb);
                    $("#tglbapb").val(response.tglbapb);
                    $("#supplier").val(response.vendor);
                    // $("#nilai").val(response.nilai);
                    // $("#nilaiu").val(response.nilai);
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });

        $('.addjurnalpengeluaranbank').submit(function(e) {
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
                        $('#jurnalpengeluaranbank').DataTable().ajax.reload()
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