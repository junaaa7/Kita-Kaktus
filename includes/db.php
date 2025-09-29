<?php
$host = "localhost";
$user = "root";      // default XAMPP user
$pass = "";          // default XAMPP password (kosong)
$dbname = "kita_kaktus_db"; // ganti sesuai nama database kamu

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
