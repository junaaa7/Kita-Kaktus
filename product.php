<?php
include 'includes/config.php';
include 'includes/header_user.php';


$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$res = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
$p = mysqli_fetch_assoc($res);
if (!$p) {
echo '<p>Produk tidak ditemukan.</p>';
include 'includes/footer.php';
exit;
}
?>
<div class="product-detail">
<img src="assets/images/<?= htmlspecialchars($p['image']); ?>" alt="<?= htmlspecialchars($p['name']); ?>">
<h2><?= htmlspecialchars($p['name']); ?></h2>
<p>Rp <?= number_format($p['price'],0,',','.'); ?></p>
<p>Stok: <?= (int)$p['stock']; ?></p>
<p><?= nl2br(htmlspecialchars($p['description'])); ?></p>
<a href="cart.php?add=<?= $p['id']; ?>">Tambah ke Keranjang</a>
</div>


<?php include 'includes/footer.php'; ?>