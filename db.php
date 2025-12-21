<?php
$host = 'localhost';
$user = 'pefsdzhc_akhirudin';
$pass = 'Udin2015'; // Kosongkan jika pakai XAMPP default
$db   = 'pefsdzhc_portfolio';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>