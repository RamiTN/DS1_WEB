<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - ChallengeHub</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/images/ico.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100 d-flex align-items-center justify-content-center">
    <div class="card border-0 shadow-sm rounded-3 p-4" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <h2 class="fw-semibold mb-4">Edit profile</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger py-2 small"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="POST">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">New password (leave blank to keep current)</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Optional">
                </div>
                <button type="submit" class="btn btn-dark w-100">Save</button>
            </form>
            <p class="text-center text-muted small mt-3 mb-0">
                <a href="index.php?controller=User&action=userDashboard">Cancel</a>
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
