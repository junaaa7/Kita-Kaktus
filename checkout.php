<?php
include 'includes/config.php';
if (session_status() == PHP_SESSION_NONE) session_start();


if (!isset($_SESSION['user'])) {
header('Location: login.php'); exit;
}


$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
if (empty($cart)) {
header('Location: cart.php'); exit;
}


$ids = implode(',', array_keys($cart));
$res = mysqli_query($conn, "SELECT * FROM products WHERE id IN ($ids)");
$total = 0;
$items = [];
while ($p = mysqli_fetch_assoc($res)) {
$qty = $cart[$p['id']];
$items[] = [
'product_id' => $p['id'],
'qty' => $qty,
'price' => $p['price']
];
$total += $p['price'] * $qty;
}


// simpan order
$user_id = (int)$_SESSION['user']['id'];
mysqli_query($conn, "INSERT INTO orders (user_id,total_price,status,created_at) VALUES ($user_id, $total, 'pending', NOW())");
$order_id = mysqli_insert_id($conn);
foreach ($items as $it) {
$pid = (int)$it['product_id'];
$qty = (int)$it['qty'];
$price = (float)$it['price'];
mysqli_query($conn, "INSERT INTO order_items (order_id,product_id,quantity,price) VALUES ($order_id,$pid,$qty,$price)");
// update stock
mysqli_query($conn, "UPDATE products SET stock = stock - $qty WHERE id = $pid");
}


// kosongkan keranjang
unset($_SESSION['cart']);


include 'includes/header_user.php';
?>
<h2>Terima kasih, pesananmu berhasil dibuat.</h2>
<p>ID Pesanan: <?= $order_id; ?></p>
<a href="index.php">Kembali ke toko</a>
<?php include 'includes/footer.php'; ?>