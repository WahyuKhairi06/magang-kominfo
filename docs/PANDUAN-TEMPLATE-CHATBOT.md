# Panduan Penggunaan Ulang (Replication & Reuse) Template AI Chatbot
## Untuk Website Puskesmas Lain

Dokumen ini menjelaskan langkah-langkah teknis (oleh Developer) dan langkah operasional (oleh **Superadmin**) agar modul AI Chatbot yang sudah dikembangkan dapat langsung diduplikasi dan digunakan di website Puskesmas lain secara instan (*plug-and-play*).

---

## A. Persiapan Teknis (Oleh Developer)

Sebelum Superadmin dapat menggunakan sistem ini di website Puskesmas baru, developer harus menyalin komponen chatbot berikut ke dalam aplikasi Laravel yang baru:

### 1. Salin Folder Layanan AI
Salin seluruh folder `ai-service/` ke root direktori proyek website Puskesmas yang baru. Folder ini berisi:
* `chat_api.py` (Script eksekusi chat).
* `extract_ocr.py` (Script ekstraksi teks dari gambar/OCR).
* `prompt.py` (Instruksi sistem kepribadian AI).
* `requirements.txt` (Daftar *dependency* Python).

### 2. Instalasi Dependency di Server Baru
Jalankan perintah berikut di server baru untuk mengunduh pustaka Python yang dibutuhkan:
```bash
pip install -r ai-service/requirements.txt
```

### 3. Konfigurasi Environment (`.env`)
Tambahkan variabel berikut pada file `.env` di website baru:
```env
GEMINI_API_KEY=isi_api_key_gemini_puskesmas_baru
GEMINI_MODEL=gemini-2.5-flash
```

### 4. Database Migrasi
Pastikan tabel `chatbot_settings` dibuat di database baru dengan skema berikut:
```php
Schema::create('chatbot_settings', function (Blueprint $table) {
    $table->id();
    $table->string('ai_name');
    $table->string('puskesmas_display_name');
    $table->string('primary_color');
    $table->string('logo_chatbot')->nullable();
    $table->enum('status', ['active', 'inactive'])->default('active');
    $table->timestamps();
});
```

### 5. Salin Controller, Views & Routes
* **Controller:** Salin [ChatbotController.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Http/Controllers/ChatbotController.php) dan [ChatbotSettingController.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Http/Controllers/Admin/ChatbotSettingController.php).
* **Views:** 
  - Salin view chatbot pengunjung ([chat.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/chat.blade.php)).
  - Salin view widget melayang ([chatbot-widget.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/chatbot-widget.blade.php)).
  - Salin halaman admin ([index.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/admin/chatbot-setting/index.blade.php)).
* **Integrasi Layout & Footer:**
  - Untuk menampilkan widget melayang di semua halaman publik, sertakan `@include('chatbot-widget')` pada file footer global (seperti [footer.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/footer.blade.php)) sebelum penutupan body. Sebaiknya sembunyikan di halaman `/chat` penuh dan halaman `/admin*`.
  - Tautan menu chatbot di [navbar.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/navbar.blade.php) (baik di desktop maupun mobile) tetap dipertahankan guna memberikan kemudahan akses bagi pengguna yang ingin langsung pergi ke halaman chat penuh.
* **Routes:** Daftarkan rute `/chat`, `/chat/send` dan `/admin/chatbot-setting` di `routes/web.php`.

---

## B. Panduan Pengaturan (Oleh Superadmin)

Setelah sistem terpasang, Superadmin di website Puskesmas baru hanya perlu melakukan konfigurasi sederhana melalui Panel Admin tanpa menyentuh kode pemrograman sama sekali.

### 1. Menentukan Identitas & Tema Warna Chatbot
Superadmin masuk ke menu **Setting AI Chatbot** di Panel Admin untuk mengatur:
* **Nama AI:** Ketik nama asisten virtual yang diinginkan (contoh: *Pariaman Care AI*, *Si-Peka AI*).
* **Nama Puskesmas:** Masukkan nama Puskesmas baru (contoh: *Puskesmas Kurai Taji*). Nama ini akan disuntikkan secara otomatis ke instruksi sistem AI.
* **Warna Tema:** Pilih salah satu *preset* warna atau ketikkan kode warna HEX (misal: `#3b82f6` untuk biru) agar tampilan antarmuka chat langsung selaras dengan identitas visual Puskesmas tersebut.
* **Status:** Aktifkan chatbot agar langsung muncul pada rute `/chat` website.

---

### 2. Menambahkan Tombol Aksi / Link Navigasi (Super Ringan)
Untuk memandu pengunjung agar langsung mengakses menu tertentu (seperti halaman pengaduan, daftar online, atau jadwal), chatbot ini mendukung konversi **Tautan Markdown** secara otomatis menjadi **Tombol Aksi Hijau yang Premium**.

#### Cara Superadmin menambahkan tombol:
Cukup tuliskan tautan dengan format Markdown berikut di dalam konten artikel, informasi halaman, atau jawaban FAQ di Panel Admin:
```markdown
[Teks Tombol](URL Tujuan)
```

#### Contoh Penerapan:
* **Tombol Pendaftaran Online:**
  Jika admin menulis: `Silakan daftar online melalui link berikut: [Daftar Pelayanan](https://puskesmas-baru.go.id/pendaftaran)`
  * **Hasil di Chatbot:** Chatbot akan menampilkan teks tersebut dan mengubah `[Daftar Pelayanan]` menjadi sebuah **tombol klik berwarna hijau** yang mengarahkan pengunjung ke halaman pendaftaran.
  
* **Tombol Pengaduan Masyarakat:**
  Jika admin menulis: `Untuk melapor, silakan klik [Form Pengaduan](https://puskesmas-baru.go.id/pengaduan)`
  * **Hasil di Chatbot:** Muncul tombol bertuliskan **"Form Pengaduan"** di dalam gelembung obrolan chatbot.

---

### 3. Mengisi Data Basis Pengetahuan (Knowledge Base)
Chatbot ini bersifat dinamis dan langsung membaca database website. Superadmin hanya perlu mengisi konten website Puskesmas seperti biasa melalui Panel Admin pada modul-modul berikut:
* **Profil / Halaman Informasi:** Tulis Visi, Misi, Sejarah, Layanan Poliklinik, dan Fasilitas Puskesmas.
* **FAQ (Tanya Jawab):** Tambahkan daftar pertanyaan umum yang sering ditanyakan masyarakat (misal: syarat BPJS, jadwal loket, alur rujukan).
* **Agenda:** Isi kegiatan-kegiatan Puskesmas mendatang.
* **Dokumen Publik:** Unggah SOP pelayanan atau alur pendaftaran.

Setiap kali modul di atas diperbarui oleh Superadmin, basis pengetahuan chatbot akan ter-update secara otomatis secara real-time.

---

### 4. Kemampuan Membaca Gambar Jadwal / Alur (Otomatis OCR)
Jika Puskesmas memiliki berkas brosur jadwal pelayanan atau alur pemeriksaan dalam bentuk **Gambar (JPG/PNG)**:
1. Superadmin cukup mengunggah gambar tersebut ke dalam editor konten di menu **Halaman Profil / Informasi**.
2. Sistem secara otomatis di belakang layar akan memindai gambar tersebut (OCR), mengekstrak teksnya secara detail, dan menyimpannya ke database.
3. Chatbot langsung dapat menjawab pertanyaan pengunjung seperti *"Jadwal Poli Gigi hari apa saja?"* dengan akurat merujuk pada teks gambar yang sudah diekstrak tersebut.
