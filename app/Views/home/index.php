<?php
/** @var array $featuredRows */
$user = $_SESSION['user'] ?? null;
?>
<section class="hero p-4 p-md-5 rounded-4 shadow-sm bg-white mb-4">
    <h1 class="display-6 fw-bold mb-3">Bienvenue sur Revieweo</h1>
    <p class="lead text-muted mb-4">
        Plateforme de critiques de films : consultez les avis, les notes et les categories.
    </p>
    <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-primary" href="index.php?url=review/index">Voir les critiques</a>
        <?php if (!$user): ?>
            <a class="btn btn-outline-secondary" href="index.php?url=auth/register">Creer un compte</a>
            <a class="btn btn-outline-secondary" href="index.php?url=auth/login">Se connecter</a>
        <?php endif; ?>
    </div>
</section>

<section class="mb-4">
    <h2 class="h4 mb-3">A la une</h2>
    <?php if ($featuredRows === []): ?>
        <div class="alert alert-light border">Aucune critique publiee pour le moment.</div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($featuredRows as $item): ?>
                <?php
                $r = $item['review'];
                $cats = $item['categories'];
                $likes = (int) ($r['likes_count'] ?? 0);
                $pinned = (int) ($r['is_pinned'] ?? 0) === 1;
                ?>
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <?php if ($pinned): ?>
                            <div class="card-header py-1 small bg-warning bg-opacity-25">Epingle</div>
                        <?php endif; ?>
                        <div class="card-body">
                            <h3 class="h6 card-title">
                                <a href="index.php?url=review/show/<?= (int) $r['id'] ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($r['title']) ?>
                                </a>
                            </h3>
                            <p class="small text-muted mb-2">
                                <?= htmlspecialchars($r['username']) ?> &middot; <?= (int) $r['rating'] ?>/10
                                &middot; <?= $likes ?> like<?= $likes !== 1 ? 's' : '' ?>
                            </p>
                            <?php if ($cats !== []): ?>
                                <p class="small mb-0">
                                    <?php foreach (array_slice($cats, 0, 3) as $cat): ?>
                                        <span class="badge text-bg-light border"><?= htmlspecialchars($cat['name']) ?></span>
                                    <?php endforeach; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="mt-2 mb-0">
            <a href="index.php?url=review/index" class="btn btn-sm btn-outline-primary">Toutes les critiques</a>
        </p>
    <?php endif; ?>
</section>

<section class="row g-3 mt-2">
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <h4 class="h6">Lire</h4>
                <p class="card-text text-muted small mb-0">Liste en cartes, filtre par categorie.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <h4 class="h6">Liker</h4>
                <p class="card-text text-muted small mb-0">Apres connexion, like en AJAX sur la fiche critique.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <h4 class="h6">Publier</h4>
                <p class="card-text text-muted small mb-0">Comptes auteurs : dashboard et formulaires dedies.</p>
            </div>
        </div>
    </div>
</section>
