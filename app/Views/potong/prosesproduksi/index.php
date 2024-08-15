<?= $this->extend('layouts/main_master') ?>

<?= $this->section('isi') ?>
<!-- Small boxes (Stat box) -->
<div class="row">

    <!-- ./col -->
</div>
<!-- /.row -->
<!-- Main row -->
<?= form_open('admin/potong/carirls', ['class' => 'carirls']) ?>
<?= csrf_field() ?>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="inputItem">Proses</label>
        <select name="norcn" id="norcn" class="form-control pilihdataspp" required>
            <option selected>Choose...</option>
            <?php foreach ($allspp as $spp) : ?>
                <option value="<?= $spp['norcn'] ?>"><?= $spp['spp'] ?> || <?= $spp['namatipe'] ?> || <?= $spp['tgl'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>
<button type="submit" class="btn btn-primary btnsearch">Cari</button>
<?= form_close() ?>
<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-table mr-1"></i>
                    Realisasi Produksi
                </h3>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="outer">
                    <div class="inner datarencana">
                        <!-- <div class="datarencana" style="display: none;"></div> -->
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
    $(document).ready(function() {
        const Toasts = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 15000
        });

        $('.carirls').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnsearch').attr('disable', 'disabled');
                    $('.btnsearch').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnsearch').removeAttr('disable');
                    $('.btnsearch').html('Cari');
                },
                success: function(response) {
                    $('.datarencana').html(response.sukses);
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })

        $('.pilihdataspp').select2();

        $('#tipeitem tbody').on('click', '.btn-edit', function(e) {
            const id = $(this).data('seq');

            $.ajax({
                url: "<?= base_url('admin/potong/item/edit') ?>",
                method: "post",
                data: {
                    id: id
                },
                dataType: "json",
                beforeSend: function() {
                    $('.btn-edit').attr('disable', 'disabled');
                    $('.btn-edit').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btn-edit').removeAttr('disable');
                    $('.btn-edit').html('<i class="fas fa-edit"></i>');
                },
                success: function(response) {
                    if (response.sukses) {
                        $('.vieweditdata').html(response.sukses).show();
                        $('#editdata').modal('show');
                    }
                    $('input[name=csrf_test_name]').val(response.csrf_test_name);
                },
                error: function(xhr, ajaxOption, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>