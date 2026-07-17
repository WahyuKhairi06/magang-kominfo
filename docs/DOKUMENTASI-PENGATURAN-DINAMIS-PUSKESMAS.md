# DOKUMENTASI FITUR: PENGATURAN DINAMIS IDENTITAS PUSKESMAS (SINGLE CODEBASE)

Dokumen ini menjelaskan detail fungsionalitas, arsitektur data, komponen teknis, serta panduan operasional untuk fitur **Pengaturan Dinamis Identitas Puskesmas** yang dirancang agar satu basis kode (*single codebase*) dapat digunakan di 9 puskesmas berbeda secara mandiri.

---

## 1. GAMBARAN UMUM
Untuk menghindari duplikasi kode (*copy-paste* proyek) saat meluncurkan website di 9 puskesmas berbeda, seluruh identitas utama website telah dipindahkan dari file kode program (*hardcoded*) ke dalam basis data (*database-driven config*). 

Dengan pendekatan ini:
*   Website dideploy dengan **kode program (repository Git) yang sama**.
*   Identitas khusus masing-masing puskesmas (seperti nama, alamat, no telp, email, logo, jam pelayanan, dan media sosial) dikonfigurasi melalui panel admin.
*   Perubahan data di admin panel langsung memperbarui tampilan antarmuka di sisi pengunjung (frontend) dan halaman manajemen (admin panel).

---

## 2. PANDUAN PENGGUNAAN (ADMIN PANEL)
Admin masing-masing puskesmas dapat memperbarui informasi dengan langkah berikut:
1.  Masuk ke **Admin Panel** menggunakan kredensial yang valid.
2.  Buka menu **Setting Identitas Puskesmas** pada sidebar kiri.
3.  Isi formulir yang tersedia:
    *   **Identitas Utama:** Nama Puskesmas, Kabupaten/Kota, dan Logo Puskesmas (Unggah file).
    *   **Jam Pelayanan:** Jadwal jam kerja Senin-Kamis, Jumat, dan Sabtu.
    *   **Kontak & Media Sosial:** Alamat Lengkap, Nomor Telepon, Email Resmi, Link Facebook, dan Link Instagram.
4.  Klik tombol **Simpan Identitas Puskesmas**.
5.  Periksa perubahan secara otomatis di halaman beranda (Navbar, Footer, Quick Info, dan Sambutan).

---

## 3. ARSITEKTUR & KOMPONEN TEKNIS

### 3.1 Skema Tabel Database (`puskesmas_settings`)
Tabel ini menampung satu baris record (`id = 1`) yang menyimpan konfigurasi identitas aktif.

| Nama Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | bigint (unsigned) | Primary Key |
| `nama_puskesmas` | string(150) | Nama puskesmas (Contoh: "Puskesmas Marunggi") |
| `kabupaten_kota` | string(150) | Wilayah tingkat II (Contoh: "Kota Pariaman") |
| `alamat` | text | Alamat fisik lengkap puskesmas |
| `no_telp` | string(50) | Kontak telepon resmi |
| `email` | string(150) | Email resmi puskesmas |
| `logo` | string(255) | Path file gambar logo yang diunggah |
| `jam_senin_kamis` | string(100) | Jam pelayanan Senin - Kamis (Default: '08:00 - 14:00') |
| `jam_jumat` | string(100) | Jam pelayanan Jumat (Default: '08:00 - 11:00') |
| `jam_sabtu` | string(100) | Jam pelayanan Sabtu (Default: '08:00 - 13:00') |
| `link_facebook` | string(255) | Tautan URL profil Facebook |
| `link_instagram` | string(255) | Tautan URL profil Instagram |

### 3.2 File yang Dibuat / Dimodifikasi

1.  **Model (`app/Models/PuskesmasSetting.php`):**
    Mengatur properti `$fillable` untuk mendukung mass assignment saat penyimpanan form data.
2.  **Controller (`app/Http/Controllers/Admin/PuskesmasSettingController.php`):**
    *   `index()`: Mengambil baris pertama tabel pengaturan atau membuat data default jika database kosong (`firstOrCreate`).
    *   `update()`: Memvalidasi data input, menangani upload logo baru ke folder `public/uploads/puskesmas/`, menghapus file logo lama di server, dan menyimpan pembaruan data ke database.
3.  **Global View Sharing (`app/Providers/AppServiceProvider.php`):**
    Menggunakan Laravel *View Composer* untuk mendistribusikan data `$puskesmasSetting` secara efisien (menggunakan static variable caching per request) ke seluruh render file `.blade.php` tanpa membebani query database.
4.  **Routing (`routes/web.php`):**
    Menambahkan route admin panel untuk menampilkan form (`GET /admin/puskesmas-setting`) dan memproses form (`PUT /admin/puskesmas-setting`) di dalam grup otentikasi.
5.  **Tampilan Panel Admin (`resources/views/admin/puskesmas-setting/index.blade.php`):**
    Halaman antarmuka input pengaturan menggunakan form responsive bertema Tailwind CSS.
6.  **Sidebar Dashboard (`resources/views/template/layout.blade.php`):**
    Menyambungkan menu baru "Setting Identitas Puskesmas" serta memodifikasi teks statis sidebar ("PUSKESMAS Marunggi") dan header topbar agar membaca database.
7.  **Frontend Layouts (`navbar.blade.php`, `footer.blade.php`, `landing.blade.php`):**
    Mengubah title browser, logo, favicon, kontak, jam kerja, sosial media, dan sambutan kepala puskesmas agar mengambil data secara dinamis.

---

## 4. PANDUAN DEPLOYMENT (UNTUK 9 PUSKESMAS)
Untuk meluncurkan sistem ke puskesmas baru:
1.  Pastikan repository kode program yang di-clone pada server/subdomain baru adalah basis kode utama yang sama (*single repository*).
2.  Setup server/hosting baru (atau subdomain baru) dan buat database kosong di server tersebut.
3.  Konfigurasikan file `.env` di server baru tersebut agar mengarah ke database kosong yang baru dibuat.
4.  Jalankan perintah migrasi database untuk membuat tabel-tabel terstruktur:
    ```bash
    php artisan migrate
    ```
5.  Masuk ke halaman login admin, login menggunakan akun admin default, lalu navigasikan ke halaman **Setting Identitas Puskesmas**.
6.  Isi data identitas spesifik milik puskesmas baru tersebut dan simpan. Website puskesmas baru Anda kini siap digunakan!
