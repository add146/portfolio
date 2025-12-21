<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // Kosongkan jika pakai XAMPP default
$db   = 'database_portfolio';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>
