# Riwayat Perubahan (Changelog)

Semua perubahan signifikan pada modul AI didokumentasikan di sini secara kronologis.
Format mengikuti [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## [1.0.1] — 28 Juli 2026

### Perbaikan Infrastruktur & Runtime AI Service

- **[Added]** Kelas layanan `App\Services\AiProcessService` untuk memusatkan logika pencarian executable Python dan instansiasi `Symfony\Component\Process\Process` di seluruh aplikasi secara *clean* dan DRY.
- **[Fixed]** Bug `WinError 10106` saat Symfony `Process` mengeksekusi Python di Windows — diperbaiki dengan otomatis mempassing variabel environment sistem (`SystemRoot`, `WINDIR`, `PATH`) melalui `AiProcessService`.
- **[Fixed]** Bug parsing `.env` yang membaca karakter petik ganda (`"`) secara literal pada `PYTHON_EXECUTABLE` dan spasi di awal `GEMINI_API_KEY`.
- **[Fixed]** Penanganan exception pada `ai-service/main.py` yang sebelumnya menangkap `ImportError` saja — diperluas ke `except Exception:` agar kesalahan socket di lingkungan non-interaktif tidak memicu error *"Library google-genai belum terinstall"*.
- **[Added]** Dokumen troubleshooting baru: [`TROUBLESHOOTING_AI_SERVICE.md`](./TROUBLESHOOTING_AI_SERVICE.md).

---

## [1.0.0] — Juli 2026

Rilis pertama modul AI sebagai hasil pengembangan selama magang.

### Modul Chatbot AI (Fase 1–4)

**Fase 1 — Migrasi Basis Pengetahuan Dinamis & Kustomisasi Identitas AI**

- **[Added]** Tabel `chatbot_settings` untuk konfigurasi dinamis nama AI, nama Puskesmas, pesan sambutan, warna tema, logo, dan status chatbot.
- **[Added]** `ChatbotSettingController.php` dengan antarmuka admin lengkap.
- **[Added]** Live Preview Simulator di halaman admin — perubahan warna dan teks terefleksi secara real-time sebelum disimpan.
- **[Added]** Algoritma kontras warna otomatis YIQ untuk menjamin keterbacaan teks di atas warna primer chatbot.
- **[Added]** Integrasi parameter dinamis (`ai_name`, `puskesmas_display_name`) ke dalam `ChatbotController.php` dan `prompt.py`.
- **[Changed]** Chatbot sebelumnya membaca dari file JSON statis `puskesmas.json`; kini data diambil langsung dari database MySQL secara real-time.

**Fase 2 — Optimasi Performa Frontend**

- **[Changed]** Mengganti Tailwind Play CDN dengan kompilasi aset statis via Vite (`npm run build`). Waktu render halaman utama turun dari ~22 detik menjadi < 500ms.
- **[Fixed]** Bug fatal error pada penghapusan halaman informasi di admin (`HalamanController::delete()`) — diperbaiki menggunakan DB query builder.
- **[Fixed]** Bug upload gambar sambutan di Windows/Laragon — diperbaiki dengan mengalihkan root disk ke `public_path('storage')`.

**Fase 3 — Rich UI: Tautan Navigasi & Rangkuman Berita**

- **[Added]** Parsing markdown ke HTML di `ChatbotController::send()`: bold (`**text**` → `<strong>`), italic (`*text*` → `<em>`), link (`[teks](url)` → `<a href>`).
- **[Added]** Aturan 10 & 11 pada system instruction `prompt.py`: AI wajib menyertakan tautan navigasi dan memberikan rangkuman artikel berita.
- **[Added]** Blok `WAKTU SEKARANG (WIB)` pada prompt — AI mengetahui tanggal saat ini dan dapat menjawab pertanyaan terkait waktu secara akurat.

**Fase 4 — Pre-extraction OCR (Optimasi Biaya & Latensi)**

- **[Added]** Kolom `isi_ocr` (longtext, nullable) ke tabel `halamen` via migration `2026_07_15_...`.
- **[Added]** Migration mencakup backfill otomatis untuk semua rekord halaman yang sudah ada.
- **[Added]** Script Python `ai-service/extract_ocr.py` untuk ekstraksi teks terstruktur dari gambar menggunakan Gemini Vision API.
- **[Added]** Method `extractOcrFromHtml()` di `HalamanController.php` yang dipanggil secara otomatis saat admin menyimpan/memperbarui halaman.
- **[Changed]** `ChatbotController::generateDatabaseKnowledge()` kini menyertakan `isi_ocr` dalam knowledge JSON dan menerapkan `strip_tags()` pada kolom `isi`.
- **[Changed]** `main.py` — real-time multimodal OCR (mengirim gambar biner ke Gemini saat chat) dihapus dan digantikan oleh pembacaan `isi_ocr` dari JSON.

---

### Modul Klasifikasi Pengaduan AI

- **[Added]** Penambahan 9 kolom AI ke tabel `pengaduans` via migration `2026_07_16_...`:
  `kategori_ai`, `urgensi_ai`, `alasan_ai`, `kategori_final`, `urgensi_final`, `is_overridden`, `status_klasifikasi`, `reviewed_by`, `reviewed_at`.
- **[Added]** File `ai-service/taxonomy.py` sebagai Single Source of Truth (SSoT) untuk taksonomi 7 kategori dan 3 level urgensi pengaduan.
- **[Added]** File `ai-service/prompt_classify.py` untuk prompt engineering klasifikasi (terpisah dari chatbot publik).
- **[Added]** `ClassifyPengaduanJob.php` — Laravel Queue Job untuk klasifikasi asinkron menggunakan Gemini REST API dengan structured JSON output.
- **[Added]** Mekanisme fallback classifier lokal berbasis keyword PHP murni dalam `ClassifyPengaduanJob`.
- **[Added]** Endpoint `PATCH /admin/pengaduan/{id}/klasifikasi` untuk admin melakukan override kategori/urgensi via AJAX.
- **[Added]** Mekanisme `dispatchSync` di `PengaduanController::edit()` — klasifikasi sinkron dijalankan otomatis saat admin membuka detail pengaduan yang masih `pending`.
- **[Added]** Fitur Paginasi Dinamis pada halaman admin pengaduan (`10`, `25`, `50`, `100` data per halaman) via query string `per_page`.
- **[Added]** Fitur Cetak Rekapitulasi PDF Pengaduan (`admin.pengaduan.cetak-pdf`) yang dilengkapi dengan filter rentang tanggal (Mulai s/d Sampai) menggunakan DomPDF (`pdf.blade.php`).
- **[Changed]** `ClassifyPengaduanJob.php` kini mengeksekusi script Python CLI (`ai-service/classify_cli.py`) via `Symfony\Component\Process\Process` guna menyelaraskan arsitektur autentikasi Google GenAI dengan Chatbot (mem-bypass masalah kredensial GCP OAuth di PHP).
- **[Changed]** Model Gemini diperbarui ke versi stabil `gemini-2.0-flash`.
- **[Changed]** `LandingpageController::pengaduanStore()` diperbarui untuk dispatch `ClassifyPengaduanJob` setelah menyimpan pengaduan.
- **[Changed]** `Pengaduan::$fillable` diperbarui untuk menyertakan semua kolom AI baru.

---

### Modul AI Settings

- **[Added]** Tabel `puskesmas_settings` untuk konfigurasi identitas Puskesmas (nama, alamat, jam layanan, media sosial) via migration `2026_07_17_...`.
- **[Added]** `PuskesmasSettingController.php` dengan halaman pengaturan admin.
- **[Added]** Inisialisasi record default menggunakan `firstOrCreate` — tidak membutuhkan seeder manual.

---

## Keterangan Format

| Tanda | Arti |
|:------|:-----|
| **[Added]** | Fitur baru yang ditambahkan |
| **[Changed]** | Perubahan pada fitur yang sudah ada |
| **[Fixed]** | Perbaikan bug |
| **[Removed]** | Fitur yang dihapus |
| **[Security]** | Perbaikan terkait keamanan |
