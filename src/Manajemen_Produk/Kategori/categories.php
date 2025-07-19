<?php
include 'includes/auth.php';
include 'includes/db.php';

// Prepare query select semua kategori
$stmt = $conn->prepare("SELECT id, category_name FROM categories ORDER BY id ASC");
if (!$stmt) {
    die("<div class='alert alert-danger'>Prepare statement error: " . htmlspecialchars($conn->error) . "</div>");
}

if (!$stmt->execute()) {
    die("<div class='alert alert-danger'>Execute statement error: " . htmlspecialchars($stmt->error) . "</div>");
}

$stmt->store_result();
$stmt->bind_result($id, $category_name);

$categories = [];
while ($stmt->fetch()) {
    $categories[] = [
        'id' => $id,
        'category_name' => $category_name,
    ];
}
$stmt->close();
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

    h3.title {
        font-weight: bold;
        background: linear-gradient(to right, #a64dff, #d580ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>

<div class="table-wrapper">
    <h3 class="title mb-3">🏷️ Manajemen Kategori Parfum</h3>
    <a href="index.php?page=tambah_kategori" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle-fill"></i> Tambah Kategori
    </a>

    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nama Kategori</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($categories) === 0): ?>
            <tr>
                <td colspan="3" class="text-center">Belum ada kategori.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($categories as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['category_name']) ?></td>
                    <td>
                        <a href="index.php?page=edit_kategori&id=<?= urlencode($row['id']) ?>" class="btn btn-edit btn-sm me-1" title="Edit Kategori">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="index.php?page=hapus_kategori&id=<?= urlencode($row['id']) ?>" class="btn btn-delete btn-sm" title="Hapus Kategori" onclick="return confirm('Yakin hapus?')">
                            <i class="bi bi-trash-fill"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
