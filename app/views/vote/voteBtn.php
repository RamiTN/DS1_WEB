<form method="POST" action="index.php?controller=Vote&action=vote&submission_id=<?= $submission_id ?>">
    <button type="submit">Vote (<?= $votes_count ?>)</button>
</form>