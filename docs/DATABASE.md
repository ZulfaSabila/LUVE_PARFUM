# 📦 Dokumentasi Struktur Database `toko_parfum`

Berikut adalah penjelasan dari struktur database `toko_parfum` berdasarkan diagram ERD.

---

## 🧾 Daftar Tabel

### 1. `users`
Menyimpan data akun pengguna (admin dan customer).

| Kolom       | Tipe Data        | Keterangan                         |
|-------------|------------------|------------------------------------|
| id          | INT(11)          | Primary key                        |
| username    | VARCHAR(50)      | Digunakan untuk login              |
| password    | VARCHAR(255)     | Password yang sudah di-hash        |
| role_id     | INT(11)          | Relasi ke tabel `roles`            |
| name        | VARCHAR(100)     | Nama lengkap user                  |
| phone       | VARCHAR(20)      | Nomor HP pengguna                  |

---

### 2. `roles`
Menentukan peran dari user (`admin` atau `customer`).

| Kolom      | Tipe Data     | Keterangan              |
|------------|---------------|-------------------------|
| id         | INT(11)       | Primary key             |
| role_name  | VARCHAR(50)   | Nama peran (admin/user) |

---

### 3. `products`
Data produk parfum yang tersedia.

| Kolom       | Tipe Data        | Keterangan                         |
|-------------|------------------|------------------------------------|
| id          | INT(11)          | Primary key                        |
| product_name| VARCHAR(100)     | Nama produk                        |
| category_id | INT(11)          | Relasi ke tabel `categories`       |
| supplier_id | INT(11)          | Relasi ke tabel `suppliers`        |
| price       | DECIMAL(10,2)    | Harga produk                       |
| stock       | INT(11)          | Jumlah stok                        |
| gambar      | VARCHAR(255)     | Nama file gambar produk            |

---

### 4. `categories`
Kategori dari produk parfum.

| Kolom         | Tipe Data        | Keterangan             |
|---------------|------------------|------------------------|
| id            | INT(11)          | Primary key            |
| category_name | VARCHAR(100)     | Nama kategori          |

---

### 5. `suppliers`
Data supplier atau pemasok parfum.

| Kolom     | Tipe Data        | Keterangan             |
|-----------|------------------|------------------------|
| id        | INT(11)          | Primary key            |
| name      | VARCHAR(100)     | Nama supplier          |
| phone     | VARCHAR(20)      | Nomor telepon          |
| address   | TEXT             | Alamat lengkap         |

---

### 6. `transactions`
Menyimpan data transaksi penjualan.

| Kolom            | Tipe Data        | Keterangan                          |
|------------------|------------------|-------------------------------------|
| id               | INT(11)          | Primary key                         |
| user_id          | INT(11)          | Relasi ke tabel `users`             |
| transaction_date | DATETIME         | Tanggal dan waktu transaksi         |
| total            | DECIMAL(10,2)    | Total nominal transaksi             |

---

### 7. `transaction_details`
Detail dari produk yang dibeli dalam suatu transaksi.

| Kolom         | Tipe Data        | Keterangan                          |
|---------------|------------------|-------------------------------------|
| id            | INT(11)          | Primary key                         |
| transaction_id| INT(11)          | Relasi ke tabel `transactions`      |
| product_id    | INT(11)          | Relasi ke tabel `products`          |
| quantity      | INT(11)          | Jumlah barang                       |
| subtotal      | DECIMAL(10,2)    | Harga total barang (qty × harga)    |

---

### 8. `activity_logs`
Mencatat aktivitas user (opsional/logging).

| Kolom        | Tipe Data    | Keterangan                 |
|--------------|--------------|----------------------------|
| id           | INT(11)      | Primary key                |
| user_id      | INT(11)      | Relasi ke tabel `users`    |
| activity     | TEXT         | Deskripsi aktivitas        |
| activity_time| DATETIME     | Waktu aktivitas terjadi    |

---

### 9. `contacts`
Form kontak / pesan dari pengunjung website.

| Kolom     | Tipe Data     | Keterangan            |
|-----------|---------------|-----------------------|
| id        | INT(11)       | Primary key           |
| nama      | VARCHAR(100)  | Nama pengirim         |
| email     | VARCHAR(100)  | Email pengirim        |
| pesan     | TEXT          | Isi pesan             |
| created_at| DATETIME      | Waktu pengiriman      |

---

### 10. `customers` *(opsional jika tidak pakai `users`)*
Jika kamu memisahkan `customers` dari `users`.

| Kolom | Tipe Data | Keterangan |
|-------|-----------|------------|
| id    | INT(11)   | Primary key |
| name  | VARCHAR(100) | Nama customer |
| email | VARCHAR(100) | Email |
| phone | VARCHAR(20) | Nomor HP |

---

### 11. `shipping_addresses`
Alamat pengiriman customer (jika diperlukan dalam pemesanan online).

| Kolom       | Tipe Data     | Keterangan                      |
|-------------|---------------|---------------------------------|
| id          | INT(11)       | Primary key                     |
| customer_id | INT(11)       | Relasi ke tabel `customers`     |
| address     | TEXT          | Alamat                          |
| city        | VARCHAR(100)  | Kota                            |
| postal_code | VARCHAR(10)   | Kode pos                        |
| country     | VARCHAR(100)  | Negara                          |

---

### 12. `settings`
Konfigurasi sistem (opsional).

| Kolom        | Tipe Data     | Keterangan                  |
|--------------|---------------|-----------------------------|
| id           | INT(11)       | Primary key                 |
| setting_key  | VARCHAR(100)  | Nama pengaturan             |
| setting_value| TEXT          | Nilai konfigurasi           |

---

## 🔗 Relasi Antar Tabel

- `users.role_id` → `roles.id`
- `products.category_id` → `categories.id`
- `products.supplier_id` → `suppliers.id`
- `transactions.user_id` → `users.id`
- `transaction_details.transaction_id` → `transactions.id`
- `transaction_details.product_id` → `products.id`
- `activity_logs.user_id` → `users.id`
- `shipping_addresses.customer_id` → `customers.id`
