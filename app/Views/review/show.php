<?php
/** @var array $review */
/** @var array $reviewCategories */
/** @var int $likesCount */
/** @var bool $userLiked */
$user = $_SESSION['user'] ?? null;
?>
<article class="card shadow-sm">
    <div class="card-body p-4">
        <?php if ((int) ($review['is_pinned'] ?? 0) === 1): ?>
            <p class="mb-2"><span class="badge bg-warning text-dark">A la une</span></p>
        <?php endif; ?>
        <h1 class="h2 mb-3"><?= htmlspecialchars($review['title']) ?></h1>
        <p class="text-muted small mb-3">
            Par <strong><?= htmlspecialchars($review['username']) ?></strong>
            &middot; <?= htmlspecialchars((string) ($review['created_at'] ?? '')) ?>
        </p>
        <p class="mb-3"><span class="badge bg-primary">Note : <?= (int) $review['rating'] ?>/10</span></p>
        <?php if ($reviewCategories !== []): ?>
            <p class="mb-4">
                <?php foreach ($reviewCategories as $cat): ?>
                    <span class="badge text-bg-light border me-1"><?= htmlspecialchars($cat['name']) ?></span>
                <?php endforeach; ?>
            </p>
        <?php endif; ?>
        <div class="mb-4"><?= nl2br(htmlspecialchars($review['content'])) ?></div>

        <div class="border-top pt-3 d-flex flex-wrap align-items-center gap-3">
            <?php if ($user): ?>
                <button type="button" class="btn btn-outline-danger btn-sm btn-like"
                        data-review-id="<?= (int) $review['id'] ?>"
                        data-liked="<?= $userLiked ? '1' : '0' ?>"
                        aria-pressed="<?= $userLiked ? 'true' : 'false' ?>">
                    <span class="like-label"><?= $userLiked ? 'Retirer le like' : 'Liker' ?></span>
                </button>
            <?php else: ?>
                <p class="text-muted small mb-0">
                    <a href="index.php?url=auth/login">Connectez-vous</a> pour liker.
                </p>
            <?php endif; ?>
            <span class="small text-muted">
                <strong class="like-count"><?= (int) $likesCount ?></strong> like<?= (int) $likesCount !== 1 ? 's' : '' ?>
            </span>
        </div>
    </div>
</article>
