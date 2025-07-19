<?php
// Perbaiki path jika file ini ada di folder Manajemen_Produk/Kategori/
include '../../auth.php';
include '../../db.php';

// Validasi method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../index.php?page=tambah_kategori");
    exit;
}

// Ambil input dan validasi
$category_name = trim($_POST['category_name'] ?? '');

if ($category_name === '') {
    die('Nama kategori tidak boleh kosong.');
}

// Simpan ke database
$stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
if (!$stmt) {
    die('Query prepare gagal: ' . htmlspecialchars($conn->error));
}
$stmt->bind_param("s", $category_name);
if (!$stmt->execute()) {
    die('Query eksekusi gagal: ' . htmlspecialchars($stmt->error));
}
$stmt->close();

// Redirect ke halaman kategori
header("Location: ../../index.php?page=categories");
exit;
?>
