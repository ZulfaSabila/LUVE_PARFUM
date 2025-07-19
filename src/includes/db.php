<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'toko_parfum';

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die('Koneksi ke database gagal: ' . $conn->connect_error);
}
?>
