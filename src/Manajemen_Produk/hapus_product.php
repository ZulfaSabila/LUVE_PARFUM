<?php
include 'includes/db.php';
include 'includes/auth.php';

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID produk tidak ditemukan.</div>";
    exit;
}

$id = $_GET['id'];
$conn->query("DELETE FROM products WHERE id = $id");

header("Location: index.php?page=products");
exit;
?>
