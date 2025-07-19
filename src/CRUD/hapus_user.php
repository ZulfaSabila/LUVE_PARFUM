<?php
include __DIR__ . '/../includes/db.php';

if (!isset($_GET['id'])) {
    die("ID pengguna tidak ditemukan.");
}

$id = intval($_GET['id']);

// Hapus detail transaksi terlebih dahulu (karena relasi ke transaction_id)
$hapusDetail = $conn->prepare("
    DELETE td FROM transaction_details td
    JOIN transactions t ON td.transaction_id = t.id
    WHERE t.user_id = ?
");
$hapusDetail->bind_param("i", $id);
$hapusDetail->execute();

// Hapus transaksi milik user
$hapusTransaksi = $conn->prepare("DELETE FROM transactions WHERE user_id = ?");
$hapusTransaksi->bind_param("i", $id);
$hapusTransaksi->execute();

// Hapus user
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: ../index.php?page=users&deleted=1");
    exit;
} else {
    echo "Gagal menghapus pengguna.";
}
?>
