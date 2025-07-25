Panduan Instalasi Aplikasi Toko Parfum

1. Persyaratan Sistem

   Pastikan sistem Anda memenuhi syarat berikut:
   - Web Server: Apache (XAMPP / LAMP / Laragon)
   - PHP: Versi 7.4 atau lebih tinggi
   - MySQL / MariaDB
   - Browser: Chrome, Firefox, Edge, atau browser modern lainnya
   - Git (opsional): untuk cloning repository

---

2. Struktur Folder Proyek

Gunakan struktur folder seperti berikut untuk menjaga keteraturan proyek:
TOKOPARFUM/
│
├── docs/ # Dokumentasi proyek
│ ├── INSTALLATION.md
│ └── USAGE.md
│
├── sql/ # Skrip SQL dan struktur database
│ └── toko_parfum.sql
│
├── src/ # Source code utama
│ ├── Manajemen_Produk/
│ ├── Daftar_Transaksi/
│ ├── Laporan/
│ ├── pemesanan_customer/
│ ├── CRUD/
│ └── includes/
│
├── uploads/ # Direktori upload gambar produk
│
├── hash.php
├── hashcustomer.php
├── order_tamu.php
├── register.php
├── index.php
├── login.php
├── logout.php
├── koneksi.php
└── dashboard.php

---

3. Langkah Instalasi

   a. Langkah 1: Clone atau Salin Proyek
      Jika menggunakan Git:
      ```bash
      git clone https://github.com/username/toko-parfum.git
      Atau salin folder proyek ke direktori htdocs (untuk XAMPP) atau www (untuk Laragon):
      C:\xampp\htdocs\tokoparfum\

   b. Langkah 2: Impor Database
      Buka phpMyAdmin
      Buat database baru, misalnya: toko_parfum
      Impor file sql/toko_parfum.sql

   c. Langkah 3: Konfigurasi Koneksi Database
      Edit file koneksi.php:
      <?php
      $host = 'localhost';
      $user = 'root';
      $pass = '';
      $db   = 'toko_parfum';
      $conn = new mysqli($host, $user, $pass, $db);
      if ($conn->connect_error) {
          die('Koneksi ke database gagal: ' . $conn->connect_error);
      }
      ?>
      
   d. Langkah 4: Jalankan Aplikasi
      Aktifkan Apache dan MySQL melalui XAMPP atau Laragon
      Buka browser dan akses:
      http://localhost/tokoparfum/

---

4. Akun Login Awal
   Admin
   Username: (masukkan sesuai data di database)
   Password: admin123
   Customer
   Registrasi melalui register.php
