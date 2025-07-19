<?php 
include 'includes/db.php';
include 'includes/auth.php';

// Ambil data kategori dan supplier
$kategori = $conn->query("SELECT * FROM categories");
$supplier = $conn->query("SELECT * FROM suppliers");
?>

<h4>Tambah Produk Baru</h4>

<form action="index.php?page=proses_tambah_product" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Nama Produk</label>
        <input type="text" name="product_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Harga</label>
        <input type="number" name="price" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Stok</label>
        <input type="number" name="stock" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Kategori</label>
        <select name="category_id" class="form-control" required>
            <option value="">-- Pilih Kategori --</option>
            <?php while ($kat = $kategori->fetch_assoc()): ?>
                <option value="<?= $kat['id'] ?>"><?= htmlspecialchars($kat['category_name']) ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Supplier</label>
        <select name="supplier_id" class="form-control" required>
            <option value="">-- Pilih Supplier --</option>
            <?php while ($sup = $supplier->fetch_assoc()): ?>
                <option value="<?= $sup['id'] ?>"><?= htmlspecialchars($sup['name']) ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Gambar Produk</label>
        <input type="file" name="gambar" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="index.php?page=products" class="btn btn-secondary">Kembali</a>
</form>
