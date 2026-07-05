<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Menu Warung Burjo</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; color: #2c2c2c; margin: 30px; }
        h1 { text-align: center; font-size: 18px; color: #3b2417; margin-bottom: 4px; }
        .subtitle { text-align: center; font-size: 11px; color: #888; margin-bottom: 20px; }
        h2 { font-size: 14px; color: #3b2417; border-bottom: 2px solid #d97b2b; padding-bottom: 4px; margin-top: 24px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead tr { background-color: #3b2417; color: #fff; }
        th, td { padding: 8px 10px; text-align: left; border: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #fdf6ec; }
        .badge { padding: 2px 8px; border-radius: 10px; font-size: 11px; }
        .tersedia { background: #d4edda; color: #155724; }
        .habis { background: #f8d7da; color: #721c24; }
        .footer { text-align: center; font-size: 10px; color: #aaa; margin-top: 30px; }
    </style>
</head>
<body>

    <h1>Warung Burjo Barokah</h1>
    <p class="subtitle">Daftar Menu &mdash; Dicetak pada <?= $tanggal ?></p>

    <h2>Makanan</h2>
    <?php if (empty($makanan)) : ?>
        <p>Tidak ada data makanan.</p>
    <?php else : ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Menu</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($makanan as $i => $item) : ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($item['nama']) ?></td>
                <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                <td>
                    <span class="badge <?= $item['status'] ?>">
                        <?= ucfirst($item['status']) ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <h2>Minuman</h2>
    <?php if (empty($minuman)) : ?>
        <p>Tidak ada data minuman.</p>
    <?php else : ?>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Menu</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($minuman as $i => $item) : ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($item['nama']) ?></td>
                <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                <td>
                    <span class="badge <?= $item['status'] ?>">
                        <?= ucfirst($item['status']) ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <p class="footer">&copy; <?= date('Y') ?> Warung Burjo Barokah</p>

</body>
</html>
