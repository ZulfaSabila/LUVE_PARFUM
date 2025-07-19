<?php
if (!isset($_SESSION)) session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $_SESSION['role_id'] == 1 ? 'Dashboard Admin' : 'Dashboard Pengguna' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <?= $_SESSION['role_id'] == 1 ? 'Admin Panel - Toko Parfum' : 'Customer - Toko Parfum' ?>
    </a>
    <div class="d-flex">
      <?php if ($_SESSION['role_id'] == 2): ?>
        <a href="index.php?page=form_pemesanan" class="btn btn-outline-light me-2">Pesan Parfum</a>
        <a href="index.php?page=riwayat" class="btn btn-outline-light me-2">Riwayat</a>
      <?php else: ?>
        <a href="index.php?page=dashboard" class="btn btn-outline-light me-2">Dashboard</a>
      <?php endif; ?>
      <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>
<div class="container mt-4">
