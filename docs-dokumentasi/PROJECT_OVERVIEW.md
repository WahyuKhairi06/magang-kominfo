# Gambaran Umum Proyek — Modul AI Puskesmas

> Baca dokumen ini sebelum membaca dokumen lainnya.
> Referensi: [`README.md`](./README.md)

---

## 1. Konteks & Latar Belakang

Website Sistem Informasi Puskesmas Marunggi telah beroperasi sebelum program magang ini dimulai. Website tersebut menyediakan informasi layanan kesehatan, pengelolaan konten (berita, halaman, dokumen), serta sistem PKK dan Dasawisma.

Selama program magang, pengembang menambahkan **modul kecerdasan buatan (AI)** yang terdiri dari:

1. **AI Chatbot Healthcare Assistant** — Asisten virtual berbasis Google Gemini yang menjawab pertanyaan masyarakat menggunakan data resmi Puskesmas.
2. **Sistem Klasifikasi Pengaduan Otomatis** — Engine triage berbasis Gemini yang mengelompokkan pengaduan warga ke dalam kategori dan tingkat urgensi secara otomatis di latar belakang.
3. **AI Settings (Pengaturan AI)** — Panel kendali admin untuk mengkonfigurasi identitas chatbot dan parameter yang memungkinkan satu codebase digunakan oleh banyak Puskesmas.
4. **Knowledge Pipeline** — Sistem yang membangun basis pengetahuan chatbot secara dinamis dari database website.
5. **Pre-extraction OCR Pipeline** — Sistem yang mengekstrak teks dari gambar saat diunggah admin agar chatbot dapat menjawab pertanyaan tentang gambar tersebut tanpa biaya komputasi tambahan saat runtime.

---

## 2. Tumpukan Teknologi (Technology Stack)

| Lapisan | Teknologi | Versi | Peran |
|:--------|:----------|:------|:------|
| Backend Web | Laravel | 13 | Orkestrasi, API, database, queue |
| Runtime PHP | PHP | 8.3+ | Eksekusi Laravel |
| AI Service | Python | 3.11+ | Komunikasi dengan Gemini, retrieval |
| LLM Provider | Google Gemini API | `gemini-2.0-flash` | Model bahasa utama |
| Database | MySQL | — | Penyimpanan data website & knowledge source |
| Queue Driver | Laravel Queue (Database) | — | Async job klasifikasi pengaduan |
| Frontend | HTML5, Alpine.js, Tailwind CSS, Vite | — | Antarmuka pengguna |

**Dependensi Python (`ai-service/requirements.txt`):**
```
google-genai>=0.3.0
python-dotenv>=1.0.1
rich>=13.7.1
fastapi>=0.111.0
uvicorn>=0.30.1
pydantic>=2.7.0
```

---

## 3. Arsitektur Keseluruhan Modul AI

Modul AI dibangun menggunakan pola **orchestrator-executor** antara Laravel dan Python:

```
┌─────────────────────────────────────────────────────────────────────────┐
│                          BROWSER PENGUNJUNG                              │
└──────────────────────────────┬──────────────────────────────────────────┘
                               │ HTTP Request
                               ▼
┌─────────────────────────────────────────────────────────────────────────┐
│                         LARAVEL (PHP Backend)                            │
│                                                                          │
│  ┌────────────────────┐    ┌──────────────────┐    ┌──────────────────┐ │
│  │  ChatbotController  │    │ PengaduanController│   │ChatbotSetting    │ │
│  │                    │    │                  │    │Controller        │ │
│  │ 1. Query database  │    │ 1. Receive aduan │    │                  │ │
│  │ 2. Build JSON KB   │    │ 2. Dispatch Job  │    │ CRUD chatbot_    │ │
│  │ 3. Spawn Python    │    │ 3. Override AI   │    │ settings table   │ │
│  │ 4. Parse response  │    │                  │    │                  │ │
│  └──────────┬─────────┘    └────────┬─────────┘    └──────────────────┘ │
│             │                       │                                    │
│             │ Symfony Process       │ Queue Dispatch                     │
└─────────────┼───────────────────────┼────────────────────────────────────┘
              │                       │
              ▼                       ▼
┌─────────────────────┐   ┌──────────────────────────────────────────────┐
│ PYTHON AI SERVICE   │   │          LARAVEL QUEUE WORKER                 │
│                     │   │                                               │
│ chat_api.py         │   │   ClassifyPengaduanJob                        │
│  └─ main.py         │   │    ├── Baca isi_pengaduan dari DB             │
│      ├─ load KB     │   │    ├── Bangun prompt klasifikasi              │
│      ├─ build corpus│   │    ├── POST ke Gemini REST API                │
│      ├─ retrieve    │   │    ├─ Parse responseSchema JSON               │
│      └─ ask Gemini  │   │    └── Update kolom AI di pengaduans         │
│  prompt.py          │   │                                               │
└──────────┬──────────┘   └───────────────────────┬───────────────────────┘
           │                                       │
           │ SDK google-genai                      │ HTTP REST API
           ▼                                       ▼
┌──────────────────────────────────────────────────────────────────────────┐
│                        GOOGLE GEMINI API                                  │
│                   Model: gemini-2.5-flash                                 │
└──────────────────────────────────────────────────────────────────────────┘
```

---

## 4. Inventaris File AI

### 4.1 File Baru yang Dibuat

| File | Tanggal Dibuat | Keterangan |
|:-----|:--------------|:-----------|
| `app/Http/Controllers/ChatbotController.php` | Juli 2026 | Orkestrasi chatbot |
| `app/Http/Controllers/Admin/ChatbotSettingController.php` | Juli 2026 | Manajemen konfigurasi chatbot |
| `app/Http/Controllers/Admin/PuskesmasSettingController.php` | Juli 2026 | Konfigurasi identitas Puskesmas |
| `app/Jobs/ClassifyPengaduanJob.php` | Juli 2026 | Async job klasifikasi |
| `app/Models/ChatbotSetting.php` | Juli 2026 | Model ORM chatbot settings |
| `ai-service/chat_api.py` | Juli 2026 | Entry point CLI chatbot |
| `ai-service/prompt.py` | Juli 2026 | Prompt engineering chatbot |
| `ai-service/prompt_classify.py` | Juli 2026 | Prompt engineering klasifikasi |
| `ai-service/taxonomy.py` | Juli 2026 | Sumber kebenaran kategori pengaduan |
| `ai-service/extract_ocr.py` | Juli 2026 | Utilitas ekstraksi OCR |

### 4.2 File Existing yang Dimodifikasi

| File | Perubahan yang Ditambahkan |
|:-----|:--------------------------|
| `app/Http/Controllers/Admin/HalamanController.php` | Penambahan method `extractOcrFromHtml()`, integrasi OCR di `store()` dan `update()` |
| `app/Http/Controllers/LandingpageController.php` | Penambahan method `pengaduanStore()` yang men-dispatch `ClassifyPengaduanJob` |
| `app/Models/Pengaduan.php` | Penambahan kolom AI di `$fillable` |
| `ai-service/main.py` | Perubahan dari real-time OCR ke pre-extracted text |

### 4.3 Migration Baru yang Dibuat

| File Migration | Tabel | Keterangan |
|:--------------|:------|:-----------|
| `2026_07_14_105838_create_chatbot_settings_table.php` | `chatbot_settings` | Konfigurasi AI chatbot |
| `2026_07_15_142435_add_isi_ocr_to_halamen_table.php` | `halamen` | Kolom `isi_ocr` + backfill |
| `2026_07_16_000001_add_ai_classification_to_pengaduans_table.php` | `pengaduans` | Kolom-kolom AI klasifikasi |
| `2026_07_17_144351_create_puskesmas_settings_table.php` | `puskesmas_settings` | Identitas Puskesmas |

---

## 5. Alur Data Lintas Modul

```
[Admin Input Konten]           [Warga Kirim Pengaduan]      [Warga Buka Chatbot]
        │                               │                            │
        ▼                               ▼                            ▼
[HalamanController.store()]    [LandingpageController          [ChatbotController
 └─ extractOcrFromHtml()        .pengaduanStore()]              .send()]
     └─ extract_ocr.py         └─ INSERT pengaduans            ├─ generateDatabaseKnowledge()
         └─ Gemini Vision API  └─ ClassifyPengaduanJob          │   └─ Query 9 tabel → JSON
              │                    ::dispatch()                  │
              ▼                    │                             ▼
    [halamen.isi_ocr]              ▼                    [chat_api.py ← Symfony Process]
                           [Queue Worker]               └─ main.py
                           └─ ClassifyPengaduanJob           ├─ load JSON KB
                               ├─ build prompt               ├─ build corpus
                               ├─ Gemini REST API            ├─ retrieve context (Top-K)
                               └─ UPDATE pengaduans          └─ ask_gemini (prompt.py)
                                                                      │
                                                                      ▼
                                                              [Gemini API Response]
                                                              └─ JSON → ChatbotController
                                                                  └─ parse markdown → HTML
                                                                  └─ return ke browser
```

---

## 6. Diagram Entity Relationship (ERD) Modul AI

```mermaid
erDiagram
    chatbot_settings {
        bigint id PK
        string logo_chatbot "nullable"
        string ai_name "default: Asisten Puskesmas"
        string puskesmas_display_name "default: Puskesmas Marunggi"
        text greeting_message "nullable"
        string primary_color "default: #1e6b4d"
        enum status "active|inactive"
        timestamps
    }

    puskesmas_settings {
        bigint id PK
        string nama_puskesmas
        string kabupaten_kota
        text alamat
        string no_telp
        string email
        string logo "nullable"
        string jam_senin_kamis
        string jam_jumat
        string jam_sabtu
        string link_facebook "nullable"
        string link_instagram "nullable"
        timestamps
    }

    pengaduans {
        bigint id PK
        string nama
        string no_hp
        text isi_pengaduan
        string kategori_ai "nullable — saran awal AI"
        enum urgensi_ai "rendah|sedang|tinggi|null — audit trail"
        text alasan_ai "nullable — reasoning AI"
        string kategori_final "nullable — nilai aktif (dapat di-override)"
        enum urgensi_final "rendah|sedang|tinggi|null — nilai aktif"
        boolean is_overridden "default: false"
        enum status_klasifikasi "pending|selesai|gagal"
        bigint reviewed_by "nullable FK → users"
        timestamp reviewed_at "nullable"
        timestamps
    }

    halamen {
        bigint id PK
        string judul
        int kategori_halaman_id FK
        text isi
        longtext isi_ocr "nullable — ditambahkan oleh modul AI"
        timestamps
    }

    users {
        bigint id PK
        string name
        string email
    }

    pengaduans }|--o{ users : "reviewed_by"
```

---

## 7. Variabel Lingkungan yang Dibutuhkan

### `/.env` (Laravel Root)

| Variabel | Nilai | Keterangan |
|:---------|:------|:-----------|
| `GEMINI_API_KEY` | `<api_key>` | Kunci API Gemini untuk klasifikasi pengaduan di PHP |
| `QUEUE_CONNECTION` | `database` | Wajib agar async job berjalan |
| `PYTHON_EXECUTABLE` | `python` (default) | Nama/path executable Python |

### `/ai-service/.env`

| Variabel | Nilai | Keterangan |
|:---------|:------|:-----------|
| `GEMINI_API_KEY` | `<api_key_sama>` | Kunci API Gemini untuk chatbot & OCR di Python |
| `GEMINI_MODEL` | `gemini-2.5-flash` | Nama model Gemini untuk chatbot & OCR |

> **Catatan:** Kedua file `.env` menggunakan API Key yang **sama**. Pemisahan dilakukan karena Laravel dan Python adalah dua runtime yang berbeda dan masing-masing membaca konfigurasi dari lingkungannya sendiri secara independen.
