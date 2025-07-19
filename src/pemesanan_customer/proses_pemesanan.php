<?php
include 'includes/auth.php';
include 'includes/db.php';

$user_id = $_SESSION['user_id'] ?? null;
$produk_id = $_POST['produk_id'] ?? [];
$qty = $_POST['qty'] ?? [];

if (!$user_id || empty($produk_id) || empty($qty)) {
    die("Data tidak lengkap.");
}

// Filter produk yang qty-nya > 0
$data_produk = [];
for ($i = 0; $i < count($produk_id); $i++) {
    if ((int)$qty[$i] > 0) {
        $data_produk[] = [
            'id' => (int)$produk_id[$i],
            'qty' => (int)$qty[$i]
        ];
    }
}

if (empty($data_produk)) {
    die("Tidak ada produk yang dipesan.");
}

// Buat transaksi
$conn->query("INSERT INTO transactions (user_id, customer_id, total) VALUES ($user_id, $user_id, 0)");
$transaction_id = $conn->insert_id;

// Insert detail transaksi
$total = 0;
foreach ($data_produk as $item) {
    $id_produk = $item['id'];
    $jumlah = $item['qty'];

    $result = $conn->query("SELECT price FROM products WHERE id = $id_produk");
    if ($result->num_rows > 0) {
        $harga = $result->fetch_assoc()['price'];
        $subtotal = $harga * $jumlah;

        $stmt = $conn->prepare("INSERT INTO transaction_details (transaction_id, product_id, qty, subtotal) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $transaction_id, $id_produk, $jumlah, $subtotal);
        $stmt->execute();

        $total += $subtotal;
    }
}

// Update total di transaksi
$conn->query("UPDATE transactions SET total = $total WHERE id = $transaction_id");

header("Location: index.php?page=riwayat_pemesanan");
exit;
