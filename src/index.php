<?php 
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role_id'])) {
    header("Location: login.php");
    exit;
}
include 'includes/auth.php';
include 'includes/db.php';

$page = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $_SESSION['role_id'] == 1 ? 'Dashboard Admin' : 'Dashboard Pengguna' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5e6ff;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .sidebar {
            width: 240px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background: linear-gradient(to bottom, #a64dff, #d580ff);
            padding: 20px;
            color: white;
        }
        .sidebar h4 {
            font-weight: bold;
            margin-bottom: 30px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px 0;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding-left: 10px;
        }
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }
        .card-hover {
            background: #fff;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            color: inherit;
        }
        .card-hover:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
        h3 span {
            background: linear-gradient(to right, #a64dff, #d580ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .logout-btn {
            position: absolute;
            bottom: 20px;
            width: calc(100% - 40px);
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4><?= $_SESSION['role_id'] == 1 ? 'Admin Panel' : 'Customer Area' ?></h4>
    <?php if ($_SESSION['role_id'] == 1): ?>
        <a href="index.php?page=dashboard"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a href="index.php?page=users"><i class="bi bi-people-fill me-2"></i> Pengguna</a>
        <a href="index.php?page=products"><i class="bi bi-bag-fill me-2"></i> Produk</a>
        <a href="index.php?page=categories"><i class="bi bi-tags-fill me-2"></i> Kategori</a>
        <a href="index.php?page=transactions"><i class="bi bi-receipt-cutoff me-2"></i> Transaksi</a>
        <a href="index.php?page=report"><i class="bi bi-bar-chart-fill me-2"></i> Laporan</a>
        <a href="index.php?page=contacts"><i class="bi bi-envelope-fill me-2"></i> Kontak Masuk</a>
    <?php else: ?>
        <a href="index.php?page=form_pemesanan"><i class="bi bi-cart-plus-fill me-2"></i> Pesan Parfum</a>
        <a href="index.php?page=riwayat"><i class="bi bi-clock-history me-2"></i> Riwayat</a>
        <a href="index.php?page=hubungi_kami"><i class="bi bi-envelope-paper-fill me-2"></i> Hubungi Kami</a>
    <?php endif; ?>
    <a href="logout.php" class="btn btn-warning logout-btn">Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
<?php
switch ($page) {
    case 'dashboard':
        ?>
        <h3 class="mb-4 fw-bold">Selamat Datang di <span>Dashboard Toko Parfum</span></h3>
        <p class="text-muted">Jelajahi Koleksi Parfum dan Atur Penjualanmu di Sini</p>

        <div class="row g-4">
            <?php if ($_SESSION['role_id'] == 1): ?>
                <div class="col-md-3">
                    <a href="index.php?page=users" class="card card-hover text-center p-4 d-block">
                        <i class="bi bi-people-fill display-6 text-primary"></i>
                        <h6 class="mt-2">Manajemen Pengguna</h6>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="index.php?page=contacts" class="card card-hover text-center p-4 d-block">
                        <i class="bi bi-envelope-fill display-6 text-info"></i>
                        <h6 class="mt-2">Kontak Masuk</h6>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="index.php?page=products" class="card card-hover text-center p-4 d-block">
                        <i class="bi bi-bag-fill display-6 text-success"></i>
                        <h6 class="mt-2">Produk</h6>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="index.php?page=categories" class="card card-hover text-center p-4 d-block">
                        <i class="bi bi-tags-fill display-6 text-warning"></i>
                        <h6 class="mt-2">Kategori</h6>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="index.php?page=transactions" class="card card-hover text-center p-4 d-block">
                        <i class="bi bi-receipt-cutoff display-6 text-danger"></i>
                        <h6 class="mt-2">Transaksi</h6>
                    </a>
                </div>
            <?php else: ?>
                <div class="col-md-6">
                    <a href="index.php?page=form_pemesanan" class="card card-hover text-center p-4 d-block">
                        <i class="bi bi-cart-plus-fill display-6 text-success"></i>
                        <h6 class="mt-2">Pesan Parfum</h6>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="index.php?page=riwayat" class="card card-hover text-center p-4 d-block">
                        <i class="bi bi-clock-history display-6 text-primary"></i>
                        <h6 class="mt-2">Riwayat Pemesanan</h6>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        <?php
        break;

    case 'users':
        include 'CRUD/users.php'; break;
    case 'proses_tambah_user':
        include 'CRUD/proses_tambah_user.php'; break;
    case 'tambah_user':
        include 'CRUD/tambah_user.php'; break;
    case 'edit_user':
        include 'CRUD/edit_user.php'; break;
    case 'hapus_user':
        include 'CRUD/hapus_user.php'; break;

    case 'products':
        include 'Manajemen_Produk/products.php'; break;
    case 'tambah_product':
        include 'Manajemen_Produk/tambah_product.php'; break;
    case 'edit_product':
        include 'Manajemen_Produk/edit_product.php'; break;
    case 'hapus_product':
        include 'Manajemen_Produk/hapus_product.php'; break;
    case 'proses_tambah_product':
        include 'Manajemen_Produk/proses_tambah_product.php'; break;
    case 'proses_edit_product':
        include 'Manajemen_Produk/proses_edit_product.php'; break;

    case 'categories':
        include 'Manajemen_Produk/Kategori/categories.php'; break;
    case 'tambah_kategori':
        include 'Manajemen_Produk/Kategori/tambah_kategori.php'; break;
    case 'proses_tambah_kategori':
        include 'Manajemen_Produk/Kategori/proses_tambah_kategori.php'; break;
    case 'edit_kategori':
        include 'Manajemen_Produk/Kategori/edit_kategori.php'; break;
    case 'proses_edit_kategori':
        include 'Manajemen_Produk/Kategori/proses_edit_kategori.php'; break;
    case 'hapus_kategori':
        include 'Manajemen_Produk/Kategori/hapus_kategori.php'; break;

    case 'transactions':
        include 'Daftar_Transaksi/transactions.php'; break;
    case 'tambah_transaksi':
        include 'Daftar_Transaksi/tambah_transaksi.php'; break;
    case 'proses_transaksi':
        include 'Daftar_Transaksi/proses_transaksi.php'; break;
    case 'detail_transaksi':
        include 'Daftar_Transaksi/detail_transaksi.php'; break;

    case 'report':
        include 'Laporan/report_transactions.php'; break;
    
    case 'contacts':
        include 'Laporan/contacts.php'; break;

    case 'form_pemesanan':
        include 'pemesanan_customer/form_pemesanan.php'; break;
    case 'proses_pemesanan':
        include 'pemesanan_customer/proses_pemesanan.php'; break;
    case 'riwayat':
        include 'pemesanan_customer/riwayat_pemesanan.php'; break;
    case 'hubungi_kami':
        include 'pemesanan_customer/hubungi_kami.php'; break;

    default:
        echo "<div class='alert alert-danger'>Halaman tidak ditemukan.</div>";
}
?>
</div>
</body>
</html>
