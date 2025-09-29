<?php
session_start();
include '../includes/db.php';

// proteksi: hanya admin bisa masuk
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

// Tambah produk
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $desc = $_POST['description'];

    // upload gambar
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "../uploads/" . $image);

    $sql = "INSERT INTO product (name, price, stock, description, image) 
            VALUES ('$name','$price','$stock','$desc','$image')";
    mysqli_query($conn, $sql);
    header("Location: manage_products.php");
    exit();
}

// Hapus produk
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM product WHERE id=$id");
    header("Location: manage_products.php");
    exit();
}

// Ambil semua produk
$result = mysqli_query($conn, "SELECT * FROM product");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Produk - Admin Kita Kaktus</title>
  <link rel="stylesheet" href="../assets/admin.css">
</head>
<body>
  <h1>Kelola Produk 🌵</h1>
  <a href="dashboard.php">← Kembali ke Dashboard</a>

  <h2>Tambah Produk Baru</h2>
  <form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Nama Kaktus" required>
    <input type="number" step="0.01" name="price" placeholder="Harga" required>
    <input type="number" name="stock" placeholder="Stok" required>
    <textarea name="description" placeholder="Deskripsi"></textarea>
    <input type="file" name="image" accept="image/*" required>
    <button type="submit" name="add">Tambah Produk</button>
  </form>

  <h2>Daftar Produk</h2>
  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>ID</th>
      <th>Nama</th>
      <th>Harga</th>
      <th>Stok</th>
      <th>Deskripsi</th>
      <th>Gambar</th>
      <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
        <td><?= $row['stock'] ?></td>
        <td><?= $row['description'] ?></td>
        <td>
          <?php if ($row['image']) : ?>
            <img src="../uploads/<?= $row['image'] ?>" width="80">
          <?php endif; ?>
        </td>
        <td>
          <a href="manage_products.php?delete=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus produk ini?')">Hapus</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
