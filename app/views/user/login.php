<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ChallengeHub</title>
    <link rel="icon" type="image/png" href="public/images/ico.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100 d-flex align-items-center justify-content-center">

    <div class="card border-0 shadow-sm rounded-3 p-4" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <p class="text-muted mb-1 fw-semibold">ChallengeHub</p>
            <h2 class="fw-semibold mb-4">Welcome back</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger py-2 small"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label fw-medium small">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="example@gmail.com" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label fw-medium small">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-dark w-100">Login</button>
            </form>

            <p class="text-center text-muted small mt-3 mb-0">
                Don't have an account? <a href="index.php?controller=User&action=register" class="text-dark fw-medium">Register</a>
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>