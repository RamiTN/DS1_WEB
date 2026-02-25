<div style="margin-top:10px;">

    <p><strong>Votes:</strong> <?= $challenge['votes_count'] ?? 0 ?></p>

    <?php if ($challenge['has_voted']): ?>
        <button disabled style="color:gray;">You already voted ✅</button>
    <?php else: ?>
        <form method="POST" action="index.php?controller=Vote&action=vote">
            <input type="hidden" name="challenge_id" value="<?= $challenge['id'] ?>">
            <button type="submit">Vote</button>
        </form>
    <?php endif; ?>

</div>