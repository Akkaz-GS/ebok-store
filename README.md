# 📚 EbookStore — Platform Jual Beli Ebook Digital

EbookStore adalah aplikasi web berbasis Laravel untuk jual beli ebook digital, dikembangkan sebagai project akademik dengan arsitektur multi-role sesuai use case diagram yang telah ditentukan. Sistem ini menghubungkan **Penjual** yang ingin menjual ebook, **Pembeli** yang ingin membeli dan mengunduh ebook, serta **Admin** yang mengelola keseluruhan platform.

## Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Aktor & Hak Akses](#aktor--hak-akses)
- [Tech Stack](#tech-stack)
- [Struktur Database](#struktur-database)
- [Instalasi & Setup](#instalasi--setup)
- [Akun Demo](#akun-demo)
- [Struktur Folder Penting](#struktur-folder-penting)

## Fitur Utama

### Pembeli
- Registrasi & login akun
- Mencari dan memfilter ebook berdasarkan kategori atau kata kunci
- Melihat detail ebook (deskripsi, harga, rating, ulasan)
- Membeli ebook dan mengunggah bukti pembayaran
- Melihat riwayat pembelian beserta status pembayaran
- Mengunduh ebook setelah pembayaran terverifikasi
- Memberikan ulasan dan rating untuk ebook yang sudah dibeli

### Penjual
- Login ke dashboard penjual
- Mengelola data ebook (tambah, edit, hapus) lengkap dengan cover dan file PDF
- File PDF disimpan di private storage agar tidak bisa diakses langsung tanpa pembayaran
- Mengonfirmasi atau menolak pembayaran dari pembeli
- Melihat laporan penjualan dengan filter bulan/tahun

### Admin
- Dashboard statistik keseluruhan sistem (jumlah pembeli, penjual, ebook, transaksi)
- Mengelola data user (tambah, edit, hapus, atur role)
- Mengelola kategori ebook
- Melihat laporan transaksi global beserta rekap per kategori

## Aktor & Hak Akses

| Aktor | Cara Mendapatkan Akun | Akses |
|---|---|---|
| Pembeli | Registrasi mandiri melalui halaman daftar | Dashboard pembeli, katalog, pembelian, unduhan |
| Penjual | Dibuat oleh Admin | Dashboard penjual, manajemen ebook, laporan penjualan |
| Admin | Akun bawaan (seeder) | Dashboard admin, manajemen user & kategori, laporan global |

Registrasi publik hanya menghasilkan akun dengan role **Pembeli**. Akun Penjual dan Admin dikelola langsung oleh Admin melalui menu Kelola User.

## Tech Stack

- **Backend**: Laravel
- **Frontend**: Blade Template + Bootstrap 5
- **Autentikasi**: Laravel Breeze
- **Database**: MySQL (via Laragon)
- **Storage**: Local disk Laravel — disk `public` untuk cover ebook & bukti pembayaran, disk `private` untuk file PDF ebook

## Struktur Database

| Tabel | Keterangan |
|---|---|
| `users` | Data pengguna dengan kolom `role` (pembeli/penjual/admin) |
| `categories` | Kategori ebook |
| `ebooks` | Data ebook: judul, deskripsi, harga, cover, file PDF, status |
| `orders` | Transaksi pembelian: status pending/lunas/ditolak, bukti pembayaran |
| `downloads` | Log riwayat pengunduhan ebook |
| `reviews` | Ulasan dan rating dari pembeli |
| `promos` | Diskon untuk ebook tertentu dalam rentang waktu |

## Instalasi & Setup

1. Clone repository
   ```bash
   git clone https://github.com/Akkaz-GS/ebok-store.git
   cd ebok-store
   ```

2. Install dependencies
   ```bash
   composer install
   npm install
   ```

3. Salin file environment dan generate application key
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

4. Sesuaikan konfigurasi database di `.env`
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=ebook_store
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Jalankan migration dan seeder
   ```bash
   php artisan migrate:fresh --seed
   ```

6. Buat symbolic link untuk storage publik
   ```bash
   php artisan storage:link
   ```

7. Jalankan server
   ```bash
   php artisan serve
   ```

   Aplikasi dapat diakses di `http://127.0.0.1:8000`

## Akun Demo

| Role | Email | Password |
|---|---|---|
| Admin | admin@ebook.com | password |
| Penjual | penjual@ebook.com | password |
| Pembeli | pembeli@ebook.com | password |

## Struktur Folder Penting

```
app/
├── Http/Controllers/
│   ├── HomeController.php       # Beranda & pencarian publik
│   ├── EbookController.php       # CRUD ebook (penjual) & detail ebook (publik)
│   ├── OrderController.php       # Pembelian & riwayat pembeli
│   ├── DownloadController.php    # Unduh ebook dengan verifikasi pembayaran
│   ├── ReviewController.php      # Ulasan & rating
│   ├── PembeliController.php     # Dashboard pembeli
│   ├── PenjualController.php     # Dashboard, penjualan, laporan penjual
│   ├── AdminController.php       # Dashboard & laporan admin
│   ├── UserController.php        # Kelola user (admin)
│   └── CategoryController.php    # Kelola kategori (admin)
├── Models/                        # Eloquent model & relasi antar tabel
└── Http/Middleware/RoleMiddleware.php  # Pembatasan akses berdasarkan role

resources/views/
├── home/        # Halaman publik (beranda, kategori, detail ebook)
├── auth/        # Halaman login & registrasi
├── pembeli/     # Dashboard & riwayat pembeli
├── penjual/     # Dashboard, manajemen ebook, laporan penjual
└── admin/       # Dashboard, kelola user, kategori, laporan admin
```
