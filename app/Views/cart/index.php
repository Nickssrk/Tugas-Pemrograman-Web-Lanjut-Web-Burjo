<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<section class="section-pesan">
    <div class="container" style="max-width:700px;">

        <h2 style="font-family:'Poppins',sans-serif;color:var(--burjo-coffee);margin-bottom:1.5rem;">
            🛒 Keranjang Belanja
        </h2>

        <?php if (empty($items)) : ?>
            <div class="text-center py-5">
                <div style="font-size:3rem;">🛒</div>
                <p class="text-muted mt-2">Keranjang masih kosong.</p>
                <a href="<?= base_url('pesan') ?>" class="btn-burjo" style="text-decoration:none;margin-top:1rem;display:inline-block;">
                    Lihat Menu
                </a>
            </div>
        <?php else : ?>

            <div class="table-card">
                <table class="table-burjo">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) : ?>
                        <tr>
                            <td><?= esc($item['nama']) ?></td>
                            <td class="text-center">
                                <form action="<?= base_url('cart/update') ?>" method="post" class="d-flex align-items-center justify-content-center gap-1">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="menu_id" value="<?= $item['id'] ?>">
                                    <input type="number" name="jumlah" value="<?= $item['jumlah'] ?>"
                                           min="1" max="99" class="qty-input"
                                           onchange="this.form.submit()">
                                </form>
                            </td>
                            <td class="text-end text-muted">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                            <td class="text-end fw-bold">Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('cart/remove/' . $item['id']) ?>"
                                   onclick="return confirm('Hapus item ini?')"
                                   style="color:var(--burjo-red);font-size:.85rem;">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold" style="color:var(--burjo-coffee);">
                                Total
                            </td>
                            <td class="text-end fw-bold" style="color:var(--burjo-amber);font-size:1.1rem;">
                                Rp <?= number_format($total, 0, ',', '.') ?>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-4 flex-wrap gap-2">
                <a href="<?= base_url('cart/destroy') ?>"
                   onclick="return confirm('Kosongkan semua keranjang?')"
                   class="btn btn-sm btn-outline-danger" style="border-radius:20px;">
                    🗑️ Kosongkan Keranjang
                </a>
                <a href="<?= base_url('pesan') ?>" class="btn-burjo" style="text-decoration:none;">
                    Lanjut Pesan →
                </a>
            </div>

        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>