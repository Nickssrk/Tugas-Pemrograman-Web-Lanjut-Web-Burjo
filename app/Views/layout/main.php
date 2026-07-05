<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Warung Burjo Barokah') ?></title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><rect width=%22100%22 height=%22100%22 rx=%2220%22 fill=%22%233b2417%22/><text x=%2250%22 y=%2268%22 font-size=%2252%22 font-family=%22Arial,sans-serif%22 font-weight=%22bold%22 fill=%22%23d97b2b%22 text-anchor=%22middle%22>WB</text></svg>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <text y=%22.9em%22 font-size=%2290%22></text></svg>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-burjo sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>">Warung Burjo Barokah</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-label="Buka menu navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#makanan">Makanan</a></li>
                <li class="nav-item"><a class="nav-link" href="#minuman">Minuman</a></li>
                <li class="nav-item"><a class="nav-link nav-pesan" href="<?= base_url('pesan') ?>">Pesan Sekarang</a></li>
            </ul>
        </div>
    </div>
    <div class="gingham-strip"></div>
</nav>

<?= $this->renderSection('content') ?>

<div class="gingham-strip"></div>
<footer class="footer-burjo text-center py-4">
    <div class="container">
        <p class="mb-0">&copy; <?= date('Y') ?> Warung Burjo Barokah</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
