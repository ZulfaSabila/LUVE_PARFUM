<?php
include 'includes/db.php';

$no = 1;
$query = "SELECT t.*, u.name AS user_name FROM transactions t
          JOIN users u ON t.user_id = u.id
          ORDER BY t.transaction_date DESC";
$result = $conn->query($query);
?>

<style>
    .table-wrapper {
        background: #f3e5ff;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .table th {
        background: linear-gradient(to right, #a64dff, #d580ff);
        color: white;
        text-align: center;
        vertical-align: middle;
    }

    .table td {
        background-color: #fff;
        text-align: center;
        vertical-align: middle;
    }

    h3.title {
        font-weight: bold;
        background: linear-gradient(to right, #a64dff, #d580ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<div class="table-wrapper">
    <h3 class="title mb-3">🧾 Daftar Transaksi</h3>
    <a href="index.php?page=tambah_transaksi" class="btn btn-primary mb-3">
        <i class="bi bi-cart-plus-fill"></i> Tambah Transaksi
    </a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Pengguna</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['user_name']) ?></td>
                    <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                    <td><?= date('d M Y, H:i', strtotime($row['transaction_date'])) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
