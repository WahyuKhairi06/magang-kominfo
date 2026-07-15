# Product Requirements Document (PRD) - Peningkatan Sistem & AI Chatbot Terpadu

**Nama Proyek**: AI Healthcare Assistant & Optimasi Infrastruktur Web  
**Tanggal**: 15 Juli 2026  
**Status**: Implementasi Selesai  
**Penulis**: Antigravity (AI Coding Assistant) & Tim Developer  

---

## 1. Pendahuluan & Latar Belakang
Sistem informasi web Puskesmas saat ini dikembangkan untuk memudahkan masyarakat dalam mengakses layanan kesehatan, berita kegiatan, dokumen publik, serta konsultasi mandiri berbasis AI. 

Sebelumnya, terdapat beberapa kendala performa dan keterbatasan fitur:
1. **Kecepatan loading rendah** karena penggunaan Tailwind Play CDN dinamis yang memblokir rendering halaman utama (rata-rata 22 detik).
2. **Chatbot bersifat statis** karena hanya membaca data *hardcoded* dari file JSON lokal (`puskesmas.json`), sehingga tidak sinkron dengan data baru dari admin panel.
3. **Gambar jadwal tidak terbaca** oleh AI serta ketiadaan tautan navigasi langsung ke halaman terkait di dalam balasan chat.
4. **Kesalahan sistem internal** seperti kegagalan unggah foto pejabat pada modul sambutan di Windows, serta fatal error pada proses penghapusan data halaman.

Dokumen PRD ini merinci spesifikasi kebutuhan produk, arsitektur teknis, dan fitur yang telah berhasil diimplementasikan untuk menyelesaikan masalah di atas.

---

## 2. Tujuan Produk
* **Performa Maksimal**: Mengurangi waktu render halaman utama hingga di bawah 1 detik.
* **Integrasi Data Real-Time**: Mengubah basis pengetahuan chatbot dari statis menjadi dinamis yang terhubung langsung ke database MySQL (dengan mengecualikan data sensitif).
* **AI Multimodal**: Mengaktifkan kemampuan membaca tulisan di dalam gambar (OCR) oleh chatbot agar dapat menjawab pertanyaan seputar gambar jadwal pelayanan yang diunggah.
* **Pengalaman Pengguna (UX) Chatbot Terpadu**: Memberikan rekomendasi tautan aksi berupa tombol/link langsung ke modul layanan terkait.
* **Stabilitas Sistem**: Memperbaiki bug fungsionalitas di area admin (unggah foto & hapus data).

---

## 3. Spesifikasi Kebutuhan Fungsional (Functional Requirements)

### F01: Optimasi Kecepatan Rendering Halaman
* **Kebutuhan**: Mengurangi beban browser dari mengompilasi CSS secara langsung (runtime).
* **Solusi**: Mengganti Tailwind Play CDN dengan kompilasi aset statis melalui Vite (`npm run build`).
* **Preservasi Fitur**: Konfigurasi `@theme` Tailwind v4 dipetakan ke variabel root CSS (`var(--primary)`, dll.) agar fitur penggantian warna dinamis (Theme Switcher) di panel admin tetap berfungsi.

### F02: Migrasi Chatbot ke Database
* **Kebutuhan**: AI Chatbot harus menjawab berdasarkan data terbaru dari database.
* **Solusi**: Laravel mengekstrak data publik dari tabel `sambutans`, `halamen`, `agendas`, `beritas`, `infografis`, `galeris`, `dokumen`, `faqs`, dan `inovasi1`, mengekspornya menjadi berkas `database_knowledge.json` pada setiap permintaan pesan, lalu diumpankan ke AI Service.
* **Keamanan Data**: Mengecualikan tabel sensitif seperti `users`, `sessions`, dan data pribadi.

### F03: Kemampuan Membaca Gambar (Pre-extraction OCR)
* **Kebutuhan**: AI harus mampu menjawab pertanyaan seputar isi gambar (misalnya gambar jadwal pelayanan) secara cepat dan hemat token.
* **Solusi**: Gambar dipindai dan diekstrak isinya (OCR) menggunakan Gemini Vision sekali saja saat diunggah/diperbarui oleh admin, lalu disimpan di kolom database `isi_ocr`. AI membaca teks hasil ekstraksi yang terstruktur di JSON basis pengetahuan tanpa perlu mengirim ulang berkas gambar biner saat runtime chat.

### F04: Tautan Tombol & Rangkuman Berita
* **Kebutuhan**: Chatbot harus menyajikan link aksi dan rangkuman berita terstruktur.
* **Solusi**: 
  - Menyediakan tautan terenkripsi dari controller ke JSON.
  - Memformat tautan markdown `[Teks](url)` dari AI menjadi tag anchor `<a>` berkelas Tailwind (seperti tombol/link hijau) di sisi frontend.
  - Menyusun rangkuman/garis besar (outline) berita secara otomatis.

### F05: Perbaikan Modul Admin & File Upload
* **Kebutuhan**: Memperbaiki sistem unggah gambar sambutan dan pratinjau gambar, serta fungsionalitas hapus data.
* **Solusi**:
  - Mengalihkan penyimpanan disk `public` langsung ke direktori fisik `public/storage` guna menghindari masalah *symbolic link* di Windows/Laragon.
  - Menambahkan javascript `previewFoto(event)` untuk pratinjau gambar dinamis saat form tambah/edit diakses.
  - Memperbaiki kueri penanganan hapus halaman menggunakan DB query builder `delete()`.

---

## 4. Spesifikasi Non-Fungsional (Non-Functional Requirements)
* **Waktu Respon (Performance)**: Pemuatan halaman utama harus berada di kisaran **< 500 milidetik** di lokal.
* **Ketersediaan Layanan (Availability)**: Chatbot harus terus siaga 24/7 dengan fallback aman (pesan ramah jika kuota Gemini API habis).
* **Kompatibilitas Sistem**: Aplikasi harus berjalan lancar di server Windows (Laragon) maupun Linux (Production) tanpa perlu membuat ulang *symbolic link* secara manual.

---

## 5. Arsitektur Teknis Sistem

1. **Alur Penyimpanan Konten & Ekstraksi Gambar (Offline/Admin):**
```
[Admin Update Halaman]
       │
       ▼
[Deteksi Tag <img> di HTML]
       │
       ▼
[Execute Python extract_ocr.py] ─── (Gemini Vision API) ───► [Extract structured OCR text]
       │
       ▼
[Simpan ke halamen.isi_ocr]
```

2. **Alur Tanya Jawab Chatbot (Runtime):**
```
[User Input] 
     │
     ▼
[Laravel Controller] ─── (Query DB & strip_tags) ───► [database_knowledge.json (termasuk isi_ocr)]
     │                                                                  │
     ▼                                                                  ▼
[Execute Python Process] ◄──────────────────────────────────────────────┘
     │
     ▼
[Gemini API / gemini-2.5-flash (Text Only)]
     │
     ▼
[Markdown Response] ─── (Parsed to Link HTML) ───► [Display in Chat UI]
```

---

## 6. Daftar Tabel Database yang Digunakan
| Nama Tabel | Deskripsi Penggunaan oleh Chatbot |
| :--- | :--- |
| `chatbot_settings` | Konfigurasi Nama AI, Nama Display Puskesmas, dan Pesan Sambutan |
| `sambutans` | Profil dan kata sambutan kepala instansi |
| `halamen` | Visi & Misi, Sejarah, Program Pokok, Struktur Organisasi, Jadwal Pelayanan |
| `agendas` | Agenda kegiatan mendatang (`upcoming`) |
| `beritas` | Artikel dan kabar berita puskesmas |
| `infografis` & `galeris` | Dokumentasi program dan gambar infografis |
| `dokumen` | Dokumen panduan atau SOP publik yang aktif |
| `faqs` | Pertanyaan yang sering diajukan masyarakat |
| `inovasi1` | Detail terobosan/inovasi program yang dipublikasikan |

---

## 7. Metrik Keberhasilan
1. **Page Load Time**: Penurunan latensi dari 22 detik menjadi di bawah 450 milidetik.
2. **Chatbot Accuracy**: AI mampu menyebutkan agenda mendatang dan menyajikan tombol navigasi ke halaman jadwal/berita secara presisi.
3. **Stabilitas Admin**: Form sambutan dapat mengunggah gambar baru, menampilkan pratinjau langsung, dan menghapus halaman informasi tanpa menyebabkan fatal error.

---

## 8. Tahapan Implementasi & Kronologi Perubahan

Penyempurnaan sistem ini dilakukan secara bertahap dalam tiga fase utama untuk memastikan stabilitas dan keamanan pada setiap perubahan:

### Fase 1: Migrasi Basis Pengetahuan Dinamis & Kustomisasi Identitas AI
* **Deskripsi**: Mengalihkan basis pengetahuan chatbot dari file JSON statis `puskesmas.json` ke database dinamis untuk mengintegrasikan data puskesmas secara real-time.
* **Perubahan Kode**:
  * Menambahkan tabel `chatbot_settings` melalui berkas migrasi dan seeder baru.
  * Membuat Admin Controller ([ChatbotSettingController.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Http/Controllers/Admin/ChatbotSettingController.php)) dan halaman pengaturannya ([index.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/admin/chatbot-setting/index.blade.php)) lengkap dengan fitur Live Preview Simulator dan perhitungan tingkat kecerahan warna YIQ untuk kontras teks otomatis.
  * Mengintegrasikan dynamic parameter (`ai_name`, `puskesmas_display_name`, `greeting_message`) ke dalam [ChatbotController.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Http/Controllers/ChatbotController.php) dan Python system prompt ([prompt.py](file:///c:/laragon/www/marunggi/sitariktageh/ai-service/prompt.py)).

### Fase 2: Pembenahan Infrastruktur, Optimasi Performa & Bug Fixing
* **Deskripsi**: Mengoptimalkan waktu render frontend dan memperbaiki kendala teknis pada sistem unggah file dan manajemen halaman admin.
* **Perubahan Kode**:
  * Mengganti load Tailwind Play CDN dengan kompilasi aset statis Vite (`npm run build`) pada file layout ([navbar.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/navbar.blade.php), [layout.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/template/layout.blade.php), dan [guest.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/layouts/guest.blade.php)).
  * Mengkonfigurasi file [vite.config.js](file:///c:/laragon/www/marunggi/sitariktageh/vite.config.js) untuk mengabaikan folder `ai-service/` (`ignored: ['**/ai-service/**']`) agar proses penulisan file database dinamis tidak memicu auto-reload halaman web yang sedang aktif.
  * Mengalihkan root disk penyimpanan `public` di Laravel [filesystems.php](file:///c:/laragon/www/marunggi/sitariktageh/config/filesystems.php) langsung ke `public_path('storage')` demi menghindari kendala path symbolic link di OS Windows/Laragon.
  * Menambahkan pratinjau gambar instan (`previewFoto`) menggunakan Javascript FileReader pada form sambutan admin ([create.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/admin/sambutan/create.blade.php) & [edit.blade.php](file:///c:/laragon/www/marunggi/sitariktageh/resources/views/admin/sambutan/edit.blade.php)).
  * Memperbaiki bug fatal error penghapusan data halaman informasi pada [HalamanController.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Http/Controllers/Admin/HalamanController.php) menggunakan database query builder `delete()`.

### Fase 3: AI Tingkat Lanjut (Multimodal OCR, Rich UI Link, & Rangkuman Berita)
* **Deskripsi**: Memperluas kegunaan chatbot agar mampu membaca media visual secara langsung (OCR), menyajikan navigasi aksi interaktif, serta memberikan respon adaptif terhadap waktu.
* **Perubahan Kode**:
  * Menambahkan generator basis pengetahuan dinamis di [ChatbotController.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Http/Controllers/ChatbotController.php) yang mengekspor data publik ke `database_knowledge.json`.
  * Memperbarui [main.py](file:///c:/laragon/www/marunggi/sitariktageh/ai-service/main.py) di Python Service untuk memindai referensi gambar di folder `/uploads/`, membaca file fisik di `public/uploads/` secara biner, dan meneruskannya sebagai `types.Part.from_bytes` ke Gemini API (Multimodal OCR).
  * Menyuntikkan string tanggal dinamis (format Indonesia) di [prompt.py](file:///c:/laragon/www/marunggi/sitariktageh/ai-service/prompt.py) sebagai blok `WAKTU SEKARANG (WIB)` sebelum dikirim ke Gemini.
  * Menambahkan parse regex markdown link `[Teks](url)` di [ChatbotController.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Http/Controllers/ChatbotController.php) untuk dikonversi menjadi tag HTML `<a>` dengan styling visual tombol hijau.
  * Memperbarui instruksi sistem AI di [prompt.py](file:///c:/laragon/www/marunggi/sitariktageh/ai-service/prompt.py) (Poin 10 & 11) untuk menangani keluaran tautan tombol aksi serta menyusun rangkuman/garis besar artikel berita secara terstruktur.

### Fase 4: Optimasi Biaya & Latensi (Pre-extraction OCR)
* **Deskripsi**: Mengalihkan proses OCR multimodal dari real-time (setiap chat berlangsung) ke offline (satu kali saat gambar diunggah/diperbarui oleh admin) untuk mempercepat respon chatbot dan menghemat kuota token.
* **Perubahan Kode**:
  * Menambahkan kolom `isi_ocr` ke tabel `halamen` lewat berkas migrasi kustom ([2026_07_15_142435_add_isi_ocr_to_halamen_table.php](file:///c:/laragon/www/marunggi/sitariktageh/database/migrations/2026_07_15_142435_add_isi_ocr_to_halamen_table.php)) yang juga secara otomatis melakukan backfill/OCR pada halaman yang sudah ada.
  * Membuat utilitas python ([extract_ocr.py](file:///c:/laragon/www/marunggi/sitariktageh/ai-service/extract_ocr.py)) untuk memicu ekstraksi gambar terstruktur via Gemini.
  * Mengintegrasikan fungsi pembantu `extractOcrFromHtml` ke dalam [HalamanController.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Http/Controllers/Admin/HalamanController.php) pada method `store` dan `update`.
  * Memperbarui [ChatbotController.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Http/Controllers/ChatbotController.php) agar menyertakan kolom `isi_ocr` dan membersihkan tag HTML pada field `isi` saat diekspor.
  * Mengubah [main.py](file:///c:/laragon/www/marunggi/sitariktageh/ai-service/main.py) di Python Service untuk mematikan pembacaan berkas gambar lokal dan pengiriman data biner multimodal saat chat berlangsung.
