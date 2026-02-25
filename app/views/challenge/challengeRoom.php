<!DOCTYPE html>
<html>
<head>
    <title>Challenges - ChallengeHub</title>
    <link rel="icon" type="image/png" href="/images/ico.png">
</head>
<body>

<h2>All Challenges</h2>

<a href="index.php?controller=Challenge&action=create">Create New Challenge</a> | 
<a href="index.php?controller=User&action=logout">Logout</a>
<p><a href="javascript:history.back()">← Go Back</a></p>
<hr>

<?php if(empty($challenges)): ?>
    <p>No challenges yet!</p>
<?php else: ?>

    <?php foreach($challenges as $c): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">

            <h3><?= htmlspecialchars($c['title']) ?></h3>
            <p><?= htmlspecialchars($c['description']) ?></p>

            <p>
                Category: <?= htmlspecialchars($c['category']) ?> |
                Deadline: <?= htmlspecialchars($c['deadline']) ?>
            </p>

            <!-- ✅ Vote Button -->
            <?php 
                $challenge = $c;
                require __DIR__ . '/../vote/voteBtn.php'; 
            ?>

            <a href="index.php?controller=Challenge&action=edit&id=<?= $c['id'] ?>">Edit</a>
            <a href="index.php?controller=Challenge&action=delete&id=<?= $c['id'] ?>">Delete</a>

            <hr>

            <!-- SUBMISSION FORM -->
            <h4>Add Submission:</h4>
            <form method="POST" action="index.php?controller=Submission&action=create">
                <input type="hidden" name="challenge_id" value="<?= $c['id'] ?>">
                <textarea name="description" required placeholder="Your submission..."></textarea>
                <br>
                <input type="text" name="image_or_link" placeholder="Image URL or link (optional)">
                <br>
                <button type="submit">Submit</button>
            </form>

            <hr>

            <!-- SUBMISSIONS -->
            <h4>Submissions:</h4>
            <?php if(empty($c['submissions'])): ?>
                <p>No submissions yet.</p>
            <?php else: ?>
                <?php foreach($c['submissions'] as $s): ?>
                    <div style="border:1px dashed #999; padding:5px; margin-bottom:5px;">
                        <p><?= htmlspecialchars($s['description']) ?></p>
                        <p>By User: <?= htmlspecialchars($s['user_name']) ?></p>
                        <?php if(!empty($s['image_or_link'])): ?>
                            <p>
                                <a href="<?= htmlspecialchars($s['image_or_link']) ?>" target="_blank">View image/link</a>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    <?php endforeach; ?>

<?php endif; ?>

</body>
</html>