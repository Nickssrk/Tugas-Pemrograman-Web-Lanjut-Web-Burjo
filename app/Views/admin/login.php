<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2220%22 fill=%22%233b2417%22/><text x=%2250%22 y=%2268%22 font-size=%2252%22 font-family=%22Arial,sans-serif%22 font-weight=%22bold%22 fill=%22%23d97b2b%22 text-anchor=%22middle%22>WB</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <text y=%22.9em%22 font-size=%2290%22></text></svg>
</head>
<body class="login-page">
    <div class="login-card">
        <div class="gingham-strip login-strip"></div>
        <h3 class="text-center mb-1">Warung Burjo</h3>
        <p class="text-center text-muted mb-4">Masuk ke Panel Admin</p>

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

        <form action="<?= base_url('admin/login') ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= old('username') ?>" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-burjo w-100">Masuk</button>
        </form>
        <p class="text-center text-muted small mt-3 mb-0">
            <a href="<?= base_url('/') ?>">&larr; Kembali ke halaman utama</a>
        </p>
    </div>
</body>
</html>
