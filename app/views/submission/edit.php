<!DOCTYPE html>
<html>
<head>
    <title>Edit Submission - ChallengeHub</title>
        <link rel="icon" type="image/png" href="public/images/ico.png">

</head>
<body>
<h2>Edit Submission</h2>
<form method="POST">
    <textarea name="description" required><?= htmlspecialchars($submission['description']) ?></textarea><br>
    <input type="text" name="image_or_link" value="<?= htmlspecialchars($submission['image_or_link']) ?>"><br>
    <button type="submit">Update</button>
</form>
<a href="index.php?controller=Challenge&action=index">Back</a>
</body>
</html>