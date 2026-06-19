# Warung Burjo Berkah — Website CodeIgniter 4

Website sederhana untuk **Warung Burjo Barokah** (warung makanan & minuman ala burjo) dengan halaman menu publik yang menarik, ditambah panel **admin** untuk mengelola (CRUD) data makanan & minuman. Dibangun di atas **CodeIgniter 4**, tampilan dibuat simple, hangat, dan nyaman di mata (tanpa warna neon menyolok).

## Fitur

- **Halaman publik** menampilkan daftar menu makanan & minuman dalam bentuk kartu, lengkap dengan harga, deskripsi, status (Tersedia/Habis), dan pencarian menu secara langsung (live search) tanpa reload halaman.
- **Login admin** sederhana berbasis session (username & password).
- **Dashboard admin** dengan ringkasan jumlah menu, jumlah makanan, jumlah minuman, dan jumlah menu yang habis.
- **CRUD menu** lengkap di panel admin:
  - Tambah menu baru (nama, kategori, harga, deskripsi, gambar, status)
  - Edit menu, termasuk ganti gambar (opsional)
  - Hapus menu (otomatis menghapus file gambar terkait)
  - Cari & filter menu berdasarkan nama/kategori
  - Pagination daftar menu
- **Upload gambar menu** opsional — jika tidak ada gambar, tampilan otomatis memakai ikon 🍛 / 🥤 sebagai placeholder.
- Desain UI/UX custom (bukan template Bootstrap default) dengan aksen garis kotak-kotak merah-putih ala tablecloth warung, palet warna coklat kopi & kuning lampu yang hangat.

##  Teknologi

- PHP 8 + [CodeIgniter 4](https://codeigniter.com/)
- MySQL/MariaDB
- Bootstrap 5 (CDN, untuk grid/layout dasar)
- Google Fonts: Poppins & Nunito Sans
- Vanilla JavaScript (untuk live search, tanpa library tambahan)

## Struktur folder

Repo/folder ini **bukan** project CodeIgniter 4 yang lengkap (tidak menyertakan folder `vendor/`, `system/`, atau file konfigurasi default CI4 lainnya). Yang disediakan hanya file-file **custom** yang perlu ditambahkan ke atas instalasi CI4 standar:

```
warung-burjo-ci4/
├── app/
│   ├── Config/
│   │   ├── Routes.php          # Routing halaman publik & admin
│   │   └── Filters.php         # Registrasi filter "adminauth"
│   ├── Controllers/
│   │   ├── Home.php            # Halaman publik
│   │   └── Admin/
│   │       ├── AuthController.php
│   │       ├── DashboardController.php
│   │       └── MenuController.php
│   ├── Filters/
│   │   └── AdminFilter.php     # Filter cek login admin
│   ├── Models/
│   │   ├── MenuModel.php
│   │   └── UserModel.php
│   ├── Database/
│   │   ├── Migrations/         # Migrasi tabel users & menus
│   │   └── Seeds/               # Seeder admin default + 11 contoh menu
│   └── Views/
│       ├── layout/             # Layout publik (main.php) & admin (admin.php)
│       ├── home.php
│       └── admin/               # login, dashboard, menu (index/create/edit)
├── public/
│   └── assets/
│       ├── css/style.css       # Semua styling custom
│       └── uploads/menu/       # Folder upload gambar menu
├── .env.example
├── .gitignore
└── README.md
```

## Struktur Database

Website ini menggunakan **2 tabel** di database, dibuat otomatis lewat migration (`php spark migrate`).

### 1. Tabel `users`

Menyimpan akun admin yang bisa login ke panel admin. Tabel ini **tidak di-CRUD** lewat UI (tidak ada fitur tambah/edit/hapus user dari tampilan), hanya diisi awal lewat seeder demi alasan keamanan.

| Kolom        | Tipe Data     | Keterangan                                  |
|--------------|---------------|----------------------------------------------|
| `id`         | INT, AUTO_INCREMENT, PRIMARY KEY | ID unik tiap admin              |
| `username`   | VARCHAR(50), UNIQUE | Username untuk login                   |
| `password`   | VARCHAR(255)  | Password ter-enkripsi (hash, bukan plain text) |
| `created_at` | DATETIME, nullable | Waktu akun dibuat                       |
| `updated_at` | DATETIME, nullable | Waktu akun terakhir diubah              |

### 2. Tabel `menus`

Menyimpan data menu makanan & minuman. Tabel inilah yang menjadi objek **CRUD utama** di panel admin (Create, Read, Update, Delete).

| Kolom        | Tipe Data     | Keterangan                                              |
|--------------|---------------|------------------------------------------------------------|
| `id`         | INT, AUTO_INCREMENT, PRIMARY KEY | ID unik tiap menu                       |
| `nama`       | VARCHAR(150)  | Nama menu (cth: "Indomie Goreng Telur")                    |
| `kategori`   | ENUM('makanan', 'minuman'), default `makanan` | Kategori menu             |
| `harga`      | INT, unsigned | Harga menu dalam Rupiah (cth: `8000`)                       |
| `deskripsi`  | TEXT, nullable | Deskripsi singkat menu (boleh kosong)                      |
| `gambar`     | VARCHAR(255), nullable | Nama file gambar menu (boleh kosong → pakai ikon emoji) |
| `status`     | ENUM('tersedia', 'habis'), default `tersedia` | Status stok menu          |
| `created_at` | DATETIME, nullable | Waktu data dibuat                                     |
| `updated_at` | DATETIME, nullable | Waktu data terakhir diubah                            |

### Pemetaan fitur CRUD ke tabel `menus`

| Operasi CRUD | Controller & Method                          | Route                         | Fungsi                                   |
|--------------|-----------------------------------------------|--------------------------------|-------------------------------------------|
| **Create**   | `Admin\MenuController::create()` & `store()`  | `GET/POST admin/menu/create`, `POST admin/menu/store` | Form tambah menu baru          |
| **Read**     | `Admin\MenuController::index()`               | `GET admin/menu`               | Daftar menu (admin) + pencarian & filter  |
| **Read**     | `Home::index()`                               | `GET /`                        | Tampilan menu untuk pengunjung publik     |
| **Update**   | `Admin\MenuController::edit()` & `update()`   | `GET admin/menu/edit/(:num)`, `POST admin/menu/update/(:num)` | Form edit menu       |
| **Delete**   | `Admin\MenuController::delete()`              | `GET admin/menu/delete/(:num)` | Hapus menu beserta file gambarnya         |

>  Diagram relasi: kedua tabel ini **tidak saling berelasi** (tidak ada foreign key). Tabel `users` murni untuk autentikasi admin, sedangkan tabel `menus` murni untuk data menu yang ditampilkan ke publik dan dikelola admin.

##  Cara Instalasi

### 1. Buat project CodeIgniter 4 baru

```bash
composer create-project codeigniter4/appstarter warung-burjo
cd warung-burjo
```

### 2. Salin (merge) file dari folder ini

Copy folder `app/` dan `public/assets/` dari project ini **ke dalam** folder `warung-burjo` hasil `composer create-project` di atas, lalu konfirmasi **overwrite** untuk file yang sama (Routes.php, Filters.php).

>  **Catatan tentang `app/Config/Filters.php`:** isi file di sini hanya menambahkan satu baris alias filter `adminauth`. Jika versi CodeIgniter 4 kamu punya struktur `Filters.php` yang berbeda (CI4 versi terbaru kadang berubah format konfigurasinya), jangan langsung overwrite — cukup buka file aslinya dan tambahkan secara manual:
> ```php
> use App\Filters\AdminFilter;
> // ...
> public array $aliases = [
>     // ...alias bawaan lainnya...
>     'adminauth' => AdminFilter::class,
> ];
> ```

### 3. Konfigurasi environment

```bash
cp .env.example .env
```

Lalu sesuaikan bagian `database.default.*` di `.env` dengan kredensial MySQL/MariaDB kamu (hostname, nama database, username, password).

Buat database baru (misalnya `burjo_db`) di MySQL sebelum lanjut ke langkah berikutnya:

```sql
CREATE DATABASE burjo_db;
```

### 4. Jalankan migrasi & seeder

```bash
php spark migrate
php spark db:seed DatabaseSeeder
```

Perintah di atas akan membuat tabel `users` & `menus`, lalu mengisi data awal: 1 akun admin dan 11 contoh menu makanan/minuman.

### 5. Jalankan server lokal

```bash
php spark serve
```

Buka `http://localhost:8080` di browser untuk halaman publik, dan `http://localhost:8080/admin/login` untuk login admin.

## 🔑 Login Admin Default

| Username | Password   |
|----------|------------|
| `admin`  | `admin123` |

> 🔒 **Penting:** Segera ganti password default ini setelah login pertama kali (saat ini belum ada fitur ganti password di UI, jadi bisa diganti langsung lewat database menggunakan `password_hash()` di PHP, atau tambahkan fitur ganti password sebagai pengembangan lanjutan).

## 📤 Cara Push ke GitHub

Jika folder ini sudah digabung dengan hasil `composer create-project` (langkah instalasi di atas), jalankan dari root project:

```bash
git init
git add .
git commit -m "Initial commit: Warung Burjo CI4"
git branch -M main
git remote add origin https://github.com/USERNAME/NAMA-REPO.git
git push -u origin main
```

Ganti `USERNAME` dan `NAMA-REPO` sesuai akun & repository GitHub kamu. File `.gitignore` yang disediakan sudah mengecualikan `vendor/`, `.env`, dan isi folder `writable/` agar tidak ikut ter-commit.

## Pengembangan Lanjutan (Opsional)

Beberapa ide jika ingin dikembangkan lebih jauh:
- Fitur ganti password admin dari dalam dashboard.
- Multi-admin / role management.
- Kategori menu yang lebih fleksibel (tidak hardcode makanan/minuman).
- Filter ketersediaan stok otomatis berbasis jumlah stok, bukan status manual.
- Mode gelap (dark mode) untuk halaman publik.

---

