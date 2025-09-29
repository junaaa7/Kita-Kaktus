<?php
include '../includes/config.php';
include '../includes/auth_check.php';
include '../includes/header.php';


// info singkat
$c1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM products"))['c'];
$c2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM orders"))['c'];
?>
<link rel="stylesheet" href="../assets/css/admin.css">

<h2>Admin Dashboard</h2>
<p>Jumlah produk: <?= $c1; ?></p>
<p>Jumlah pesanan: <?= $c2; ?></p>
<p><a href="products.php">Kelola Produk</a></p>
<?php include '../includes/footer.php'; ?>