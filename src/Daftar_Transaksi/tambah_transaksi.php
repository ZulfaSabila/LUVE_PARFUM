<?php
include 'includes/auth.php';
include 'includes/db.php';

// Ambil semua produk ke array
$produk_result = $conn->query("SELECT * FROM products");
$produk_list = [];
while ($row = $produk_result->fetch_assoc()) {
    $produk_list[] = $row;
}

// Ambil daftar customer (role_id = 2)
$customers = $conn->query("SELECT id, name, phone FROM users WHERE role_id = 2");
?>

<h4>Tambah Transaksi</h4>

<form method="POST" action="index.php?page=proses_transaksi">
    <div class="mb-3">
        <label>Customer</label>
        <select name="user_id" class="form-control" required>
            <option value="">-- Pilih Customer --</option>
            <?php while ($c = $customers->fetch_assoc()): ?>
                <option value="<?= $c['id'] ?>">
                    <?= htmlspecialchars($c['name']) ?> (<?= htmlspecialchars($c['phone']) ?>)
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div id="produk-wrapper">
        <div class="row mb-2">
            <div class="col-md-6">
                <label>Produk</label>
                <select name="produk_id[]" class="form-control" required>
                    <option value="">-- Pilih Produk --</option>
                    <?php foreach ($produk_list as $row): ?>
                        <option value="<?= $row['id'] ?>">
                            <?= htmlspecialchars($row['product_name']) ?> - Rp <?= number_format($row['price']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label>Qty</label>
                <input type="number" name="qty[]" class="form-control" min="1" value="1" required>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-secondary mb-2" onclick="tambahProduk()">+ Produk</button>
    <br>
    <button type="submit" class="btn btn-success">Simpan Transaksi</button>
</form>

<script>
function tambahProduk() {
    const wrapper = document.getElementById('produk-wrapper');
    const firstRow = wrapper.querySelector('.row');
    const clone = firstRow.cloneNode(true);

    clone.querySelectorAll('select, input').forEach(el => {
        if (el.tagName === 'SELECT') el.selectedIndex = 0;
        if (el.tagName === 'INPUT') el.value = 1;
    });

    wrapper.appendChild(clone);
}
</script>
