<?php
/** @var array $categories */
?>
<h1 class="h3 mb-3"><?= htmlspecialchars($title ?? 'Nouvelle critique') ?></h1>

<form method="post" action="index.php?url=critic/create" class="card shadow-sm">
    <div class="card-body">
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Contenu</label>
            <textarea class="form-control" id="content" name="content" rows="8" required></textarea>
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Note (1 a 10)</label>
            <input type="number" class="form-control" id="rating" name="rating" min="1" max="10" value="7" required>
        </div>
        <div class="mb-3">
            <span class="form-label d-block">Categories</span>
            <?php foreach ($categories as $c): ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="categories[]" value="<?= (int) $c['id'] ?>" id="cat<?= (int) $c['id'] ?>">
                    <label class="form-check-label" for="cat<?= (int) $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Publier</button>
        <a href="index.php?url=critic/dashboard" class="btn btn-link">Annuler</a>
    </div>
</form>
