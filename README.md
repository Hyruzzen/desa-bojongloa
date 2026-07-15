# E-Arsip Kantor Desa Bojongloa (Laravel 12)

Project ini dibangun **di atas skeleton Laravel 12 **


- `app/Models/Kategori.php`, `app/Models/Arsip.php`
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php` (login/logout)
- `app/Http/Controllers/DashboardController.php`, `KategoriController.php`, `ArsipController.php`
- `database/migrations/2025_01_01_000001_create_kategoris_table.php`
- `database/migrations/2025_01_01_000002_create_arsips_table.php`
- `database/seeders/DatabaseSeeder.php` (diubah — sekarang membuat akun admin & kategori awal)
- `resources/views/layouts/app.blade.php`, `auth/login.blade.php`, `dashboard.blade.php`, `kategori/*.blade.php`, `arsip/*.blade.php`
- `routes/web.php` (diganti dengan routing dashboard/kategori/arsip)
- `bootstrap/app.php` (ditambahkan `redirectGuestsTo('/login')`)
