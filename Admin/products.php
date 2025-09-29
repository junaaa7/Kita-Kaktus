<?php
include '../includes/config.php';
include '../includes/auth_check.php';
include '../includes/header.php';


$res = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
?>
<h2>Kelola Produk</h2>
<p><a href="add_product.php">Tambah Produk</a></p>
<table>