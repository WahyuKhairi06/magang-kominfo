# Dokumentasi Sistem: Klasifikasi Otomatis Pengaduan (AI-Assisted Complaint Triage)

Dokumen ini menjelaskan detail fitur, daftar berkas, konfigurasi, dan cara kerja dari modul **Klasifikasi Otomatis Pengaduan** yang diintegrasikan ke dalam Sistem Informasi Puskesmas Marunggi.

---

## 1. Deskripsi Fitur
Setiap pengaduan/keluhan warga yang dikirimkan melalui form publik (`/pengaduan`) akan diproses secara asinkron di latar belakang menggunakan kecerdasan buatan (Gemini API) untuk:
1. **Klasifikasi Kategori:** Mengelompokkan aduan secara instan ke dalam salah satu dari 7 kategori.
2. **Analisis Urgensi:** Menilai prioritas penanganan (Rendah, Sedang, Tinggi) berdasarkan rubrik keselamatan.
3. **Analisis Alasan:** Menyertakan 1 kalimat argumentasi logis mengapa kategori & urgensi tersebut dipilih.
4. **Override Admin:** Admin di panel kendali `/admin/pengaduan` memiliki kendali penuh untuk meninjau hasil klasifikasi AI dan mengubahnya jika dirasa kurang pas.
5. **Sistem Klasifikasi Cadangan (Rule-based Fallback):** Jika API Gemini habis kuota (Error 429) atau server AI mengalami downtime, sistem secara otomatis beralih menggunakan pencocokan kata kunci lokal (*local keyword matching*) di sisi Python FastAPI maupun Laravel Queue Job. Hasil triage lokal akan langsung disimpan dengan status `selesai` dan diberikan penanda khusus di halaman admin.

---

## 2. Berkas & Komponen yang Ditambahkan/Dimodifikasi

### A. Sisi Laravel (PHP & Blade)
* **Model Baru:** [Pengaduan.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Models/Pengaduan.php)
  Eloquent model untuk mempermudah operasi database pada tabel `pengaduans`.
* **Queue Job Baru:** [ClassifyPengaduanJob.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Jobs/ClassifyPengaduanJob.php)
  Job yang dikirim ke antrean database (`jobs`) untuk mengirimkan request HTTP POST klasifikasi ke AI Service.
* **Migrasi Database:** [2026_07_16_000001_add_ai_classification_to_pengaduans_table.php](file:///c:/laragon/www/marunggi/sitariktageh/database/migrations/2026_07_16_000001_add_ai_classification_to_pengaduans_table.php)
  Menambahkan kolom `kategori_ai`, `urgensi_ai`, `alasan_ai`, `kategori_final`, `urgensi_final`, `is_overridden`, `status_klasifikasi` setelah kolom `isi_pengaduan`.
* **Rute Baru ([web.php](file:///c:/laragon/www/marunggi/sitariktageh/routes/web.php)):**
  - `GET /admin/pengaduan/{id}/edit` -> Menampilkan halaman detail & triage aduan.
  - `PATCH /admin/pengaduan/{id}/klasifikasi` -> Mengubah data kategori/urgensi final secara asinkron.
* **Controller Dimodifikasi:**
  - [LandingpageController.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Http/Controllers/LandingpageController.php): Memotong 50 karakter keluhan sebagai subjek, lalu men-dispatch job asinkron sesaat setelah data pengaduan masuk.
  - [PengaduanController.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Http/Controllers/Admin/PengaduanController.php): Ditambahkan method `edit` dan `updateKlasifikasi`.
* **Antarmuka / Views Baru & Dimodifikasi:**
  - [index.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/admin/pengaduan/index.blade.php): Menambahkan kolom klasifikasi & tombol Detail.
  - [edit.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/admin/pengaduan/edit.blade.php): Halaman detail keluhan terintegrasi panel triage.
  - [_badge_klasifikasi.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/admin/pengaduan/_badge_klasifikasi.blade.php): Desain badge status di list.
  - [_klasifikasi_chip.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/admin/pengaduan/_klasifikasi_chip.blade.php): Desain chip interaktif AJAX (AlpineJS).

### B. Sisi AI Service (Python)
* **Chatbot Engine ([chat_api.py](file:///c:/laragon/www/marunggi/sitariktageh/ai-service/chat_api.py)):**
  Menggunakan SDK resmi Google Gemini untuk memproses obrolan interaktif asisten Puskesmas. Script ini dipanggil langsung oleh Laravel `ChatbotController` menggunakan `Process` Symfony (CLI Execution), sehingga tidak memerlukan server web FastAPI (`uvicorn`) yang aktif terus-menerus.
* **Knowledge Base ([database_knowledge.json](file:///c:/laragon/www/marunggi/sitariktageh/ai-service/knowledge/database_knowledge.json)):**
  Daftar informasi Puskesmas dinamis yang digenerate otomatis oleh Laravel dari database MySQL sebagai database pengetahuan asisten.

---

## 3. Taksonomi Sumber Kebenaran

### Daftar Kategori Resmi:
1. `Pendaftaran & Administrasi`
2. `Pelayanan Petugas/Medis`
3. `Waktu Tunggu & Antrean`
4. `Kebersihan & Fasilitas`
5. `Ketersediaan Obat`
6. `Sarana & Prasarana`
7. `Lainnya`

### Rubrik Urgensi:
* **tinggi:** Berpotensi membahayakan keselamatan/kesehatan, butuh tindakan < 24 jam.
* **sedang:** Mengganggu kualitas layanan, perlu tindak lanjut dalam beberapa hari.
* **rendah:** Masukan atau kritik ringan, tidak mendesak.

---

## 4. Konfigurasi Lingkungan (.env)

### A. `.env` di Laravel Root
```env
# API Key Resmi Google Gemini (Digunakan langsung oleh Laravel untuk klasifikasi)
GEMINI_API_KEY=<API_KEY_GEMINI_ANDA>

# Queue Connection (harus database)
QUEUE_CONNECTION=database
```

### B. `.env` di `ai-service/`
```env
# API Key Resmi Google Gemini (Digunakan oleh script chatbot Python)
GEMINI_API_KEY=<API_KEY_GEMINI_ANDA>
GEMINI_MODEL=gemini-2.5-flash
```

---

## 5. Cara Menjalankan untuk Pengembangan (Local Dev)

Karena klasifikasi otomatis pengaduan sekarang berjalan secara langsung via REST API dari Laravel, Anda **tidak perlu lagi menjalankan server FastAPI uvicorn**. Anda hanya perlu menjalankan **dua komponen** berikut:

1. **Server Web Laravel (PHP):**
   ```bash
   php artisan serve
   ```
2. **Queue Worker Laravel (Background Listener):**
   ```bash
   php artisan queue:work
   ```
