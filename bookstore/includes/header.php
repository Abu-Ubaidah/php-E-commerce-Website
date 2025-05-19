<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$cart_count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MyBookStore</title>
    <link rel="stylesheet" href="/bookstore/style.css">
</head>
<body>
<header class="site-header">
    <div class="container">
        <div class="logo">📚 ILM House</div>
        <nav class="nav">
            <a href="/bookstore/index.php">Home</a>
            <a href="/bookstore/cart.php">Cart (<?= $cart_count ?>)</a>
            <a href="/bookstore/about.php">About</a>
            <a href="/bookstore/contact.php">Contact</a>
        </nav>
    </div>
</header>
