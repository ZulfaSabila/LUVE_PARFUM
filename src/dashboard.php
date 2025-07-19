<?php
include 'includes/auth.php';
include 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Toko Parfum</a>
        <div class="d-flex">
            <a href="logout.php" class="btn btn-outline-light">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h3 class="fw-bold">Selamat Datang di <span class="text-primary">Dashboard Toko Parfum</span></h3>
    <p>Jelajahi Koleksi Parfum dan Atur Penjualanmu di Sini</p>
    
    <div class="row mt-4">
        <div class="col-md-3">
            <a href="users.php" class="btn btn-outline-primary w-100 mb-3">
                👥 Manajemen Pengguna
            </a>
        </div>
        <div class="col-md-3">
            <a href="products.php" class="btn btn-outline-success w-100 mb-3">
                🛍️ Produk
            </a>
        </div>
        <div class="col-md-3">
            <a href="categories.php" class="btn btn-outline-warning w-100 mb-3">
                🏷️ Kategori
            </a>
        </div>
        <div class="col-md-3">
            <a href="transactions.php" class="btn btn-outline-danger w-100 mb-3">
                📄 Transaksi
            </a>
        </div>
        <div class="col-md-3">
            <a href="report.php" class="btn btn-outline-dark w-100 mb-3">
                📊 Laporan
            </a>
        </div>
        <div class="col-md-3">
            <a href="laporan/contacts.php" class="btn btn-outline-secondary w-100 mb-3">
                ✉️ Kontak Masuk
            </a>
        </div>
    </div>
</div>

</body>
</html>
