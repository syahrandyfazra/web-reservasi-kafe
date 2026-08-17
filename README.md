# ☕ Web Reservasi Kafe

Aplikasi **Web Reservasi Kafe** merupakan sistem informasi berbasis web yang dikembangkan menggunakan **Laravel** untuk membantu proses reservasi meja, pemesanan menu, pembayaran, dan pengelolaan data kafe secara terintegrasi.

Sistem ini dirancang untuk memberikan kemudahan bagi pelanggan dalam melakukan reservasi meja dan pemesanan makanan/minuman secara online, sekaligus membantu administrator dalam mengelola menu, kategori, meja, reservasi, pembayaran, serta melakukan verifikasi reservasi menggunakan kode/QR.

---

## 📌 Daftar Isi

* [Tentang Project](#-tentang-project)
* [Tujuan](#-tujuan)
* [Fitur Utama](#-fitur-utama)
* [Role Pengguna](#-role-pengguna)
* [Alur Sistem](#-alur-sistem)
* [Alur Customer](#-alur-customer)
* [Alur Admin](#-alur-admin)
* [Manajemen Reservasi](#-manajemen-reservasi)
* [Sistem Pemesanan Menu](#-sistem-pemesanan-menu)
* [Sistem Pembayaran](#-sistem-pembayaran)
* [QR Code Reservasi](#-qr-code-reservasi)
* [Rekomendasi Menu](#-rekomendasi-menu)
* [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
* [Struktur Project](#-struktur-project)
* [Struktur Database](#-struktur-database)
* [Relasi Database](#-relasi-database)
* [Validasi dan Keamanan](#-validasi-dan-keamanan)
* [Persyaratan Sistem](#-persyaratan-sistem)
* [Instalasi](#-instalasi)
* [Konfigurasi Database](#-konfigurasi-database)
* [Migrasi dan Seeder](#-migrasi-dan-seeder)
* [Menjalankan Project](#-menjalankan-project)
* [Akun Admin](#-akun-admin)
* [Build untuk Production](#-build-untuk-production)
* [Perintah Laravel yang Sering Digunakan](#-perintah-laravel-yang-sering-digunakan)
* [Status Reservasi](#-status-reservasi)
* [Struktur Fitur Admin](#-struktur-fitur-admin)
* [Struktur Fitur Customer](#-struktur-fitur-customer)
* [Keamanan](#-keamanan)
* [Pengembangan Selanjutnya](#-pengembangan-selanjutnya)
* [Lisensi](#-lisensi)

---

# 📖 Tentang Project

**Web Reservasi Kafe** adalah aplikasi web yang menggabungkan beberapa proses utama operasional kafe dalam satu sistem, yaitu:

1. Pengelolaan kategori menu.
2. Pengelolaan makanan dan minuman.
3. Pengelolaan meja kafe.
4. Pemeriksaan ketersediaan meja berdasarkan tanggal dan jam.
5. Reservasi meja.
6. Pemesanan menu saat melakukan reservasi.
7. Perhitungan total harga pesanan.
8. Checkout reservasi.
9. Pembayaran melalui transfer/QR.
10. Upload bukti pembayaran.
11. Verifikasi pembayaran oleh admin.
12. Pengelolaan status reservasi.
13. Scan kode reservasi/QR untuk pemeriksaan data.
14. Rekomendasi menu berdasarkan pola pemesanan sebelumnya.
15. Dashboard admin untuk melihat statistik sistem.

Aplikasi mendukung reservasi menggunakan akun pelanggan dan juga menyediakan mekanisme **reservasi sebagai guest** tanpa harus memiliki akun.

---

# 🎯 Tujuan

Project ini dibuat dengan beberapa tujuan utama:

* Mempermudah pelanggan melakukan reservasi meja.
* Mengurangi risiko bentrok jadwal meja.
* Mempermudah pelanggan memilih dan memesan menu.
* Mengintegrasikan reservasi dengan pemesanan makanan/minuman.
* Mempermudah proses pembayaran dan verifikasi pembayaran.
* Membantu admin mengelola data kafe.
* Menyediakan informasi reservasi secara terstruktur.
* Memanfaatkan data transaksi untuk memberikan rekomendasi menu.
* Meningkatkan efisiensi pengelolaan reservasi kafe.

---

# ✨ Fitur Utama

## 👤 Customer

Customer dapat:

* Registrasi akun.
* Login dan logout.
* Mengelola profil.
* Melakukan reservasi meja.
* Memilih tanggal reservasi.
* Memilih jam mulai dan jam selesai.
* Melihat meja yang tersedia.
* Memilih jenis meja.
* Melihat menu berdasarkan kategori.
* Memesan makanan/minuman.
* Wajib memilih minimal satu menu.
* Melihat total harga.
* Melakukan checkout.
* Memilih metode pembayaran.
* Mengupload bukti pembayaran.
* Melihat QR Code reservasi.
* Melihat status reservasi.
* Membatalkan reservasi yang masih menunggu pembayaran.
* Melihat riwayat reservasi.

## 👨‍💼 Admin

Admin dapat:

* Melihat dashboard.
* Melihat jumlah menu.
* Melihat jumlah meja.
* Melihat jumlah reservasi.
* Melihat total pendapatan dari pembayaran berhasil.
* Mengelola kategori menu.
* Menambahkan kategori.
* Mengubah kategori.
* Menghapus kategori.
* Mengelola menu.
* Menambahkan menu.
* Mengubah menu.
* Menghapus menu.
* Upload foto menu.
* Mengelola meja.
* Menambahkan meja.
* Mengubah meja.
* Menghapus meja.
* Melihat data pembayaran.
* Memverifikasi pembayaran.
* Menyelesaikan reservasi.
* Membatalkan reservasi.
* Melakukan pengecekan reservasi menggunakan kode reservasi/QR.

---

# 👥 Role Pengguna

Sistem memiliki dua role utama:

| Role        | Keterangan                                          |
| ----------- | --------------------------------------------------- |
| `admin`     | Mengelola seluruh data dan proses operasional kafe  |
| `pelanggan` | Melakukan reservasi, pemesanan menu, dan pembayaran |

Selain pelanggan yang memiliki akun, sistem juga menyediakan **guest reservation** untuk melakukan reservasi tanpa login.

---

# 🔄 Alur Sistem

Secara umum alur sistem adalah:

```text
                ┌──────────────────┐
                │      LOGIN       │
                └────────┬─────────┘
                         │
             ┌───────────┴───────────┐
             │                       │
             ▼                       ▼
        ┌─────────┐             ┌───────────┐
        │  ADMIN  │             │ CUSTOMER  │
        └────┬────┘             └─────┬─────┘
             │                        │
             ▼                        ▼
      Dashboard Admin          Pilih Tanggal
             │                        │
             ├── Kategori             ▼
             ├── Menu          Pilih Jam Reservasi
             ├── Meja                  │
             ├── Pembayaran            ▼
             └── Scan QR        Cek Meja Tersedia
                                      │
                                      ▼
                                Pilih Meja
                                      │
                                      ▼
                               Pilih Menu
                                      │
                                      ▼
                                  Checkout
                                      │
                                      ▼
                                  Pembayaran
                                      │
                                      ▼
                            Upload Bukti Bayar
                                      │
                                      ▼
                              Verifikasi Admin
                                      │
                                      ▼
                             Reservasi Dibayar
                                      │
                                      ▼
                              Pelanggan Datang
                                      │
                                      ▼
                             Scan Kode Reservasi
                                      │
                                      ▼
                               Reservasi Selesai
```

---

# 👤 Alur Customer

## 1. Registrasi

Pelanggan dapat membuat akun dengan memasukkan:

* Nama.
* Email.
* Password.
* Konfirmasi password.

Role pengguna yang melakukan registrasi otomatis ditetapkan sebagai:

```text
pelanggan
```

---

## 2. Login

Setelah memiliki akun, pelanggan dapat login untuk mengakses fitur customer.

Setelah login, sistem mengarahkan pengguna berdasarkan role:

```text
Admin      → /admin/dashboard
Pelanggan  → /customer/home
```

---

## 3. Memilih Jadwal Reservasi

Pelanggan memasukkan:

* Tanggal.
* Jam mulai.
* Jam selesai.

Sistem kemudian memeriksa meja yang sudah digunakan pada waktu tersebut.

Reservasi yang memiliki status:

```text
menunggu_pembayaran
dibayar
```

akan dianggap sebagai reservasi aktif dalam pengecekan bentrok jadwal.

---

## 4. Memilih Meja

Sistem menampilkan meja yang tersedia.

Jenis meja yang digunakan:

### Meja Reguler

Digunakan untuk reservasi biasa.

### Meeting Room

Digunakan untuk kebutuhan dengan kapasitas lebih besar.

Contoh data awal:

```text
Meja 01       → Kapasitas 2
Meja 02       → Kapasitas 2
Meja 03       → Kapasitas 4
Meja 04       → Kapasitas 4
Meja 05       → Kapasitas 6
Meja 06       → Kapasitas 6
Meja 07       → Kapasitas 8
Meja 08       → Kapasitas 8
Meeting Room A → Kapasitas 15
Meeting Room B → Kapasitas 20
```

---

# 🍽️ Sistem Pemesanan Menu

Reservasi tidak hanya digunakan untuk memilih meja.

Pelanggan juga harus memilih minimal **1 menu**.

Menu dikelompokkan berdasarkan kategori:

* Makanan.
* Minuman.
* Snack.
* Paket.

Setiap menu memiliki:

* Nama menu.
* Deskripsi.
* Harga.
* Foto.
* Status ketersediaan.
* Kategori.

Status menu:

```text
tersedia
habis
```

Menu yang berstatus `habis` tidak dapat dipilih pelanggan.

---

# 💰 Perhitungan Pesanan

Setiap item pesanan memiliki:

```text
Harga × Jumlah = Subtotal
```

Kemudian seluruh subtotal dijumlahkan menjadi:

```text
Total Pesanan
```

Total tersebut digunakan sebagai total harga reservasi.

Sistem menggunakan transaksi database ketika membuat reservasi dan pesanan sehingga proses penyimpanan data dapat dilakukan secara konsisten.

---

# 🪑 Manajemen Reservasi

Setiap reservasi memiliki:

* ID.
* User.
* Nama guest jika reservasi guest.
* Email guest jika reservasi guest.
* Meja.
* Kode reservasi.
* Tanggal.
* Jam mulai.
* Jam selesai.
* Total harga.
* Status.

Setiap reservasi menghasilkan kode unik:

```text
kode_reservasi
```

Kode tersebut dapat digunakan untuk melakukan pengecekan reservasi.

---

# 💳 Sistem Pembayaran

Setelah reservasi dan pemesanan menu selesai, pelanggan diarahkan ke halaman checkout.

Pelanggan dapat:

1. Melihat detail reservasi.
2. Melihat meja.
3. Melihat daftar menu.
4. Melihat jumlah pesanan.
5. Melihat total pembayaran.
6. Memilih metode pembayaran.
7. Upload bukti pembayaran.

Data pembayaran menyimpan:

* Reservasi.
* Metode pembayaran.
* Jumlah pembayaran.
* Bukti pembayaran.
* Status pembayaran.
* Tanggal pembayaran.

Status pembayaran:

```text
pending
berhasil
gagal
```

---

# 🔎 Verifikasi Pembayaran

Pembayaran yang dilakukan pelanggan memiliki status awal:

```text
pending
```

Admin kemudian dapat memeriksa pembayaran.

Jika pembayaran valid:

```text
Pembayaran
     ↓
berhasil
     ↓
Reservasi
     ↓
dibayar
     ↓
Meja
     ↓
dipesan
```

Jika pembayaran dibatalkan/gagal, status pembayaran dapat menjadi:

```text
gagal
```

dan meja dikembalikan menjadi:

```text
tersedia
```

---

# 📱 QR Code Reservasi

Sistem menyediakan QR Code yang berhubungan dengan reservasi.

QR/kode reservasi dapat digunakan admin untuk melakukan pengecekan data reservasi.

Admin dapat melihat informasi seperti:

* Data pelanggan.
* Data meja.
* Detail pesanan.
* Pembayaran.
* Status reservasi.

Fitur ini menggunakan package:

```text
simplesoftwareio/simple-qrcode
```

---

# 🤖 Rekomendasi Menu

Sistem memiliki fitur rekomendasi menu sederhana berdasarkan pola menu yang sering dipesan bersama.

Algoritma yang digunakan adalah pendekatan **association / Apriori sederhana**.

Sistem menganalisis pasangan menu yang terdapat pada transaksi yang sama.

Contohnya:

```text
Nasi Goreng + Es Kopi Susu Aren
```

Jika pasangan menu tersebut sering muncul dalam transaksi, sistem dapat menggunakan pola tersebut untuk memberikan rekomendasi.

Rekomendasi mengambil hingga **2 menu terkait** untuk setiap menu.

Tujuan fitur ini adalah membantu pelanggan menemukan menu lain yang kemungkinan sesuai dengan pilihannya.

---

# 👨‍💼 Alur Admin

Setelah admin login, admin diarahkan ke:

```text
/admin/dashboard
```

Dashboard menampilkan informasi:

* Total menu.
* Total meja.
* Total reservasi.
* Total pendapatan dari pembayaran berhasil.
* Reservasi terbaru.

---

# 📊 Dashboard Admin

Dashboard berfungsi sebagai pusat informasi operasional.

Data yang ditampilkan meliputi:

```text
Total Menu
Total Meja
Total Reservasi
Total Pendapatan
Reservasi Terbaru
```

Total pendapatan dihitung berdasarkan pembayaran dengan status:

```text
berhasil
```

---

# 🗂️ Manajemen Kategori

Admin dapat melakukan CRUD kategori:

```text
Create
Read
Update
Delete
```

Data kategori terdiri dari:

* Nama kategori.
* Deskripsi.

Contoh kategori:

```text
Makanan
Minuman
Snack
Paket
```

---

# 🍔 Manajemen Menu

Admin dapat:

* Melihat menu.
* Menambahkan menu.
* Mengedit menu.
* Menghapus menu.
* Menentukan kategori.
* Menentukan harga.
* Menentukan status.
* Menambahkan foto menu.

Foto menu disimpan pada:

```text
public/menus/
```

Nama file foto dibuat menggunakan UUID agar mengurangi kemungkinan nama file yang sama.

---

# 🪑 Manajemen Meja

Admin dapat mengelola data meja.

Data meja terdiri dari:

* Nomor meja.
* Kapasitas.
* Status.
* Tipe meja.

Status meja:

```text
tersedia
dipesan
```

Tipe meja:

```text
reguler
meeting_room
```

---

# 💵 Manajemen Pembayaran

Admin dapat melihat seluruh pembayaran dan reservasi.

Tersedia beberapa tindakan:

### Verifikasi

Mengubah pembayaran menjadi:

```text
berhasil
```

dan reservasi menjadi:

```text
dibayar
```

serta meja menjadi:

```text
dipesan
```

### Selesai

Setelah pelanggan selesai menggunakan meja:

```text
reservasi → selesai
meja → tersedia
```

### Batal

Jika reservasi dibatalkan:

```text
reservasi → dibatalkan
pembayaran → gagal
meja → tersedia
```

---

# 📷 Scan Reservasi

Admin memiliki halaman:

```text
/admin/scan
```

Admin dapat memasukkan kode reservasi untuk mendapatkan data reservasi.

Data yang dapat diperiksa meliputi:

* Pelanggan.
* Meja.
* Pesanan.
* Pembayaran.
* Status reservasi.

Fitur ini dapat digunakan sebagai proses validasi ketika pelanggan datang ke kafe.

---

# 🔐 Validasi Bentrok Reservasi

Salah satu fitur penting sistem adalah pencegahan bentrok reservasi.

Sistem melakukan pengecekan berdasarkan:

```text
Tanggal
+
Jam mulai
+
Jam selesai
+
Meja
```

Sistem akan menolak reservasi apabila terdapat reservasi aktif dengan waktu yang bertabrakan.

Secara konsep:

```text
Jam Reservasi Baru
        │
        ▼
Cek Reservasi Aktif
        │
        ├── Tidak Bentrok → Lanjut
        │
        └── Bentrok → Tolak Reservasi
```

Selain pengecekan biasa, proses pembuatan reservasi menggunakan:

```text
Database Transaction
+
lockForUpdate()
```

untuk membantu mencegah dua proses melakukan pemesanan meja yang sama secara bersamaan.

---

# 🧑‍💻 Guest Reservation

Sistem juga menyediakan reservasi tanpa akun.

Guest dapat mengirim:

```text
Nama
Email
Tanggal
Jam
Meja
Menu
```

Pada database, `user_id` reservasi guest dapat bernilai:

```text
NULL
```

Data guest disimpan pada:

```text
guest_name
guest_email
```

Dengan demikian, sistem dapat mendukung:

```text
Customer Login
+
Guest Reservation
```

---

# 🗄️ Struktur Database

Database utama terdiri dari beberapa tabel:

```text
users
kategori_menu
menu
meja
reservasi
pesanan
detail_pesanan
pembayaran
sessions
cache
cache_locks
jobs
job_batches
failed_jobs
password_reset_tokens
```

---

# 🔗 Relasi Database

Struktur relasi utama:

```text
users
  │
  └──── reservasi
             │
             ├──── meja
             │
             ├──── pesanan
             │        │
             │        └──── detail_pesanan
             │                    │
             │                    └──── menu
             │
             └──── pembayaran

kategori_menu
      │
      └──── menu
```

### Relasi utama

```text
KategoriMenu 1 ──── N Menu

User 1 ──── N Reservasi

Meja 1 ──── N Reservasi

Reservasi 1 ──── N Pesanan

Pesanan 1 ──── N DetailPesanan

Menu 1 ──── N DetailPesanan

Reservasi 1 ──── N Pembayaran
```

---

# 🛠️ Teknologi yang Digunakan

## Backend

* PHP 8.3+
* Laravel 13
* Laravel Eloquent ORM
* Laravel Blade
* Laravel Breeze
* Livewire
* Livewire Volt

## Frontend

* HTML
* CSS
* JavaScript
* Blade Template
* Tailwind CSS
* Vite
* Alpine.js

## Database

* MySQL

## Package Tambahan

### Laravel DOMPDF

Digunakan untuk kebutuhan pembuatan dokumen/PDF.

```text
barryvdh/laravel-dompdf
```

### Simple QR Code

Digunakan untuk pembuatan QR Code.

```text
simplesoftwareio/simple-qrcode
```

### Livewire

Digunakan untuk komponen interaktif pada aplikasi.

```text
livewire/livewire
livewire/volt
```

---

# 📁 Struktur Project

Struktur utama aplikasi:

```text
web-reservasi-kafe/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── Auth/
│   │   │   └── Customer/
│   │   │
│   │   ├── Middleware/
│   │   └── Requests/
│   │
│   ├── Livewire/
│   ├── Models/
│   ├── Providers/
│   └── View/
│
├── bootstrap/
│
├── config/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── public/
│   ├── menus/
│   └── ...
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── customer/
│       ├── layouts/
│       ├── livewire/
│       └── profile/
│
├── routes/
│   ├── web.php
│   ├── auth.php
│   └── console.php
│
├── storage/
│
├── tests/
│
├── .env.example
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── package-lock.json
├── vite.config.js
└── README.md
```

---

# ⚙️ Persyaratan Sistem

Sebelum menjalankan project, pastikan komputer sudah memiliki:

* PHP **8.3 atau lebih baru**
* Composer
* Node.js
* NPM
* MySQL
* Git
* Web browser

Project ini menggunakan:

```text
Laravel 13
PHP ^8.3
```

---

# 🚀 Instalasi

## 1. Clone Repository

Clone repository:

```bash
git clone https://github.com/syahrandyfazra/web-reservasi-kafe.git
```

Masuk ke folder:

```bash
cd web-reservasi-kafe
```

---

# 2. Install Dependency Laravel

Jalankan:

```bash
composer install
```

Perintah ini akan menginstall dependency PHP yang terdapat pada:

```text
composer.json
```

---

# 3. Install Dependency Frontend

Jalankan:

```bash
npm install
```

Perintah ini menginstall dependency frontend seperti:

* Vite.
* Tailwind CSS.
* Alpine.js.
* Livewire dependencies.
* Laravel Vite Plugin.

---

# 4. Membuat File `.env`

Jangan menggunakan `.env` dari repository.

Salin:

```bash
cp .env.example .env
```

Pada Windows PowerShell dapat menggunakan:

```powershell
Copy-Item .env.example .env
```

---

# 5. Generate Application Key

Jalankan:

```bash
php artisan key:generate
```

Laravel akan mengisi:

```text
APP_KEY
```

pada file `.env`.

---

# 🗄️ Konfigurasi Database

Buat database MySQL, misalnya:

```text
web_reservasi_kafe
```

Kemudian ubah konfigurasi `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_reservasi_kafe
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan:

```text
DB_DATABASE
DB_USERNAME
DB_PASSWORD
```

dengan konfigurasi MySQL pada komputer masing-masing.

---

# 🔄 Migrasi Database

Setelah database dibuat, jalankan:

```bash
php artisan migrate
```

Migration akan membuat tabel yang dibutuhkan aplikasi.

---

# 🌱 Seeder

Project menyediakan beberapa seeder:

```text
AdminSeeder
CafeSeeder
ReservasiSeeder
DatabaseSeeder
```

Untuk menjalankan seluruh seeder:

```bash
php artisan db:seed
```

Atau untuk menghapus dan membuat ulang database sekaligus menjalankan seeder:

```bash
php artisan migrate:fresh --seed
```

> Gunakan `migrate:fresh --seed` hanya pada database development karena perintah ini menghapus tabel/data yang sudah ada.

---

# 📦 Data Awal Seeder

`CafeSeeder` menyediakan data awal seperti:

### Kategori

```text
Makanan
Minuman
Snack
Paket
```

### Meja

Terdapat beberapa meja reguler dan meeting room dengan kapasitas berbeda.

### Contoh Menu

```text
Nasi Goreng Spesial
Mie Goreng Jawa
Ayam Bakar Madu
Es Kopi Susu Aren
Teh Manis Dingin
Matcha Latte
French Fries
Roti Bakar Cokelat Keju
Cireng Rujak
Paket Rame-rame
```

`ReservasiSeeder` juga menyediakan data reservasi dummy untuk membantu pengujian fitur sistem, termasuk pola transaksi yang digunakan dalam rekomendasi menu.

---

# 👨‍💼 Akun Admin

Project menyediakan `AdminSeeder` untuk membuat akun administrator pada database development.

Akun admin dibuat melalui:

```text
database/seeders/AdminSeeder.php
```

Untuk alasan keamanan, **jangan menggunakan kredensial bawaan/default untuk production** dan ubah password administrator setelah instalasi.

---

# ▶️ Menjalankan Project

Ada beberapa cara menjalankan aplikasi.

## Cara 1 — Server Laravel + Vite secara terpisah

Terminal pertama:

```bash
php artisan serve
```

Terminal kedua:

```bash
npm run dev
```

Kemudian buka:

```text
http://127.0.0.1:8000
```

---

## Cara 2 — Menggunakan script development

Project memiliki script:

```bash
composer run dev
```

Script tersebut menjalankan beberapa proses development, termasuk:

```text
Laravel Server
Queue Listener
Vite
```

Jika command tersebut berjalan dengan baik, aplikasi dapat diakses melalui alamat server Laravel yang ditampilkan pada terminal.

---

# 🎨 Build Frontend

Untuk membuat build frontend:

```bash
npm run build
```

Vite akan menghasilkan asset production pada:

```text
public/build
```

---

# 🧹 Membersihkan Cache

Jika terjadi masalah konfigurasi atau cache, jalankan:

```bash
php artisan optimize:clear
```

Kemudian:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

# 🔧 Perintah Laravel yang Sering Digunakan

## Menjalankan server

```bash
php artisan serve
```

## Melihat daftar route

```bash
php artisan route:list
```

## Membuat controller

```bash
php artisan make:controller NamaController
```

## Membuat model

```bash
php artisan make:model NamaModel
```

## Membuat migration

```bash
php artisan make:migration create_nama_table
```

## Menjalankan migration

```bash
php artisan migrate
```

## Reset migration

```bash
php artisan migrate:reset
```

## Fresh migration + seeder

```bash
php artisan migrate:fresh --seed
```

## Menjalankan seeder

```bash
php artisan db:seed
```

## Membersihkan cache

```bash
php artisan optimize:clear
```

## Menjalankan test

```bash
php artisan test
```

---

# 📊 Status Reservasi

Reservasi memiliki beberapa status.

## `menunggu_pembayaran`

Reservasi sudah dibuat tetapi pembayaran belum diverifikasi.

```text
Reservasi dibuat
       ↓
menunggu_pembayaran
```

## `dibayar`

Pembayaran sudah diverifikasi admin.

```text
Pembayaran berhasil
       ↓
dibayar
```

## `selesai`

Reservasi sudah selesai digunakan.

```text
Reservasi selesai
       ↓
selesai
```

Meja akan dikembalikan menjadi:

```text
tersedia
```

## `dibatalkan`

Reservasi dibatalkan oleh customer/admin.

```text
Reservasi
    ↓
dibatalkan
```

Meja juga dikembalikan menjadi:

```text
tersedia
```

---

# 💳 Status Pembayaran

Pembayaran memiliki tiga status:

```text
pending
berhasil
gagal
```

Alur pembayaran:

```text
Customer membuat reservasi
          ↓
Upload bukti pembayaran
          ↓
       pending
          ↓
    Admin verifikasi
       ↙       ↘
 berhasil      gagal
    ↓             ↓
 dibayar      dibatalkan
```

---

# 🧩 Struktur Fitur Admin

```text
ADMIN
│
├── Dashboard
│   ├── Total Menu
│   ├── Total Meja
│   ├── Total Reservasi
│   ├── Total Pendapatan
│   └── Reservasi Terbaru
│
├── Kategori
│   ├── Tambah
│   ├── Edit
│   └── Hapus
│
├── Menu
│   ├── Daftar Menu
│   ├── Tambah Menu
│   ├── Edit Menu
│   ├── Hapus Menu
│   ├── Upload Foto
│   └── Status Menu
│
├── Meja
│   ├── Tambah
│   ├── Edit
│   ├── Hapus
│   ├── Kapasitas
│   └── Status Meja
│
├── Pembayaran
│   ├── Lihat Pembayaran
│   ├── Verifikasi
│   ├── Selesai
│   └── Batal
│
└── Scan Reservasi
    └── Cek Kode Reservasi
```

---

# 🧑‍🍳 Struktur Fitur Customer

```text
CUSTOMER
│
├── Home
│   ├── Menu
│   └── Riwayat Reservasi
│
├── Reservasi
│   ├── Pilih Tanggal
│   ├── Pilih Jam
│   ├── Cek Ketersediaan
│   ├── Pilih Meja
│   └── Pilih Menu
│
├── Checkout
│   ├── Detail Reservasi
│   ├── Detail Pesanan
│   ├── Total Pembayaran
│   └── Metode Pembayaran
│
├── Pembayaran
│   ├── Upload Bukti
│   └── QR Code
│
└── Status
    ├── Menunggu Pembayaran
    ├── Dibayar
    ├── Selesai
    └── Dibatalkan
```

---

# 🔐 Validasi dan Keamanan

Project menggunakan beberapa mekanisme untuk menjaga keamanan dan konsistensi sistem.

### Authentication

Akses pengguna dilindungi oleh middleware:

```text
auth
```

### Admin Middleware

Halaman administrator menggunakan middleware:

```text
admin
```

sehingga fitur admin hanya dapat diakses oleh pengguna dengan role:

```text
admin
```

### Form Request Validation

Validasi request dipisahkan menggunakan Form Request, seperti:

```text
KategoriRequest
MenuRequest
MejaRequest
ReservationAvailabilityRequest
StoreReservationRequest
StoreGuestReservationRequest
PayReservationRequest
ScanReservationRequest
```

### Password Hashing

Password pengguna disimpan menggunakan hashing Laravel.

### Database Transaction

Proses penting seperti pembuatan reservasi dan verifikasi pembayaran menggunakan:

```text
DB::transaction()
```

### Row Locking

Pemesanan meja menggunakan:

```text
lockForUpdate()
```

untuk membantu menghindari kondisi race condition saat beberapa proses mencoba menggunakan meja yang sama.

---

# 🔒 Keamanan File `.env`

**Jangan upload file `.env` ke GitHub.**

File `.env` berisi konfigurasi environment aplikasi seperti:

```text
APP_KEY
DB_DATABASE
DB_USERNAME
DB_PASSWORD
MAIL_USERNAME
MAIL_PASSWORD
AWS_ACCESS_KEY_ID
AWS_SECRET_ACCESS_KEY
```

Gunakan:

```text
.env.example
```

sebagai template konfigurasi.

Jika `.env` pernah terlanjur di-upload ke repository publik dan berisi credential/API key yang valid, credential tersebut sebaiknya segera diganti/revoke.

---

# 📸 Penyimpanan Foto Menu

Foto menu disimpan pada:

```text
public/menus/
```

Saat admin menambahkan menu, sistem:

1. Memeriksa apakah file foto tersedia.
2. Membuat folder `public/menus` jika belum ada.
3. Menghasilkan nama file menggunakan UUID.
4. Menyimpan file ke folder menu.
5. Menyimpan path file ke database.

Contoh:

```text
public/menus/
├── 122310e4-788b-44c7-abf6-b27d649ce6a6.jpg
├── 1cd3d52d-bbba-4a26-bdd8-2924c5fee5f9.jpg
└── ...
```

---

# 🧪 Pengujian Sistem

Sebelum digunakan, beberapa skenario yang dapat diuji:

### Authentication

* Registrasi customer.
* Login customer.
* Login admin.
* Logout.
* Reset password.

### Reservasi

* Memilih tanggal.
* Memilih jam.
* Memilih meja.
* Reservasi pada jadwal tersedia.
* Reservasi pada jadwal bentrok.
* Reservasi guest.
* Membatalkan reservasi.

### Menu

* Menampilkan menu.
* Menambahkan menu.
* Mengubah menu.
* Menghapus menu.
* Mengubah status menu.
* Upload foto menu.

### Pembayaran

* Checkout.
* Upload bukti pembayaran.
* Verifikasi pembayaran.
* Pembayaran gagal.
* Pembatalan reservasi.

### Admin

* Dashboard.
* Kategori.
* Menu.
* Meja.
* Pembayaran.
* Scan reservasi.

### Rekomendasi

* Membuat transaksi dummy.
* Memastikan pola menu terbaca.
* Memastikan rekomendasi menu muncul.

---

# 📈 Pengembangan Selanjutnya

Beberapa fitur yang dapat dikembangkan pada versi berikutnya:

* Integrasi payment gateway seperti Midtrans/Xendit.
* Notifikasi WhatsApp setelah reservasi.
* Email konfirmasi reservasi.
* Notifikasi pembayaran.
* Dashboard statistik yang lebih lengkap.
* Laporan pendapatan berdasarkan periode.
* Export laporan ke PDF/Excel.
* Manajemen stok menu.
* Sistem promo dan voucher.
* Rating dan review menu.
* Sistem membership pelanggan.
* Multi-cabang kafe.
* Integrasi printer struk.
* Real-time notification.
* Peningkatan algoritma rekomendasi menggunakan Association Rule Mining yang lebih lengkap.
* Pengembangan API untuk aplikasi mobile.

---

# 📌 Catatan Penggunaan

Project ini merupakan aplikasi berbasis Laravel yang ditujukan untuk kebutuhan pembelajaran, pengembangan sistem informasi, dan simulasi pengelolaan reservasi kafe.

Untuk penggunaan production, beberapa aspek perlu disesuaikan kembali, terutama:

* Konfigurasi server.
* Keamanan `.env`.
* Pengelolaan credential.
* Payment gateway.
* Email/notification service.
* Storage file.
* Backup database.
* HTTPS.
* Monitoring.
* Logging.
* Pengaturan queue.
* Pengamanan akun administrator.

---

# 🧑‍💻 Git & GitHub

Untuk mengambil versi terbaru dari repository:

```bash
git pull origin main
```

Untuk mengirim perubahan:

```bash
git add .
git commit -m "Update project"
git push origin main
```

Repository:

**https://github.com/syahrandyfazra/web-reservasi-kafe**

---

# 📄 Lisensi

Project menggunakan lisensi MIT sesuai konfigurasi Laravel dan dependency project.

---

# 👨‍💻 Developer

**Syahrandy Fazra**

Project:

**Web Reservasi Kafe**

Dibangun menggunakan:

```text
Laravel 13
PHP 8.3+
MySQL
Blade
Tailwind CSS
Livewire
Vite
Alpine.js
```

---

## ⭐ Kesimpulan

**Web Reservasi Kafe** merupakan aplikasi reservasi dan pemesanan kafe yang mengintegrasikan proses:

```text
Registrasi/Login
      ↓
Pilih Jadwal
      ↓
Cek Ketersediaan Meja
      ↓
Pilih Meja
      ↓
Pilih Menu
      ↓
Checkout
      ↓
Pembayaran
      ↓
Upload Bukti
      ↓
Verifikasi Admin
      ↓
Reservasi Dibayar
      ↓
Scan Reservasi
      ↓
Reservasi Selesai
