<?php
require '../includes/db.php';
session_start();

$user_id = $_SESSION['user_id'];

// Fetch all auctions where the buyer participated and the auction has ended
$sql = "SELECT a.product_name AS produce, a.end_time AS auction_date, b.bid_amount, 
        IF(b.bid_amount = (SELECT MAX(bid_amount) FROM bids WHERE auction_id = a.id), 'Won', 'Lost') as result 
        FROM auctions a 
        JOIN bids b ON a.id = b.auction_id 
        WHERE b.buyer_id = :user_id AND a.status = 'ended'";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$results = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Auction Results</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Auction Results</h1>
        <ul>
            <?php foreach ($results as $result): ?>
                <li>
                    <?= htmlspecialchars($result['produce']) ?> - 
                    Your Bid: <?= htmlspecialchars($result['bid_amount']) ?> - 
                    Result: <?= htmlspecialchars($result['result']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
