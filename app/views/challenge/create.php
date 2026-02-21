<!DOCTYPE html>
<html>
<head>
    <title>Create Challenge - ChallengeHub</title>
</head>
<body>
<h2>Create Challenge</h2>
<form method="POST">
    <input type="text" name="title" placeholder="Title" required><br>
    <textarea name="description" placeholder="Description" required></textarea><br>
    <input type="text" name="category" placeholder="Category" required><br>
    <input type="date" name="deadline" required><br>
    <input type="text" name="image" placeholder="Image URL (optional)"><br>
    <button type="submit">Create</button>
</form>
<a href="index.php?controller=Challenge&action=index">Back</a>
</body>
</html>