<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - ChallengeHub</title>
    <link rel="icon" type="image/png" href="/images/ico.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2>Admin Dashboard</h2>

<!-- ================== STATISTICS ================== -->
<h3>System Statistics</h3>
<ul>
    <li>Total Users: <?= $totalUsers ?></li>
    <li>Total Challenges: <?= $totalChallenges ?></li>
    <li>Total Submissions: <?= $totalSubmissions ?></li>
    <li>Total Comments: <?= $totalComments ?></li>
    <li>Total Votes: <?= $totalVotes ?></li>
</ul>

<canvas id="statsChart" width="400" height="150"></canvas>

<script>
const ctx = document.getElementById('statsChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Users', 'Challenges', 'Submissions', 'Comments', 'Votes'],
        datasets: [{
            label: 'Platform Statistics',
            data: [
                <?= $totalUsers ?>,
                <?= $totalChallenges ?>,
                <?= $totalSubmissions ?>,
                <?= $totalComments ?>,
                <?= $totalVotes ?>
            ]
        }]
    }
});
</script>

<hr>

<!-- ================== USERS ================== -->
<h3>Users</h3>
<table border="1">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Actions</th>
</tr>
<?php foreach($users as $u): ?>
<tr>
    <td><?= $u['id'] ?></td>
    <td><?= htmlspecialchars($u['name']) ?></td>
    <td><?= htmlspecialchars($u['email']) ?></td>
    <td><?= htmlspecialchars($u['role']) ?></td>
    <td>
        <a href="index.php?controller=Admin&action=deleteUser&id=<?= $u['id'] ?>">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<hr>

<!-- ================== CHALLENGES ================== -->
<h3>Challenges</h3>
<table border="1">
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Category</th>
    <th>Deadline</th>
    <th>Actions</th>
</tr>
<?php foreach($challenges as $c): ?>
<tr>
    <td><?= $c['id'] ?></td>
    <td><?= htmlspecialchars($c['title']) ?></td>
    <td><?= htmlspecialchars($c['category']) ?></td>
    <td><?= htmlspecialchars($c['deadline']) ?></td>
    <td>
        <a href="index.php?controller=Admin&action=deleteChallenge&id=<?= $c['id'] ?>">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<hr>

<!-- ================== SUBMISSIONS ================== -->
<h3>Submissions</h3>
<table border="1">
<tr>
    <th>ID</th>
    <th>Challenge ID</th>
    <th>User ID</th>
    <th>Description</th>
    <th>Votes</th>
    <th>Actions</th>
</tr>
<?php foreach($submissions as $s): ?>
<tr>
    <td><?= $s['id'] ?></td>
    <td><?= $s['challenge_id'] ?></td>
    <td><?= $s['user_id'] ?></td>
    <td><?= htmlspecialchars($s['description']) ?></td>
    <td><?= $s['votes_count'] ?? 0 ?></td>
    <td>
        <a href="index.php?controller=Admin&action=deleteSubmission&id=<?= $s['id'] ?>">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<hr>

<!-- ================== COMMENTS ================== -->
<h3>Comments</h3>
<table border="1">
<tr>
    <th>ID</th>
    <th>Challenge ID</th>
    <th>User ID</th>
    <th>Comment</th>
    <th>Actions</th>
</tr>
<?php foreach($comments as $cm): ?>
<tr>
    <td><?= $cm['id'] ?></td>
    <td><?= $cm['submission_id'] ?></td>
    <td><?= $cm['user_id'] ?></td>
    <td><?= htmlspecialchars($cm['content']) ?></td>
    <td>
        <a href="index.php?controller=Admin&action=deleteComment&id=<?= $cm['id'] ?>">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<hr>

<a href="index.php?controller=User&action=logout">Logout</a>

</body>
</html>