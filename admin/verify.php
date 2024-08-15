<?php
session_start();
require '../includes/db.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit();
}

// Get pending auctions
$sql = "SELECT * FROM auctions WHERE status = 'pending'";
$stmt = $pdo->query($sql);
$auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $auction_id = $_POST['auction_id'];
    $action = $_POST['action'];

    if ($action == 'approve') {
        $sql = "UPDATE auctions SET status = 'approved' WHERE id = :auction_id";
    } else {
        $sql = "DELETE FROM auctions WHERE id = :auction_id";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['auction_id' => $auction_id]);

    // Redirect to avoid form resubmission
    header("Location: verify.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Verification</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Admin Verification</h1>
        <ul>
            <?php if (count($auctions) > 0): ?>
                <?php foreach ($auctions as $auction): ?>
                    <li>
                        <!-- Adjusted array keys to match database columns -->
                        <?= htmlspecialchars($auction['product_name']) ?> (Start Time: <?= htmlspecialchars($auction['start_time']) ?>, End Time: <?= htmlspecialchars($auction['end_time']) ?>)
                        <form action="verify.php" method="POST" style="display:inline;">
                            <input type="hidden" name="auction_id" value="<?= $auction['id'] ?>">
                            <button type="submit" name="action" value="approve">Approve</button>
                            <button type="submit" name="action" value="reject">Reject</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No pending auctions to verify.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
