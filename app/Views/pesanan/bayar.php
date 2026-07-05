<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Pembayaran') ?> &middot; Warung Burjo</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2220%22 fill=%22%233b2417%22/><text x=%2250%22 y=%2268%22 font-size=%2252%22 font-family=%22Arial,sans-serif%22 font-weight=%22bold%22 fill=%22%23d97b2b%22 text-anchor=%22middle%22>WB</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <text y=%22.9em%22 font-size=%2290%22>🍜</text></svg>">
</head>
<body style="background:var(--burjo-cream);">

<div class="bayar-page">
    <div class="bayar-card">

        <div class="bayar-header">
            <div class="bayar-brand">Warung Burjo Barokah</div>
            <div style="font-size:.8rem;color:#888;margin-top:.25rem;">Konfirmasi Pembayaran</div>
        </div>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success text-center">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <div class="text-center mb-3">
            <div style="font-size:.8rem;color:#888;">Kode Pesanan</div>
            <div class="kode-order" style="font-size:1.1rem;"><?= esc($order['kode_order']) ?></div>
            <div style="font-size:.9rem;color:#666;margin-top:.4rem;">
                <?= esc($order['nama_pemesan']) ?>
                <?php if ($order['nomor_meja']) : ?>
                    &nbsp;&middot;&nbsp; Meja <?= esc($order['nomor_meja']) ?>
                <?php endif; ?>
            </div>
        </div>

        <table class="table table-sm" style="font-size:.9rem;">
            <thead style="color:var(--burjo-coffee);font-weight:700;">
                <tr>
                    <th>Menu</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order['items'] as $item) : ?>
                <tr>
                    <td><?= esc($item['nama_menu']) ?></td>
                    <td class="text-center"><?= $item['jumlah'] ?>x</td>
                    <td class="text-end">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($sudahLunas) : ?>

            <div class="sudah-lunas">
                <div style="width:60px;height:60px;background:var(--burjo-amber);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;font-weight:700;color:#fff;font-size:1.1rem;font-family:'Poppins',sans-serif;">OK</div>
                <div style="font-family:'Poppins',sans-serif;font-weight:700;color:var(--burjo-coffee);font-size:1.1rem;">
                    Pembayaran Dikonfirmasi
                </div>
                <div class="bayar-total-wrap mt-3">
                    <div class="bayar-total-label">Total Pembayaran</div>
                    <div class="bayar-total-amount">Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></div>
                </div>
                <p style="color:#888;font-size:.85rem;margin-top:1rem;">
                    Transaksi ini sudah tercatat sebagai <strong>LUNAS</strong>.
                </p>
            </div>

        <?php else : ?>

            <div class="bayar-total-wrap">
                <div class="bayar-total-label">Total yang Harus Dibayar</div>
                <div class="bayar-total-amount">Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></div>
            </div>

            <?php if ($order['catatan']) : ?>
                <p style="font-size:.85rem;color:#888;text-align:center;margin-bottom:1rem;">
                    Catatan: <?= esc($order['catatan']) ?>
                </p>
            <?php endif; ?>

            <form action="<?= base_url('bayar/konfirmasi/' . $order['kode_order']) ?>" method="post">
                <?= csrf_field() ?>
                <button type="submit" class="btn-bayar">
                    Konfirmasi Pembayaran
                </button>
            </form>

        <?php endif; ?>

    </div>
</div>

</body>
</html>
