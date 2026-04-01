<?php
/** @var array $rows */
/** @var array $categories */
/** @var int|null $filterCategoryId */
?>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <h1 class="h3 mb-0">Liste des critiques</h1>
    <form method="get" action="index.php" class="d-flex align-items-center gap-2">
        <input type="hidden" name="url" value="review/index">
        <label for="filterCategory" class="form-label mb-0 small text-muted">Categorie</label>
        <select name="category" id="filterCategory" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
            <option value="">Toutes</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= (int) $c['id'] ?>" <?= ($filterCategoryId !== null && (int) $filterCategoryId === (int) $c['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<?php if ($rows === []): ?>
    <div class="alert alert-info">
        Aucune critique pour le moment.
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($rows as $item): ?>
            <?php
            $r = $item['review'];
            $cats = $item['categories'];
            $likes = (int) ($r['likes_count'] ?? 0);
            $pinned = (int) ($r['is_pinned'] ?? 0) === 1;
            $plain = strip_tags((string) $r['content']);
            $excerpt = strlen($plain) > 160 ? substr($plain, 0, 157) . '...' : $plain;
            ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php if ($pinned): ?>
                        <div class="card-header py-1 small bg-warning bg-opacity-25">A la une</div>
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h2 class="h5 card-title">
                            <a href="index.php?url=review/show/<?= (int) $r['id'] ?>" class="text-decoration-none">
                                <?= htmlspecialchars($r['title']) ?>
                            </a>
                        </h2>
                        <p class="card-text text-muted small">
                            Par <?= htmlspecialchars($r['username']) ?>
                            &middot; note <?= (int) $r['rating'] ?>/10
                            &middot; <?= $likes ?> like<?= $likes !== 1 ? 's' : '' ?>
                        </p>
                        <?php if ($cats !== []): ?>
                            <p class="small">
                                <?php foreach ($cats as $cat): ?>
                                    <span class="badge text-bg-light border"><?= htmlspecialchars($cat['name']) ?></span>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>
                        <p class="card-text small flex-grow-1"><?= nl2br(htmlspecialchars($excerpt)) ?></p>
                        <a href="index.php?url=review/show/<?= (int) $r['id'] ?>" class="btn btn-primary btn-sm align-self-start">Lire</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
