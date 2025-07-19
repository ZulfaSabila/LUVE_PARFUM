<?php
include __DIR__ . '/../../includes/auth.php';
include __DIR__ . '/../../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die('ID tidak ditemukan.');
}

$query = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$kategori = $result->fetch_assoc();

if (!$kategori) {
    die("Kategori tidak ditemukan.");
}
?>

<div class="container mt-5">
    <h2>Edit Kategori</h2>
    <form action="index.php?page=proses_edit_kategori" method="post">
        <input type="hidden" name="id" value="<?= $kategori['id'] ?>">
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="category_name" value="<?= htmlspecialchars($kategori['category_name']) ?>" class="form-control" required>
        </div>
        <br>
        <input type="submit" value="Update" class="btn btn-primary">
        <a href="../../index.php?page=categories" class="btn btn-secondary">Kembali</a>
    </form>
</div>
