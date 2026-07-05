<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="form-card">
    <form action="<?= base_url('admin/pelanggan/update/' . $pelanggan['id']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Nama Pelanggan <span class="text-danger">*</span></label>
            <input type="text" name="nama"
                   value="<?= old('nama', $pelanggan['nama']) ?>"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">No. HP <span class="text-danger">*</span></label>
            <input type="text" name="no_hp"
                   value="<?= old('no_hp', $pelanggan['no_hp']) ?>"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Email <small class="text-muted">(opsional)</small></label>
            <input type="email" name="email"
                   value="<?= old('email', $pelanggan['email']) ?>"
                   class="form-control">
        </div>

        <div class="mb-4">
            <label class="form-label">Alamat <small class="text-muted">(opsional)</small></label>
            <textarea name="alamat" class="form-control" rows="3"><?= old('alamat', $pelanggan['alamat']) ?></textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-burjo">Perbarui</button>
            <a href="<?= base_url('admin/pelanggan') ?>"
               style="padding:.55rem 1.4rem;border-radius:50px;border:1px solid var(--burjo-border);color:var(--burjo-coffee);text-decoration:none;font-weight:600;">
                Batal
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>