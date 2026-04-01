<?php
$user = $_SESSION['user'] ?? null;
$role = is_array($user) && isset($user['role']) ? (string) $user['role'] : null;
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
                <li class="nav-item">
                    <a class="nav-link" href="index.php?url=review/index">Critiques</a>
                </li>
                <?php if (!$user): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?url=auth/login">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?url=auth/register">Inscription</a>
                    </li>
                <?php else: ?>
                    <?php if ($role === 'critique' || $role === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?url=critic/dashboard">Mes critiques</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?url=critic/create">Ecrire</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($role === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="index.php?url=admin/dashboard">Admin</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <span class="nav-link disabled text-white-50 small">
                            <?= htmlspecialchars($user['username']) ?>
                            <?php if ($role): ?>
                                <span class="badge bg-secondary ms-1"><?= htmlspecialchars($role) ?></span>
                            <?php endif; ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?url=auth/logout">Deconnexion</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
