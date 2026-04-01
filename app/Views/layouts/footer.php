<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php if (!empty($extraScripts) && is_array($extraScripts)): ?>
    <?php foreach ($extraScripts as $src): ?>
        <script src="<?= htmlspecialchars($src) ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
