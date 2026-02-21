<!DOCTYPE html>
<html>
<head>
    <title>Login - ChallengeHub</title>
        <link rel="icon" type="image/png" href="public/images/ico.png">

</head>
<body>
<h2>Login</h2>
<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit">Login</button>
</form>
<p>Don't have an account? <a href="index.php?controller=User&action=register">Register</a></p>
</body>
</html>