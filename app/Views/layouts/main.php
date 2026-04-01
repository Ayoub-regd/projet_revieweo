<?php require __DIR__ . '/header.php'; ?>

<main class="container py-4">
    <?php if ($flashError): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($flashError) ?></div>
    <?php endif; ?>
    <?php if ($flashSuccess): ?>
        <div class="alert alert-success"><?= htmlspecialchars($flashSuccess) ?></div>
    <?php endif; ?>

    <?= $content ?>
</main>

<?php require __DIR__ . '/footer.php'; ?>
