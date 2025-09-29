<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['user'] = $username;
        header("Location: index.php"); // halaman utama user
    } else {
        echo "Login user gagal!";
    }
}
?>

 <link rel="stylesheet" href="assets/css/login.css">

<?php include "includes/header_user.php"; ?>

<<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Kita Kaktus</title>
  <link rel="stylesheet" href="assets/login.css">
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <form action="login_process.php" method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Masuk</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar</a></p>
  </div>
</body>
</html>
