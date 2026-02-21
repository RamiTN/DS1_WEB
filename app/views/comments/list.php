<h4>Comments:</h4>
<?php if(!empty($comments)): ?>
    <ul>
    <?php foreach($comments as $c): ?>
        <li>
            <strong><?= htmlspecialchars($c['user_id']) /* You can replace with user name later */ ?></strong>:
            <?= htmlspecialchars($c['content']) ?> 
            <a href="index.php?controller=Comment&action=delete&id=<?= $c['id'] ?>">Delete</a>
        </li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No comments yet.</p>
<?php endif; ?>