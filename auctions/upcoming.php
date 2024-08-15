<?php
require '../includes/db.php';

// Get all approved auctions
$sql = "SELECT * FROM auctions WHERE status = 'approved'";
$stmt = $pdo->query($sql);
$auctions = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upcoming Auctions</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Upcoming Auctions</h1>
        <ul>
            <?php foreach ($auctions as $auction): ?>
                <li>
                    <?= htmlspecialchars($auction['produce']) ?> (Starting Price: <?= htmlspecialchars($auction['starting_price']) ?>)
                    <a href="details.php?id=<?= $auction['id'] ?>">View Details</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
