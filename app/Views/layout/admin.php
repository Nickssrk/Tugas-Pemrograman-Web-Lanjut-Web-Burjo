<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin') ?> &middot; Warung Burjo</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2220%22 fill=%22%233b2417%22/><text x=%2250%22 y=%2268%22 font-size=%2252%22 font-family=%22Arial,sans-serif%22 font-weight=%22bold%22 fill=%22%23d97b2b%22 text-anchor=%22middle%22>WB</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <text y=%22.9em%22 font-size=%2290%22></text></svg>">
</head>
<body class="admin-body">

<div class="admin-wrapper">
    <aside class="admin-sidebar">
        <div class="sidebar-brand">Burjo Admin</div>
        <nav class="sidebar-nav">
            <a href="<?= base_url('admin/dashboard') ?>" class="<?= (uri_string() === 'admin/dashboard' || uri_string() === 'admin') ? 'active' : '' ?>">Dashboard</a>
            <a href="<?= base_url('admin/menu') ?>" class="<?= strpos(uri_string(), 'admin/menu') === 0 ? 'active' : '' ?>">Kelola Menu</a>
            <a href="<?= base_url('admin/pelanggan') ?>" class="<?= strpos(uri_string(), 'admin/pelanggan') === 0 ? 'active' : '' ?>">Pelanggan</a>
            <a href="<?= base_url('admin/pesanan') ?>" class="<?= strpos(uri_string(), 'admin/pesanan') === 0 ? 'active' : '' ?>">Pesanan</a>
            <a href="<?= base_url('/') ?>" target="_blank" rel="noopener">Lihat Website</a>
            <a href="<?= base_url('admin/logout') ?>" class="logout-link">Logout</a>
        </nav>
    </aside>

    <main class="admin-content">
        <div class="admin-topbar">
            <h5 class="mb-0"><?= esc($title ?? '') ?></h5>
            <span class="text-muted">Halo, <strong><?= esc(session()->get('username')) ?></strong></span>
        </div>

        <div class="admin-body-inner">
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                            <li><?= esc($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
