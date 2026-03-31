<?php
$user = $_SESSION['user'] ?? null;
$flashError = $_SESSION['flash_error'] ?? null;
$flashSuccess = $_SESSION['flash_success'] ?? null;
unset($_SESSION['flash_error'], $_SESSION['flash_success']);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars(($title ?? APP_NAME) . ' - ' . APP_NAME) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/base.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php?url=home/index"><?= APP_NAME ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?url=home/index">Accueil</a>
                </li>
                <?php if (!$user): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?url=auth/login">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?url=auth/register">Inscription</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <span class="nav-link text-warning">Bonjour <?= htmlspecialchars($user['username']) ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?url=auth/logout">Deconnexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    <?php if ($flashError): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($flashError) ?></div>
    <?php endif; ?>
    <?php if ($flashSuccess): ?>
        <div class="alert alert-success"><?= htmlspecialchars($flashSuccess) ?></div>
    <?php endif; ?>

    <?= $content ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
