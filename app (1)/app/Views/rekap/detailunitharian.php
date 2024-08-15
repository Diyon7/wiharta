<div class="modal fade" id="detaildata" aria-labelledby="exampleModalLabel" style="overflow:hidden;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
            <button class="btn btn-primary" onclick="ExportToExcel('xlsx')">EXPORT TO EXCEL</button>
                <h5 class="modal-title" id="exampleModalLabel">Edit Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="detailrekapharian" class="modal-body">
                <h1>Unit : <?= $unit ?></h1>
                 <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">NIP</th>
                            <th scope="col">NAMA</th>
                            <th scope="col">JABATAN</th>
                            <th scope="col">SUBUNIT</th>
                            <th scope="col">ASAL</th>
                            <th scope="col">TMT</th>
                            <th scope="col">GRUP</th>
                            <th scope="col">FINGER MASUK</th>
                            <th scope="col">FINGER PULANG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $dt) : ?>
                            <tr>
                                <td><?= $dt['idkar'] ?></td>
                                <td><?= $dt['nama'] ?></td>
                                <td><?= $dt['posisi'] ?></td>
                                <td><?= $dt['subunit'] ?></td>
                                <td><?= $dt['asal'] ?></td>
                                <td><?= $dt['tmt'] ?></td>
                                <td><?= $dt['grup'] ?></td>
                                <td><?= $dt['masuk'] ?></td>
                                <td><?= $dt['pulang'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function ExportToExcel(type, fn, dl) {
    var elt = document.getElementById('detailrekapharian');
    var wb = XLSX.utils.table_to_book(elt, {
        sheet: "sheet1"
    });
    return dl ?
        XLSX.write(wb, {
            bookType: type,
            bookSST: true,
            type: 'base64'
        }) :
        XLSX.writeFile(wb, fn || ('Detail Rekap Harian.' + (type || 'xlsx')));
}
</script>