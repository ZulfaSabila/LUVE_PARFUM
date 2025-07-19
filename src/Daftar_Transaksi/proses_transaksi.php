<?php
include '../db.php'; // atau sesuaikan path jika beda
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $product_ids = $_POST['produk_id'] ?? [];
    $quantities = $_POST['qty'] ?? [];

    if (!$user_id || empty($product_ids) || empty($quantities) || count($product_ids) !== count($quantities)) {
        die("Data tidak lengkap.");
    }

    // Insert transaksi baru
    $insertTrans = $conn->prepare("INSERT INTO transactions (user_id, transaction_date, total) VALUES (?, NOW(), 0)");
    $insertTrans->bind_param('i', $user_id);
    $insertTrans->execute();
    $transaction_id = $insertTrans->insert_id;

    $total = 0;

    // Siapkan statement
    $getPrice = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $insertDetail = $conn->prepare("INSERT INTO transaction_details (transaction_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?)");

    for ($i = 0; $i < count($product_ids); $i++) {
        $pid = $product_ids[$i];
        $qty = $quantities[$i];

        $getPrice->bind_param('i', $pid);
        $getPrice->execute();
        $getPrice->bind_result($price);
        $getPrice->store_result();

        if ($getPrice->fetch()) {
            $subtotal = $price * $qty;
            $total += $subtotal;

            $insertDetail->bind_param('iiid', $transaction_id, $pid, $qty, $subtotal);
            $insertDetail->execute();
        }

        $getPrice->free_result(); // ✅ WAJIB untuk loop berikutnya
    }

    // Update total transaksi
    $updateTotal = $conn->prepare("UPDATE transactions SET total = ? WHERE id = ?");
    $updateTotal->bind_param('di', $total, $transaction_id);
    $updateTotal->execute();

    header("Location: ../index.php?page=transactions&success=1");
    exit();
}
?>
