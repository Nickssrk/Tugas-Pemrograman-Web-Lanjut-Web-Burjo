<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="mb-4">
    <a href="<?= base_url('admin/pesanan') ?>"
       style="color:var(--burjo-amber-dark);text-decoration:none;font-size:.9rem;">
        ← Kembali ke Daftar Pesanan
    </a>
</div>

<?php
$statusLabel = [
    'menunggu' => '⏳ Menunggu',
    'diproses' => '👨‍🍳 Diproses',
    'selesai'  => '✅ Selesai',
    'lunas'    => '💚 Lunas',
];
?>

<div class="row g-4">

    <!-- Kiri: Info pesanan + tabel item + update status -->
    <div class="col-lg-7">
        <div class="table-card">

            <!-- Header kode & status -->
            <div class="detail-order-header">
                <div>
                    <div style="font-size:.78rem;color:#999;margin-bottom:.2rem;">Kode Pesanan</div>
                    <div class="kode-order-admin"><?= esc($order['kode_order']) ?></div>
                </div>
                <span class="badge-status-order badge-order-<?= esc($order['status']) ?>" style="font-size:.85rem;">
                    <?= $statusLabel[$order['status']] ?? esc($order['status']) ?>
                </span>
            </div>

            <!-- Meta info -->
            <div class="detail-order-meta">
                <span>👤 <?= esc($order['nama_pemesan']) ?></span>
                <?php if ($order['nomor_meja']) : ?>
                    <span>🪑 Meja <?= esc($order['nomor_meja']) ?></span>
                <?php endif; ?>
                <span>🕐 <?= date('d M Y, H:i', strtotime($order['created_at'])) ?></span>
            </div>

            <?php if ($order['catatan']) : ?>
            <div class="detail-order-catatan">
                📝 <?= esc($order['catatan']) ?>
            </div>
            <?php endif; ?>

            <!-- Tabel item pesanan -->
            <table class="table table-sm mt-4" style="font-size:.9rem;">
                <thead style="color:var(--burjo-coffee);font-weight:700;border-bottom:2px solid var(--burjo-border);">
                    <tr>
                        <th>Menu</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Harga</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order['items'] as $item) : ?>
                    <tr>
                        <td><?= esc($item['nama_menu']) ?></td>
                        <td class="text-center"><?= $item['jumlah'] ?>×</td>
                        <td class="text-end text-muted">Rp <?= number_format($item['harga_menu'], 0, ',', '.') ?></td>
                        <td class="text-end fw-bold">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot style="border-top:2px solid var(--burjo-border);">
                    <tr>
                        <td colspan="3" class="text-end fw-bold" style="color:var(--burjo-coffee);">
                            Total Pembayaran
                        </td>
                        <td class="text-end fw-bold" style="color:var(--burjo-amber);font-size:1.1rem;">
                            Rp <?= number_format($order['total_harga'], 0, ',', '.') ?>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!-- Update status -->
            <div class="detail-order-status-form">
                <label class="form-label" style="font-size:.88rem;">Update Status Pesanan</label>
                <form action="<?= base_url('admin/pesanan/update-status/' . $order['id']) ?>" method="post"
                      class="d-flex gap-2 flex-wrap">
                    <?= csrf_field() ?>
                    <select name="status" class="form-select form-select-sm" style="max-width:180px;">
                        <?php foreach (['menunggu', 'diproses', 'selesai', 'lunas'] as $st) : ?>
                        <option value="<?= $st ?>" <?= $order['status'] === $st ? 'selected' : '' ?>>
                            <?= ucfirst($st) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn-burjo" style="padding:.35rem 1.1rem;font-size:.88rem;">
                        Simpan
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- Kanan: QR Code pembayaran -->
    <div class="col-lg-5">
        <div class="table-card text-center">
            <div style="font-family:'Poppins',sans-serif;font-weight:700;color:var(--burjo-coffee);margin-bottom:1rem;font-size:1rem;">
                📲 QR Code Pembayaran
            </div>

            <?php if ($order['status'] === 'lunas') : ?>
                <div style="font-size:3.5rem;line-height:1;">💚</div>
                <p style="color:#666;font-size:.9rem;margin-top:.75rem;">
                    Pesanan ini sudah lunas.<br>Tidak perlu scan lagi.
                </p>
            <?php else : ?>
                <div id="qrcode" style="display:inline-block;margin-bottom:.75rem;"></div>
                <p style="font-size:.78rem;color:#888;margin:0;">
                    Tunjukkan / bagikan link ini ke pelanggan:<br>
                    <a href="<?= base_url('bayar/' . $order['kode_order']) ?>"
                       target="_blank"
                       style="color:var(--burjo-amber-dark);word-break:break-all;font-size:.78rem;">
                        <?= base_url('bayar/' . $order['kode_order']) ?>
                    </a>
                </p>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
                <script>
                new QRCode(document.getElementById("qrcode"), {
                    text: "<?= base_url('bayar/' . esc($order['kode_order'], 'js')) ?>",
                    width: 210, height: 210,
                    colorDark: "#3b2417",
                    colorLight: "#fbf3e7",
                    correctLevel: QRCode.CorrectLevel.H
                });
                </script>
            <?php endif; ?>

            <hr style="margin:1.25rem 0;border-color:var(--burjo-border);">
            <div style="font-size:.78rem;color:#aaa;">
                Pelanggan scan QR → buka halaman konfirmasi → tekan tombol bayar → status otomatis jadi <strong>Lunas</strong>.
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
