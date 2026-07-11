# E-Arsip Kantor Desa Bojongloa (Laravel 12)

Project ini dibangun **di atas skeleton Laravel 12 baru Anda** (dari `repomix-output.xml`) dan ditambahkan modul E-Arsip: login admin, kategori, dan data arsip dengan upload file.

## Yang Ditambahkan ke Project Anda

- `app/Models/Kategori.php`, `app/Models/Arsip.php`
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php` (login/logout)
- `app/Http/Controllers/DashboardController.php`, `KategoriController.php`, `ArsipController.php`
- `database/migrations/2025_01_01_000001_create_kategoris_table.php`
- `database/migrations/2025_01_01_000002_create_arsips_table.php`
- `database/seeders/DatabaseSeeder.php` (diubah — sekarang membuat akun admin & kategori awal)
- `resources/views/layouts/app.blade.php`, `auth/login.blade.php`, `dashboard.blade.php`, `kategori/*.blade.php`, `arsip/*.blade.php`
- `routes/web.php` (diganti dengan routing dashboard/kategori/arsip)
- `bootstrap/app.php` (ditambahkan `redirectGuestsTo('/login')`)

File bawaan lain (composer.json, package.json, vite.config.js, config/*, dsb) **tidak saya ubah** — tetap sama seperti project asli Anda. Styling tetap pakai **Tailwind CSS v4 + Vite** sesuai setup Anda (bukan CDN), lewat `resources/css/app.css` yang sudah ada.

## Cara Menjalankan

1. **Install dependency PHP & JS**
   ```bash
   composer install
   npm install
   ```

2. **Environment**
   File `.env` sudah saya siapkan (salinan dari `.env.example` bawaan Anda). Kalau belum ada key:
   ```bash
   php artisan key:generate
   ```

3. **Database**
   Default `DB_CONNECTION=sqlite` (sesuai `.env.example` Anda), file `database/database.sqlite` sudah dibuat kosong. Kalau mau pakai MySQL, ubah `.env` seperti biasa lalu buat databasenya dulu.

4. **Migrasi + seeder**
   ```bash
   php artisan migrate --seed
   ```
   Ini akan membuat tabel `kategoris`, `arsips`, plus tabel bawaan Laravel (users, sessions, cache, jobs), dan mengisi akun admin + kategori awal.

5. **Storage link** (supaya file arsip yang diupload bisa diakses via browser)
   ```bash
   php artisan storage:link
   ```

6. **Jalankan aplikasi** (server + Vite dev server sekaligus, sudah ada script `dev` di composer.json Anda)
   ```bash
   composer run dev
   ```
   atau manual di dua terminal:
   ```bash
   php artisan serve
   npm run dev
   ```
   Buka `http://localhost:8000`.

   Untuk build production aset: `npm run build`.

## Akun Login Default

| Email                        | Password      |
|------------------------------|---------------|
| admin@desabojongloa.go.id    | bojongloa123  |

**Ganti password ini setelah login pertama** (lewat `php artisan tinker` untuk sekarang, karena fitur ubah password dari UI belum ada).

## Kategori Bawaan (bisa diubah lewat menu Kategori)

- Surat Keputusan
- Surat Masuk
- Surat Keluar
- Laporan Keuangan
- Dokumen Kependudukan

## Fitur

- Login admin (single role, session driver `database` sesuai default Laravel 12)
- Dashboard: total arsip, total kategori, grafik arsip per kategori, arsip terbaru
- CRUD Kategori Arsip
- CRUD Arsip: upload file (PDF/gambar/dokumen Office, maks 10MB), judul, nomor arsip, tanggal, deskripsi
- Pencarian & filter arsip (kata kunci, kategori, rentang tanggal)
- Detail & unduh arsip

## Catatan

Saya tulis/tempel kode ini secara manual berdasarkan isi `repomix-output.xml` yang Anda upload — environment saya tidak punya PHP/Composer/Node/internet untuk benar-benar menjalankan project ini, jadi belum sempat saya test-run. Kalau ada error saat `composer install`, `npm install`, `migrate`, atau saat load halaman, kirim pesan errornya, saya bantu perbaiki.

## Pengembangan Lanjutan (opsional)

- Multi-role (Kepala Desa, operator, warga)
- Export laporan ke Excel/PDF
- Log aktivitas (audit trail)
- Fitur ubah password/profil dari UI
- Backup otomatis

## Upload kode terbaru ke github

- git add .
- git commit -m "Pesan commit bebas"
- git push -u origin main  (jka pertamakali)
- git push