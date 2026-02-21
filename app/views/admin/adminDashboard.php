<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - ChallengeHub</title>
</head>
<body>
<h2>Admin Dashboard</h2>
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
<a href="index.php?controller=User&action=logout">Logout</a>
</body>
</html>