<?php
include 'includes/db.php';
include 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = $_POST['id'];
    $nama       = $_POST['product_name'];
    $harga      = $_POST['price'];
    $stok       = $_POST['stock'];
    $kategori   = $_POST['category_id'];
    $supplier   = $_POST['supplier_id'];

    $stmt = $conn->prepare("UPDATE products SET product_name=?, price=?, stock=?, category_id=?, supplier_id=? WHERE id=?");
    $stmt->bind_param("siiiis", $nama, $harga, $stok, $kategori, $supplier, $id);
    $stmt->execute();

    header("Location: index.php?page=products");
    exit;
}
