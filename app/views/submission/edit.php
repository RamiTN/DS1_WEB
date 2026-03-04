<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Submission - ChallengeHub</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/images/ico.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/forms.css">
</head>
<body class="form-page">
    <a href="index.php?controller=Challenge&action=challengeRoom" class="back-link">← Back to challenges</a>
    <h2>Edit submission</h2>
    <form method="POST">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" required><?= htmlspecialchars($submission['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="image_or_link">Image or link <span class="form-note">(optional)</span></label>
            <input type="text" id="image_or_link" name="image_or_link" value="<?= htmlspecialchars($submission['image_or_link'] ?? '') ?>" placeholder="URL">
        </div>
        <button type="submit" class="btn">Update</button>
    </form>
</body>
</html>
