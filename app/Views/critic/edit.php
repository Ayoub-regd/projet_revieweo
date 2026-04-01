<?php
/** @var array $review */
/** @var array $categories */
/** @var array $selectedCategoryIds */
?>
<h1 class="h3 mb-3"><?= htmlspecialchars($title ?? 'Modifier') ?></h1>

<form method="post" action="index.php?url=critic/edit/<?= (int) $review['id'] ?>" class="card shadow-sm">
    <div class="card-body">
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" required value="<?= htmlspecialchars($review['title']) ?>">
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Contenu</label>
            <textarea class="form-control" id="content" name="content" rows="8" required><?= htmlspecialchars($review['content']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Note (1 a 10)</label>
            <input type="number" class="form-control" id="rating" name="rating" min="1" max="10" value="<?= (int) $review['rating'] ?>" required>
        </div>
        <div class="mb-3">
            <span class="form-label d-block">Categories</span>
            <?php foreach ($categories as $c): ?>
                <?php $cid = (int) $c['id']; ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="categories[]" value="<?= $cid ?>" id="cat<?= $cid ?>"
                        <?= in_array($cid, $selectedCategoryIds, true) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="cat<?= $cid ?>"><?= htmlspecialchars($c['name']) ?></label>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="index.php?url=critic/dashboard" class="btn btn-link">Retour</a>
    </div>
</form>
