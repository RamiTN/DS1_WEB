<form method="POST" action="index.php?controller=Comment&action=create&submission_id=<?= $submission_id ?>">
    <textarea name="content" placeholder="Add a comment..." required></textarea><br>
    <button type="submit">Comment</button>
</form>