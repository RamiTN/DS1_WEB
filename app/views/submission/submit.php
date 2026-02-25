<!DOCTYPE html>
<html>
<head>
    <title>Submit Entry - ChallengeHub</title>
    <link rel="icon" type="image/png" href="public/images/ico.png">
</head>
<body>

<h2>Submit to Challenge</h2>

<form method="POST" action="index.php?controller=Submission&action=create">
    
    <!-- IMPORTANT: send challenge_id -->
    <input type="hidden" name="challenge_id" value="<?= htmlspecialchars($challenge_id) ?>">

    <textarea name="description" placeholder="Your submission description" required></textarea><br>
    
    <input type="text" name="image_or_link" placeholder="Image URL or external link (optional)"><br>
    
    <button type="submit">Submit</button>
</form>

<a href="index.php?controller=Challenge&action=challengeRoom">Back</a>

</body>
</html>