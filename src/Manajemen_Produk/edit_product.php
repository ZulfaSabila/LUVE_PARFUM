<?php
include 'includes/db.php';
include 'includes/auth.php';

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID produk tidak ditemukan.</div>";
    exit;
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM products WHERE id = $id");
$produk = $result->fetch_assoc();

$kategori = $conn->query("SELECT * FROM categories");
$supplier = $conn->query("SELECT * FROM suppliers");
?>

<h4>Edit Produk</h4>
<form action="index.php?page=proses_edit_product" method="POST">
    <input type="hidden" name="id" value="<?= $produk['id'] ?>">
    <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text" name="product_name" class="form-control" value="<?= $produk['product_name'] ?>" required>
    </div>
    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="price" class="form-control" value="<?= $produk['price'] ?>" required>
    </div>
    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stock" class="form-control" value="<?= $produk['stock'] ?>" required>
    </div>
    <div class="mb-3">
        <label>Kategori</label>
        <select name="category_id" class="form-control">
            <?php while ($kat = $kategori->fetch_assoc()): ?>
                <option value="<?= $kat['id'] ?>" <?= $kat['id'] == $produk['category_id'] ? 'selected' : '' ?>>
                    <?= $kat['category_name'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Supplier</label>
        <select name="supplier_id" class="form-control">
            <?php while ($sup = $supplier->fetch_assoc()): ?>
                <option value="<?= $sup['id'] ?>" <?= $sup['id'] == $produk['supplier_id'] ? 'selected' : '' ?>>
                    <?= $sup['name'] ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="index.php?page=products" class="btn btn-secondary">Kembali</a>
</form>
