<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../includes/db.php';

if ($_SESSION['role'] !== 'buyer') {
    header('Location: ../auth/login.php');
    exit();
}

// Get approved auctions
$sql = "SELECT * FROM auctions WHERE status = 'approved'";
$stmt = $pdo->query($sql);
$auctions = $stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $auction_id = $_POST['auction_id'];
    $bid_amount = $_POST['bid_amount'];

    // Insert bid into the database
    $sql = "INSERT INTO bids (auction_id, buyer_id, bid_amount) VALUES (:auction_id, :buyer_id, :bid_amount)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'auction_id' => $auction_id,
        'buyer_id' => $_SESSION['user_id'],
        'bid_amount' => $bid_amount
    ]);

    echo "Bid placed!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buyer Bidding</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Available Auctions</h1>
        <ul>
            <?php foreach ($auctions as $auction): ?>
                <li>
                    <?= htmlspecialchars($auction['produce'] ?? 'No produce info') ?> (Starting Price: <?= htmlspecialchars($auction['starting_price'] ?? 'N/A') ?>)
                    <form action="bid.php" method="POST">
                        <input type="hidden" name="auction_id" value="<?= htmlspecialchars($auction['id'] ?? '') ?>">
                        <input type="number" name="bid_amount" placeholder="Your Bid" required>
                        <button type="submit">Place Bid</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
