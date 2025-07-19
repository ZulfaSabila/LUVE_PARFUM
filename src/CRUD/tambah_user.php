<?php
include 'includes/auth.php';
include 'includes/db.php';

$roles = $conn->query("SELECT * FROM roles");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Tambah Pengguna</h3>
    <form action="index.php?page=proses_tambah_user" method="post">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role_id" class="form-control" required>
                <?php while ($r = $roles->fetch_assoc()): ?>
                    <option value="<?= $r['id'] ?>"><?= $r['role_name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php?page=users" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
