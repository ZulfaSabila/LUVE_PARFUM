# 🔐 Login

## a. Login Admin
- Akses melalui: `login.php`
- Masukkan username dan password:
  - Username: (sesuai data di database)
  - Password: `admin123`
- Setelah login berhasil, admin akan diarahkan ke dashboard admin.

## b. Login Customer
- Akses melalui halaman depan atau langsung ke `login.php`
- Jika belum memiliki akun, klik menu Daftar untuk registrasi akun baru.

---

# 🧭 Navigasi Halaman

Setelah login, pengguna akan diarahkan ke dashboard sesuai perannya.

## a. Admin
Sidebar Menu:
- Dashboard: Menampilkan ringkasan statistik (jumlah produk, transaksi, pengguna)
- Manajemen Produk:
  - Tambah, edit, dan hapus produk
  - Kelola kategori produk
- Daftar Transaksi:
  - Lihat histori pembelian semua pelanggan
- Laporan:
  - Cetak laporan transaksi berdasarkan tanggal
- Logout: Keluar dari sistem

## b. Customer
- Lihat produk
- Tambahkan produk ke keranjang
- Checkout
- Cek status transaksi
- Akses halaman Hubungi Kami

---

# 📦 Manajemen Produk (Admin)

Masuk ke menu Manajemen Produk di sidebar admin.

## a. Tambah Produk
- Klik Tambah Produk
- Isi form: nama produk, harga, stok, kategori, supplier, dan upload gambar
- Klik Simpan

## b. Edit Produk
- Klik tombol Edit pada daftar produk
- Ubah data yang dibutuhkan, lalu klik Simpan

## c. Hapus Produk
- Klik tombol Hapus untuk menghapus produk dari sistem

---

# 🧾 Transaksi

## a. Admin
- Akses menu Daftar Transaksi untuk melihat semua transaksi pelanggan
- Urutkan berdasarkan tanggal
- Cetak laporan melalui menu Laporan

## b. Customer
- Tambahkan produk ke keranjang
- Checkout dari keranjang
- Isi alamat pengiriman
- Lihat status pesanan

---

# 🛡️ Keamanan

- Sistem menggunakan autentikasi berbasis role: admin, kasir, customer
- Password disimpan dengan metode enkripsi (hash) – lihat file `hash.php`
- Session login divalidasi menggunakan `$_SESSION`
- Halaman sensitif tidak bisa diakses tanpa login
- Validasi form dilakukan di sisi client dan server

---

# 📞 Hubungi Kami (Customer)

Customer dapat mengisi form kontak:
- Nama
- Email
- Pesan

Data akan disimpan di tabel `contacts` beserta timestamp saat dikirim.

---

# 🧩 Fitur Lain

- Registrasi Customer: melalui `register.php`
- Dasbor Customer: menampilkan daftar pesanan dan statusnya
