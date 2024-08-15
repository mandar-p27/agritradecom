<?php
session_start();

if ($_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit();
}

// Admin-specific functionalities here
echo "<h1>Welcome, Admin!</h1>";
?>
