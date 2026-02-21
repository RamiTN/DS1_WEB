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
<hr>

<?php if(empty($challenges)): ?>
    <div>
        <p>No challenges yet!</p>
    </div>
<?php else: ?>
    <?php foreach($challenges as $c): ?>
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <h3><?= htmlspecialchars($c['title']) ?></h3>
            <p><?= htmlspecialchars($c['description']) ?></p>
            <p>Category: <?= htmlspecialchars($c['category']) ?> | Deadline: <?= $c['deadline'] ?></p>
            <a href="index.php?controller=Challenge&action=edit&id=<?= $c['id'] ?>">Edit</a>
            <a href="index.php?controller=Challenge&action=delete&id=<?= $c['id'] ?>">Delete</a>

            <h4>Submissions:</h4>
            <?php
                $submissions = $submissionModel->getAllByChallenge($c['id']);
                foreach($submissions as $s):
            ?>
                <div style="border:1px dashed #999; padding:5px; margin-bottom:5px;">
                    <p><?= htmlspecialchars($s['description']) ?></p>
                    <p>By User ID: <?= $s['user_id'] ?></p>

                    <!-- Vote button -->
                    <?php $votes_count = $voteModel->countBySubmission($s['id']); ?>
                    <form method="POST" action="index.php?controller=Vote&action=vote&submission_id=<?= $s['id'] ?>">
                        <button type="submit">Vote (<?= $votes_count ?>)</button>
                    </form>

                    <!-- Comments -->
                    <?php
                        $comments = $commentModel->getAllBySubmission($s['id']);
                        $submission_id = $s['id'];
                    ?>
                    <?php include '../app/views/comment/list.php'; ?>
                    <?php include '../app/views/comment/create.php'; ?>
                </div>
            <?php endforeach; ?>

        </div>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>