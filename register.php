<?php
// register.php
require 'includes/config.php';
include 'includes/header_user.php';
if (session_status() == PHP_SESSION_NONE) session_start();

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $err = 'Username dan password harus diisi.';
    } else {
        // cek username exists
        $stmt = pdo_query("SELECT id FROM users WHERE username = :u", ['u' => $username]);
        if ($stmt->fetch()) {
            $err = 'Username sudah dipakai.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $ins = pdo_query("INSERT INTO users (username, password, role) VALUES (:u, :p, 'user')", [
                'u' => $username,
                'p' => $hash
            ]);
            header('Location: login.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - Kita Kaktus</title>
  <link rel="stylesheet" href="assets/css/register.css">
</head>
<body>
  <div class="register-container">
    <h2>Daftar Akun</h2>
    <form action="register_process.php" method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
      <button type="submit">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login</a></p>
  </div>
</body>
</html>

<?php include 'includes/footer.php'; ?>
