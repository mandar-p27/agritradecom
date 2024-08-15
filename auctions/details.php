<?php
require '../includes/db.php';

if (!isset($_GET['id'])) {
    die('Auction ID not provided.');
}

$auction_id = $_GET['id'];

// Get auction details
$sql = "SELECT * FROM auctions WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $auction_id]);
$auction = $stmt->fetch();

if (!$auction) {
    die('Auction not found.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Auction Details</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1><?= htmlspecialchars($auction['produce']) ?></h1>
        <p>Starting Price: <?= htmlspecialchars($auction['starting_price']) ?></p>
        <p>Auction Date: <?= htmlspecialchars($auction['auction_date']) ?></p>
        <form action="../buyer/bid.php" method="POST">
            <input type="hidden" name="auction_id" value="<?= $auction['id'] ?>">
            <input type="number" name="bid_amount" placeholder="Your Bid" required>
            <button type="submit">Place Bid</button>
        </form>
    </div>
</body>
</html>
