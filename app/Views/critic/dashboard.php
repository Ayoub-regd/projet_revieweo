<?php
/** @var array $reviews */
?>
<h1 class="h3 mb-3"><?= htmlspecialchars($title ?? 'Mes critiques') ?></h1>

<?php if ($reviews === []): ?>
    <div class="alert alert-info">Vous n'avez pas encore publie de critique.</div>
    <a href="index.php?url=critic/create" class="btn btn-success">Rediger une critique</a>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Note</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $r): ?>
                    <tr>
                        <td>
                            <a href="index.php?url=review/show/<?= (int) $r['id'] ?>"><?= htmlspecialchars($r['title']) ?></a>
                        </td>
                        <td><?= (int) $r['rating'] ?>/10</td>
                        <td class="small text-muted"><?= htmlspecialchars((string) ($r['created_at'] ?? '')) ?></td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-primary" href="index.php?url=critic/edit/<?= (int) $r['id'] ?>">Modifier</a>
                            <form action="index.php?url=critic/delete" method="post" class="d-inline" onsubmit="return confirm('Supprimer cette critique ?');">
                                <input type="hidden" name="review_id" value="<?= (int) $r['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <a href="index.php?url=critic/create" class="btn btn-success">Nouvelle critique</a>
<?php endif; ?>
