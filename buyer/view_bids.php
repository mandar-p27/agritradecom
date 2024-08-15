<?php
require '../includes/db.php';
session_start();

$user_id = $_SESSION['user_id'];

// Fetch all bids made by the buyer
$sql = "SELECT b.bid_amount, a.product_name AS produce, a.start_time AS auction_date 
        FROM bids b
        JOIN auctions a ON b.auction_id = a.id
        WHERE b.buyer_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$bids = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Bids</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>My Bids</h1>
        <ul>
            <?php foreach ($bids as $bid): ?>
                <li>
                    <?= htmlspecialchars($bid['produce']) ?> - 
                    Bid Amount: <?= htmlspecialchars($bid['bid_amount']) ?> - 
                    Auction Date: <?= htmlspecialchars($bid['auction_date']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
