<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header class="header">
  <div class="logo">🌵 Kaktus Shop</div>
  <nav>
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="cart.php">Keranjang (<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>)</a>
    <?php if(isset($_SESSION['user'])): ?>
      <a href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a> | <a href="register.php">Register</a>
    <?php endif; ?>
  </nav>
</header>
