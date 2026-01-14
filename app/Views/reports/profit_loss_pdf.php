<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 8px; border-bottom: 1px solid #ddd; }
        .bg-gray { background-color: #f2f2f2; font-weight: bold; }
        .text-right { text-align: right; }
        .text-danger { color: #dc3545; }
        .text-success { color: #28a745; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN LABA RUGI</h2>
        <p>Periode: <?= $periodName ?></p>
    </div>

    <table>
        <tr class="bg-gray"><td colspan="2">PENDAPATAN</td></tr>
        <?php foreach($revenues as $rev): if($rev['saldo'] != 0): ?>
        <tr>
            <td><?= $rev['nama_akun'] ?></td>
            <td class="text-right">Rp <?= number_format($rev['saldo'], 0, ',', '.') ?></td>
        </tr>
        <?php endif; endforeach; ?>
        <tr class="bg-gray">
            <td>TOTAL PENDAPATAN</td>
            <td class="text-right">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></td>
        </tr>
    </table>

    <table>
        <tr class="bg-gray"><td colspan="2">BEBAN USAHA</td></tr>
        <?php foreach($expenses as $exp): if($exp['saldo'] != 0): ?>
        <tr>
            <td><?= $exp['nama_akun'] ?></td>
            <td class="text-right">Rp <?= number_format($exp['saldo'], 0, ',', '.') ?></td>
        </tr>
        <?php endif; endforeach; ?>
        <tr class="bg-gray">
            <td>TOTAL BEBAN</td>
            <td class="text-right">Rp <?= number_format($totalExpense, 0, ',', '.') ?></td>
        </tr>
    </table>

    <div style="padding: 15px; border: 2px solid #333; text-align: center;">
        <h3 style="margin:0">
            <?= $netProfit >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' ?>: 
            <span class="<?= $netProfit >= 0 ? 'text-success' : 'text-danger' ?>">
                Rp <?= number_format(abs($netProfit), 0, ',', '.') ?>
            </span>
        </h3>
    </div>
</body>
</html>