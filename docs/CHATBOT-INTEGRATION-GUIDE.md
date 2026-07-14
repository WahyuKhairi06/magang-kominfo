# Panduan Integrasi & Kloning Fitur Chatbot AI
Dokumen ini menjelaskan strategi untuk mengintegrasikan chatbot yang telah dibuat ke website lain atau cara melakukan kloning fitur secara mandiri untuk website baru.

---

## METODE 1: Integrasi Lintas Website (Website Lain Menghubungi Server Ini)

Jika Anda ingin website lain menampilkan chatbot yang dikelola oleh server Puskesmas Marunggi ini (menggunakan database & kecerdasan AI yang sama), ada dua pendekatan utama:

### Pendekatan A: Menggunakan `iframe` Widget (Sangat Direkomendasikan & Termudah)
Anda dapat membuat halaman chat khusus tanpa navbar/footer (tampilan bersih) di Laravel saat ini, kemudian dipasang menggunakan tag `iframe` di website tujuan.

1. **Langkah di Website Utama (Laravel Host)**:
   - Buat route baru, misalnya `/chat/widget` yang merender halaman chat bersih (tanpa `@include('navbar')` dan `@include('footer')`).
   - Nonaktifkan proteksi X-Frame-Options (middleware) agar web lain diperbolehkan memuat halaman tersebut.
2. **Langkah di Website Lain (WordPress, Web Statis, dll)**:
   - Cukup tempel kode HTML berikut di bagian yang diinginkan:
     ```html
     <iframe src="https://website-puskesmas-marunggi.com/chat/widget" 
             style="position: fixed; bottom: 20px; right: 20px; width: 400px; height: 600px; border: none; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 9999;">
     </iframe>
     ```
   *Kelebihan: Jika Anda mengubah setelan nama atau warna tema di panel admin, tampilan di website lain otomatis ikut berubah secara real-time.*

---

### Pendekatan B: Integrasi API Headless (Untuk Kustomisasi UI Penuh)
Website lain menggunakan antarmukanya sendiri (frontend kustom) dan hanya menembak API (backend) dari server Laravel Puskesmas Marunggi.

1. **Langkah di Website Utama (Laravel Host)**:
   - Daftarkan route baru di file `routes/api.php` agar dapat diakses dari luar:
     ```php
     Route::post('/chatbot/query', [ChatbotController::class, 'apiSend']);
     ```
   - Di Controller, kembalikan jawaban langsung dalam format JSON.
   - Aktifkan CORS (Cross-Origin Resource Sharing) agar website luar diizinkan mengirim request.
2. **Langkah di Website Lain**:
   - Kirim HTTP POST Request (melalui Javascript fetch/axios) ke `https://website-puskesmas-marunggi.com/api/chatbot/query` dengan data `{ message: "Pertanyaan user" }`.
   - Tangkap respon JSON jawaban dan tampilkan di UI mereka sendiri.

---

## METODE 2: Kloning Fitur Secara Mandiri (Separate Instance)

Jika Anda ingin menduplikasi/mengkloning fitur chatbot ini agar berjalan secara mandiri dan terpisah pada website lain (memiliki database sendiri, panel admin sendiri, dan basis pengetahuan/knowledge base sendiri), ikuti langkah-langkah pemindahan komponen berikut:

### 1. Salin Folder Layanan Kecerdasan Buatan (Python Service)
- Salin seluruh folder `ai-service/` ke direktori root proyek website baru.
- Instal pustaka Python yang dibutuhkan pada server baru:
  ```bash
  pip install google-genai
  ```
- Konfigurasikan file `.env` di server baru dan tambahkan API Key Gemini Anda:
  ```env
  GEMINI_API_KEY="AIzaSy..."
  GEMINI_MODEL_NAME="gemini-2.5-flash"
  ```
- Sesuaikan dokumen referensi kesehatan di dalam folder `ai-service/knowledge/` agar sesuai dengan konten website baru tersebut.

### 2. Salin Komponen Backend Laravel (Database, Model, Controller)
- **Model**: Salin berkas `app/Models/ChatbotSetting.php`.
- **Migration**: Salin berkas migrasi `2026_07_14_105838_create_chatbot_settings_table.php` ke folder migrasi website baru, lalu jalankan `php artisan migrate`.
- **Seeder**: Salin `database/seeders/ChatbotSettingsSeeder.php` dan jalankan seeder untuk inisialisasi awal.
- **Controller**:
  - Salin `app/Http/Controllers/ChatbotController.php` (untuk chat publik).
  - Salin `app/Http/Controllers/Admin/ChatbotSettingController.php` (untuk panel admin).

### 3. Salin Halaman Antarmuka (Views)
- **Tampilan Publik**: Salin `resources/views/chat.blade.php`.
- **Tampilan Admin**: Salin folder `resources/views/admin/chatbot-setting/`.
- Daftarkan route-route yang sesuai di `routes/web.php` pada website baru seperti yang ada di website Puskesmas Marunggi saat ini.

*Kelebihan Kloning Fitur: Website baru akan memiliki lingkungan yang terisolasi penuh. Mereka dapat mengubah database, mengunggah knowledge base baru, dan mengganti warna tema tanpa memengaruhi website Puskesmas Marunggi.*
