<?php
include 'includes/auth.php';
include 'includes/db.php';

// Validasi data POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password_plain = $_POST['password'] ?? '';
    $role_id = $_POST['role_id'] ?? '';

    // Validasi minimal
    if ($username && $password_plain && $role_id) {
        $password = password_hash($password_plain, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $username, $password, $role_id);
        $stmt->execute();

        // Kembali ke halaman users (pakai routing)
        header("Location: index.php?page=users");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Data tidak lengkap. Pastikan semua form diisi.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Akses tidak valid.</div>";
}
?>
