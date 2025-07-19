<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Koneksi ke database (pakai MySQLi)
include 'includes/db.php';

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = $_POST['nama'];
    $email = $_POST['email'];
    $pesan = $_POST['pesan'];

    $stmt = $conn->prepare("INSERT INTO contacts (nama, email, pesan, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $nama, $email, $pesan);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Pesan berhasil dikirim!</div>";
    } else {
        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . $stmt->error . "</div>";
    }

    $stmt->close();
}
?>

<h3>Hubungi Kami</h3>
<form method="post">
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Pesan</label>
        <textarea name="pesan" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Kirim</button>
</form>
