<table id="tabel1" class="table table-striped table-bordered" style="width: 100%;">
    <div id="filtertable"></div>
    <thead>
        <tr>
            <th>NIP</th>
            <th>NAMA</th>
            <th>DIVISI</th>
            <th>UNIT</th>
            <th>SUB UNIT</th>
            <th>ASAL</th>
            <th>GOL</th>
            <th>TMT</th>
            <th>GRUP</th>
            <?php foreach ($tbldataabsen[0][0]['tgllaporan'] as $tbltanggal => $tgl) : ?>
            <th><?= $tbldataabsen[0][0]['day'][$tbltanggal] ?>, <?= $tbldataabsen[0][0]['tgllaporan'][$tbltanggal] ?>
            </th>
            <?php endforeach; ?>
            <th>HADIR</th>
            <th>TIDAK HADIR</th>
            <th>TERLAMBAT</th>
            <th>KELEBIHAN JAM</th>
        </tr>
    </thead>
    <tbody>
        <?php $n = 1; ?>
        <?php foreach ($tbldataabsen as $tblk) :
            foreach ($tblk as $tblk2) : ?>
        <tr>
            <td class="fix"><?= $tblk2['idkar'] ?></td>
            <td><?= $tblk2['nama'] ?></td>
            <td><?= $tblk2['divisi'] ?></td>
            <td><?= $tblk2['unit'] ?></td>
            <td><?= $tblk2['subunit'] ?></td>
            <td><?= $tblk2['asal'] ?></td>
            <td><?= $tblk2['golongan'] ?></td>
            <td><?= $tblk2['tmt'] ?></td>
            <td><?= $tblk2['grup'] ?></td>
            <?php foreach ($tblk2['color'] as $color => $value) : ?>
            <td bgcolor="<?= $tblk2['color'][$color] ?>"><?= $tblk2['finger'][$color] ?>
            </td>
            <?php endforeach; ?>
            <th><?= count($tblk2['msk']) / count($tblk2['m'])  ?></th>
            <th><?= count($tblk2['tm']) / count($tblk2['m'])  ?></th>
            <th><?= $tblk2['terlambat'] / count($tblk2['m'])  ?></th>
            <th><?= $tblk2['kelebihanjam'] / count($tblk2['m'])  ?></th>
        </tr>
        <?php endforeach;
            $n++;
        endforeach ?>
    </tbody>
</table>
<caption>*** Kuning : hari Libur/ hari minggu</caption>

<script type="text/javascript">
$('#tabel1').DataTable({
    "responsive": true,
    "lengthMenu": [
        [5, 10, 20, 50],
        [5, 10, 20, 50]
    ],
    "initComplete": function() {
        this.api().columns([6, 3, 4]).every(function(d) { //THis is used for specific column
            var column = this;
            var theadname = $('#example3 th').eq([d]).text();
            var select = $('<select class="col col-3"><option value="">' + theadname +
                    ': All</option></select>')
                .appendTo('#filtertable')
                .on('change', function() {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                        .search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
            column.data().unique().sort().each(function(d, j) {
                var val = $('<div/>').html(d).text();
                select.append('<option value="' + d + '">' + d + '</option>')
            });
        });
    },
    "buttons": ["copy", "csv", "colvis",
        {
            extend: 'excelHtml5',
            title: 'Rekap Absen Vendor : <?= $vendor ?> || Jabatan <?= $jabatan ?>',
            customize: function(xlsx) {
                var sheet = xlsx.xl.worksheets['sheet1.xml'];
                var col = $('col', sheet);
                col.each(function() {
                    $(this).attr('width', 9);
                });
            }
        },
        {
            'extend': 'pdfHtml5',
            'orientation': 'landscape',
            'title': 'Rekap Absen Vendor : <?= $vendor ?>',
            'pageSize': 'A1',
            'exportOptions': {
                'stripNewlines': false
            }
        },
        {
            'extend': 'print',
            'text': 'Print All',
            'title': 'Rekap Absen Vendor : <?= $vendor ?>',
            'orientation': 'landscape',
            'customize': function(win) {

                var last = null;
                var current = null;
                var bod = [];

                var css = '@page { size: landscape; }',
                    head = win.document.head || win.document.getElementsByTagName('head')[0],
                    style = win.document.createElement('style');

                style.type = 'text/css';
                style.media = 'print';

                if (style.styleSheet) {
                    style.styleSheet.cssText = css;
                } else {
                    style.appendChild(win.document.createTextNode(css));
                }

                head.appendChild(style);
            }
        },
        {
            extend: 'print',
            text: 'Print selected'
        }
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