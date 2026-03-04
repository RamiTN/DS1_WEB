<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Challenge - ChallengeHub</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/images/ico.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/forms.css">
</head>
<body class="form-page">
    <a href="index.php?controller=Challenge&action=challengeRoom" class="back-link">← Back to challenges</a>
    <h2>Create challenge</h2>
    <form method="POST">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" placeholder="Challenge title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" placeholder="Describe the challenge" required></textarea>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" id="category" name="category" placeholder="e.g. Design, Photo, Code" required>
        </div>
        <div class="form-group">
            <label for="deadline">Deadline</label>
            <input type="date" id="deadline" name="deadline" required>
        </div>
        <div class="form-group">
            <label for="image">Image URL <span class="form-note">(optional)</span></label>
            <input type="text" id="image" name="image" placeholder="https://...">
        </div>
        <button type="submit" class="btn">Create</button>
    </form>
</body>
</html>
