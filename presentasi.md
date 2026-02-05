# PILKETOS - Pemilihan Ketua OSIS

## Deskripsi Aplikasi

**PILKETOS** adalah aplikasi web pemilihan ketua OSIS berbasis Laravel 12 dengan tampilan modern menggunakan DaisyUI dan TailwindCSS. Aplikasi ini dirancang untuk memudahkan proses pemilihan ketua OSIS di sekolah dengan fitur voting yang aman dan transparan.

---

## Fitur Utama

### 1. Halaman Publik

- **Beranda** dengan hero section dan statistik real-time
- **Daftar Kandidat** dengan foto dan perolehan suara
- **Grafik Perolehan Suara** menggunakan Chart.js
- **REST API** dengan dokumentasi lengkap

### 2. Portal Siswa

- **Login** dengan NISN dan password
- **Voting** dengan tampilan card kandidat
- **Konfirmasi** sebelum vote terkirim
- **One Vote Policy** - siswa hanya bisa vote sekali

### 3. Panel Admin

- **Dashboard** dengan statistik kandidat, siswa, dan suara
- **CRUD Kandidat** - tambah, edit, hapus kandidat
- **CRUD Siswa** - kelola data pemilih
- **CRUD Admin** - kelola akun administrator

---

## Teknologi yang Digunakan

| Kategori   | Teknologi                         |
| ---------- | --------------------------------- |
| Backend    | Laravel 12 (PHP 8.2+)             |
| Frontend   | Blade, TailwindCSS 4, DaisyUI 5.5 |
| Database   | MySQL                             |
| Icons      | Font Awesome 7                    |
| Chart      | Chart.js                          |
| Build Tool | Vite 7                            |

---

## Struktur MVC

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Controller admin (Dashboard, Kandidat, Siswa, Admin)
│   │   ├── Siswa/          # Controller siswa (Auth, Voting)
│   │   └── PublicController.php
│   └── Middleware/
│       ├── AdminMiddleware.php
│       └── SiswaMiddleware.php
├── Models/
│   ├── Admin.php
│   ├── Kandidat.php
│   ├── Pemilihan.php
│   └── Siswa.php
```

---

## Keunggulan Aplikasi

### 1. Keamanan

- Session-based authentication untuk Admin dan Siswa
- Custom middleware untuk proteksi route
- CSRF protection pada semua form
- Password hashing dengan bcrypt

### 2. UI/UX Modern

- Desain responsive (mobile-first)
- Komponen DaisyUI yang konsisten
- Animasi dan transisi halus
- Dark/Light mode ready

### 3. Best Practices Laravel 12

- Struktur folder terorganisir
- Route grouping dengan prefix dan middleware
- Eloquent ORM dengan relasi
- Blade templating dengan layout system

---

## Alur Penggunaan

### Siswa Voting

```
Login → Pilih Kandidat → Konfirmasi → Selesai
```

### Admin Mengelola

```
Login → Dashboard → Kelola Data (Kandidat/Siswa/Admin)
```

---

## Komponen DaisyUI yang Digunakan

| Komponen   | Penggunaan            |
| ---------- | --------------------- |
| `navbar`   | Navigasi utama        |
| `drawer`   | Sidebar admin         |
| `card`     | Container konten      |
| `table`    | Daftar data CRUD      |
| `btn`      | Tombol aksi           |
| `input`    | Form input            |
| `badge`    | Label status          |
| `stats`    | Statistik dashboard   |
| `hero`     | Hero section homepage |
| `avatar`   | Foto profil kandidat  |
| `alert`    | Notifikasi pesan      |
| `dropdown` | Menu navigasi         |
| `progress` | Bar persentase suara  |

---

## REST API

| Endpoint        | Method | Deskripsi       |
| --------------- | ------ | --------------- |
| `/api/kandidat` | GET    | Daftar kandidat |
| `/api/hasil`    | GET    | Hasil voting    |

---

## Cara Menjalankan

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Migrasi database
php artisan migrate

# Jalankan
composer dev
```

---

## Kesimpulan

PILKETOS adalah solusi modern untuk pemilihan ketua OSIS yang:

- **Aman** - Autentikasi dan validasi ketat
- **Transparan** - Hasil real-time untuk semua
- **User-friendly** - Tampilan modern dan responsif
- **Maintainable** - Kode terstruktur sesuai best practices Laravel
