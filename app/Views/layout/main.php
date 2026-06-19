<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Warung Burjo Barokah') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700&family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-burjo sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/') ?>">🍜 Warung Burjo Barokah</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-label="Buka menu navigasi">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#makanan">Makanan</a></li>
                <li class="nav-item"><a class="nav-link" href="#minuman">Minuman</a></li>
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
