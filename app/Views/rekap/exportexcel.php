<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <title></title>
</head>

<body>
    <h1>TANGGAL <?= $tanggal ?></h1>
    <div class="col-lg-12">
        <table class="table table-striped table-bordered ">
            <thead>
                <tr>
                    <th rowspan="2" style="text-align: center;">DEVISI</th>
                    <th rowspan="2">DKP</th>
                    <th rowspan="2">LIBUR</th>
                    <th colspan="2">NS</th>
                    <th colspan="2">SHIFT 1</th>
                    <th colspan="2">SHIFT 2</th>
                    <th colspan="2">SHIFT 3</th>
                    <th colspan="2">GRAND TOTAL</th>
                </tr>
                <tr>
                    <th>M</th>
                    <th>TM</th>
                    <th>M</th>
                    <th>TM</th>
                    <th>M</th>
                    <th>TM</th>
                    <th>M</th>
                    <th>TM</th>
                    <th>TM</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dkpharian as $dh => $value) : ?>
                <tr>
                    <td><?= $dkpharian[$dh]['pembagian2_nama'] ?></td>
                    <td><?= $dkp = $dkpharian[$dh]['dkp'] ?></td>
                    <?php $dkp2 = $dkp2 + $dkp; ?>
                    <td><?= $libur = $dkpharian[$dh]['sh0'] ?></td>
                    <td><?= $dkpmnssl = $dkpmasuk[$dh]['ns1'] ?></td>
                    <?php $dkpmnssl2 = $dkpmnssl2 + $dkpmnssl ?>
                    <td><?= $tmns1 = $dkpharian[$dh]['ns1'] - $dkpmasuk[$dh]['ns1'] ?></td>
                    <?php $tmns12 = $tmns12 + $tmns1; ?>
                    <td><?= $dkpshs = $dkpmasuk[$dh]['sh1'] ?></td>
                    <?php $dkpshs2 = $dkpshs2 + $dkpshs; ?>
                    <td><?= $tmsh1 = $dkpharian[$dh]['sh1'] - $dkpmasuk[$dh]['sh1'] ?></td>
                    <?php $tmsh12 = $tmsh12 + $tmsh1; ?>
                    <td><?= $dkpshd = $dkpmasuk[$dh]['sh2'] ?></td>
                    <?php $dkpshd2 = $dkpshd2 + $dkpshd ?>
                    <td><?= $tmsh2 = $dkpharian[$dh]['sh2'] - $dkpmasuk[$dh]['sh2'] ?></td>
                    <?php $tmsh22 = $tmsh22 + $tmsh2; ?>
                    <td><?= $dkpsht = $dkpmasuk[$dh]['sh3'] ?></td>
                    <?php $dkpsht2 = $dkpsht2 + $dkpsht ?>
                    <td><?= $tmsh3 = $dkpharian[$dh]['sh3'] - $dkpmasuk[$dh]['sh3'] ?></td>
                    <?php $tmsh32 = $tmsh32 + $tmsh3; ?>
                    <td><?= $tmnsa = $tmns1 + $tmns2 + $tmsh1 + $tmsh2 + $tmsh3 ?></td>
                    <?php $tmnsa2 = $tmnsa2 + $tmnsa  ?>
                    <td><?= ceil((($tmns1 + $tmns2 + $tmsh1 + $tmsh2 + $tmsh3) / ($dkp - $libur)) * 100) ?>%</td>
                </tr>
                <?php endforeach ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>TOTAL</td>
                    <td><?= $dkp2 ?></td>
                    <td></td>
                    <td><?= $dkpmnssl2 ?></td>
                    <td><?= $tmns12 ?></td>
                    <td><?= $dkpshs2 ?></td>
                    <td><?= $tmsh12 ?></td>
                    <td><?= $dkpshd2 ?></td>
                    <td><?= $tmsh22 ?></td>
                    <td><?= $dkpsht2 ?></td>
                    <td><?= $tmsh32 ?></td>
                    <td><?= $tmnsa2 ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>