<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ChallengeHub</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/images/ico.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100 py-4">
    <div class="container">
        <h2>Profile</h2>
        <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p>
            <a href="index.php?controller=User&action=editProfile" class="btn btn-outline-primary btn-sm">Edit profile</a>
            <a href="index.php?controller=Challenge&action=challengeRoom" class="btn btn-primary btn-sm">Access challenges</a>
            <a href="index.php?controller=User&action=logout" class="btn btn-outline-secondary btn-sm">Logout</a>
        </p>
        <?php if (isset($user['role']) && $user['role'] !== 'admin'): ?>
        <hr>
        <p>
            <form method="POST" action="index.php?controller=User&action=deleteAccount" onsubmit="return confirm('Are you sure you want to delete your account? This cannot be undone.');" class="d-inline">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-outline-danger btn-sm">Delete my account</button>
            </form>
        </p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>