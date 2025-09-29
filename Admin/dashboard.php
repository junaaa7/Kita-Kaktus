<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin - Kita Kaktus</title>
  <link rel="stylesheet" href="../assets/admin.css">
</head>
<body>
  <h1>Selamat Datang, Admin <?= $_SESSION['admin']; ?> 🌵</h1>
  <ul>
    <li><a href="manage_products.php">Kelola Produk</a></li>
    <li><a href="manage_users.php">Kelola User</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
</body>
</html>
