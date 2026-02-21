<!DOCTYPE html>
<html>
<head>
    <title>Register - ChallengeHub</title>
</head>
<body>
<h2>Register</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Register</button>
</form>
<p>Already have an account? <a href="index.php?controller=User&action=login">Login</a></p>
</body>
</html>