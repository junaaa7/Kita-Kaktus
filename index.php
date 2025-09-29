<?php
session_start();

// contoh produk (nanti bisa ambil dari database)
$produk = [
    ["id" => 1, "nama" => "Kaktus Mini", "harga" => 15000],
    ["id" => 2, "nama" => "Kaktus Hias", "harga" => 25000],
    ["id" => 3, "nama" => "Kaktus Jumbo", "harga" => 40000]
];

// proses tambah ke keranjang
if (isset($_GET['add'])) {
    $id = $_GET['add'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    // tambahkan produk ke keranjang
    $_SESSION['cart'][] = $id;
    header("Location: cart.php");
    exit;
}

include "includes/header_user.php";
?>
<head>
  <link rel="stylesheet" href="assets/css/user.css">
</head>
<?php
include 'includes/db.php'; // pastikan ini ada $conn

// ambil data dari tabel product
$sql = "SELECT * FROM products"; 
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>

<section class="products">
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <div class="product-card">
            <img src="<?= $row['image'] ?>" alt="<?= $row['name'] ?>">
            <h3><?= $row['name'] ?></h3>
            <p><?= $row['description'] ?></p>
            <div class="price">Rp <?= number_format($row['price'], 0, ',', '.') ?></div>
            <p>Stok: <?= $row['stock'] ?></p>

            <?php if ($row['stock'] > 0): ?>
                <form method="post" action="add_to_cart.php">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit">Tambah ke Keranjang</button>
                </form>
            <?php else: ?>
                <p style="color:red;">Stok Habis</p>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</section>

<?php include 'includes/footer.php'; ?>