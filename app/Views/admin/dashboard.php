<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<div class="row g-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon">🍽️</div>
            <div class="stat-number"><?= $totalMenu ?></div>
            <div class="stat-label">Total Menu</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon">🍛</div>
            <div class="stat-number"><?= $totalMakanan ?></div>
            <div class="stat-label">Makanan</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon">🥤</div>
            <div class="stat-number"><?= $totalMinuman ?></div>
            <div class="stat-label">Minuman</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon">⚠️</div>
            <div class="stat-number"><?= $totalHabis ?></div>
            <div class="stat-label">Stok Habis</div>
        </div>
    </div>
</div>

<div class="mt-5">
    <a href="<?= base_url('admin/menu') ?>" class="btn btn-burjo">Kelola Menu &rarr;</a>
</div>

<?= $this->endSection() ?>
