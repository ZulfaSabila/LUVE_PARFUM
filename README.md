# 🌸 Toko Parfum – Aplikasi Pemesanan dan Manajemen Penjualan Parfum

Selamat datang di repositori **Toko Parfum**, sebuah aplikasi web berbasis HTML, PHP Native, Javascript dan MySQL yang digunakan untuk mengelola data produk parfum, pemesanan pelanggan, serta transaksi penjualan secara online dan efisien.

---

## 📽️ Video Demo

[Link Youtube]https://youtu.be/NAieXu3PV7k?si=kqAAhH5INh2Y4F9Z

---

## 🌐 Hosting & Demo

[Link Hosting]http://luveparfum.web.id/

---

## 📌 Fitur Unggulan

### 🔐 Login
- Admin: Login menggunakan username & password  
  ➤ Default login:  
  `username: admin`  
  `password: admin123`

- Customer: klik menu Daftar untuk registrasi akun baru.

---

### 👩‍💼 Modul Admin
- Dashboard statistik transaksi, produk, dan pelanggan
- Manajemen User/Admin
- Manajemen Kategori Parfum
- Manajemen Produk Parfum & Gambar
- Manajemen Supplier
- Lihat & Kelola Data Transaksi
- Riwayat Aktivitas Admin (Log Aktivitas)
- Kelola Setting Toko
- Kelola Kontak Masuk (Hubungi Kami)

---

### 🧍‍♂️ Modul Customer
- Melihat daftar parfum berdasarkan kategori
- Melakukan pemesanan (form pemesanan + detail pengiriman)
- Mengirim pesan ke toko melalui fitur **Hubungi Kami**
- Melihat status dan konfirmasi pembelian (Invoice Otomatis)

---

## 🛠️ Teknologi yang Digunakan

| Teknologi   | Keterangan                           |
|-------------|--------------------------------------|
| HTML/CSS    | Tampilan dan struktur website        |
| PHP Native  | Backend logic & kontrol sesi         |
| MySQL       | Sistem basis data relasional         |
| Bootstrap   | Desain antarmuka responsif           |

---

## 🗃️ Struktur Folder

toko-parfum/
├── src/
│ ├── index.php
│ ├── login.php
│ ├── dashboard/
│ │ ├── admin/
│ │ └── customer/
│ ├── produk/
│ ├── kategori/
│ ├── supplier/
│ ├── transaksi/
│ ├── laporan/
│ ├── kontak/
│ ├── settings/
│ ├── register.php
│ ├── logout.php
│ └── assets/
│ └── images/
├── sql/
│ └── toko_parfum.sql
├── docs/
│ ├── INSTALLATION.md
│ └── USAGE.md
└── README.md

---

## 🧾 Struktur Database & ERD

### Tabel Utama:
- `users`: data user/admin
- `roles`: hak akses (admin/staff)
- `customers`: pelanggan toko
- `contacts`: form hubungi kami
- `categories`: kategori parfum
- `products`: daftar produk parfum
- `suppliers`: data supplier parfum
- `transactions`: transaksi penjualan
- `transaction_details`: detail produk dalam transaksi
- `activity_logs`: log aktivitas admin
- `settings`: informasi pengaturan toko
- `shipping_addresses`: alamat kirim customer

### Diagram ERD:
>  Silakan lihat file gambar ERD di folder `/docs`

---

## ⚙️ Cara Install & Menjalankan Proyek

📄 Lihat selengkapnya di file [`docs/INSTALLATION.md`](docs/INSTALLATION.md)

---

## 📖 Panduan Penggunaan Aplikasi

📄 Lihat panduan lengkap penggunaan admin & customer di file [`docs/USAGE.md`](docs/USAGE.md)

---


## 🧑‍🎓 Dibuat oleh:

Zulfa Sabila (20231217)  
Proyek UAS – Mata Kuliah Pemrograman Web
STITEK Bontang
