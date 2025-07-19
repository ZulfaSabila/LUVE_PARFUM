<?php
include 'includes/db.php';
include 'includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = $_POST['product_name'];
    $harga    = $_POST['price'];
    $stok     = $_POST['stock'];
    $kategori = $_POST['category_id'];
    $supplier = $_POST['supplier_id'];

    // Validasi nilai
    if (empty($nama) || empty($harga) || empty($stok) || empty($kategori) || empty($supplier)) {
        die("Semua field wajib diisi!");
    }

    // Upload gambar
    $gambar = '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = basename($_FILES['gambar']['name']);
        $target = $uploadDir . uniqid() . '_' . $filename;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
            $gambar = $target;
        } else {
            die("Upload gambar gagal.");
        }
    }

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO products (product_name, price, stock, category_id, supplier_id, gambar) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiiss", $nama, $harga, $stok, $kategori, $supplier, $gambar);

    if ($stmt->execute()) {
        header("Location: index.php?page=products");
        exit;
    } else {
        echo "Gagal menyimpan produk: " . $stmt->error;
    }
}
