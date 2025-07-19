<?php
session_start();
include 'includes/db.php';

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($username) || empty($password)) {
        $error = "Username dan password harus diisi.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, role_id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result(); // simpan hasil ke buffer

    // Bind kolom database ke variabel PHP
    $stmt->bind_result($id, $db_username, $db_password, $role_id);

    if ($stmt->fetch()) {
    // Verifikasi password
    if (password_verify($password, $db_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['role_id'] = $role_id;
        $_SESSION['username'] = $db_username;

        if ($role_id == 1) {
            header("Location: index.php?page=dashboard");
        } else {
            header("Location: index.php?page=form_pemesanan");
        }
        exit;
    } else {
        $error = "Username atau password salah.";
    }
} else {
    $error = "Username atau password salah.";
}


        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['username'] = $user['username'];

            if ($user['role_id'] == 1) {
                header("Location: index.php?page=dashboard");
            } else {
                header("Location: index.php?page=form_pemesanan");
            }
            exit;
        } else {
            $error = "Username atau password salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #d580ff, #8ec5fc);
        }
        .login-container {
            max-width: 450px;
            margin: 80px auto;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-title {
            color: #a933ff;
            font-weight: bold;
            font-size: 24px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2 class="text-center form-title mb-4">🔐 Login Akun</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif (isset($_GET['success'])): ?>
        <div class="alert alert-success">Akun berhasil didaftarkan. Silakan login.</div>
    <?php endif; ?>

    <form method="post" autocomplete="off">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>" required autocomplete="username">
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required autocomplete="current-password">
        </div>
        <button class="btn btn-primary w-100" type="submit">Login</button>
    </form>

    <p class="mt-3 text-center">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</div>
</body>
</html>
