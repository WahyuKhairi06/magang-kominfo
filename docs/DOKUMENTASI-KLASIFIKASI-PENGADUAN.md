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

### B. Sisi AI Service (Python & FastAPI)
* **API Entrypoint ([main.py](file:///c:/laragon/www/marunggi/sitariktageh/ai-service/main.py)):**
  Diintegrasikan dengan FastAPI app sehingga file ini bisa dijalankan sebagai HTTP Server port `8001` sekaligus CLI Chatbot biasa.
* **Endpoint Klasifikasi ([classify_complaint.py](file:///c:/laragon/www/marunggi/sitariktageh/ai-service/classify_complaint.py)):**
  Berisi logika POST `/api/v1/admin/classify-complaint` menggunakan official Google Gemini SDK (`google-genai`) dengan pengamanan API Key.
* **Prompt Engine ([prompt_classify.py](file:///c:/laragon/www/marunggi/sitariktageh/ai-service/prompt_classify.py)):**
  Membentuk prompt khusus Gemini untuk tugas klasifikasi teks.
* **Taksonomi & Schema ([taxonomy.py](file:///c:/laragon/www/marunggi/sitariktageh/ai-service/taxonomy.py)):**
  Sumber kebenaran tunggal (*Single Source of Truth*) daftar Kategori, Urgensi, dan skema validasi keluaran JSON Gemini.

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
# URL API Python FastAPI
AI_SERVICE_URL=http://127.0.0.1:8001
AI_SERVICE_INTERNAL_KEY=marunggi-ai-internal-key-12345

# Queue Connection (harus database)
QUEUE_CONNECTION=database
```

### B. `.env` di `ai-service/`
```env
INTERNAL_API_KEY=marunggi-ai-internal-key-12345
GEMINI_CLASSIFY_MODEL=gemini-2.5-flash
```

---

## 5. Cara Menjalankan untuk Pengembangan (Local Dev)

Agar fitur ini berjalan secara real-time, Anda perlu menjalankan **tiga komponen** berikut secara bersamaan:

1. **Server Web Laravel (PHP):**
   ```bash
   php artisan serve
   ```
2. **Server Background API Python (FastAPI):**
   Di folder `ai-service/`, jalankan:
   ```bash
   uvicorn main:app --port 8001 --reload
   ```
3. **Queue Worker Laravel (Background Listener):**
   ```bash
   php artisan queue:work
   ```
