# Sistem Manajemen Ritel Sederhana

Aplikasi web berbasis **Laravel 13** untuk mengelola kategori barang, data barang, stok, serta akun pengguna dengan penerapan **Role-Based Access Control**.

Aplikasi ini dibuat sebagai proyek skill test Fullstack Laravel dengan autentikasi Laravel Breeze, tampilan Tailwind CSS 4, database MySQL/MariaDB, dan notifikasi SweetAlert2.

---

## Daftar Isi

1. [Fitur Aplikasi](#fitur-aplikasi)
2. [Hak Akses](#hak-akses)
3. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
4. [Struktur Database](#struktur-database)
5. [Persyaratan Sistem](#persyaratan-sistem)
6. [Instalasi di Perangkat Baru](#instalasi-di-perangkat-baru)
7. [Konfigurasi Database](#konfigurasi-database)
8. [Menjalankan Aplikasi](#menjalankan-aplikasi)
9. [Akun Admin Demo](#akun-admin-demo)
10. [Struktur Folder Penting](#struktur-folder-penting)
11. [Validasi dan Keamanan](#validasi-dan-keamanan)
12. [Perintah Penting](#perintah-penting)
13. [Troubleshooting](#troubleshooting)
14. [Catatan Deployment](#catatan-deployment)

---

# Fitur Aplikasi

## 1. Autentikasi

Aplikasi menggunakan Laravel Breeze untuk menyediakan:

- Login menggunakan email dan password.
- Registrasi pengguna.
- Logout.
- Pengelolaan profil pengguna.
- Session authentication.
- Password hashing.
- Perlindungan route menggunakan middleware `auth`.

Pengguna yang mendaftar melalui halaman registrasi otomatis mendapatkan role:

```text
user
```

Role admin tidak dapat dipilih melalui halaman registrasi publik.

---

## 2. Dashboard

Dashboard menampilkan ringkasan data aplikasi, meliputi:

- Total kategori.
- Total barang.
- Total stok.
- Jumlah barang dengan stok menipis.
- Lima barang terbaru.
- Daftar barang dengan stok rendah.
- Total user khusus admin.
- Tombol akses cepat untuk menambah kategori, barang, atau user.

Barang dianggap memiliki stok menipis apabila:

```text
stock <= 5
```

---

## 3. Manajemen Kategori

Fitur kategori meliputi:

- Menampilkan daftar kategori.
- Menambahkan kategori.
- Mengubah kategori.
- Menghapus kategori.
- Menampilkan jumlah barang pada setiap kategori.
- Pagination daftar kategori.
- Validasi nama kategori.
- Mencegah kategori dengan nama yang sama.
- Mencegah penghapusan kategori yang masih memiliki barang.

---

## 4. Manajemen Barang

Fitur barang meliputi:

- Menampilkan daftar barang.
- Menambahkan barang.
- Mengubah barang.
- Menghapus barang.
- Memilih kategori melalui dropdown.
- Mengelola harga barang.
- Mengelola stok barang.
- Menampilkan status stok.
- Pagination daftar barang.

Data barang yang dikelola:

```text
Nama Barang
Kategori
Harga
Stok
```

---

## 5. Manajemen User

Fitur ini hanya dapat diakses oleh admin.

Fitur manajemen user meliputi:

- Menampilkan daftar user.
- Menambahkan user.
- Mengubah nama user.
- Mengubah email user.
- Mengubah role user.
- Mengganti password user.
- Menghapus user.
- Mencegah admin menghapus akun yang sedang digunakan.
- Mencegah admin mengubah role akun sendiri menjadi user.
- Mencegah admin terakhir dihapus.

---

## 6. Notifikasi Popup

Aplikasi menggunakan SweetAlert2 untuk:

- Notifikasi berhasil.
- Notifikasi gagal.
- Pesan kesalahan validasi.
- Konfirmasi sebelum menghapus data.
- Peringatan ketika operasi tidak diperbolehkan.

SweetAlert2 hanya digunakan untuk tampilan notifikasi. Keamanan aplikasi tetap ditangani oleh Laravel melalui validasi, middleware, CSRF, Eloquent ORM, dan password hashing.

---

## 7. Halaman Unauthorized

User biasa yang mencoba membuka halaman khusus admin akan mendapatkan:

```text
403 Unauthorized
```

Halaman tersebut menampilkan countdown, kemudian mengarahkan pengguna kembali ke dashboard.

---

# Hak Akses

Aplikasi memiliki dua role:

```text
admin
user
```

Tabel hak akses:

| Fitur               | Admin | User  |
| ------------------- | :---: | :---: |
| Login               |  Ya   |  Ya   |
| Logout              |  Ya   |  Ya   |
| Dashboard           |  Ya   |  Ya   |
| Melihat kategori    |  Ya   |  Ya   |
| Menambah kategori   |  Ya   |  Ya   |
| Mengubah kategori   |  Ya   |  Ya   |
| Menghapus kategori  |  Ya   |  Ya   |
| Melihat barang      |  Ya   |  Ya   |
| Menambah barang     |  Ya   |  Ya   |
| Mengubah barang     |  Ya   |  Ya   |
| Menghapus barang    |  Ya   |  Ya   |
| Mengelola profil    |  Ya   |  Ya   |
| Melihat daftar user |  Ya   | Tidak |
| Menambah user       |  Ya   | Tidak |
| Mengubah user       |  Ya   | Tidak |
| Menghapus user      |  Ya   | Tidak |

Route manajemen user dilindungi menggunakan:


Route::middleware(['auth', 'admin'])->group(function () {
    // Route khusus admin
});

---

# Teknologi yang Digunakan

## Backend

- Laravel 13
- PHP 8.3
- Laravel Breeze
- Eloquent ORM
- Form Request Validation
- Middleware
- MySQL/MariaDB

## Frontend

- Blade Template
- Tailwind CSS 4
- Alpine.js
- SweetAlert2
- Axios
- Vite

## Package Manager

- Composer
- NPM

---

# Struktur Database

Database terdiri dari tiga tabel utama:

users
categories
items

## Tabel `users`

| Kolom             | Keterangan                       |
| ----------------- | -------------------------------- |
| id                | Primary key                      |
| name              | Nama pengguna                    |
| email             | Email pengguna dan bersifat unik |
| email_verified_at | Waktu verifikasi email           |
| password          | Password yang sudah di-hash      |
| role              | Role `admin` atau `user`         |
| remember_token    | Token autentikasi                |
| created_at        | Waktu data dibuat                |
| updated_at        | Waktu data diperbarui            |

## Tabel `categories`

| Kolom      | Keterangan                      |
| ---------- | ------------------------------- |
| id         | Primary key                     |
| name       | Nama kategori dan bersifat unik |
| created_at | Waktu data dibuat               |
| updated_at | Waktu data diperbarui           |

## Tabel `items`

| Kolom       | Keterangan                      |
| ----------- | ------------------------------- |
| id          | Primary key                     |
| category_id | Foreign key ke tabel categories |
| name        | Nama barang                     |
| price       | Harga barang                    |
| stock       | Jumlah stok                     |
| created_at  | Waktu data dibuat               |
| updated_at  | Waktu data diperbarui           |

## Relasi Database

Category 1 ─────────── M Item

Artinya:

- Satu kategori dapat memiliki banyak barang.
- Satu barang hanya memiliki satu kategori.
- Barang wajib memiliki kategori yang valid.
- Kategori yang masih memiliki barang tidak dapat dihapus.

---

# Persyaratan Sistem

Sebelum menjalankan aplikasi di perangkat baru, pastikan perangkat memiliki:

- PHP 8.3 atau versi yang kompatibel dengan Laravel 13.
- Composer.
- Node.js 22 atau versi yang kompatibel dengan Vite.
- NPM.
- MySQL atau MariaDB.
- Git, jika proyek diambil dari repository.
- Web server lokal seperti Laragon, XAMPP, atau Laravel development server.

Versi yang digunakan saat pengembangan:

Laravel : 13.x
PHP     : 8.3
Node.js : 22.x
NPM     : 11.x

Untuk pengguna Windows, Laragon direkomendasikan karena sudah menyediakan PHP, MySQL, dan terminal proyek.


# Instalasi di Perangkat Baru

## Penting

Pada perangkat baru, tidak perlu menjalankan kembali perintah berikut:

php artisan breeze:install blade
npm install sweetalert2
npm install tailwindcss
npm install alpinejs

Package tersebut sudah tercatat di:

composer.json
composer.lock
package.json
package-lock.json

Perangkat baru cukup menjalankan:

composer install
npm ci

`composer install` akan membuat ulang folder:

vendor

`npm ci` akan membuat ulang folder:

node_modules

---

## 1. Clone Repository

git clone (https://github.com/AgungReza/Manajemen-Ritel.git)

Masuk ke folder proyek:

cd manajemen-barang

Apabila proyek diberikan dalam bentuk ZIP:

1. Ekstrak file ZIP.
2. Pindahkan folder ke direktori web server.
3. Buka terminal pada folder proyek.

Contoh lokasi Laragon:

C:\laragon\www\manajemen-barang

---

## 2. Instal Dependency PHP

Jalankan:

composer install

Perintah ini membaca:

composer.json
composer.lock

dan memasang seluruh dependency PHP ke folder `vendor`.

---

## 3. Instal Dependency Frontend

Disarankan menggunakan:

npm ci

Perintah tersebut membaca `package-lock.json` dan memasang versi dependency yang sama dengan perangkat pengembangan.

Jika `npm ci` gagal karena tidak tersedia `package-lock.json`, gunakan:

```bash
npm install
```

Dependency frontend yang akan dipasang meliputi:

- Tailwind CSS 4.
- `@tailwindcss/vite`.
- Vite.
- Laravel Vite Plugin.
- Alpine.js.
- Axios.
- SweetAlert2.

---

## 4. Buat File Environment

### Windows PowerShell

```powershell
Copy-Item .env.example .env
```

### Windows Command Prompt

```cmd
copy .env.example .env
```

### Linux/macOS

```bash
cp .env.example .env
```

---

## 5. Buat Application Key

Jalankan:

```bash
php artisan key:generate
```

Application key digunakan Laravel untuk enkripsi session, cookie, dan data aplikasi lainnya.

---

## 6. Bersihkan Cache Awal

Jalankan:

```bash
php artisan optimize:clear
```

Perintah ini membersihkan cache konfigurasi, route, view, dan cache aplikasi.

---

# Konfigurasi Database

## 1. Buat Database

Buat database baru melalui phpMyAdmin, HeidiSQL, MySQL Workbench, atau terminal MySQL.

Contoh nama database:

```text
manajemen_barang
```

Contoh SQL:

```sql
CREATE DATABASE manajemen_barang;
```

---

## 2. Atur File `.env`

Buka file:

```text
.env
```

Atur konfigurasi berikut:

```env
APP_NAME="Sistem Manajemen Ritel"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=manajemen_barang
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan:

```text
DB_DATABASE
DB_USERNAME
DB_PASSWORD
```

dengan konfigurasi database pada perangkat masing-masing.

Untuk Laragon, konfigurasi bawaan biasanya:

```env
DB_USERNAME=root
DB_PASSWORD=
```

---

## 3. Jalankan Migration

Jalankan:

```bash
php artisan migrate
```

Migration akan membuat tabel yang dibutuhkan aplikasi.

Periksa status migration:

```bash
php artisan migrate:status
```

Pastikan seluruh migration memiliki status:

```text
Ran
```

---

## 4. Buat Akun Admin

Jalankan seeder admin:

```bash
php artisan db:seed --class=AdminSeeder
```

Seeder akan membuat atau memperbarui akun admin awal.

Jika `AdminSeeder` sudah dipanggil melalui `DatabaseSeeder`, dapat menggunakan:

```bash
php artisan db:seed
```

Namun perintah yang paling aman untuk proyek ini adalah:

```bash
php artisan db:seed --class=AdminSeeder
```

---

## 5. Reset Database

Gunakan perintah ini hanya jika seluruh data boleh dihapus:

```bash
php artisan migrate:fresh
```

Untuk menghapus seluruh tabel, membuat ulang tabel, dan menjalankan seeder:

```bash
php artisan migrate:fresh --seed
```

Perhatian:

```text
migrate:fresh akan menghapus seluruh data dalam database.
```

---

# Menjalankan Aplikasi

## Mode Development

Gunakan dua terminal.

### Terminal Pertama: Laravel Server

```bash
php artisan serve
```

Aplikasi akan berjalan di:

```text
http://127.0.0.1:8000
```

### Terminal Kedua: Vite

```bash
npm run dev
```

Vite digunakan untuk memproses:

- Tailwind CSS.
- JavaScript.
- Alpine.js.
- SweetAlert2.
- Hot reload saat pengembangan.

Biarkan kedua terminal tetap berjalan selama aplikasi digunakan.

---

## Menjalankan Semua Proses Sekaligus

Apabila script `dev` pada Composer tersedia dan berjalan dengan baik:

```bash
composer run dev
```

Perintah tersebut dapat menjalankan Laravel server, queue, log, dan Vite secara bersamaan.

Jika terjadi error pada salah satu proses, gunakan dua terminal terpisah agar error lebih mudah diketahui:

```bash
php artisan serve
```

dan:

```bash
npm run dev
```

---

## Mode Production

Build aset frontend:

```bash
npm run build
```

Hasil build akan disimpan di:

```text
public/build
```

Pada mode production, Vite development server tidak perlu dijalankan.

Atur file `.env`:

```env
APP_ENV=production
APP_DEBUG=false
```

Kemudian jalankan optimasi:

```bash
php artisan optimize
```

---

# Akun Admin Demo

Akun admin bawaan dari seeder:

```text
Email    : admin@example.com
Password : Admin123!
Role     : admin
```

Gunakan akun tersebut untuk mengakses:

```text
Dashboard
Kategori
Barang
Manajemen User
```

Untuk keamanan, password admin sebaiknya diganti ketika aplikasi digunakan di lingkungan sebenarnya.

---

# Struktur Folder Penting

```text
manajemen-barang/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CategoryController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ItemController.php
│   │   │   ├── ProfileController.php
│   │   │   └── UserController.php
│   │   │
│   │   ├── Middleware/
│   │   │   └── AdminMiddleware.php
│   │   │
│   │   └── Requests/
│   │       ├── StoreCategoryRequest.php
│   │       ├── UpdateCategoryRequest.php
│   │       ├── StoreItemRequest.php
│   │       ├── UpdateItemRequest.php
│   │       ├── StoreUserRequest.php
│   │       └── UpdateUserRequest.php
│   │
│   └── Models/
│       ├── Category.php
│       ├── Item.php
│       └── User.php
│
├── bootstrap/
│   └── app.php
│
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── AdminSeeder.php
│       └── DatabaseSeeder.php
│
├── resources/
│   ├── css/
│   │   └── app.css
│   │
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   │
│   └── views/
│       ├── auth/
│       ├── categories/
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── index.blade.php
│       │
│       ├── errors/
│       │   └── unauthorized.blade.php
│       │
│       ├── items/
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── index.blade.php
│       │
│       ├── layouts/
│       │   ├── app.blade.php
│       │   └── navigation.blade.php
│       │
│       ├── users/
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── index.blade.php
│       │
│       └── dashboard.blade.php
│
├── routes/
│   ├── auth.php
│   └── web.php
│
├── composer.json
├── composer.lock
├── package.json
├── package-lock.json
├── vite.config.js
└── README.md
```

---

# Validasi dan Keamanan

## 1. Form Request Validation

Validasi input disimpan di:

```text
app/Http/Requests
```

Validasi yang diterapkan meliputi:

- Nama kategori wajib diisi.
- Nama kategori harus unik.
- Kategori barang harus tersedia.
- Nama barang wajib diisi.
- Harga tidak boleh negatif.
- Stok harus berupa bilangan bulat.
- Stok tidak boleh negatif.
- Email user harus valid.
- Email user harus unik.
- Role hanya boleh `admin` atau `user`.
- Password minimal delapan karakter.
- Password harus memiliki huruf besar dan kecil.
- Password harus mengandung angka.
- Konfirmasi password harus sesuai.

---

## 2. CSRF Protection

Setiap form perubahan data menggunakan:

```blade
@csrf
```

Form edit dan hapus menggunakan method spoofing:

```blade
@method('PUT')
```

atau:

```blade
@method('DELETE')
```

Jangan menghapus `@csrf` dari form.

---

## 3. Eloquent ORM

Interaksi database menggunakan Eloquent ORM.

Contoh:

```php
Category::create($data);
Item::create($data);
User::create($data);
```

Penggunaan Eloquent membantu mencegah SQL injection karena query menggunakan parameter binding.

Hindari menyusun query mentah dengan menggabungkan input pengguna secara langsung.

Contoh yang tidak disarankan:

```php
DB::select("SELECT * FROM users WHERE email = '$email'");
```

---

## 4. Password Hashing

Password disimpan menggunakan hashing Laravel.

Model `User` menggunakan cast:

```php
'password' => 'hashed'
```

Controller juga dapat menggunakan:

```php
Hash::make($password);
```

Password asli tidak disimpan dalam database.

---

## 5. Middleware

Aplikasi menggunakan:

```text
auth
admin
```

Middleware `auth` memastikan pengguna sudah login.

Middleware `admin` memastikan hanya pengguna dengan:

```text
role = admin
```

yang dapat mengakses halaman manajemen user.

---

## 6. Mass Assignment Protection

Model menggunakan daftar atribut yang boleh diisi.

Contoh:

```php
#[Fillable(['name', 'email', 'password', 'role'])]
```

Atribut di luar daftar tersebut tidak dapat dimasukkan melalui mass assignment.

---

## 7. Foreign Key

Tabel `items` menggunakan foreign key:

```text
category_id
```

Foreign key mengarah ke:

```text
categories.id
```

Kategori yang masih mempunyai barang tidak dapat dihapus.

---

# Perintah Penting

## Menjalankan Laravel

```bash
php artisan serve
```

## Menjalankan Vite

```bash
npm run dev
```

## Build Frontend

```bash
npm run build
```

## Membersihkan Cache

```bash
php artisan optimize:clear
```

## Melihat Daftar Route

```bash
php artisan route:list
```

## Melihat Route Kategori

```bash
php artisan route:list --name=categories
```

## Melihat Route Barang

```bash
php artisan route:list --name=items
```

## Melihat Route User

```bash
php artisan route:list --name=users
```

## Melihat Status Migration

```bash
php artisan migrate:status
```

## Menjalankan Migration

```bash
php artisan migrate
```

## Menjalankan Seeder Admin

```bash
php artisan db:seed --class=AdminSeeder
```

## Membersihkan View Cache

```bash
php artisan view:clear
```

## Membersihkan Route Cache

```bash
php artisan route:clear
```

## Membersihkan Config Cache

```bash
php artisan config:clear
```

## Menjalankan Test

```bash
php artisan test
```

## Memeriksa Sintaks PHP

Contoh:

```bash
php -l app/Http/Controllers/ItemController.php
```

---

# Troubleshooting

## 1. Halaman Putih

Pastikan file `.env` berisi:

```env
APP_ENV=local
APP_DEBUG=true
```

Kemudian jalankan:

```bash
php artisan optimize:clear
```

Periksa log:

### Windows PowerShell

```powershell
Get-Content .\storage\logs\laravel.log -Tail 50
```

### Linux/macOS

```bash
tail -n 50 storage/logs/laravel.log
```

---

## 2. View Tidak Ditemukan

Contoh error:

```text
View [categories.create] not found
```

Pastikan file tersedia:

```text
resources/views/categories/create.blade.php
```

Contoh pemetaan nama view:

```php
return view('categories.create');
```

akan mencari:

```text
resources/views/categories/create.blade.php
```

Setelah membuat file, jalankan:

```bash
php artisan view:clear
```

---

## 3. Route Tidak Ditemukan

Jalankan:

```bash
php artisan route:list
```

Pastikan route yang dibutuhkan tersedia.

Bersihkan cache:

```bash
php artisan optimize:clear
```

---

## 4. Tailwind Tidak Tampil

Pastikan Vite berjalan:

```bash
npm run dev
```

Pastikan `resources/css/app.css` memiliki:

```css
@import "tailwindcss";
```

Pastikan `vite.config.js` menggunakan plugin:

```javascript
import tailwindcss from "@tailwindcss/vite";
```

Kemudian build ulang:

```bash
npm run build
```

Lakukan hard refresh pada browser:

```text
Ctrl + F5
```

---

## 5. Error PostCSS Tailwind CSS 4

Jika muncul error:

```text
It looks like you're trying to use tailwindcss directly as a PostCSS plugin
```

Pastikan proyek menggunakan `@tailwindcss/vite`.

Konfigurasi PostCSS lama tidak diperlukan jika sudah menggunakan plugin Vite.

Pastikan tidak terdapat konfigurasi lama aktif seperti:

```javascript
tailwindcss: {
}
```

---

## 6. SweetAlert Tidak Muncul

Pastikan package terpasang:

```bash
npm ci
```

atau:

npm install


Pastikan `resources/js/app.js` mengimpor:

import Swal from "sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

Pastikan Vite berjalan:

npm run dev

---

## 7. Database Connection Error

Periksa `.env`:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=manajemen_barang
DB_USERNAME=root
DB_PASSWORD=


Pastikan MySQL sedang berjalan.

Pada Laragon, klik:

Start All

Kemudian jalankan:

php artisan config:clear

---

## 8. Middleware Admin Tidak Ditemukan

Jika muncul:

Target class [admin] does not exist

Pastikan alias middleware sudah didaftarkan di:

bootstrap/app.php

Contoh:

$middleware->alias([
    'admin' => AdminMiddleware::class,
]);

Kemudian jalankan:

php artisan optimize:clear

---

## 9. Dependency Bermasalah

Hapus dan instal ulang dependency frontend.

### Windows PowerShell

Remove-Item -Recurse -Force .\node_modules
npm ci

Jika perlu menghapus lock file:

Remove-Item -Force .\package-lock.json
npm install

Untuk dependency PHP:

composer install

Jangan menghapus `composer.lock` kecuali memang ingin memperbarui versi dependency.

---

# Catatan Deployment

## File yang Harus Dikirim atau Masuk Repository

Pastikan file berikut ikut:

app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
tests/
artisan
composer.json
composer.lock
package.json
package-lock.json
vite.config.js
README.md
.env.example

## File yang Tidak Perlu Dikirim ke Repository

.env
vendor/
node_modules/

Alasannya:

- `vendor` dibuat kembali dengan `composer install`.
- `node_modules` dibuat kembali dengan `npm ci`.
- `.env` berisi konfigurasi dan informasi rahasia perangkat.

Pastikan `.gitignore` mencakup:

/vendor
/node_modules
.env

---

## Build Sebelum Deployment

Jalankan:

composer install --no-dev --optimize-autoloader
npm ci
npm run build
php artisan optimize

Atur environment:

APP_ENV=production
APP_DEBUG=false

Jangan menggunakan:

APP_DEBUG=true

pada server production karena dapat menampilkan informasi internal aplikasi.

---

# Instalasi Singkat

Ringkasan instalasi pada perangkat baru:

git clone <alamat-repository>
cd manajemen-barang

composer install
npm ci

cp .env.example .env
php artisan key:generate

Atur database pada `.env`, kemudian:

php artisan migrate
php artisan db:seed --class=AdminSeeder
npm run build
php artisan serve

Untuk mode pengembangan, jalankan terminal kedua:

npm run dev

Buka aplikasi:

http://127.0.0.1:8000

Login admin:

Email    : admin@example.com
Password : Admin123!

---

# Catatan untuk Pengguna Akhir

Pengguna akhir yang hanya mengakses aplikasi melalui browser tidak perlu menginstal:

PHP
Composer
Node.js
NPM
Laravel
Tailwind CSS
SweetAlert2
Laravel Breeze

Instalasi tersebut hanya diperlukan pada:

- Perangkat developer.
- Server aplikasi.
- Perangkat yang menjalankan source code secara lokal.

Pengguna akhir cukup membuka alamat aplikasi melalui browser.

---

# Lisensi

Proyek ini dibuat untuk kebutuhan skill test dan pembelajaran pengembangan aplikasi web menggunakan Laravel.
