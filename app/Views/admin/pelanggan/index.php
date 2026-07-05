<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <form class="d-flex gap-2" method="get">
        <input type="text" name="q" value="<?= esc($q ?? '') ?>"
               placeholder="Cari nama / no HP / email..."
               class="form-control form-control-sm" style="width:260px;">
        <button type="submit" class="btn btn-sm btn-secondary">Cari</button>
        <?php if ($q) : ?>
            <a href="<?= base_url('admin/pelanggan') ?>" class="btn btn-sm btn-outline-secondary">Reset</a>
        <?php endif; ?>
    </form>
    <a href="<?= base_url('admin/pelanggan/create') ?>" class="btn-burjo" style="text-decoration:none;padding:.45rem 1.1rem;font-size:.85rem;">
        + Tambah Pelanggan
    </a>
</div>

<div class="table-card">
    <?php if (empty($pelanggans)) : ?>
        <p class="text-center text-muted py-5">Belum ada data pelanggan.</p>
    <?php else : ?>
    <div class="table-responsive">
        <table class="table-burjo">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pelanggans as $i => $p) : ?>
                <tr>
                    <td class="text-muted"><?= $i + 1 ?></td>
                    <td><?= esc($p['nama']) ?></td>
                    <td><?= esc($p['no_hp']) ?></td>
                    <td><?= $p['email'] ? esc($p['email']) : '<span class="text-muted">—</span>' ?></td>
                    <td><?= $p['alamat'] ? esc(substr($p['alamat'], 0, 40)) . '...' : '<span class="text-muted">—</span>' ?></td>
                    <td class="text-center">
                        <a href="<?= base_url('admin/pelanggan/edit/' . $p['id']) ?>"
                           class="btn btn-sm" style="border:1px solid var(--burjo-border);border-radius:20px;font-size:.78rem;color:var(--burjo-coffee);padding:.25rem .75rem;">
                            Edit
                        </a>
                        <a href="<?= base_url('admin/pelanggan/delete/' . $p['id']) ?>"
                           class="btn btn-sm btn-danger"
                           style="border-radius:20px;font-size:.78rem;padding:.25rem .75rem;"
                           onclick="return confirm('Hapus pelanggan <?= esc($p['nama']) ?>?')">
                            Hapus
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-3 d-flex justify-content-end">
        <?= $pager->links() ?>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>