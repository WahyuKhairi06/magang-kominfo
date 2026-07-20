# 🏥 Sistem Informasi Website Puskesmas (Multi-Puskesmas & AI Triage/Chatbot)

Sistem Informasi Website Puskesmas merupakan portal informasi layanan kesehatan terpadu yang dilengkapi dengan asisten virtual kecerdasan buatan (AI) serta sistem manajemen internal PKK & Dasawisma.

Website ini dirancang menggunakan konsep **Single Codebase**, sehingga satu basis kode yang sama dapat diduplikasi dan digunakan oleh puskesmas mana pun hanya dengan menyesuaikan konfigurasi identitas melalui Admin Panel — **tanpa menyentuh kode program sama sekali**.

---

## 📖 Fitur Utama

### 1. ⚙️ Pengaturan Dinamis Identitas (Single Codebase)
*   Mendukung penggunaan multi-puskesmas pada hosting terpisah dengan kode program yang sama.
*   Admin dapat mengonfigurasi nama puskesmas, kabupaten/kota, logo, alamat, nomor telepon, email, jam operasional, dan link media sosial langsung dari panel kendali admin (`/admin/puskesmas-setting`).
*   Semua data identitas di navbar, footer, halaman utama, dan admin panel akan ter-update secara otomatis secara global.

### 2. 🤖 AI Chatbot Healthcare Assistant (Asisten Virtual 24/7)
*   Widget chat interaktif di landing page untuk menjawab pertanyaan masyarakat seputar jadwal, layanan, poli, persyaratan BPJS, dan FAQ resmi puskesmas.
*   Terintegrasi langsung dengan API Google Gemini melalui script Python (`ai-service/chat_api.py`) yang dijalankan secara *on-demand* (tanpa beban server FastAPI).
*   **Dynamic Knowledge Base:** Informasi disinkronkan secara otomatis dari database MySQL menjadi format JSON saat ada obrolan masuk agar data selalu mutakhir.
*   **Guardrails Medis:** Diprogram secara ketat untuk menolak melakukan diagnosis penyakit, resep obat, atau memberikan nasihat medis mandiri demi keselamatan pasien.

### 3. 📢 Triage & Klasifikasi Pengaduan Otomatis AI
*   Warga dapat mengirimkan pengaduan/keluhan secara online di form publik.
*   Pengaduan diklasifikasikan secara asinkron di latar belakang (*Laravel Queue Worker*) ke dalam 7 kategori resmi dan 3 tingkat urgensi penanganan (Rendah, Sedang, Tinggi) menggunakan Gemini API.
*   **Override & Triage Admin:** Admin dapat meninjau, menyetujui, atau mengubah hasil klasifikasi AI melalui panel triage admin.
*   **Fallback Classifier:** Dilengkapi pendeteksi error kuota/jaringan API. Jika terjadi error, sistem secara otomatis beralih ke mesin pencocok kata kunci lokal (*local keyword matching*).

### 4. 🗂️ Sistem PKK & Dasawisma
*   Sistem pendataan kependudukan komunitas, catatan data keluarga, catatan ibu hamil, kegiatan pokja (Kelompok Kerja 1-3), dan monitoring program inovasi desa.

---

## 🚀 Teknologi Utama

*   **Backend Framework:** Laravel 13
*   **Runtime PHP:** PHP 8.3+
*   **Runtime Python (AI):** Python 3.11+ (google-genai, python-dotenv, rich)
*   **Frontend Engine:** HTML5, Alpine.js, Tailwind CSS, Vite
*   **Database:** MySQL
*   **LLM API:** Google Gemini API (`gemini-2.5-flash`)

---

## 📁 Struktur Utama Proyek

```
sitariktageh/
│
├── ai-service/                   # Modul AI berbasis Python
│   ├── knowledge/
│   │   └── database_knowledge.json  # Sinkronisasi basis data dinamis Laravel (auto-generated)
│   ├── chat_api.py               # Entry point CLI chatbot asisten
│   ├── main.py                   # Core AI: retrieval, corpus builder, Gemini client
│   ├── prompt.py                 # Prompt engineering chatbot publik
│   ├── prompt_classify.py        # Prompt engineering klasifikasi pengaduan
│   ├── taxonomy.py               # Sumber kebenaran tunggal kategori & urgensi
│   ├── extract_ocr.py            # Utilitas OCR gambar via Gemini Vision
│   ├── requirements.txt          # Dependensi library Python
│   └── .env                      # Konfigurasi API Key untuk Python service
│
├── app/
│   ├── Http/Controllers/
│   │   ├── ChatbotController.php          # Controller chatbot asisten
│   │   └── Admin/
│   │       ├── PuskesmasSettingController.php  # Pengaturan identitas dinamis
│   │       ├── ChatbotSettingController.php    # Pengaturan widget chatbot
│   │       └── PengaduanController.php         # Triage aduan admin
│   ├── Jobs/
│   │   └── ClassifyPengaduanJob.php       # Job asinkron klasifikasi Gemini
│   └── Models/
│       ├── PuskesmasSetting.php
│       ├── ChatbotSetting.php
│       └── Pengaduan.php
│
├── docs-dokumentasi/             # Dokumentasi modul AI (lengkap)
│   ├── README.md
│   ├── PROJECT_OVERVIEW.md
│   ├── AI_CHATBOT_PRD.md
│   ├── AI_COMPLAINT_CLASSIFICATION_PRD.md
│   ├── AI_SETTINGS_PRD.md
│   ├── KNOWLEDGE_PIPELINE.md
│   ├── OCR_PIPELINE.md
│   ├── AI_GUARDRAILS.md
│   ├── DESIGN_DECISIONS.md
│   ├── TESTING.md
│   ├── CHANGELOG.md
│   └── ROADMAP.md
│
├── docs/                         # Berkas dokumentasi tambahan
│
└── .env                          # Konfigurasi kunci API dan database
```

---

## ⚙️ Petunjuk Instalasi (Setup Awal)

### Prasyarat

Pastikan perangkat sudah terinstal:
- **PHP 8.3+** & **Composer**
- **Node.js 18+** & **npm**
- **MySQL 8.0+**
- **Python 3.11+**
- **Git**

---

### Langkah 1 — Clone Repository

```bash
git clone https://github.com/WahyuKhairi06/magang-kominfo.git
cd magang-kominfo
```

---

### Langkah 2 — Instalasi Dependensi Laravel

```bash
composer install
npm install
```

---

### Langkah 3 — Setup File Environment

```bash
cp .env.example .env
php artisan key:generate
```

Kemudian buka file `.env` dan sesuaikan konfigurasi database:

```env
APP_NAME="Puskesmas Nama Anda"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database
```

---

### Langkah 4 — Konfigurasi API Key Gemini

Dapatkan API Key gratis di [Google AI Studio](https://aistudio.google.com/apikey), lalu isi di **dua tempat**:

**File `.env` (root Laravel) — untuk klasifikasi pengaduan:**
```env
GEMINI_API_KEY=ISI_API_KEY_ANDA_DI_SINI
PYTHON_EXECUTABLE=python
```

**File `ai-service/.env` — untuk chatbot & OCR:**
```env
GEMINI_API_KEY=ISI_API_KEY_YANG_SAMA
GEMINI_MODEL=gemini-2.5-flash
```

> **Catatan:** Kedua file menggunakan **API Key yang sama**. Pemisahan terjadi karena Laravel (PHP) dan Python adalah dua runtime berbeda yang masing-masing membaca `.env`-nya sendiri.

---

### Langkah 5 — Migrasi Database

```bash
php artisan migrate
```

---

### Langkah 6 — Setup Python (Modul AI)

```bash
# Masuk ke folder ai-service
cd ai-service

# Buat virtual environment
python -m venv .venv

# Aktifkan virtual environment
# Windows (PowerShell):
.venv\Scripts\activate
# macOS / Linux:
source .venv/bin/activate

# Install library Python
pip install -r requirements.txt

# Kembali ke root project
cd ..
```

---

### Langkah 7 — Build Aset Frontend

```bash
npm run build
```

---

### Langkah 8 — Menjalankan Server Lokal

Jalankan tiga perintah berikut di **terminal terpisah**:

```bash
# Terminal 1 — Server Web Laravel
php artisan serve

# Terminal 2 — Queue Worker (untuk klasifikasi pengaduan AI)
php artisan queue:work

# Terminal 3 — (Opsional) Vite saat development
npm run dev
```

Website dapat diakses di: **`http://127.0.0.1:8000`**

---

### Langkah 9 — Login Admin

| Field | Nilai Default |
|:------|:-------------|
| Email | `admin@gmail.com` |
| Password | `admin123` |

> **Penting:** Segera ganti password setelah pertama kali login.

---

## 🏥 Panduan Kustomisasi untuk Puskesmas Lain

Setelah instalasi berhasil, ikuti langkah-langkah berikut untuk menyesuaikan website dengan identitas puskesmas Anda — **tanpa mengubah kode program**.

### Langkah A — Atur Identitas Puskesmas

Buka halaman: **Admin Panel → Pengaturan → Identitas Puskesmas** (`/admin/puskesmas-setting`)

Isi semua field berikut:

| Field | Contoh |
|:------|:-------|
| Nama Puskesmas | `Puskesmas Sungai Limau` |
| Kabupaten/Kota | `Kabupaten Padang Pariaman` |
| Alamat | `Jl. Raya Sungai Limau No. 1, Sumatera Barat` |
| No. Telepon | `(0751) 789-012` |
| Email | `info@puskesmaslimau.go.id` |
| Jam Senin–Kamis | `08:00 - 14:00` |
| Jam Jumat | `08:00 - 11:00` |
| Jam Sabtu | `08:00 - 13:00` |
| Logo Puskesmas | Upload file logo |
| Link Facebook & Instagram | Isi URL media sosial jika ada |

Klik **Simpan** — seluruh website (navbar, footer, halaman) akan otomatis menampilkan identitas baru.

---

### Langkah B — Atur Identitas AI Chatbot

Buka halaman: **Admin Panel → Pengaturan → Pengaturan Chatbot** (`/admin/chatbot-setting`)

| Field | Kustomisasi |
|:------|:-----------|
| Nama AI | Nama asisten virtual Anda, misal: `Sari`, `Andi`, atau `Asisten Limau` |
| Nama Puskesmas (Chatbot) | Nama lengkap untuk dipakai AI dalam percakapan |
| Pesan Sambutan | Teks pembuka saat widget chat pertama kali dibuka |
| Warna Utama | Pilih warna tema chatbot sesuai identitas puskesmas (HEX) |
| Logo Chatbot | Avatar gambar yang tampil di header widget |
| Status | `Active` untuk mengaktifkan, `Inactive` untuk menyembunyikan widget |

> Perubahan nama AI langsung tersinkronisasi ke dalam kepribadian chatbot — AI akan mengenalkan diri dengan nama baru tersebut.

---

### Langkah C — Kelola Konten (Knowledge Base Chatbot)

Chatbot menjawab berdasarkan konten yang dikelola admin. Tambahkan konten agar chatbot semakin informatif:

| Modul Admin | Jenis Konten | Dampak ke Chatbot |
|:-----------|:------------|:-----------------|
| **Halaman Informasi** | Jadwal poli, SOP, alur layanan, visi-misi | Chatbot menjawab pertanyaan umum layanan |
| **FAQ** | Pertanyaan & jawaban yang sering diajukan | Chatbot menjawab FAQ spesifik puskesmas |
| **Berita** | Artikel dan kabar kegiatan | Chatbot merangkum berita terbaru |
| **Agenda** | Kegiatan mendatang | Chatbot menjawab "ada acara apa?" |
| **Dokumen** | SOP, brosur, panduan publik | Chatbot memberi info dokumen tersedia |
| **Inovasi** | Program unggulan puskesmas | Chatbot menceritakan inovasi puskesmas |

> **Tips OCR:** Jika halaman informasi mengandung gambar (poster jadwal, infografis, SOP bergambar), sistem akan otomatis mengekstrak teks dari gambar tersebut sehingga chatbot bisa membaca isinya.

---

### Langkah D — Akun Admin Pertama

Jika perlu membuat akun admin baru dengan email berbeda:

```bash
php artisan tinker --execute="DB::table('users')->insert(['name' => 'Admin Baru', 'email' => 'admin@puskesmas.go.id', 'password' => bcrypt('password_aman'), 'created_at' => now(), 'updated_at' => now()]);"
```

---

## 📚 Dokumentasi Lengkap Modul AI

Seluruh dokumentasi teknis modul AI tersedia di folder [`docs-dokumentasi/`](./docs-dokumentasi/):

| Dokumen | Isi |
|:--------|:----|
| [`PROJECT_OVERVIEW.md`](./docs-dokumentasi/PROJECT_OVERVIEW.md) | Arsitektur sistem & inventaris file |
| [`AI_CHATBOT_PRD.md`](./docs-dokumentasi/AI_CHATBOT_PRD.md) | Spesifikasi teknis chatbot |
| [`AI_COMPLAINT_CLASSIFICATION_PRD.md`](./docs-dokumentasi/AI_COMPLAINT_CLASSIFICATION_PRD.md) | Spesifikasi klasifikasi pengaduan |
| [`AI_SETTINGS_PRD.md`](./docs-dokumentasi/AI_SETTINGS_PRD.md) | Panduan pengaturan AI |
| [`KNOWLEDGE_PIPELINE.md`](./docs-dokumentasi/KNOWLEDGE_PIPELINE.md) | Cara chatbot membangun basis pengetahuan |
| [`OCR_PIPELINE.md`](./docs-dokumentasi/OCR_PIPELINE.md) | Pipeline ekstraksi gambar |
| [`AI_GUARDRAILS.md`](./docs-dokumentasi/AI_GUARDRAILS.md) | Batasan keamanan AI |
| [`DESIGN_DECISIONS.md`](./docs-dokumentasi/DESIGN_DECISIONS.md) | Alasan setiap keputusan teknis |
| [`TESTING.md`](./docs-dokumentasi/TESTING.md) | Catatan & cara pengujian |
| [`CHANGELOG.md`](./docs-dokumentasi/CHANGELOG.md) | Riwayat perubahan |
| [`ROADMAP.md`](./docs-dokumentasi/ROADMAP.md) | Rencana pengembangan |

---

## 👨‍💻 Pengembang

**Wahyu Khairi**
Praktik Kerja Lapangan (PKL)
Dinas Komunikasi dan Informatika Kota Pariaman

© 2026 Puskesmas — Dinas Kesehatan Kota Pariaman
 