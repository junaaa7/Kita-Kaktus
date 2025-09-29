<?php
session_start();

// contoh produk sama kayak di index (nanti ambil dari DB)
$produk = [
    1 => ["nama" => "Kaktus Mini", "harga" => 15000],
    2 => ["nama" => "Kaktus Hias", "harga" => 25000],
    3 => ["nama" => "Kaktus Jumbo", "harga" => 40000]
];

include "includes/header_user.php";
?>

<head>
  <link rel="stylesheet" href="assets/css/user.css">
</head>


<h2>Keranjang Belanja 🛒</h2>

<?php if (empty($_SESSION['cart'])): ?>
    <p>Keranjang masih kosong.</p>
<?php else: ?>
   <div class="cart-container">
    <h2>Keranjang Belanja</h2>
    <table class="cart-table">
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>Kaktus Mini</td>
            <td>2</td>
            <td>Rp 25.000</td>
            <td>Rp 50.000</td>
        </tr>
    </table>
    <div class="cart-actions">
        <button>Lanjut Belanja</button>
        <button>Checkout</button>
    </div>
</div>

<td><?= $qty ?></td>
<td>
    <?php if ($qty > $row['stock']) : ?>
        <span style="color:red;">Stok tidak cukup (tersisa <?= $row['stock'] ?>)</span>
    <?php endif; ?>
</td>



    <?php if (!isset($_SESSION['username'])): ?>
        <p>⚠️ Silakan <a href="login.php">Login</a> untuk melanjutkan checkout.</p>
    <?php else: ?>
        <p>✅ Terima kasih <?= $_SESSION['username'] ?>, silakan lanjutkan pembayaran.</p>
    <?php endif; ?>
<?php endif; ?>
