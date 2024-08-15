<style>
.c1 {
    position: sticky;
    left: 0;
    background: white;
}
</style>

<div class="table-responsive" style="overflow: auto;">
    <table id="tabel1" class="table table-striped table-bordered">
        <div id="filtertable"></div>
        <thead>
            <tr>
                <th class="c1">NIP</th>
                <th class="c1">NAMA</th>
                <th>DIVISI</th>
                <th>UNIT</th>
                <th>SUB UNIT</th>
                <th>ASAL</th>
                <th>GOL</th>
                <th>TMT</th>
                <th>GRUP</th>
                <?php foreach ($tbldataabsen[0][0]['tgllaporan'] as $tbltanggal => $tgl) : ?>
                <th><?= $tbldataabsen[0][0]['day'][$tbltanggal] ?>,
                    <?= $tbldataabsen[0][0]['tgllaporan'][$tbltanggal] ?>
                </th>
                <?php endforeach; ?>
                <th>HADIR</th>
                <th>TIDAK HADIR</th>
                <th>TERLAMBAT</th>
                <th>KELEBIHAN JAM</th>
                <th>PULANG CEPAT</th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1; ?>
            <?php foreach ($tbldataabsen as $tblk) :
                foreach ($tblk as $tblk2) : ?>
            <tr>
                <td class="c1"><?= $tblk2['idkar'] ?></td>
                <td class="c1"><?= $tblk2['nama'] ?></td>
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
                <?php if (count($tblk2['msk']) != 0) {
                            $masuk = (count($tblk2['msk']) / count($tblk2['m']));
                        } else {
                            $masuk = 0;
                        } ?>
                <td><?= $masuk ?></td>
                <?php if (count($tblk2['tm']) != 0) { ?>
                <td><?= count($tblk2['tm']) / count($tblk2['m'])  ?></td>
                <?php  } else { ?>
                <td>0</td>
                <?php } ?>
                <?php if ($tblk2['terlambat'] != 0) { ?>
                <td><?= $tblk2['terlambat'] / count($tblk2['m'])  ?></td>
                <?php  } else { ?>
                <td>0</td>
                <?php } ?>
                <?php if ($tblk2['kelebihanjam'] != 0) { ?>
                <td><?= $tblk2['kelebihanjam'] / count($tblk2['m'])  ?></td>
                <?php  } else { ?>
                <td>0</td>
                <?php } ?>
                <?php if ($tblk2['pcepat'] != 0) { ?>
                <td><?= $tblk2['pcepat'] / count($tblk2['m'])  ?></td>
                <?php  } else { ?>
                <td>0</td>
                <?php } ?>
            </tr>
            <?php endforeach;
                $n++;
            endforeach ?>
        </tbody>
    </table>
</div>
<div class="">
    <caption>*** Kuning : Hari Libur/ hari minggu</caption>
</div>
<div class="">
    <caption>*** Merah : Tidak finger</caption>
</div>
<div class="">
    <caption>*** Abu - abu : Kelebihan Jam</caption>
</div>
<div class="">
    <caption>*** Orange : Terlambat</caption>
</div>

<script type="text/javascript">
$('#tabel1').DataTable({
    "dom": 'Blfrtip',
    "responsive": true,
    "lengthMenu": [
        [5, 10, 20, 50],
        [5, 10, 20, 50]
    ],
    "initComplete": function() {
        this.api().columns([8, 3, 4]).every(function(d) { //THis is used for specific column
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
            'pageSize': 'A1',
            'exportOptions': {
                'stripNewlines': false
            }
        },
        {
            'extend': 'print',
            'text': 'Print All',
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
    "select": true,
    "paging": true,
    "searching": true,
    "ordering": true,
    "info": true,
    "autoWidth": true,
    "scrollX": true,
    "fixedHeader": true
});
</script>
<p>Page rendered in {elapsed_time}</p>