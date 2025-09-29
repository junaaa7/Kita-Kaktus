<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header style="padding:10px; background:#e0ffe0; display:flex; justify-content:space-between;">
    <h2>🌵 Kaktus Shop</h2>
    <nav>
        <a href="index.php">Home</a> |
        <a href="about.php">About</a> |
        <a href="cart.php">Keranjang (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>)</a> |
        <?php if (isset($_SESSION['username'])): ?>
            <span>Halo, <?= $_SESSION['username'] ?></span> |
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
