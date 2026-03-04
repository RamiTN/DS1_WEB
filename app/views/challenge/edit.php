<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Challenge - ChallengeHub</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/images/ico.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/forms.css">
</head>
<body class="form-page">
    <a href="index.php?controller=Challenge&action=challengeRoom" class="back-link">← Back to challenges</a>
    <h2>Edit challenge</h2>
    <?php if (empty($challenge)): ?>
        <p>Challenge not found.</p>
    <?php else: ?>
        <form method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($challenge['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($challenge['description']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" value="<?= htmlspecialchars($challenge['category']) ?>" required>
            </div>
            <div class="form-group">
                <label for="deadline">Deadline</label>
                <input type="date" id="deadline" name="deadline" value="<?= htmlspecialchars($challenge['deadline'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="image">Image URL <span class="form-note">(optional)</span></label>
                <input type="text" id="image" name="image" value="<?= htmlspecialchars($challenge['image'] ?? '') ?>">
                <?php if (!empty($challenge['image'])): ?>
                    <img src="<?= htmlspecialchars($challenge['image']) ?>" alt="" class="form-preview">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn">Update challenge</button>
        </form>
    <?php endif; ?>
</body>
</html>
