<div class="modal fade" id="editdata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <?= form_open('admin/exim/importbahanbaku/saveeditimport', ['class' => 'saveimport']) ?>
                <?= csrf_field() ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="hidden" class="form-control" name="seq" value="<?= $dataimport['seq'] ?>">
                        <label for="inputItem">Item</label>
                        <select name="kodeitem" id="kodeitem" data-source="" class="form-control pilihnamaitem">
                            <option value="<?= $dataimport['kode_item'] ?>" selected><?= $dataimport['kode_item'] ?> ||
                                <?= $dataimport['desk'] ?></option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Fasilitas</label>
                        <select name="fasilitas" id="fasilitas" class="form-control pilihfasilitas">
                            <option value="<?= $dataimport['fasilitas'] ?>" selected><?= $dataimport['fasilitas'] ?>
                            </option>
                            <option value="FK">KITE</option>
                            <option value="FNK">NON KITE</option>
                            <option value="NF">NON FASILITAS</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputItem">Penjual || Pengirim || negara</label>
                        <select name="penjual" id="penjual" class="form-control pilihpenjual">
                            <option value="<?= $dataimport['id_vendor'] ?>" selected><?= $dataimport['penjual'] ?> ||
                                <?= $dataimport['pengirim'] ?> || <?= $dataimport['negara'] ?></option>
                            <?php foreach ($penjual as $pjl) : ?>
                                <option value="<?= $pjl['seq'] ?>">
                                    <?= $pjl['penjual'] ?> || <?= $pjl['pengirim'] ?> || <?= $pjl['negara'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">Aju</label>
                        <input type="text" class="form-control" name="aju" placeholder="no aju" value="<?= $dataimport['aju'] ?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">EMKL PTJ</label>
                        <select name="emklptj" id="emklptj" class="form-control pilihemklptj">
                            <option value="<?= $dataimport['emkl_ptj'] ?>" selected><?= $dataimport['emkl_ptj'] ?>
                            </option>
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
                        <input type="text" class="form-control" name="nocoo" value="<?= $dataimport['no_coo'] ?>" placeholder="nocoo">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">TGL COO</label>
                        <input type="date" class="form-control" name="tglcoo" value="<?= $dataimport['tgl_coo'] ?>" placeholder="tglcoo">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">PIB</label>
                        <input type="text" class="form-control" name="pib" value="<?= $dataimport['pib'] ?>" placeholder="pib">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">TGL PIB</label>
                        <input type="date" class="form-control" name="tglpib" value="<?= $dataimport['tglpib'] ?>" placeholder="tglpib">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputItem">Qty</label>
                        <input type="text" class="form-control" name="qty" value="<?= $dataimport['qty'] ?>" placeholder="qty">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">KGM</label>
                        <input type="text" class="form-control" name="kgm" value="<?= $dataimport['kgm'] ?>" placeholder="kgm">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="">NILAI</label>
                        <input type="text" class="form-control" name="nilai" value="<?= $dataimport['nilai'] ?>" placeholder="nilai">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">HS CODE</label>
                        <input type="text" class="form-control" name="hscode" value="<?= $dataimport['HSCODE'] ?>" placeholder="hscode">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">BL</label>
                        <input type="text" class="form-control" name="bl" value="<?= $dataimport['bl'] ?>" placeholder="bl">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">PARTY</label>
                        <input type="text" class="form-control" name="party" value="<?= $dataimport['party'] ?>" placeholder="party">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">ETD</label>
                        <input type="date" class="form-control" name="etd" value="<?= $dataimport['etd'] ?>" placeholder="etd">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">ETA</label>
                        <input type="date" class="form-control" name="eta" value="<?= $dataimport['eta'] ?>" placeholder="eta">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">ETA WKA</label>
                        <input type="date" class="form-control" name="etawka" value="<?= $dataimport['eta_wka'] ?>" placeholder="etawka">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">TERM</label>
                        <input type="text" class="form-control" name="term" value="<?= $dataimport['term'] ?>" placeholder="term">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">INVOICE</label>
                        <input type="text" class="form-control" name="inv" value="<?= $dataimport['inv'] ?>" placeholder="inv">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">MU</label>
                        <input type="text" class="form-control" name="mu" value="<?= $dataimport['MU'] ?>" placeholder="mu">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">NILAI PIB (USD)</label>
                        <input type="text" class="form-control" name="nilaipibusd" value="<?= $dataimport['nilai_pib_usd'] ?>" placeholder="nilaipibusd">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">NILAI PIB (IDR)</label>
                        <input type="text" class="form-control" name="nilaipibidr" value="<?= $dataimport['nilai_pib_idr'] ?>" placeholder="nilaipibidr">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">BM</label>
                        <input type="text" class="form-control" name="bm" value="<?= $dataimport['bm'] ?>" placeholder="bm">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">BMT BMAD BMI BMPT</label>
                        <input type="text" class="form-control" name="bmtbmadbmibmpt" value="<?= $dataimport['bmt_bmad_bmi_bmtp'] ?>" placeholder="bmtbmadbmibmpt">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">PPN</label>
                        <input type="text" class="form-control" name="ppn" value="<?= $dataimport['ppn'] ?>" placeholder="ppn">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">PPH</label>
                        <input type="text" class="form-control" name="pph" value="<?= $dataimport['pph'] ?>" placeholder="pph">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">REMARK</label>
                        <input type="text" class="form-control" name="remark" value="<?= $dataimport['remark'] ?>" placeholder="remark">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">BM DIBEBASKAN</label>
                        <input type="text" class="form-control" name="bmdibebaskan" value="<?= $dataimport['bm_dibebaskan'] ?>" placeholder="bmdibebaskan">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">PPN TIDAK DIPUNGUT</label>
                        <input type="text" class="form-control" name="ppntidakdipungut" value="<?= $dataimport['ppn_tidakdipungut'] ?>" placeholder="ppntidakdipungut">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="">TOTAL PAYMENT PIB</label>
                        <input type="text" class="form-control" name="totalpaymentpib" value="<?= $dataimport['total_payment_pib'] ?>" placeholder="totalpaymentpib">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Input</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

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


        $('.saveimport').submit(function(e) {
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
                        $('#importtabeljkt').DataTable().ajax.reload()
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