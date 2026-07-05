# 🍜 Warung Burjo — Website CodeIgniter 4

Aplikasi web untuk **Warung Burjo** (warung makanan & minuman sederhana) yang mendukung tampilan menu publik, **pemesanan oleh pelanggan**, **konfirmasi pembayaran cashless via QR Code**, serta panel **admin** untuk mengelola menu dan memantau pesanan/transaksi. Dibangun di atas **CodeIgniter 4** dengan tampilan hangat dan nyaman di mata.

## ✨ Fitur

**Sisi Pelanggan (Publik)**
- Halaman beranda menampilkan daftar menu makanan & minuman (live search tanpa reload)
- Halaman pemesanan: pilih menu, atur jumlah, isi nama & catatan, lihat total secara langsung
- Setelah pesan → muncul **QR Code pembayaran** yang bisa di-scan
- Halaman konfirmasi bayar: pelanggan/kasir scan QR → lihat rincian → tekan tombol → pesanan otomatis ditandai **Lunas**
- Halaman status pesanan: pelanggan bisa cek status (Menunggu / Diproses / Selesai / Lunas)

**Sisi Admin (Perlu Login)**
- Login admin berbasis session
- Dashboard: statistik menu (total, makanan, minuman, habis) + statistik pesanan (total, hari ini, menunggu, lunas)
- Kelola Menu (CRUD lengkap: tambah, lihat, edit, hapus, upload gambar, filter, pencarian, pagination)
- Kelola Pesanan: lihat semua pesanan, filter berdasarkan status, detail tiap pesanan, update status manual
- **QR Meja**: generate & print QR code yang ditempel di meja warung — pelanggan scan → langsung diarahkan ke halaman pesan

## 🔄 Alur Pemesanan & Pembayaran

```
[Pelanggan scan QR di meja]
        ↓
[Halaman /pesan — pilih menu & isi nama]
        ↓
[Submit → sistem simpan pesanan ke database]
        ↓
[Muncul QR Code pembayaran (kode unik per pesanan)]
        ↓
[Pelanggan/kasir scan QR → halaman /bayar/{kode}]
        ↓
[Tekan "Konfirmasi Pembayaran" → status jadi LUNAS]
        ↓
[Admin bisa pantau & update status di panel admin]
```

## 🛠️ Teknologi

- PHP 8 + [CodeIgniter 4](https://codeigniter.com/) (versi 4.5.0+)
- MySQL / MariaDB
- Bootstrap 5 (CDN)
- Google Fonts: Poppins & Nunito Sans
- [QRCode.js](https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js) — generate QR code di sisi klien (tanpa library server-side)
- Vanilla JavaScript (live search, live total, qty control)

## 🗄️ Struktur Database

Aplikasi menggunakan **4 tabel**, dibuat otomatis lewat migration.

### 1. Tabel `users`
Menyimpan akun admin. Tidak di-CRUD lewat UI, hanya diisi seeder awal.

| Kolom        | Tipe              | Keterangan                            |
|--------------|-------------------|----------------------------------------|
| `id`         | INT AUTO_INCREMENT PK | ID unik                           |
| `username`   | VARCHAR(50) UNIQUE | Username login                        |
| `password`   | VARCHAR(255)      | Password ter-hash (`password_hash()`) |
| `created_at` | DATETIME nullable | Waktu dibuat                          |
| `updated_at` | DATETIME nullable | Waktu diubah                          |

### 2. Tabel `menus`
Tabel utama CRUD menu. Ditampilkan di halaman publik dan dikelola admin.

| Kolom        | Tipe                                    | Keterangan                                |
|--------------|-----------------------------------------|--------------------------------------------|
| `id`         | INT AUTO_INCREMENT PK                   | ID unik                                   |
| `nama`       | VARCHAR(150)                            | Nama menu                                 |
| `kategori`   | ENUM('makanan','minuman') def. makanan  | Kategori                                  |
| `harga`      | INT UNSIGNED                            | Harga dalam Rupiah                        |
| `deskripsi`  | TEXT nullable                           | Deskripsi singkat (opsional)              |
| `gambar`     | VARCHAR(255) nullable                   | Nama file gambar (opsional)               |
| `status`     | ENUM('tersedia','habis') def. tersedia  | Status stok                               |
| `created_at` | DATETIME nullable                       | Waktu dibuat                              |
| `updated_at` | DATETIME nullable                       | Waktu diubah                              |

### 3. Tabel `orders`
Menyimpan header setiap transaksi/pesanan pelanggan.

| Kolom           | Tipe                                               | Keterangan                       |
|-----------------|----------------------------------------------------|-----------------------------------|
| `id`            | INT AUTO_INCREMENT PK                              | ID unik                          |
| `kode_order`    | VARCHAR(20) UNIQUE                                 | Kode unik pesanan (cth: BRJ-XXXX)|
| `nama_pemesan`  | VARCHAR(100)                                       | Nama pelanggan                   |
| `nomor_meja`    | VARCHAR(10) nullable                               | Nomor meja (opsional)            |
| `catatan`       | TEXT nullable                                      | Catatan untuk dapur (opsional)   |
| `total_harga`   | INT UNSIGNED                                       | Total harga semua item           |
| `status`        | ENUM('menunggu','diproses','selesai','lunas')      | Status pesanan                   |
| `created_at`    | DATETIME nullable                                  | Waktu dibuat                     |
| `updated_at`    | DATETIME nullable                                  | Waktu diubah                     |

### 4. Tabel `order_items`
Menyimpan detail item per pesanan (relasi ke `orders`).

| Kolom        | Tipe              | Keterangan                                       |
|--------------|-------------------|---------------------------------------------------|
| `id`         | INT AUTO_INCREMENT PK | ID unik                                       |
| `order_id`   | INT UNSIGNED      | FK ke `orders.id`                                |
| `menu_id`    | INT UNSIGNED      | Referensi ke `menus.id`                          |
| `nama_menu`  | VARCHAR(150)      | Snapshot nama menu saat pesan (anti hilang jika menu dihapus) |
| `harga_menu` | INT UNSIGNED      | Snapshot harga saat pesan                        |
| `jumlah`     | INT UNSIGNED      | Jumlah item dipesan                              |
| `subtotal`   | INT UNSIGNED      | `harga_menu × jumlah`                            |
| `created_at` | DATETIME nullable | Waktu dibuat                                     |
| `updated_at` | DATETIME nullable | Waktu diubah                                     |

> 📌 **Relasi:** `order_items.order_id` → `orders.id` (one-to-many). Tabel `users` dan `menus` tidak saling berelasi.

### Pemetaan CRUD → Tabel `menus`

| Operasi | Controller & Method                         | Route                                 |
|---------|----------------------------------------------|----------------------------------------|
| Create  | `Admin\MenuController::create()` / `store()` | GET/POST `admin/menu/create`          |
| Read    | `Admin\MenuController::index()`              | GET `admin/menu`                      |
| Read    | `Home::index()`                              | GET `/`                               |
| Update  | `Admin\MenuController::edit()` / `update()`  | GET/POST `admin/menu/edit/(:num)`     |
| Delete  | `Admin\MenuController::delete()`             | GET `admin/menu/delete/(:num)`        |

## 📂 Struktur Folder (file custom)

```
warung-burjo-ci4/
├── app/
│   ├── Config/
│   │   ├── Routes.php          # Semua routing (menu + pesanan + admin)
│   │   └── Filters.php         # Registrasi filter adminauth
│   ├── Controllers/
│   │   ├── Home.php            # Halaman publik menu
│   │   ├── PesananController.php   # Pemesanan & pembayaran (pelanggan)
│   │   └── Admin/
│   │       ├── AuthController.php
│   │       ├── DashboardController.php
│   │       ├── MenuController.php
│   │       └── PesananController.php   # Kelola pesanan (admin)
│   ├── Filters/
│   │   └── AdminFilter.php
│   ├── Models/
│   │   ├── MenuModel.php
│   │   ├── OrderModel.php
│   │   ├── OrderItemModel.php
│   │   └── UserModel.php
│   ├── Database/
│   │   ├── Migrations/         # 4 migration: users, menus, orders, order_items
│   │   └── Seeds/              # UserSeeder + MenuSeeder + DatabaseSeeder
│   └── Views/
│       ├── layout/             # Layout publik (main.php) & admin (admin.php)
│       ├── home.php
│       ├── pesanan/            # form.php, status.php, bayar.php
│       └── admin/
│           ├── login.php, dashboard.php
│           ├── menu/           # index, create, edit
│           └── pesanan/        # index, detail, qr_warung
├── public/
│   └── assets/
│       ├── css/style.css
│       └/uploads/menu/
├── .env.example
├── .gitignore
└── README.md
```

## 🚀 Cara Instalasi

### 1. Buat project CodeIgniter 4 baru
```bash
composer create-project codeigniter4/appstarter warung-burjo
cd warung-burjo
```

### 2. Copy file dari folder ini
Salin folder `app/` dan `public/assets/` ke dalam project hasil composer di atas (konfirmasi overwrite untuk `Routes.php` dan `Filters.php`).

> ⚠️ Jika `Filters.php` versi CI4 kamu berbeda, cukup tambahkan manual ke array `$aliases` yang sudah ada:
> ```php
> use App\Filters\AdminFilter;
> // ...
> 'adminauth' => AdminFilter::class,
> ```

### 3. Konfigurasi `.env`
```bash
cp .env.example .env
```
Edit `.env`, sesuaikan:
```
app.baseURL = http://localhost:8080/
database.default.hostname = localhost
database.default.database = burjo_db
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

Buat database di MySQL terlebih dahulu:
```sql
CREATE DATABASE burjo_db;
```

### 4. Jalankan migration & seeder
```bash
php spark migrate
php spark db:seed DatabaseSeeder
```

### 5. Jalankan server
```bash
php spark serve
```
- Halaman publik: `http://localhost:8080`
- Halaman pesan: `http://localhost:8080/pesan`
- Admin: `http://localhost:8080/admin/login`

## 🔑 Login Admin Default

| Username | Password   |
|----------|------------|
| `admin`  | `admin123` |

> 🔒 Ganti password setelah login pertama (via database menggunakan `password_hash()`).

## 📲 Tips Demo QR Code dengan HP

Agar QR code bisa benar-benar di-scan dengan HP:
1. Pastikan HP dan komputer terhubung ke **WiFi yang sama**
2. Cari IP komputer kamu (contoh: `192.168.1.5`)
3. Ubah `app.baseURL` di `.env` menjadi:
   ```
   app.baseURL = http://192.168.1.5:8080/
   ```
4. Akses dari HP: `http://192.168.1.5:8080/pesan`
5. QR code yang ter-generate akan otomatis menggunakan IP tersebut

## 📤 Cara Push ke GitHub

```bash
git init
git add .
git commit -m "Initial commit: Warung Burjo CI4 + Fitur Pemesanan & QR Payment"
git branch -M main
git remote add origin https://github.com/USERNAME/NAMA-REPO.git
git push -u origin main
```

File `.gitignore` sudah mengecualikan `vendor/`, `.env`, dan isi `writable/`.
