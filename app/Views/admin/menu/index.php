<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <form class="d-flex gap-2 flex-wrap" method="get" action="<?= base_url('admin/menu') ?>">
        <input type="text" name="q" class="form-control" placeholder="Cari nama menu..." value="<?= esc($keyword ?? '') ?>">
        <select name="kategori" class="form-select">
            <option value="">Semua Kategori</option>
            <option value="makanan" <?= ($kategori ?? '') === 'makanan' ? 'selected' : '' ?>>Makanan</option>
            <option value="minuman" <?= ($kategori ?? '') === 'minuman' ? 'selected' : '' ?>>Minuman</option>
        </select>
        <button type="submit" class="btn btn-outline-secondary">Cari</button>
    </form>
    <a href="<?= base_url('admin/menu/create') ?>" class="btn btn-burjo">+ Tambah Menu</a>
    <a href="<?= base_url('admin/menu/export-pdf') ?>" 
   class="btn btn-sm btn-danger" 
   style="border-radius:20px;font-size:.85rem;">
    📄 Export PDF
</a>
</div>

<div class="table-card">
    <div class="table-responsive">
        <table class="table table-burjo align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Gambar</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($menus)) : ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data menu. Klik &ldquo;+ Tambah Menu&rdquo; untuk menambahkan.</td>
                    </tr>
                <?php else : ?>
                    <?php $no = 1; foreach ($menus as $menu) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?php if (! empty($menu['gambar'])) : ?>
                                    <img src="<?= base_url('assets/uploads/menu/' . $menu['gambar']) ?>" class="table-thumb" alt="<?= esc($menu['nama']) ?>">
                                <?php else : ?>
                                    <span class="table-thumb-icon"><?= $menu['kategori'] === 'makanan' ? '🍛' : '🥤' ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($menu['nama']) ?></td>
                            <td><span class="badge-kategori badge-<?= esc($menu['kategori']) ?>"><?= ucfirst($menu['kategori']) ?></span></td>
                            <td>Rp <?= number_format((float) $menu['harga'], 0, ',', '.') ?></td>
                            <td><span class="badge-status badge-<?= esc($menu['status']) ?>"><?= ucfirst($menu['status']) ?></span></td>
                            <td class="text-center text-nowrap">
                                <a href="<?= base_url('admin/menu/edit/' . $menu['id']) ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <a href="<?= base_url('admin/menu/delete/' . $menu['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus menu \'<?= esc($menu['nama'], 'js') ?>\'?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    <?= $pager->links() ?>
</div>

<?= $this->endSection() ?>
