<?php
include '../../includes/auth.php';
include '../../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID kategori tidak ditemukan.");
}

$stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
    die("Gagal menghapus kategori.");
}
$stmt->close();

header("Location: ../../index.php?page=categories");
exit;
