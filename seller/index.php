<?php
<link rel="stylesheet" href="../assets/css/styles.css">

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../auth/login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Welcome to the Seller Dashboard</h1>
    <a href="schedule_auction.php">Schedule Auction</a>
    <a href="upload_id.php">Upload ID for Verification</a>
</body>
</html>
