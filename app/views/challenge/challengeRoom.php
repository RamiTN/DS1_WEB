<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenges - ChallengeHub</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/images/ico.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h1 class="mb-4">Challenges</h1>
    <p>
        <a href="index.php?controller=Challenge&action=create" class="btn btn-primary">Create challenge</a>
        <a href="index.php?controller=User&action=userDashboard" class="btn btn-outline-secondary">Dashboard</a>
        <a href="index.php?controller=User&action=logout" class="btn btn-outline-secondary">Logout</a>
    </p>

    <!-- Search, filter, sort -->
    <form method="GET" action="index.php" class="row g-2 mb-4">
        <input type="hidden" name="controller" value="Challenge">
        <input type="hidden" name="action" value="challengeRoom">
        <div class="col-auto">
            <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= htmlspecialchars($keyword ?? '') ?>">
        </div>
        <div class="col-auto">
            <select name="category" class="form-select">
                <option value="">All categories</option>
                <?php foreach ($categories ?? [] as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= (isset($category) && $category === $cat) ? 'selected' : '' ?>><?= htmlspecialchars($cat) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <select name="sort" class="form-select">
                <option value="newest" <?= (isset($sort) && $sort === 'newest') ? 'selected' : '' ?>>Newest first</option>
                <option value="popularity" <?= (isset($sort) && $sort === 'popularity') ? 'selected' : '' ?>>Most popular</option>
                <option value="date" <?= (isset($sort) && $sort === 'date') ? 'selected' : '' ?>>By deadline</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-secondary">Apply</button>
        </div>
    </form>

    <hr>

<?php if (empty($challenges)): ?>
    <p class="text-muted">No challenges found.</p>
<?php else: ?>
    <?php foreach ($challenges as $c): ?>
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h3 class="card-title"><?= htmlspecialchars($c['title']) ?></h3>
                <p class="card-text"><?= nl2br(htmlspecialchars($c['description'])) ?></p>
                <p class="text-muted small">
                    Category: <?= htmlspecialchars($c['category']) ?>
                    <?php if (!empty($c['deadline'])): ?> | Deadline: <?= htmlspecialchars($c['deadline']) ?><?php endif; ?>
                </p>
                <?php if (!empty($c['image'])): ?>
                    <img src="<?= htmlspecialchars($c['image']) ?>" alt="" class="img-fluid rounded mb-2" style="max-height:200px">
                <?php endif; ?>

                <?php if ((int)$c['user_id'] === (int)($_SESSION['user']['id'] ?? 0)): ?>
                    <p class="mb-2">
                        <a href="index.php?controller=Challenge&action=edit&id=<?= (int)$c['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                        <a href="index.php?controller=Challenge&action=delete&id=<?= (int)$c['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this challenge?');">Delete</a>
                    </p>
                <?php endif; ?>

                <!-- Add submission -->
                <hr>
                <h5>Add your submission</h5>
                <form method="POST" action="index.php?controller=Submission&action=create" class="mb-4">
                    <?= csrf_field() ?>
                    <input type="hidden" name="challenge_id" value="<?= (int)$c['id'] ?>">
                    <div class="mb-2">
                        <textarea name="description" class="form-control" rows="2" placeholder="Your submission..." required></textarea>
                    </div>
                    <div class="mb-2">
                        <input type="text" name="image_or_link" class="form-control" placeholder="Image URL or link (optional)">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </form>

                <!-- Submissions (ranking by votes) -->
                <h5>Submissions <span class="text-muted small">(ranking by votes)</span></h5>
                <?php if (empty($c['submissions'])): ?>
                    <p class="text-muted small">No submissions yet.</p>
                <?php else: ?>
                    <?php $rank = 1; foreach ($c['submissions'] as $s): ?>
                        <div class="border rounded p-3 mb-2 bg-white">
                            <p class="mb-1 small text-muted">#<?= $rank ?> · <?= htmlspecialchars($s['user_name']) ?></p>
                            <p class="mb-1"><?= nl2br(htmlspecialchars($s['description'])) ?></p>
                            <?php if (!empty($s['image_or_link'])): ?>
                                <p class="small"><a href="<?= htmlspecialchars($s['image_or_link']) ?>" target="_blank" rel="noopener">View image/link</a></p>
                            <?php endif; ?>
                            <p class="mb-2 small">
                                <strong>Votes: <?= (int)($s['votes_count'] ?? 0) ?></strong>
                                <?php if (!empty($s['has_voted'])): ?>
                                    <span class="text-success">· You voted</span>
                                <?php else: ?>
                                    <form method="POST" action="index.php?controller=Vote&action=vote" class="d-inline">
                                        <input type="hidden" name="submission_id" value="<?= (int)$s['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-success">Vote</button>
                                    </form>
                                <?php endif; ?>
                                <?php if ((int)$s['user_id'] === (int)($_SESSION['user']['id'] ?? 0)): ?>
                                    <a href="index.php?controller=Submission&action=edit&id=<?= (int)$s['id'] ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <a href="index.php?controller=Submission&action=delete&id=<?= (int)$s['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this submission?');">Delete</a>
                                <?php endif; ?>
                            </p>
                            <!-- Comments for this submission -->
                            <?php $comments = $s['comments'] ?? []; ?>
                            <div class="small mt-2">
                                <strong>Comments:</strong>
                                <?php if (empty($comments)): ?>
                                    <span class="text-muted">None yet.</span>
                                <?php else: ?>
                                    <ul class="list-unstyled mb-1">
                                        <?php foreach ($comments as $cm): ?>
                                            <li>
                                                <strong><?= htmlspecialchars($cm['author_name']) ?></strong>
                                                <span class="text-muted"><?= date('d/m/Y H:i', strtotime($cm['created_at'] ?? 'now')) ?></span>: <?= htmlspecialchars($cm['content']) ?>
                                                <?php if ((int)($cm['user_id'] ?? 0) === (int)($_SESSION['user']['id'] ?? 0) || ($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                                                <a href="index.php?controller=Comment&action=delete&id=<?= (int)$cm['id'] ?>" class="text-danger small">Delete</a>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <form method="POST" action="index.php?controller=Comment&action=create" class="mt-1">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="submission_id" value="<?= (int)$s['id'] ?>">
                                    <input type="text" name="content" class="form-control form-control-sm d-inline-block" style="width:auto" placeholder="Add a comment..." required>
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">Comment</button>
                                </form>
                            </div>
                        </div>
                        <?php $rank++; endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
