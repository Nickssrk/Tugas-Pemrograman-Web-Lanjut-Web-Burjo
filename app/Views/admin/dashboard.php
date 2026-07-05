<?= $this->extend('layout/admin') ?>
<?= $this->section('content') ?>

<?php if ($pesananMenunggu > 0) : ?>
<div class="alert" style="background:#fef3e2;border-left:4px solid var(--burjo-amber);color:var(--burjo-coffee);border-radius:var(--radius);margin-bottom:1.5rem;">
    Ada <strong><?= $pesananMenunggu ?></strong> pesanan menunggu konfirmasi &mdash;
    <a href="<?= base_url('admin/pesanan?status=menunggu') ?>" style="color:var(--burjo-amber-dark);font-weight:700;">Lihat sekarang &rarr;</a>
</div>
<?php endif; ?>

<h6 class="mb-3" style="color:#aaa;font-size:.78rem;letter-spacing:.08em;text-transform:uppercase;font-weight:700;">Statistik Menu</h6>
<div class="row g-4 mb-5">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon stat-icon-menu">Menu</div>
            <div class="stat-number"><?= $totalMenu ?></div>
            <div class="stat-label">Total Menu</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon stat-icon-makanan">Mkn</div>
            <div class="stat-number"><?= $totalMakanan ?></div>
            <div class="stat-label">Makanan</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon stat-icon-minuman">Mim</div>
            <div class="stat-number"><?= $totalMinuman ?></div>
            <div class="stat-label">Minuman</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon stat-icon-habis">!</div>
            <div class="stat-number"><?= $totalHabis ?></div>
            <div class="stat-label">Stok Habis</div>
        </div>
    </div>
</div>

<h6 class="mb-3" style="color:#aaa;font-size:.78rem;letter-spacing:.08em;text-transform:uppercase;font-weight:700;">Statistik Pesanan</h6>
<div class="row g-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon stat-icon-menu">All</div>
            <div class="stat-number"><?= $totalPesanan ?></div>
            <div class="stat-label">Total Pesanan</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon stat-icon-makanan">Hari</div>
            <div class="stat-number"><?= $pesananHariIni ?></div>
            <div class="stat-label">Pesanan Hari Ini</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon stat-icon-habis">Tggu</div>
            <div class="stat-number"><?= $pesananMenunggu ?></div>
            <div class="stat-label">Menunggu Bayar</div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon stat-icon-lunas">OK</div>
            <div class="stat-number"><?= $pesananLunas ?></div>
            <div class="stat-label">Lunas</div>
        </div>
    </div>
</div>

<div class="mt-5 d-flex gap-3 flex-wrap">
    <a href="<?= base_url('admin/menu') ?>" class="btn btn-burjo">Kelola Menu</a>
    <a href="<?= base_url('admin/pesanan') ?>" class="btn btn-burjo" style="background:var(--burjo-coffee);">Lihat Pesanan</a>
    <a href="<?= base_url('admin/pesanan/qr-warung') ?>" class="btn btn-burjo" style="background:#6c757d;">QR Meja</a>
</div>

<?= $this->endSection() ?>
