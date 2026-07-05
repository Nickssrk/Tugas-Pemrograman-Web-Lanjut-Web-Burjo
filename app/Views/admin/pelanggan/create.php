<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="form-card">
    <form action="<?= base_url('admin/pelanggan/store') ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
            <input type="text" name="nama" value="<?= old('nama') ?>"
                   class="form-control" placeholder="cth: Budi Santoso">
        </div>

        <div class="mb-3">
            <label class="form-label">No. HP <span class="text-danger">*</span></label>
            <input type="text" name="no_hp" value="<?= old('no_hp') ?>"
                   class="form-control" placeholder="cth: 081234567890">
        </div>

        <div class="mb-3">
            <label class="form-label">Email <small class="text-muted">(opsional)</small></label>
            <input type="email" name="email" value="<?= old('email') ?>"
                   class="form-control" placeholder="cth: budi@email.com">
        </div>

        <div class="mb-4">
            <label class="form-label">Alamat <small class="text-muted">(opsional)</small></label>
            <textarea name="alamat" class="form-control" rows="3"
                      placeholder="Alamat lengkap pelanggan"><?= old('alamat') ?></textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-burjo">Simpan</button>
            <a href="<?= base_url('admin/pelanggan') ?>"
               style="padding:.55rem 1.4rem;border-radius:50px;border:1px solid var(--burjo-border);color:var(--burjo-coffee);text-decoration:none;font-weight:600;">
                Batal
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>