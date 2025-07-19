<?php
include 'includes/auth.php';
include 'includes/db.php';

$query = "
SELECT 
    t.id AS transaksi_id, 
    t.transaction_date, 
    u.username, 
    p.product_name, 
    d.quantity, 
    d.subtotal
FROM transactions t
JOIN users u ON t.user_id = u.id
JOIN transaction_details d ON t.id = d.transaction_id
JOIN products p ON d.product_id = p.id
ORDER BY t.transaction_date DESC
";

$result = $conn->query($query);

// Susun data berdasarkan transaksi
$laporan = [];
while ($row = $result->fetch_assoc()) {
    $id = $row['transaksi_id'];
    if (!isset($laporan[$id])) {
        $laporan[$id] = [
            'tanggal' => $row['transaction_date'],
            'username' => $row['username'],
            'items' => [],
        ];
    }
    $laporan[$id]['items'][] = [
        'nama_produk' => $row['product_name'],
        'qty' => $row['quantity'],
        'subtotal' => $row['subtotal'],
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f4e6ff;
        }

        h3.title {
            font-weight: bold;
            background: linear-gradient(to right, #a64dff, #d580ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
        }

        .card {
            border-radius: 20px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
            border: none;
        }

        .card-header {
            background: linear-gradient(to right, #a64dff, #d580ff);
            font-weight: 500;
            color: white;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .table th {
            background-color: #ede7f6;
            text-align: center;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
            background-color: #fff;
        }

        .table tfoot th {
            background-color: #f3e5ff;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h3 class="title mb-4">📊 Laporan Transaksi Penjualan</h3>
    <?php foreach ($laporan as $id => $transaksi): ?>
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-receipt"></i> Transaksi <?= $id ?> • <?= date('d M Y H:i', strtotime($transaksi['tanggal'])) ?> • oleh <strong><?= htmlspecialchars($transaksi['username']) ?></strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($transaksi['items'] as $item): ?>
                        <?php $total += $item['subtotal']; ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nama_produk']) ?></td>
                            <td><?= $item['qty'] ?></td>
                            <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total</th>
                            <th>Rp <?= number_format($total, 0, ',', '.') ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
