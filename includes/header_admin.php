<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// cek role admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>
<header style="padding:10px; background:#ffefef; display:flex; justify-content:space-between;">
    <h2>🌵 Admin Panel - Kaktus Shop</h2>
    <nav>
        <a href="dashboard.php">Dashboard</a> |
        <a href="manage_products.php">Kelola Produk</a> |
        <a href="manage_users.php">Kelola User</a> |
        <a href="logout.php">Logout</a>
    </nav>
</header>
