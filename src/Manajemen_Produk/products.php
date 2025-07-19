<?php
include 'includes/db.php';
include 'includes/auth.php';

$result = $conn->query("SELECT * FROM products");
?>

<style>
    .table-wrapper {
        background: #f3e5ff;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .table th {
        background: linear-gradient(to right, #a64dff, #d580ff);
        color: white;
        text-align: center;
        vertical-align: middle;
    }

    .table td {
        vertical-align: middle;
        text-align: center;
        background-color: #fff;
    }

    .table img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .btn-edit {
        background-color: #ffdd57;
        color: black;
        font-weight: 500;
        border: none;
    }

    .btn-delete {
        background-color: #ff6b6b;
        color: white;
        font-weight: 500;
        border: none;
    }

    .btn-edit:hover {
        background-color: #ffe682;
    }

    .btn-delete:hover {
        background-color: #ff4c4c;
    }

    h4.title {
        font-weight: bold;
        background: linear-gradient(to right, #a64dff, #d580ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<div class="table-wrapper">
    <h4 class="title mb-3">📦 Daftar Produk</h4>
    <a href="index.php?page=tambah_product" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Tambah Produk
    </a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['product_name']) ?></td>
                <td>Rp <?= number_format($row['price'], 0, ',', '.') ?></td>
                <td><?= $row['stock'] ?></td>
                <td>
                    <?php if (!empty($row['gambar']) && file_exists($row['gambar'])): ?>
                        <img src="<?= $row['gambar'] ?>" alt="Gambar Produk">
                    <?php else: ?>
                        <span class="text-muted fst-italic">Tidak ada gambar</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="index.php?page=edit_product&id=<?= $row['id'] ?>" class="btn btn-edit btn-sm me-1">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="index.php?page=hapus_product&id=<?= $row['id'] ?>" class="btn btn-delete btn-sm"
                       onclick="return confirm('Yakin hapus produk ini?')">
                        <i class="bi bi-trash-fill"></i>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
