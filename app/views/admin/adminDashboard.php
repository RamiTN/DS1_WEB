<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ChallengeHub</title>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>public/images/ico.png">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/admin.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="admin-page">
<div class="container">
    <h2>Admin Dashboard</h2>
    <div class="toolbar">
        <a href="index.php?controller=Challenge&action=challengeRoom">View challenges</a>
        <a href="index.php?controller=User&action=logout" class="logout">Logout</a>
    </div>

    <!-- Statistics -->
    <div class="stats">
        <div class="stat-card"><span class="value"><?= (int) $totalUsers ?></span><br><span class="label">Users</span></div>
        <div class="stat-card"><span class="value"><?= (int) $totalChallenges ?></span><br><span class="label">Challenges</span></div>
        <div class="stat-card"><span class="value"><?= (int) $totalSubmissions ?></span><br><span class="label">Submissions</span></div>
        <div class="stat-card"><span class="value"><?= (int) $totalComments ?></span><br><span class="label">Comments</span></div>
        <div class="stat-card"><span class="value"><?= (int) $totalVotes ?></span><br><span class="label">Votes</span></div>
    </div>

    <div class="chart-wrap">
        <h3>Overview</h3>
        <canvas id="statsChart" height="120"></canvas>
    </div>

    <!-- Users -->
    <div class="section">
        <h3>Users</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= (int) $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['name']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['role']) ?></td>
                        <td><a href="index.php?controller=Admin&action=deleteUser&id=<?= (int) $u['id'] ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Challenges -->
    <div class="section">
        <h3>Challenges</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Deadline</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($challenges as $c): ?>
                    <tr>
                        <td><?= (int) $c['id'] ?></td>
                        <td><?= htmlspecialchars($c['title']) ?></td>
                        <td><?= htmlspecialchars($c['category']) ?></td>
                        <td><?= htmlspecialchars($c['deadline'] ?? '') ?></td>
                        <td><a href="index.php?controller=Admin&action=deleteChallenge&id=<?= (int) $c['id'] ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Submissions -->
    <div class="section">
        <h3>Submissions</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Challenge</th>
                        <th>User</th>
                        <th>Description</th>
                        <th>Votes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($submissions as $s): ?>
                    <tr>
                        <td><?= (int) $s['id'] ?></td>
                        <td><?= (int) $s['challenge_id'] ?></td>
                        <td><?= (int) $s['user_id'] ?></td>
                        <td class="desc-cell" title="<?= htmlspecialchars($s['description']) ?>"><?= htmlspecialchars($s['description']) ?></td>
                        <td><?= (int) ($s['votes_count'] ?? 0) ?></td>
                        <td><a href="index.php?controller=Admin&action=deleteSubmission&id=<?= (int) $s['id'] ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Comments -->
    <div class="section">
        <h3>Comments</h3>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Submission</th>
                        <th>User</th>
                        <th>Comment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($comments as $cm): ?>
                    <tr>
                        <td><?= (int) $cm['id'] ?></td>
                        <td><?= (int) $cm['submission_id'] ?></td>
                        <td><?= (int) $cm['user_id'] ?></td>
                        <td class="desc-cell" title="<?= htmlspecialchars($cm['content']) ?>"><?= htmlspecialchars($cm['content']) ?></td>
                        <td><a href="index.php?controller=Admin&action=deleteComment&id=<?= (int) $cm['id'] ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('statsChart');
    if (ctx) {
        new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Users', 'Challenges', 'Submissions', 'Comments', 'Votes'],
                datasets: [{
                    label: 'Count',
                    data: [<?= (int) $totalUsers ?>, <?= (int) $totalChallenges ?>, <?= (int) $totalSubmissions ?>, <?= (int) $totalComments ?>, <?= (int) $totalVotes ?>],
                    backgroundColor: ['#0d6efd', '#198754', '#fd7e14', '#6f42c1', '#20c997']
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
});
</script>
</body>
</html>
