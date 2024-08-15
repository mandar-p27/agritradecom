<?php
session_start();
require '../includes/db.php';

if ($_SESSION['role'] !== 'seller') {
    header('Location: ../auth/login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    
    // Check if the form fields are set
    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
    $starting_price = isset($_POST['starting_price']) ? $_POST['starting_price'] : '';
    $start_time = isset($_POST['start_time']) ? $_POST['start_time'] : '';
    $end_time = isset($_POST['end_time']) ? $_POST['end_time'] : '';

    // Insert auction into the database
    if (!empty($product_name) && !empty($starting_price) && !empty($start_time) && !empty($end_time)) {
        $sql = "INSERT INTO auctions (user_id, seller_id, product_name, starting_price, start_time, end_time) 
                VALUES (:user_id, :seller_id, :product_name, :starting_price, :start_time, :end_time)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'seller_id' => $user_id,  // Assuming the user_id is the same as seller_id
            'product_name' => $product_name,
            'starting_price' => $starting_price,
            'start_time' => $start_time,
            'end_time' => $end_time
        ]);

        echo "Auction scheduled! Await admin approval.";
    } else {
        echo "Please fill in all the required fields.";
    }
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
    <div class="container">
        <h1>Seller Dashboard</h1>
        <form action="dashboard.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="product_name" placeholder="Product Name" required>
            <textarea name="description" placeholder="Product Description"></textarea>
            <input type="datetime-local" name="start_time" placeholder="Auction Start Time" required>
            <input type="datetime-local" name="end_time" placeholder="Auction End Time" required>
            <input type="number" name="starting_price" placeholder="Starting Price" required>
            <button type="submit">Schedule Auction</button>
        </form>
    </div>
</body>
</html>
