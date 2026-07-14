<?php
require_once 'database.php';
$id = $_GET['id'] ?? 0;
$post = getPostById($pdo, $id);
include 'include/header.php';
?>

<div class="container mt-5">
    <?php if (!$post): ?>

        <div class="alert alert-danger">
            Post not found.
        </div>

    <?php else: ?>
        <div class="card">
            <div class="card-body">
                <h1><?= htmlspecialchars($post['title']) ?></h1>
                <p class="text-muted" >
                    <?= htmlspecialchars($post['category']) ?>
                    |
                    <?= $post['created_at'] ?>
                </p>

                <hr>

                <p style="white-space: pre-line;">
                    <?= htmlspecialchars($post['content']) ?>
                </p>
                <a href="index.php" class="btn btn-secondary mt-3">
                    ← Back
                </a>
            </div>
        </div>

    <?php endif; ?>
</div>

<?php include 'include/footer.php'; ?>