<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="form-card">
    <form action="<?= base_url('admin/menu/update/' . $menu['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Nama Menu</label>
            <input type="text" name="nama" class="form-control" value="<?= old('nama', $menu['nama']) ?>" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select" required>
                    <option value="makanan" <?= old('kategori', $menu['kategori']) === 'makanan' ? 'selected' : '' ?>>Makanan</option>
                    <option value="minuman" <?= old('kategori', $menu['kategori']) === 'minuman' ? 'selected' : '' ?>>Minuman</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" class="form-control" min="0" step="500" value="<?= old('harga', $menu['harga']) ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi <span class="text-muted">(opsional)</span></label>
            <textarea name="deskripsi" class="form-control" rows="3"><?= old('deskripsi', $menu['deskripsi']) ?></textarea>
        </div>

        <?php if (! empty($menu['gambar'])) : ?>
            <div class="mb-3">
                <label class="form-label d-block">Gambar Saat Ini</label>
                <img src="<?= base_url('assets/uploads/menu/' . $menu['gambar']) ?>" class="current-image" alt="<?= esc($menu['nama']) ?>">
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label">Ganti Gambar <span class="text-muted">(opsional, maks. 2MB)</span></label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>

        <div class="mb-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="tersedia" <?= old('status', $menu['status']) === 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                <option value="habis" <?= old('status', $menu['status']) === 'habis' ? 'selected' : '' ?>>Habis</option>
            </select>
        </div>

        <button type="submit" class="btn btn-burjo">Update Menu</button>
        <a href="<?= base_url('admin/menu') ?>" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>

<?= $this->endSection() ?>
