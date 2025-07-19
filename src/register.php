<?php
include 'includes/db.php';

$username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
$phone    = isset($_POST["phone"]) ? trim($_POST["phone"]) : "";
$password = isset($_POST["password"]) ? trim($_POST["password"]) : "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($username) || empty($phone) || empty($password)) {
        $error = "Semua field harus diisi.";
    } elseif (!preg_match('/^08[0-9]{8,13}$/', $phone)) {
        $error = "Format nomor HP tidak valid. Gunakan format seperti 08xxxxxxxxxx.";
    } else {
        // Cek apakah username sudah digunakan
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username sudah terdaftar.";
            $stmt->close();
        } else {
            $stmt->close();

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role_id = 2;

            $stmt = $conn->prepare("INSERT INTO users (username, password, role_id, phone) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $username, $hashed_password, $role_id, $phone);

            if ($stmt->execute()) {
                header("Location: login.php?success=1");
                exit;
            } else {
                $error = "Gagal mendaftar. Silakan coba lagi.";
            }

            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #d580ff, #8ec5fc);
        }
        .register-container {
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
<div class="register-container">
    <h2 class="text-center form-title mb-4">📁 Daftar Akun</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" autocomplete="off">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($username) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor HP</label>
            <input type="tel" class="form-control" name="phone" value="<?= htmlspecialchars($phone) ?>" required inputmode="numeric">
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required autocomplete="new-password">
        </div>
        <button class="btn btn-primary w-100" type="submit">Daftar</button>
    </form>

    <p class="mt-3 text-center">Sudah punya akun? <a href="login.php">Login di sini</a></p>
</div>
</body>
</html>
