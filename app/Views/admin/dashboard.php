<?php
/** @var array $reviewRows */
/** @var array $users */
?>
<h1 class="h3 mb-4"><?= htmlspecialchars($title ?? 'Administration') ?></h1>

<h2 class="h5 mb-3">Critiques</h2>
<?php if ($reviewRows === []): ?>
    <div class="alert alert-light border mb-4">Aucune critique en base.</div>
<?php else: ?>
    <div class="table-responsive mb-5">
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Note</th>
                    <th>Epingle</th>
                    <th>Categories</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviewRows as $item): ?>
                    <?php $r = $item['review']; $cats = $item['categories']; ?>
                    <tr>
                        <td><?= (int) $r['id'] ?></td>
                        <td>
                            <a href="index.php?url=review/show/<?= (int) $r['id'] ?>"><?= htmlspecialchars($r['title']) ?></a>
                        </td>
                        <td><?= htmlspecialchars($r['username']) ?></td>
                        <td><?= (int) $r['rating'] ?>/10</td>
                        <td><?= (int) ($r['is_pinned'] ?? 0) ? 'Oui' : 'Non' ?></td>
                        <td class="small">
                            <?php foreach ($cats as $c): ?>
                                <span class="badge text-bg-light border"><?= htmlspecialchars($c['name']) ?></span>
                            <?php endforeach; ?>
                        </td>
                        <td class="text-end text-nowrap">
                            <form action="index.php?url=admin/togglePin" method="post" class="d-inline">
                                <input type="hidden" name="review_id" value="<?= (int) $r['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-warning">Epingler / desepingler</button>
                            </form>
                            <form action="index.php?url=admin/deleteReview" method="post" class="d-inline" onsubmit="return confirm('Supprimer cette critique ?');">
                                <input type="hidden" name="review_id" value="<?= (int) $r['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<h2 class="h5 mb-3">Utilisateurs</h2>
<?php if ($users === []): ?>
    <div class="alert alert-light border">Aucun utilisateur.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pseudo</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= (int) $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['username']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['role']) ?></td>
                        <td>
                            <form action="index.php?url=admin/setUserRole" method="post" class="row g-2 align-items-center">
                                <input type="hidden" name="user_id" value="<?= (int) $u['id'] ?>">
                                <div class="col-auto">
                                    <select name="role" class="form-select form-select-sm">
                                        <option value="user" <?= $u['role'] === 'user' ? 'selected' : '' ?>>user</option>
                                        <option value="critique" <?= $u['role'] === 'critique' ? 'selected' : '' ?>>critique</option>
                                        <option value="admin" <?= $u['role'] === 'admin' ? 'selected' : '' ?>>admin</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-sm btn-primary">OK</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
