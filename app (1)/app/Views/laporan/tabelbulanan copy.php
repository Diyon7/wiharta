<table id="tabel1" class="table table-striped table-bordered" style="width: 100%;">
    <div id="filtertable"></div>
    <?php var_dump($tbldataabsen[0]['cekinmin']) ?>
    <?= $tbldataabsen[0]['cekinmin'] ?>
    <thead>
        <tr>
            <th class="fix">NIP</th>
            <th>NAMA</th>
            <th>DIVISI</th>
            <th>UNIT</th>
            <th>SUB UNIT</th>
            <th>ASAL</th>
            <th>GOL</th>
            <th>TMT</th>
            <th>GRUP</th>
            <?php foreach ($tbldataabsen[0]['tgllaporan'] as $tbltanggal) : ?>
                <th><?= $tbltanggal  ?></th>
            <?php endforeach; ?>

            <th>JUMLAH ABSEN</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tblalllaporan as $tblk) {
            foreach ($tbldataabsen[0]['idkar'] as $idkar) {
                if ($tblk['idkar'] == $idkar) {

        ?>
                    <tr>
                        <td class="fix"><?= $tblk['idkar'] ?></td>
                        <td><?= $tblk['nama'] ?></td>
                        <td><?= $tblk['divisi'] ?></td>
                        <td><?= $tblk['unit'] ?></td>
                        <td><?= $tblk['subunit'] ?></td>
                        <td><?= $tblk['asal'] ?></td>
                        <td><?= $tblk['golongan'] ?></td>
                        <td><?= $tblk['tmt'] ?></td>
                        <td><?= $tblk['grup'] ?></td>
                        <?php foreach ($tbldataabsen[0]['finger'] as $finger) : ?>
                            <td><?= $finger ?></td>
                        <?php endforeach; ?>
                    </tr>
        <?php
                }
            }
        } ?>
    </tbody>
</table>


<script type="text/javascript">
    $('#tabel1').DataTable({
        "responsive": true,
        "lengthmenu": [
            [5, 10, 20, 50],
            [5, 10, 20, 50]
        ],
        "order": [
            [3, "asc"],
            [1, "asc"]
        ],
        "dom": 'Bfrtip',
        "select": true,
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "scrollX": true,
        "fixedHeader": true
    });
</script>