<?php
include '../../includes/auth.php';
include '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../index.php?page=edit_kategori");
    exit;
}

$id = $_POST['id'] ?? '';
$category_name = trim($_POST['category_name'] ?? '');

if ($id === '' || $category_name === '') {
    die("ID atau nama kategori tidak boleh kosong.");
}

$stmt = $conn->prepare("UPDATE categories SET category_name = ? WHERE id = ?");
$stmt->bind_param("si", $category_name, $id);

if ($stmt->execute()) {
    header("Location: index.php?page=categories&updated=1");
    exit;
} else {
    die("Gagal update kategori: " . $stmt->error);
}
?>
