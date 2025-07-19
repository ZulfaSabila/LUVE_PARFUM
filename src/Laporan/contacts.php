<?php  
include 'includes/auth.php';
include 'includes/db.php';

$query = "SELECT * FROM contacts ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<h3 class="mb-4 fw-bold">Pesan Masuk dari Customer</h3>

<?php if (mysqli_num_rows($result) > 0): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Pesan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['pesan'])) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">Belum ada pesan masuk dari pelanggan.</div>
<?php endif; ?>
