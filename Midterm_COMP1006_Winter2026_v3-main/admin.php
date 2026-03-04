<?php
require "connect.php";

// get all reviews
$stmt = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<h1>Admin Page</h1>
<a href="index.php">Back to form</a>

<hr>
<?php foreach ($reviews as $r): ?>

    <h3><?php echo htmlspecialchars($r['title']); ?></h3>
    <p>
        <strong>Author:</strong>
        <?php echo htmlspecialchars($r['author']); ?>
    </p>
    <p>
        <strong>Rating:</strong>
        <?php echo $r['rating']; ?>/5
    </p>
    <p>
        <?php echo htmlspecialchars($r['review_text']); ?>
    </p>
    <small>
        <?php echo $r['created_at']; ?>
    </small>
    <hr>

<?php endforeach; ?>