<?php include 'includes/auth.php'; ?>
<h3>Tambah Kategori</h3>
<form action="index.php?page=proses_tambah_kategori" method="post">

    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="category_name" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="../../index.php?page=categories" class="btn btn-secondary">Kembali</a>
</form>
