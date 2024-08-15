<style>
.column {
    position: sticky;
    top: 0;
    left: 0;
    background: white;
}

thead th {
    position: sticky;
    top: 0;
    background: white;
}
</style>

<script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>

<!--<button id="printarea" onclick="printData()" class="btn btn-outline-success">PRINT AREA</button>-->
<!--<button class="btn btn-primary" onclick="ExportToExcel('xlsx')">EXPORT TO EXCEL</button>-->
<div class="table-responsive">
    <!--<div class="table-responsive" style="height: 500px;  overflow-x: scroll; overflow-y: scroll;">-->
    <table id="table-dkp" class="table table-striped tabel-dkp table-bordered">
        <thead>
            <tr>
                <th class="column freeze">KODE</th>
                <th class="column freeze">KATEGORI</th>
                <th class="column freeze">DIVISI</th>
                <th class="column freeze">UNIT</th>
                <th>DK</th>
                <th>DSP</th>
                <th>DKP</th>
                <th>LIBUR</th>
                <th>DILIBURKAN</th>
                <th>M</th>
                <th>TM</th>
                <th>TA</th>
                <th>DKP</th>
                <th>%</th>
            </tr>
        </thead>
        <?php $dkp2 = '0'; ?>
        <?php $dkpmnssl2 = '0'; ?>
        <?php $tmns12 = '0'; ?>
        <?php $libur2 = '0'; ?>
        <?php $dkpshs2 = '0'; ?>
        <?php $tmsh12 = '0'; ?>
        <?php $dkpshd2 = '0'; ?>
        <?php $mndk = '0'; ?>
        <?php $jp2 = '0'; ?>
        <?php $tmsh22 = '0'; ?>
        <?php $dkpsht2 = '0'; ?>
        <?php $tap2 = '0'; ?>
        <?php $tmsh32 = '0'; ?>
        <?php $mnsa2 = '0'; ?>
        <?php $tmnsa2 = '0'; ?>
        <tbody>
            <?php foreach ($dkpharian as $dh => $value) : ?>
            <?php $jp = 0; ?>
            <tr>
                <td class="column"><?= $dkpharian[$dh]['pembagian4_kode'] ?></td>
                <td class="column"><?= $dkpharian[$dh]['pembagian6_nama'] ?></td>
                <td class="column"><?= $dkpharian[$dh]['pembagian2_nama'] ?></td>
                <td class="column unit" data-unit="<?= $dkpharian[$dh]['pembagian4_nama'] ?>" data-tanggal="<?= $tanggal ?>" data-status="<?= $status ?>"><?= $dkpharian[$dh]['pembagian4_nama'] ?></td>
                <td><?= $dkp = $dkpharian[$dh]['dkp'] ?></td>
                <?php $pembagian4dkpharian = $dkpharian[$dh]['pembagian4_id'] ?>
                <td></td>
                <td></td>
                <?php $dkp2 = $dkp2 + $dkp; ?>
                <td><?= $libur = $dkpharian[$dh]['sh0'] ?></td>
                <?php $libur2 = $libur2 + $libur; ?>
                <td><?= $jp = $dkpharian[$dh]['dk'] ?></td>
                <?php $jp2 = $jp2 + $jp ?>
                <td><?= $dkpshs = $dkpmasuk[$dh]['mk'] ?></td>
                <?php $dkpshs2 = $dkpshs2 + $dkpshs; ?>
                <?php $tmsh1 = (($dkpharian[$dh]['mk'] - $dkpmasuk[$dh]['mk']) + $libur) ?>
                <td><?= $jpn = $tmsh1  ?></td>
                <td><?= $tap = $dkpharian[$dh]['mk'] - $dkpmasuk[$dh]['mk'] - $jp ?></td>
                <?php $tap2 = $tap2 + $tap ?>
                <td style="font-weight: bold;"><?= $mndk = $dkpshs + $jpn ?></td>
                <?php $mnsa2 = $mnsa2 + $mndk; ?>
                <?php $tmsh12 = $tmsh12 + $tmsh1; ?>
                <?php $tms =   $tmsh1 ?>
                <?php $dl = $dkp - $libur ?>
                <?php if ($tms != "0" && $dl != "0") { ?>
                <td><?= round(((($tmsh1) / ($dkp)) * 100),2) ?>%</td>
                <?php } else { ?>
                <td>0%</td>
                <?php } ?>
            </tr>
            <?php endforeach ?>
            
        </tbody>
       <tfoot>
           <!--<tr>-->
           <!--     <td>TOTAL</td>-->
           <!--     <td></td>-->
           <!--     <td></td>-->
           <!--     <td></td>-->
           <!--     <td><?= $dkp2 ?></td>-->
           <!--     <td></td>-->
           <!--     <td></td>-->
           <!--     <td><?= $libur2 ?></td>-->
           <!--     <td><?= $jp2 ?></td>-->
           <!--     <td><?= $dkpshs2 ?></td>-->
           <!--     <td><?= $tmsh12 ?></td>-->
           <!--     <td><?= $tap2 ?></td>-->
           <!--     <td style="font-weight: bold;"><?= $mnsa2 ?></td>-->
           <!--     <td><?= round((($tap2 * 100) / $dkp2),2) ?>%</td>-->
           <!-- </tr>-->
            <tr>
                <th>TOTAL</th>
                <th></th>
                <th></th>
                <th></th>
                <th><?= $dkp2 ?></th>
                <th></th>
                <th></th>
                <th><?= $libur2 ?></th>
                <th><?= $jp2 ?></th>
                <th><?= $dkpshs2 ?></th>
                <th><?= $tmsh12 ?></th>
                <th><?= $tap2 ?></th>
                <th style="font-weight: bold;"><?= $mnsa2 ?></th>
                <th><?= round((($tap2 * 100) / $dkp2),2) ?>%</th>
            </tr>
        </tfoot>
    </table>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#tf" id="akjjp3" data-toggle="tab">TIDAK FINGER</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tr" id="kkjjp3" data-toggle="tab">TERLAMBAT</a>
                </li>
            </ul>
        </div>
    </div><!-- /.card-header -->
    <div class="card-body">
        <div class="tab-content p-0">
            <div class="tab-pane active" id="tf" style="position: relative;">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table id="tabel1" class="table table-striped table-bordered col-xl-12" style="width: 100%;">
                            <div id="filtertable"></div>
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>NAMA</th>
                                    <th>UNIT</th>
                                    <th>GRUP KERJA</th>
                                </tr>
                            </thead>
                            <th>KARYAWAN NS</th>
                            <tbody>
                                <?php $n = 1; ?>
                                <?php foreach ($stm as $sttm) : ?>
                                <tr>
                                    <td><?= $sttm['nip'] ?></td>
                                    <td><?= $sttm['nama'] ?></td>
                                    <td><?= $sttm['unit'] ?></td>
                                    <td><?= $sttm['grup_jam_kerja'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <TH>KARYAWAN SHIFT 1</TH>
                            <tbody>
                                <?php $n = 1; ?>
                                <?php foreach ($s1 as $s1) :
                                ?>
                                <tr>
                                    <td class="fix"><?= $s1['nip'] ?></td>
                                    <td><?= $s1['nama'] ?></td>
                                    <td><?= $s1['unit'] ?></td>
                                    <td><?= $s1['grup_jam_kerja'] ?></td>
                                </tr>
                                <?php
                                endforeach ?>
                            </tbody>
                            <TH>KARYAWAN SHIFT 2</TH>
                            <tbody>
                                <?php $n = 1; ?>
                                <?php foreach ($s2 as $s2) :
                                ?>
                                <tr>
                                    <td class="fix"><?= $s2['nip'] ?></td>
                                    <td><?= $s2['nama'] ?></td>
                                    <td><?= $s2['unit'] ?></td>
                                    <td><?= $s2['grup_jam_kerja'] ?></td>
                                </tr>
                                <?php
                                endforeach ?>
                            </tbody>
                            <TH>KARYAWAN SHIFT 3</TH>
                            <tbody>
                                <?php $n = 1; ?>
                                <?php foreach ($s3 as $s3) :
                                ?>
                                <tr>
                                    <td class="fix"><?= $s3['nip'] ?></td>
                                    <td><?= $s3['nama'] ?></td>
                                    <td><?= $s3['unit'] ?></td>
                                    <td><?= $s3['grup_jam_kerja'] ?></td>
                                </tr>
                                <?php
                                endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="chart tab-pane" id="tr" style="position: relative;">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table id="tabel1" class="table table-striped table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th colspan="3">TERLAMBAT</th>
                                </tr>
                                <tr>
                                    <th>NIP</th>
                                    <th>NAMA</th>
                                    <th>DURASI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td>KARYAWAN NS</td>
                                <?php $n = 1; ?>
                                <?php foreach ($tnss as $tnsa) :
                                ?>
                                <tr>
                                    <td class="fix"><?= $tnsa['pin'] ?></td>
                                    <td><?= $tnsa['nama'] ?></td>
                                    <td><?= $tnsa['selisih'] ?></td>
                                    <?php
                                endforeach ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.card-body -->
</div>

<div class="vieweditdata" style="display: none;"></div>

<script type="text/javascript">
function ExportToExcel(type, fn, dl) {
    var elt = document.getElementById('table-dkp');
    var wb = XLSX.utils.table_to_book(elt, {
        sheet: "sheet1"
    });
    return dl ?
        XLSX.write(wb, {
            bookType: type,
            bookSST: true,
            type: 'base64'
        }) :
        XLSX.writeFile(wb, fn || ('Rekap Harian.' + (type || 'xlsx')));
}

function printData() {
    var divToPrint = document.getElementById('table-dkp');
    var htmlToPrint = '' +
        '<style type="text/css">' +
        'table th, table td {' +
        'border:1px solid #000;' +
        'padding:0.5em;' +
        '}' +
        '</style>';
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    newWin.print();
    newWin.close();
}

$(document).ready(function() {
    $('#table-dkp tbody').on('click', '.unit', function(e) {
        const unit = $(this).data('unit');
        const tanggal = $(this).data('tanggal');
        const status = $(this).data('status');
        
        $.ajax({
            url: "<?= site_url('admin/rekap/detailunit') ?>",
            method: "post",
            data: {
                unit: unit,
                tanggal: tanggal,
                status: status
            },
            dataType: "json",
            success: function(response) {
                if (response.sukses) {
                    $('.vieweditdata').html(response.sukses).show();
                    $('#detaildata').modal('show');
                }
                $('input[name=csrf_test_name]').val(response.csrf_test_name);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });
});

$('#table-dkp').DataTable({
    dom: 'Blfrtip',
    paging: false,
    scrollCollapse: true,
    scrollY: '50vh',
    fixedHeader: {
        header: true,
        footer: true
    },
    buttons:  [
            { extend: 'copy', footer: true },
            { extend: 'excel', footer: true },
            { extend: 'csv', footer: true },
            { extend: 'pdf', footer: true }
        ],
});

$('#addkaryawan').click(function(e) {
    $.ajax({
        url: "<?= site_url('admin/karyawanjp3a/add') ?>",
        type: "POST",
        dataType: "json",
        success: function(response) {
            if (response.sukses) {
                $('.vieweditdata').html(response.sukses).show();
                $('#tambahdata').modal('show');
            }
            $('input[name=csrf_test_name]').val(response.csrf_test_name);
        },
    });
});

function tabelunit(tgl) {
    $.ajax({
        url: "<?= site_url('admin/printrekap/rekapunit') ?>",
        type: "POST",
        data: {
            tglno: tgl
        },
        dataType: "json",
        success: function(response) {
            w = window.open(window.location.href, "_blank");
            w.document.open();
            w.document.write(response.sukses);
            w.document.close();
        },
        error: function(xhr, ajaxOption, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });
}
$(document).ready(function() {
    $("#list").change(function() {
        var idkar = $(this).val();

        $.ajax({
            url: '<?= site_url('admin/izin/datanamaform') ?>',
            type: 'post',
            data: {
                idkar: idkar
            },
            dataType: 'json',
            success: function(response) {
                $('.listtabelkaryawan').html(response.sukses);
            },
            error: function(xhr, ajaxOption, thrownError) {
                alert(xhr.status + "\n\n\n" + thrownError);
            }
        });
    });
});
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
            var select = $('<select class="col col-3"> <option value = "" > ' + theadname +
                    ': All</option> </select > ')
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
                var val = $(' <div/> ').html(d).text();
                select.append('<option value="' + d + '">' + d +
                    '</option>')
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
                    head = win.document.head || win.document.getElementsByTagName(
                        'head')[0],
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