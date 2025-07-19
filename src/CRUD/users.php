<?php
include 'includes/db.php';

// Ambil data user dan role
$result = $conn->query("SELECT u.id, u.username, u.name, u.phone, r.role_name FROM users u LEFT JOIN roles r ON u.role_id = r.id");
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

    h2.title {
        font-weight: bold;
        background: linear-gradient(to right, #a64dff, #d580ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .text-muted-custom {
        color: #999;
        font-style: italic;
    }
</style>

<div class="table-wrapper">
    <h2 class="title mb-3">👥 Daftar Pengguna</h2>
    <a href="index.php?page=tambah_user" class="btn btn-primary mb-3">
        <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
    </a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>No HP</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['username'] ?: "<span class='text-muted-custom'>[username kosong]</span>" ?></td>
                <td><?= $row['phone'] ?: "<span class='text-muted-custom'>[tidak ada no hp]</span>" ?></td>
                <td><?= $row['role_name'] ?: "<span class='text-muted-custom'>-</span>" ?></td>
                <td>
                    <a href="CRUD/edit_user.php?id=<?= $row['id'] ?>" class="btn btn-edit btn-sm me-1">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <a href="CRUD/hapus_user.php?id=<?= $row['id'] ?>" class="btn btn-delete btn-sm"
                       onclick="return confirm('Yakin ingin hapus?')">
                        <i class="bi bi-trash-fill"></i>
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
