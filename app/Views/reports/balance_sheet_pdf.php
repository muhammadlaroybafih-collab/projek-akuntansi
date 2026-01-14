<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border-bottom: 1px solid #ddd; }
        .header { margin-bottom: 30px; }
        .section-title { background-color: #f4f4f4; font-weight: bold; }
        .total-row { background-color: #e9ecef; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header text-center">
        <h2 style="margin-bottom: 5px;">LAPORAN NERACA</h2>
        <div style="font-size: 14px;">Periode: <?= $periodName ?></div>
    </div>

    <table>
        <thead>
            <tr class="section-title">
                <th colspan="2" style="text-align: left;">AKTIVA (ASET)</th>
            </tr>
        </thead>
        <tbody>
            <?php $totalA = 0; foreach($assets as $a): ?>
            <tr>
                <td>[<?= $a['kode_akun'] ?>] <?= $a['nama_akun'] ?></td>
                <td class="text-right">Rp <?= number_format($a['saldo_akhir'], 0, ',', '.') ?></td>
            </tr>
            <?php $totalA += $a['saldo_akhir']; endforeach; ?>
            <tr class="total-row">
                <td>TOTAL AKTIVA</td>
                <td class="text-right">Rp <?= number_format($totalA, 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr class="section-title">
                <th colspan="2" style="text-align: left;">PASIVA (LIABILITAS & EKUITAS)</th>
            </tr>
        </thead>
        <tbody>
            <?php $totalP = 0; foreach($liabilities as $l): ?>
            <tr>
                <td>[<?= $l['kode_akun'] ?>] <?= $l['nama_akun'] ?></td>
                <td class="text-right">Rp <?= number_format($l['saldo_akhir'], 0, ',', '.') ?></td>
            </tr>
            <?php $totalP += $l['saldo_akhir']; endforeach; ?>

            <?php foreach($equity as $e): ?>
            <tr>
                <td>[<?= $e['kode_akun'] ?>] <?= $e['nama_akun'] ?></td>
                <td class="text-right">Rp <?= number_format($e['saldo_akhir'], 0, ',', '.') ?></td>
            </tr>
            <?php $totalP += $e['saldo_akhir']; endforeach; ?>
            
            <tr>
                <td style="font-style: italic;">Laba Periode Berjalan</td>
                <td class="text-right">Rp <?= number_format($laba_berjalan, 0, ',', '.') ?></td>
            </tr>
            <?php $totalP += $laba_berjalan; ?>

            <tr class="total-row">
                <td>TOTAL PASIVA</td>
                <td class="text-right">Rp <?= number_format($totalP, 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <p>Dicetak pada: <?= date('d/m/Y H:i') ?></p>
        <br><br><br>
        <p>( ____________________ )</p>
    </div>
</body>
</html>