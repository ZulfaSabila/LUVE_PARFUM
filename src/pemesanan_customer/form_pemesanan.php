<?php
include 'includes/auth.php';
include 'includes/db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("<div class='alert alert-danger text-center mt-4'>⚠️ Anda harus login terlebih dahulu.</div>");
}

$produk = $conn->query("SELECT id, product_name, price, gambar FROM products");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

    if ($product_id <= 0 || $quantity <= 0) {
        echo "<div class='alert alert-danger text-center'>❌ Produk dan jumlah harus dipilih dengan benar.</div>";
    } else {
        // Prepare dan eksekusi select price produk
        $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
        if (!$stmt) {
            echo "<div class='alert alert-danger text-center'>Error prepare statement: " . $conn->error . "</div>";
        } else {
            $stmt->bind_param('i', $product_id);
            if (!$stmt->execute()) {
                echo "<div class='alert alert-danger text-center'>Error execute statement: " . $stmt->error . "</div>";
            } else {
                $stmt->bind_result($price);
                if ($stmt->fetch()) {
                    $subtotal = $price * $quantity;
                    $stmt->close();

                    // Insert ke tabel transaksi
                    $insertTrans = $conn->prepare("INSERT INTO transactions (user_id, transaction_date, total) VALUES (?, NOW(), ?)");
                    if (!$insertTrans) {
                        echo "<div class='alert alert-danger text-center'>Error prepare insertTrans: " . $conn->error . "</div>";
                    } else {
                        $insertTrans->bind_param('id', $user_id, $subtotal);
                        if (!$insertTrans->execute()) {
                            echo "<div class='alert alert-danger text-center'>Error execute insertTrans: " . $insertTrans->error . "</div>";
                        } else {
                            $transaction_id = $insertTrans->insert_id;
                            $insertTrans->close();

                            // Insert detail transaksi
                            $insertDetail = $conn->prepare("INSERT INTO transaction_details (transaction_id, product_id, quantity, subtotal) VALUES (?, ?, ?, ?)");
                            if (!$insertDetail) {
                                echo "<div class='alert alert-danger text-center'>Error prepare insertDetail: " . $conn->error . "</div>";
                            } else {
                                $insertDetail->bind_param('iiid', $transaction_id, $product_id, $quantity, $subtotal);
                                if (!$insertDetail->execute()) {
                                    echo "<div class='alert alert-danger text-center'>Error execute insertDetail: " . $insertDetail->error . "</div>";
                                } else {
                                    echo "<div class='alert alert-success text-center mt-3'>✅ Pemesanan berhasil! Terima kasih telah berbelanja 💜</div>";
                                }
                                $insertDetail->close();
                            }
                        }
                    }
                } else {
                    echo "<div class='alert alert-danger text-center'>Produk tidak ditemukan.</div>";
                }
            }
        }
    }
}
?>

<!-- Tampilan Form -->
<div class="container mt-5 p-4 rounded" style="background: #f3e5ff; box-shadow: 0 4px 20px rgba(0,0,0,0.1); max-width: 900px;">
    <h4 class="text-center mb-4 fw-bold" style="background: linear-gradient(to right, #a64dff, #d580ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        🧴 Form Pemesanan Parfum
    </h4>

    <form method="POST">
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 mb-4">
            <?php while ($row = $produk->fetch_assoc()): ?>
            <div class="col">
                <label class="d-block w-100 produk-card">
                    <input type="radio" name="product_id" value="<?= $row['id'] ?>" class="d-none" required>
                    <div class="card h-100 border-0 produk-item" data-product-id="<?= $row['id'] ?>" style="cursor: pointer;">
                        <img src="<?= htmlspecialchars($row['gambar']) ?>" class="card-img-top mx-auto mt-3" style="height: 100px; width: 100px; object-fit: contain;" alt="Produk">
                        <div class="card-body text-center p-2">
                            <h6 class="card-title mb-1" style="font-size: 0.85rem; line-height: 1.2; min-height: 2.4em;">
                                <?= htmlspecialchars($row['product_name']) ?>
                            </h6>
                            <p class="card-text fw-semibold text-purple" style="font-size: 0.8rem;">Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
                        </div>
                    </div>
                </label>
            </div>
            <?php endwhile; ?>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold text-purple">Jumlah</label>
            <input type="number" name="quantity" class="form-control" min="1" value="1" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-bold" style="background: linear-gradient(to right, #ab47bc, #7b1fa2); border: none;">
            🛒 Kirim Pemesanan
        </button>
    </form>
</div>

<!-- Script: Klik kartu akan memilih radio -->
<script>
document.querySelectorAll('.produk-item').forEach(card => {
    card.addEventListener('click', () => {
        document.querySelectorAll('.produk-item').forEach(el => {
            el.classList.remove('border-primary', 'shadow');
        });
        card.classList.add('border-primary', 'shadow');

        const radioInput = card.parentElement.querySelector('input[type="radio"]');
        if (radioInput) {
            radioInput.checked = true;
        }
    });
});
</script>

<!-- CSS: Hover dan Style -->
<style>
.produk-item:hover {
    transform: scale(1.02);
    transition: 0.2s;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.produk-item.border-primary {
    border: 3px solid #a64dff !important;
}
.card-img-top {
    transition: 0.2s ease;
}
.card:hover .card-img-top {
    transform: scale(1.05);
}
.card {
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}
.card-body {
    padding: 10px;
}
</style>
