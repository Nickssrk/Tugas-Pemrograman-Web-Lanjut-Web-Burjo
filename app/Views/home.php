<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<section class="hero-burjo">
    <div class="container py-5 text-center">
        <span class="eyebrow">Buka tiap hari &middot; 24 jam</span>
        <h1 class="display-6 fw-bold mb-2 mt-2">Selamat Datang di Warung Burjo Barokah</h1>
        <p class="lead text-muted mb-4">Tempat nongkrong santai dengan indomie, nasi, dan minuman hangat favoritmu.</p>
        <div class="search-box mx-auto">
            <input type="text" id="searchMenu" class="form-control" placeholder="Cari menu favoritmu...">
        </div>
    </div>
</section>

<div class="container py-5">

    <div id="makanan" class="menu-section mb-5">
        <h2 class="section-title mb-4">Makanan</h2>
        <?php if (empty($makanan)) : ?>
            <p class="text-muted">Belum ada menu makanan.</p>
        <?php else : ?>
            <div class="row g-4">
                <?php foreach ($makanan as $item) : ?>
                    <div class="col-md-4 menu-item" data-name="<?= esc(strtolower($item['nama'])) ?>">
                        <div class="card menu-card h-100">
                            <div class="menu-thumb">
                                <?php if (! empty($item['gambar'])) : ?>
                                    <img src="<?= base_url('assets/uploads/menu/' . $item['gambar']) ?>" alt="<?= esc($item['nama']) ?>">
                                <?php else : ?>
                                    <span class="thumb-icon thumb-makanan">M</span>
                                <?php endif; ?>
                                <?php if ($item['status'] === 'habis') : ?>
                                    <span class="badge-habis">Habis</span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-1"><?= esc($item['nama']) ?></h5>
                                <p class="price mb-2">Rp <?= number_format((float) $item['harga'], 0, ',', '.') ?></p>
                                <?php if (! empty($item['deskripsi'])) : ?>
                                    <p class="card-text text-muted small mb-2"><?= esc($item['deskripsi']) ?></p>
                                <?php endif; ?>
                                <?php if ($item['status'] !== 'habis') : ?>
                                <form action="<?= base_url('cart/insert') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="menu_id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit" class="btn-tambah-cart w-100">+ Tambah ke Pesanan</button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div id="minuman" class="menu-section">
        <h2 class="section-title mb-4">Minuman</h2>
        <?php if (empty($minuman)) : ?>
            <p class="text-muted">Belum ada menu minuman.</p>
        <?php else : ?>
            <div class="row g-4">
                <?php foreach ($minuman as $item) : ?>
                    <div class="col-md-4 menu-item" data-name="<?= esc(strtolower($item['nama'])) ?>">
                        <div class="card menu-card h-100">
                            <div class="menu-thumb">
                                <?php if (! empty($item['gambar'])) : ?>
                                    <img src="<?= base_url('assets/uploads/menu/' . $item['gambar']) ?>" alt="<?= esc($item['nama']) ?>">
                                <?php else : ?>
                                    <span class="thumb-icon thumb-minuman">M</span>
                                <?php endif; ?>
                                <?php if ($item['status'] === 'habis') : ?>
                                    <span class="badge-habis">Habis</span>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-1"><?= esc($item['nama']) ?></h5>
                                <p class="price mb-2">Rp <?= number_format((float) $item['harga'], 0, ',', '.') ?></p>
                                <?php if (! empty($item['deskripsi'])) : ?>
                                    <p class="card-text text-muted small mb-2"><?= esc($item['deskripsi']) ?></p>
                                <?php endif; ?>
                                <?php if ($item['status'] !== 'habis') : ?>
                                <form action="<?= base_url('cart/insert') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="menu_id" value="<?= $item['id'] ?>">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit" class="btn-tambah-cart w-100">+ Tambah ke Pesanan</button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<script>
document.getElementById('searchMenu').addEventListener('input', function (e) {
    var keyword = e.target.value.toLowerCase();
    document.querySelectorAll('.menu-item').forEach(function (el) {
        el.style.display = el.dataset.name.indexOf(keyword) !== -1 ? '' : 'none';
    });
});
</script>

<?= $this->endSection() ?>
