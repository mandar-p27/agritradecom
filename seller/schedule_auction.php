<?php
session_start();
require '../includes/db.php';
<link rel="stylesheet" href="../assets/css/styles.css">


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $starting_price = $_POST['starting_price'];
    $seller_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare('INSERT INTO auctions (seller_id, product_name, start_time, end_time, starting_price) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$seller_id, $product_name, $start_time, $end_time, $starting_price]);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Auction</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <form action="schedule_auction.php" method="POST">
        <input type="text" name="product_name" placeholder="Product Name" required>
        <input type="datetime-local" name="start_time" required>
        <input type="datetime-local" name="end_time" required>
        <input type="number" step="0.01" name="starting_price" placeholder="Starting Price" required>
        <button type="submit">Schedule Auction</button>
    </form>
