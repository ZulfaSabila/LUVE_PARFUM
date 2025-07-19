<?php 
include 'includes/auth.php';
include 'includes/db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("<div class='alert alert-danger text-center mt-4'>Anda harus login terlebih dahulu.</div>");
}

$query = "
SELECT t.id AS transaksi_id, t.transaction_date, t.total, p.product_name, d.quantity, d.subtotal
FROM transactions t
JOIN transaction_details d ON t.id = d.transaction_id
JOIN products p ON d.product_id = p.id
WHERE t.user_id = ?
ORDER BY t.transaction_date DESC
";

$stmt = $conn->prepare($query);
if (!$stmt) {
    die("<div class='alert alert-danger text-center mt-4'>Prepare statement error: " . htmlspecialchars($conn->error) . "</div>");
}

$stmt->bind_param('i', $user_id);
if (!$stmt->execute()) {
    die("<div class='alert alert-danger text-center mt-4'>Execute statement error: " . htmlspecialchars($stmt->error) . "</div>");
}

// Ganti get_result dengan bind_result dan fetch untuk kompatibilitas
// Variabel untuk menampung hasil fetch
$stmt->store_result();

// Ambil metadata kolom
$stmt->bind_result($transaksi_id, $transaction_date, $total, $product_name, $quantity, $subtotal);

$riwayat = [];

while ($stmt->fetch()) {
    $id = $transaksi_id;
    if (!isset($riwayat[$id])) {
        $riwayat[$id] = [
            'tanggal' => $transaction_date,
            'total' => $total,
            'items' => [],
        ];
    }
    $riwayat[$id]['items'][] = [
        'nama_produk' => $product_name,
        'qty' => $quantity,
        'subtotal' => $subtotal,
    ];
}

$stmt->close();
?>

<div class="container mt-4">
    <h4 class="text-center fw-bold mb-4" style="background: linear-gradient(to right, #a64dff, #d580ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        🕒 Riwayat Pemesanan Anda
    </h4>

    <?php if (empty($riwayat)): ?>
        <div class="alert alert-info text-center">Belum ada pemesanan.</div>
    <?php else: ?>

        <?php foreach ($riwayat as $id => $transaksi): ?>
            <div class="card shadow mb-4 border-0">
                <div class="card-header text-white" style="background: linear-gradient(to right, #ba68c8, #9c27b0);">
                    <strong>Transaksi <?= htmlspecialchars($id) ?></strong> - <?= date('d M Y, H:i', strtotime($transaksi['tanggal'])) ?>
                </div>
                <div class="card-body">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>🧴 Produk</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transaksi['items'] as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['nama_produk']) ?></td>
                                    <td><?= htmlspecialchars($item['qty']) ?></td>
                                    <td>Rp <?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold text-end">
                                <td colspan="2" class="text-end">Total</td>
                                <td class="text-dark">Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
</div>
