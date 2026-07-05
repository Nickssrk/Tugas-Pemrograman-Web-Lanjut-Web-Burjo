<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="pesan-intro">
    <div class="container">
        <h1>Pesan Menu</h1>
        <p>Pilih menu favoritmu, isi nama, dan pesan sekarang.</p>
    </div>
    <div class="gingham-strip"></div>
</div>

<section class="section-pesan">
    <div class="container">

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger mb-4"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')) : ?>
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                        <li><?= esc($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('pesan/checkout') ?>" method="post" id="formPesan">
            <?= csrf_field() ?>

            <!-- Info Pelanggan -->
            <div class="form-pesan-wrap mb-4">
                <h5 class="mb-3" style="color:var(--burjo-coffee);font-family:'Poppins',sans-serif;">Informasi Pemesan</h5>
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Nama Pemesan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_pemesan" class="form-control" placeholder="Contoh: Budi" value="<?= old('nama_pemesan') ?>" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nomor Meja <small class="text-muted">(opsional)</small></label>
                        <input type="text" name="nomor_meja" class="form-control" placeholder="Contoh: 3" value="<?= old('nomor_meja') ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Catatan <small class="text-muted">(opsional)</small></label>
                        <input type="text" name="catatan" class="form-control" placeholder="Contoh: tidak pakai pedas" value="<?= old('catatan') ?>">
                    </div>
                </div>
            </div>

            <!-- Menu Makanan -->
            <?php if (!empty($makanan)) : ?>
            <h4 class="section-title" id="makanan">Makanan</h4>
            <div class="row g-3 mb-5">
                <?php foreach ($makanan as $item) : ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="menu-pesan-card <?= $item['status'] === 'habis' ? 'habis' : '' ?>">
                        <div class="card-thumb">
                            <?php if ($item['gambar'] && file_exists(FCPATH . 'assets/uploads/menu/' . $item['gambar'])) : ?>
                                <img src="<?= base_url('assets/uploads/menu/' . esc($item['gambar'])) ?>" alt="<?= esc($item['nama']) ?>">
                            <?php else : ?>
                                <div class="thumb-placeholder thumb-makanan-sm">Mkn</div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body-pesan">
                            <div class="card-nama"><?= esc($item['nama']) ?></div>
                            <div class="card-harga">Rp <?= number_format($item['harga'], 0, ',', '.') ?></div>
                            <?php if ($item['status'] === 'habis') : ?>
                                <span class="badge bg-secondary">Habis</span>
                            <?php else : ?>
                                <div class="qty-control">
                                    <button type="button" class="qty-btn" onclick="changeQty(this, -1)">&minus;</button>
                                    <input type="number"
                                           name="qty[<?= $item['id'] ?>]"
                                           class="qty-input"
                                           value="0" min="0" max="20"
                                           data-price="<?= $item['harga'] ?>"
                                           data-name="<?= esc($item['nama']) ?>"
                                           onchange="updateSummary()">
                                    <button type="button" class="qty-btn" onclick="changeQty(this, 1)">+</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Menu Minuman -->
            <?php if (!empty($minuman)) : ?>
            <h4 class="section-title" id="minuman">Minuman</h4>
            <div class="row g-3 mb-5">
                <?php foreach ($minuman as $item) : ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="menu-pesan-card <?= $item['status'] === 'habis' ? 'habis' : '' ?>">
                        <div class="card-thumb">
                            <?php if ($item['gambar'] && file_exists(FCPATH . 'assets/uploads/menu/' . $item['gambar'])) : ?>
                                <img src="<?= base_url('assets/uploads/menu/' . esc($item['gambar'])) ?>" alt="<?= esc($item['nama']) ?>">
                            <?php else : ?>
                                <div class="thumb-placeholder thumb-minuman-sm">Mim</div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body-pesan">
                            <div class="card-nama"><?= esc($item['nama']) ?></div>
                            <div class="card-harga">Rp <?= number_format($item['harga'], 0, ',', '.') ?></div>
                            <?php if ($item['status'] === 'habis') : ?>
                                <span class="badge bg-secondary">Habis</span>
                            <?php else : ?>
                                <div class="qty-control">
                                    <button type="button" class="qty-btn" onclick="changeQty(this, -1)">&minus;</button>
                                    <input type="number"
                                           name="qty[<?= $item['id'] ?>]"
                                           class="qty-input"
                                           value="0" min="0" max="20"
                                           data-price="<?= $item['harga'] ?>"
                                           data-name="<?= esc($item['nama']) ?>"
                                           onchange="updateSummary()">
                                    <button type="button" class="qty-btn" onclick="changeQty(this, 1)">+</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Sticky order summary bar -->
            <div id="orderSummaryBar" class="order-summary-bar" style="display:none;">
                <div class="summary-info">
                    <span class="summary-count" id="summaryCount">0 item</span>
                    <span class="summary-total" id="summaryTotal">Rp 0</span>
                </div>
                <button type="submit" class="btn-pesan">Pesan Sekarang &rarr;</button>
            </div>

        </form>
    </div>
</section>

<script>
function changeQty(btn, delta) {
    const input = btn.parentNode.querySelector('.qty-input');
    const current = parseInt(input.value) || 0;
    input.value = Math.max(0, Math.min(20, current + delta));
    updateSummary();
}

function updateSummary() {
    let total = 0, count = 0;
    document.querySelectorAll('.qty-input').forEach(input => {
        const qty   = parseInt(input.value) || 0;
        const price = parseInt(input.dataset.price) || 0;
        total += qty * price;
        count += qty;
    });

    document.getElementById('summaryCount').textContent = count + ' item dipilih';
    document.getElementById('summaryTotal').textContent =
        'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('orderSummaryBar').style.display = count > 0 ? 'flex' : 'none';
}
</script>

<?= $this->endSection() ?>
