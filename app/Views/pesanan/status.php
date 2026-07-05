<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<section class="status-page">
    <div class="container">

        <?php
        $statusLabel = [
            'menunggu' => 'Menunggu Dikonfirmasi',
            'diproses' => 'Sedang Diproses',
            'selesai'  => 'Siap Diambil',
            'lunas'    => 'Sudah Lunas',
        ];
        $statusClass = [
            'menunggu' => 'badge-menunggu',
            'diproses' => 'badge-diproses',
            'selesai'  => 'badge-selesai',
            'lunas'    => 'badge-lunas',
        ];
        $s = $order['status'];
        ?>

        <div class="status-card">

            <div class="text-center mb-4">
                <div style="font-size:.85rem;color:#888;margin-bottom:.5rem;">Kode Pesanan</div>
                <div class="kode-order"><?= esc($order['kode_order']) ?></div>
                <div class="mt-2">
                    <span class="badge-status-order <?= $statusClass[$s] ?? '' ?>">
                        <?= $statusLabel[$s] ?? $s ?>
                    </span>
                </div>
            </div>

            <div class="mb-3" style="font-size:.9rem;color:#666;">
                <strong style="color:var(--burjo-coffee);"><?= esc($order['nama_pemesan']) ?></strong>
                <?php if ($order['nomor_meja']) : ?>
                    &nbsp;&middot;&nbsp; Meja <?= esc($order['nomor_meja']) ?>
                <?php endif; ?>
                <?php if ($order['catatan']) : ?>
                    <br><span><?= esc($order['catatan']) ?></span>
                <?php endif; ?>
            </div>

            <table class="table table-sm mb-3" style="font-size:.9rem;">
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
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-end fw-bold" style="color:var(--burjo-coffee);">Total</td>
                        <td class="text-end fw-bold" style="color:var(--burjo-amber);font-size:1.05rem;">
                            Rp <?= number_format($order['total_harga'], 0, ',', '.') ?>
                        </td>
                    </tr>
                </tfoot>
            </table>

            <?php if ($order['status'] !== 'lunas') : ?>
            <div class="qr-wrapper">
                <div style="font-weight:700;color:var(--burjo-coffee);margin-bottom:1rem;font-family:'Poppins',sans-serif;">
                    Kode Pembayaran
                </div>
                <div id="qrcode"></div>
                <p class="qr-caption">
                    Tunjukkan QR code ini ke kasir untuk konfirmasi pembayaran.
                </p>
            </div>

            <div class="text-center mt-3">
                <a href="<?= base_url('pesan/status/' . $order['kode_order']) ?>"
                   class="btn btn-sm"
                   style="background:var(--burjo-cream);color:var(--burjo-coffee);border-radius:20px;padding:.4rem 1.2rem;font-size:.85rem;">
                    Perbarui Status
                </a>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
            <script>
            new QRCode(document.getElementById("qrcode"), {
                text: "<?= base_url('bayar/' . $order['kode_order']) ?>",
                width: 200,
                height: 200,
                colorDark: "#3b2417",
                colorLight: "#fbf3e7",
                correctLevel: QRCode.CorrectLevel.H
            });
            </script>

            <?php else : ?>
            <div class="text-center py-3">
                <div style="width:60px;height:60px;background:var(--burjo-amber);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-weight:700;color:#fff;font-size:1.3rem;font-family:'Poppins',sans-serif;">OK</div>
                <div style="font-family:'Poppins',sans-serif;font-weight:700;color:var(--burjo-coffee);font-size:1.2rem;">
                    Pembayaran Dikonfirmasi
                </div>
                <p style="color:#888;font-size:.9rem;margin-top:.5rem;">
                    Terima kasih sudah memesan di Warung Burjo Barokah.
                </p>
                <a href="<?= base_url('/') ?>" class="btn-burjo" style="display:inline-block;margin-top:1rem;text-decoration:none;padding:.65rem 1.5rem;border-radius:30px;">
                    Kembali ke Menu
                </a>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?= $this->endSection() ?>
