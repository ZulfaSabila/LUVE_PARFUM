<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name       = $_POST['name'];
    $phone      = $_POST['phone'];
    $product_id = $_POST['product_id'];
    $quantity   = $_POST['quantity'];

    if (!$name || !$phone || !$product_id || !$quantity) {
        die("<div class='alert alert-danger text-center mt-3'>⚠️ Semua field wajib diisi.</div>");
    }

    $check = $conn->prepare("SELECT id FROM users WHERE name = ? AND phone = ? AND role_id = 2");
    $check->bind_param('ss', $name, $phone);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];
    } else {
        $username = strtolower(preg_replace('/\s+/', '', $name)) . rand(100, 999);
        $password_hash = password_hash('123456', PASSWORD_DEFAULT);
        $role_id = 2;

        $insertUser = $conn->prepare("INSERT INTO users (username, password, role_id, name, phone) VALUES (?, ?, ?, ?, ?)");
        $insertUser->bind_param('ssiss', $username, $password_hash, $role_id, $name, $phone);
        $insertUser->execute();
        $user_id = $insertUser->insert_id;
    }

    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $product = $res->fetch_assoc();
    $price = $product['price'];
    $subtotal = $price * $quantity;

    $insertTrans = $conn->prepare("INSERT INTO transactions (user_id, transaction_date, total) VALUES (?, NOW(), ?)");
    $insertTrans->bind_param('id', $user_id, $subtotal);
    $insertTrans->execute();
    $transaction_id = $insertTrans->insert_id;

    $insertItem = $conn->prepare("INSERT INTO transaction_details (transaction_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?)");
    $insertItem->bind_param('iiid', $transaction_id, $product_id, $quantity, $subtotal);
    $insertItem->execute();

    echo "<div class='alert alert-success text-center mt-4'>✅ Pesanan berhasil dikirim! Terima kasih telah mempercayai kami 💜</div>";
}

$products = $conn->query("SELECT id, product_name, price FROM products");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemesanan Tanpa Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f3e5f5, #e1bee7);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-card {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            padding: 30px;
            width: 100%;
            max-width: 600px;
        }
        .form-title {
            font-weight: bold;
            text-align: center;
            background: linear-gradient(to right, #ab47bc, #7b1fa2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.5rem;
            margin-bottom: 25px;
        }
        .btn-gradient {
            background: linear-gradient(to right, #ab47bc, #7b1fa2);
            border: none;
        }
        .btn-gradient:hover {
            background: linear-gradient(to right, #8e24aa, #6a1b9a);
        }
    </style>
</head>
<body>

<div class="form-card">
    <div class="form-title">🧾 Form Pemesanan Parfum Tanpa Login</div>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" placeholder="Contoh: Hana Putri" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor HP</label>
            <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Pilih Produk</label>
            <select name="product_id" class="form-select" required>
                <option value="">-- Pilih Produk --</option>
                <?php while($row = $products->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>">
                        <?= htmlspecialchars($row['product_name']) ?> - Rp <?= number_format($row['price'], 0, ',', '.') ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="quantity" class="form-control" value="1" min="1" required>
        </div>
        <button type="submit" class="btn btn-gradient text-white w-100 fw-semibold">
            <i class="bi bi-send-fill"></i> Kirim Pesanan
        </button>
    </form>
</div>

</body>
</html>
