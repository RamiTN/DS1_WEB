<!DOCTYPE html>
<html>
<head>
    <title>Welcome to your Dashboard - ChallengeHub</title>
</head>
<body>
<h2>Profile</h2>
<p>Name: <?= htmlspecialchars($user['name']) ?></p>
<p>Email: <?= htmlspecialchars($user['email']) ?></p>
<a href="index.php?controller=Challenge&action=challengeRoom">Access challenges</a><br>
<a href="index.php?controller=User&action=logout">Logout</a>
</body>
</html>