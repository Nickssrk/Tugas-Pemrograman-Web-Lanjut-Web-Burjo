<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="form-card">
    <form action="<?= base_url('admin/menu/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Nama Menu</label>
            <input type="text" name="nama" class="form-control" value="<?= old('nama') ?>" placeholder="Contoh: Indomie Goreng Telur" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-select" required>
                    <option value="makanan" <?= old('kategori') === 'makanan' ? 'selected' : '' ?>>Makanan</option>
                    <option value="minuman" <?= old('kategori') === 'minuman' ? 'selected' : '' ?>>Minuman</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="harga" class="form-control" min="0" step="500" value="<?= old('harga') ?>" placeholder="8000" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi <span class="text-muted">(opsional)</span></label>
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi singkat menu..."><?= old('deskripsi') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar <span class="text-muted">(opsional, maks. 2MB)</span></label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>

        <div class="mb-4">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="tersedia" <?= old('status') === 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                <option value="habis" <?= old('status') === 'habis' ? 'selected' : '' ?>>Habis</option>
            </select>
        </div>

        <button type="submit" class="btn btn-burjo">Simpan Menu</button>
        <a href="<?= base_url('admin/menu') ?>" class="btn btn-outline-secondary">Batal</a>
    </form>
</div>

<?= $this->endSection() ?>
