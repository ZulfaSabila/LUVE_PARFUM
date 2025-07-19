<?php
include '../includes/db.php';

if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = $_GET['id'];

// Ambil data user berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "User tidak ditemukan.";
    exit;
}

$roles = $conn->query("SELECT * FROM roles");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role_id = $_POST['role_id'];

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, role_id = ? WHERE id = ?");
        $stmt->bind_param("ssii", $username, $hashed, $role_id, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, role_id = ? WHERE id = ?");
        $stmt->bind_param("sii", $username, $role_id, $id);
    }

    if ($stmt->execute()) {
        header("Location: ../index.php?page=users");
        exit;
    } else {
        echo "Gagal update data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5e6ff;
            font-family: 'Segoe UI', sans-serif;
        }
        .card-custom {
            max-width: 600px;
            margin: 50px auto;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            background: #fff;
        }
        .card-header {
            background: linear-gradient(to right, #a64dff, #d580ff);
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
    </style>
</head>
<body>

<div class="card card-custom">
    <div class="card-header p-3">
        <h5 class="mb-0">Edit Pengguna</h5>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password Baru (opsional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role_id" class="form-control" required>
                    <?php while ($role = $roles->fetch_assoc()): ?>
                        <option value="<?= $role['id'] ?>" <?= $role['id'] == $user['role_id'] ? 'selected' : '' ?>>
                            <?= $role['role_name'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="../index.php?page=users" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
