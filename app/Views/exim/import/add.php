<?= $this->extend('layouts/main_master') ?>

<?= $this->section('isi') ?>

<!-- Small boxes (Stat box) -->
<div class="row">

</div>

<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-1"></i>
                    Import
                </h3>
                <br>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content p-0">
                    <div class="tab-pane active" id="ajp3" style="position: relative;">
                        <?= form_open('admin/exim/saveimport', ['class' => 'saveimport']) ?>
                        <?= csrf_field() ?>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputItem">Itema</label>
                                <select name="kodeitem" id="kodeitem" data-source="" class="form-control pilihnamaitem" required>
                                    <option selected>Choose...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputItem">Fasilitas</label>
                                <select name="fasilitas" id="fasilitas" class="form-control pilihfasilitas" required>
                                    <option selected>Choose...</option>
                                    <option value="FK">KITE</option>
                                    <option value="FNK">NON KITE</option>
                                    <option value="NF">NON FASILITAS</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputItem">Penjual || Pengirim || negara</label>
                                <select name="penjual" id="penjual" class="form-control pilihpenjual" required>
                                    <option selected>Choose...</option>
                                    <?php foreach ($penjual as $pjl) : ?>
                                        <option value="<?= $pjl['seq'] ?>">
                                            <?= $pjl['penjual'] ?> || <?= $pjl['pengirim'] ?> || <?= $pjl['negara'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">Aju</label>
                                <input type="text" class="form-control" name="aju" placeholder="no aju" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">EMKL PTJ</label>
                                <select name="emklptj" id="emklptj" class="form-control pilihemklptj" required>
                                    <option selected>Choose...</option>
                                    <option value="FIN">FIN</option>
                                    <option value="DUNEX">DUNEX</option>
                                    <option value="DHL">DHL</option>
                                    <option value="FEDEX">FEDEX</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="">Nomor COO</label>
                                <input type="text" class="form-control" name="nocoo" placeholder="nocoo">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">TGL COO</label>
                                <input type="date" class="form-control" name="tglcoo" placeholder="tglcoo">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">PIB</label>
                                <input type="text" class="form-control" name="pib" placeholder="pib" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">TGL PIB</label>
                                <input type="date" class="form-control" name="tglpib" placeholder="tglpib" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputItem">Qty</label>
                                <input type="text" class="form-control" name="qty" placeholder="qty" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">KGM</label>
                                <input type="text" class="form-control" name="kgm" placeholder="kgm" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="">NILAI</label>
                                <input type="text" class="form-control" name="nilai" placeholder="nilai" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">HS CODE</label>
                                <input type="text" class="form-control" name="hscode" placeholder="hscode" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">BL</label>
                                <input type="text" class="form-control" name="bl" placeholder="bl" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">PARTY</label>
                                <input type="text" class="form-control" name="party" placeholder="party" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">ETD</label>
                                <input type="date" class="form-control" name="etd" placeholder="etd" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">ETA</label>
                                <input type="date" class="form-control" name="eta" placeholder="eta" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">ETA WKA</label>
                                <input type="date" class="form-control" name="etawka" placeholder="etawka">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">TERM</label>
                                <input type="text" class="form-control" name="term" placeholder="term" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">INVOICE</label>
                                <input type="text" class="form-control" name="inv" placeholder="inv" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">MU</label>
                                <input type="text" class="form-control" name="mu" placeholder="mu" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">NILAI PIB (USD)</label>
                                <input type="text" class="form-control" name="nilaipibusd" placeholder="nilaipibusd" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">NILAI PIB (IDR)</label>
                                <input type="text" class="form-control" name="nilaipibidr" placeholder="nilaipibidr" required>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">BM</label>
                                <input type="text" class="form-control" name="bm" placeholder="bm">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">BMT BMAD BMI BMPT</label>
                                <input type="text" class="form-control" name="bmtbmadbmibmpt" placeholder="bmtbmadbmibmpt">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">PPN</label>
                                <input type="text" class="form-control" name="ppn" placeholder="ppn">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">PPH</label>
                                <input type="text" class="form-control" name="pph" placeholder="pph">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">REMARK</label>
                                <input type="text" class="form-control" name="remark" placeholder="remark">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">BM DIBEBASKAN</label>
                                <input type="text" class="form-control" name="bmdibebaskan" placeholder="bmdibebaskan">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">PPN TIDAK DIPUNGUT</label>
                                <input type="text" class="form-control" name="ppntidakdipungut" placeholder="ppntidakdipungut">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="">TOTAL PAYMENT PIB</label>
                                <input type="text" class="form-control" name="totalpaymentpib" placeholder="totalpaymentpib" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Input</button>
                        <?= form_close() ?>
                    </div>
                </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
</div>
<!-- /.row (main row) -->
<div class="vieweditdata" style="display: none;"></div>

<script>
    const flashDataa = "<?= session()->getFlashdata('success') ?>";

    $(document).ready(function() {

        $('.tanggalinput').daterangepicker();

        $('.pilihnamaitem').select2({
            minimumInputLength: 2,
            // allowClear: true,
            placeholder: 'Ketik Kode Item',
            ajax: {
                url: '<?= site_url('admin/exim/import/searchitem') ?>',
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
                                text: item.item + ' || ' + item.item_description,
                                id: item.item,
                            }
                        })
                    };
                },
            }
        });
        $("#kodeitem").change(function() {
            var namaitem = $(this).html();
            console.log(namaitem);
            // $("#kodeitem").val(namaitem);
        });


        $("#tgldari").change(function() {
            tajp3.draw();
        });
        $("#tglke").change(function() {
            tajp3.draw();
        });
        $("#itemfilter").change(function() {
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

        $('.saveimport').submit(function(e) {
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
                        // $('#gantishift').modal('hide');
                        Toasts.fire({
                            icon: 'success',
                            title: 'Data Berhasil',
                            type: 'success',
                        });
                        $("#importtabel").DataTable().ajax.reload();
                    } else {
                        $('#gantishift').modal('show');
                    }
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })

    });
</script>

<?= $this->endSection() ?>