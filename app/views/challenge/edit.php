<!DOCTYPE html>
<html>
<head>
    <title>Edit Challenge - ChallengeHub</title>
</head>
<body>

<h2>Edit Challenge</h2>

<a href="index.php?controller=Challenge&action=challengeRoom">← Back to Challenges</a>
<hr>

<?php if(!$challenge): ?>
    <p>Challenge not found.</p>
<?php else: ?>

<form method="POST">
    
    <label>Title:</label><br>
    <input type="text" name="title"
           value="<?= htmlspecialchars($challenge['title']) ?>"
           required>
    <br><br>

    <label>Description:</label><br>
    <textarea name="description" rows="4" cols="50" required><?= htmlspecialchars($challenge['description']) ?></textarea>
    <br><br>

    <label>Category:</label><br>
    <input type="text" name="category"
           value="<?= htmlspecialchars($challenge['category']) ?>"
           required>
    <br><br>

    <label>Deadline:</label><br>
    <input type="date" name="deadline"
           value="<?= htmlspecialchars($challenge['deadline']) ?>">
    <br><br>

    <label>Image URL:</label><br>
    <input type="text" name="image"
           value="<?= htmlspecialchars($challenge['image']) ?>">
    <br><br>

    <?php if(!empty($challenge['image'])): ?>
        <p>Current Image:</p>
        <img src="<?= htmlspecialchars($challenge['image']) ?>" 
             alt="Challenge Image"
             width="200">
        <br><br>
    <?php endif; ?>

    <button type="submit">Update Challenge</button>

</form>

<?php endif; ?>

</body>
</html>