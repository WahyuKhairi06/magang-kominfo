# 🏥 AI Service — Puskesmas Marunggi Kota Pariaman

Layanan AI berbasis **Google Gemini API** yang menjadi *backend* AI untuk website
**Puskesmas Marunggi, Kota Pariaman**. AI Service ini terdiri dari tiga modul utama:

| Modul | Fungsi |
|---|---|
| **Chatbot Publik** (`chat_api.py`) | Menjawab pertanyaan masyarakat seputar layanan Puskesmas |
| **Klasifikasi Pengaduan** (`classify_complaint.py`) | Mengklasifikasikan pengaduan masyarakat secara otomatis (internal admin) |
| **OCR Gambar** (`extract_ocr.py`) | Mengekstrak teks dari gambar (jadwal, poster, infografis) untuk Knowledge Base |

AI Chatbot **bukan chatbot umum** — hanya menjawab berdasarkan Knowledge Base resmi
(`knowledge/database_knowledge.json`) yang di-*generate* otomatis oleh Laravel, dan
menolak pertanyaan di luar konteks Puskesmas, termasuk permintaan diagnosis penyakit,
resep obat, atau hal-hal yang menggantikan peran dokter.

---

## 📁 Struktur Project

```
ai-service/
│
├── knowledge/
│   ├── database_knowledge.json   # Knowledge Base utama (di-generate oleh Laravel)
│   └── puskesmas.json            # Fallback statis jika database_knowledge.json belum ada
│
├── .env                          # Konfigurasi API Key & model Gemini (JANGAN di-commit)
├── .env example                  # Contoh variabel environment
│
├── main.py                       # Core AI: context retrieval, client Gemini, chat loop terminal
├── prompt.py                     # Prompt engineering chatbot publik (system instruction + builder)
│
├── chat_api.py                   # Adapter CLI: dipanggil Laravel via proc_open untuk chatbot publik
├── classify_complaint.py         # FastAPI router: endpoint klasifikasi pengaduan (internal)
├── extract_ocr.py                # CLI: OCR gambar menggunakan Gemini Vision (dipanggil Laravel)
│
├── prompt_classify.py            # Prompt builder khusus klasifikasi pengaduan
├── taxonomy.py                   # Taksonomi kategori & urgensi (single source of truth)
│
└── requirements.txt              # Daftar dependency Python
```

---

## ⚙️ Instalasi

### 1. Buat Virtual Environment

Dari folder `ai-service/`, jalankan perintah berikut:

**Windows:**
```bash
python -m venv venv
venv\Scripts\activate
```

**macOS / Linux:**
```bash
python3 -m venv venv
source venv/bin/activate
```

Setelah aktif, prompt terminal akan menampilkan `(venv)` di awal baris.

### 2. Install Requirements

```bash
pip install -r requirements.txt
```

Dependency yang akan terinstall:

| Package | Fungsi |
|---|---|
| `google-genai` | SDK resmi Google untuk Gemini API |
| `python-dotenv` | Memuat variabel dari file `.env` |
| `rich` | Tampilan terminal interaktif (chat loop) |
| `fastapi` | Framework REST API (endpoint klasifikasi pengaduan) |
| `uvicorn` | ASGI server untuk menjalankan FastAPI |
| `pydantic` | Validasi request/response FastAPI |

### 3. Mengisi File `.env`

Salin `.env example` menjadi `.env`, lalu isi dengan nilai yang sesuai:

```env
# API Key Gemini — dapatkan di https://aistudio.google.com/apikey
GEMINI_API_KEY=isi_api_key_anda_disini

# Model Gemini untuk chatbot publik & OCR
GEMINI_MODEL=gemini-2.5-flash

# Internal API Key — digunakan oleh Laravel untuk memanggil endpoint klasifikasi
# Harus sama persis dengan INTERNAL_AI_KEY di file .env Laravel
INTERNAL_API_KEY=marunggi-ai-internal-key-12345

# Model Gemini untuk klasifikasi pengaduan
GEMINI_CLASSIFY_MODEL=gemini-2.5-flash
```

---

## 🚀 Cara Menjalankan

### Chatbot Terminal (Pengembangan / Debug)

```bash
python main.py
```

Menjalankan sesi chat interaktif di terminal. Berguna untuk menguji Knowledge Base
dan respons AI tanpa harus melalui Laravel.

Jika berhasil, terminal akan menampilkan:

```
=================================================
🏥 AI Healthcare Assistant
Puskesmas Marunggi
Powered by Gemini
=================================================

Anda :
```

Ketik pertanyaan, tekan Enter. Ketik `exit`, `quit`, atau `keluar` untuk keluar.

### FastAPI Server (Endpoint Klasifikasi Pengaduan)

```bash
uvicorn classify_complaint:router --host 0.0.0.0 --port 8001 --reload
```

> Atau jalankan melalui `main.py` yang secara otomatis me-mount router jika FastAPI
> terinstall. Laravel memanggil endpoint ini via `ClassifyPengaduanJob`.

Endpoint yang tersedia:

| Method | URL | Deskripsi |
|---|---|---|
| `POST` | `/api/v1/admin/classify-complaint` | Klasifikasi 1 pengaduan |

### Chatbot API (via `chat_api.py`)

Tidak dijalankan secara langsung — Laravel memanggilnya via `proc_open`:

```bash
# Contoh pemanggilan Laravel (internal)
python chat_api.py "Jam berapa Puskesmas Marunggi buka?" "Sitariktageh" "Puskesmas Marunggi"
```

Output: JSON `{"status": "success", "answer": "..."}`.

### OCR Gambar (via `extract_ocr.py`)

```bash
python extract_ocr.py /path/ke/gambar.jpg
```

Output: JSON `{"status": "success", "ocr_text": "..."}`.

Laravel menggunakannya saat admin meng-upload gambar ke Knowledge Base agar konten
gambar dapat diindeks dan dijawab oleh chatbot.

---

## 🗂️ Knowledge Base

Knowledge Base terdiri dari dua file JSON di folder `knowledge/`:

| File | Sumber | Keterangan |
|---|---|---|
| `database_knowledge.json` | Di-generate Laravel (`php artisan knowledge:generate`) | **Sumber utama** — berisi data live dari database |
| `puskesmas.json` | Ditulis manual | **Fallback statis** — dipakai jika `database_knowledge.json` belum ada |

`main.py` secara otomatis menggunakan `database_knowledge.json` jika file tersebut ada,
dan *fallback* ke `puskesmas.json` jika tidak.

---

## 🔄 Flow AI — Chatbot Publik

```
User bertanya (via Website Laravel)
      │
      ▼
Laravel memanggil: python chat_api.py "<pertanyaan>" "<nama_ai>" "<nama_puskesmas>"
      │
      ▼
chat_api.py memanggil fungsi dari main.py:
  1. load_api_key()         — Baca GEMINI_API_KEY dari .env
  2. load_knowledge_base()  — Baca database_knowledge.json (atau fallback puskesmas.json)
  3. build_corpus()         — Pecah Knowledge Base menjadi chunk-chunk kecil
  4. retrieve_context()     — Keyword matching: cari chunk yang relevan dengan pertanyaan
  5. build_prompt()         — Susun System Instruction + Context + Pertanyaan
  6. ask_gemini()           — Kirim prompt ke Gemini API
      │
      ▼
Jawaban dikembalikan sebagai JSON ke Laravel
      │
      ▼
Laravel menampilkan jawaban ke pengguna di website
```

### Mekanisme Context Retrieval (Keyword Matching)

Program **tidak** mengirim seluruh Knowledge Base ke Gemini pada setiap permintaan.
Sebagai gantinya digunakan **keyword matching sederhana** (tanpa embedding / vector database):

1. Tokenisasi pertanyaan (hapus stopword, ubah ke huruf kecil)
2. Cocokkan token dengan setiap chunk Knowledge Base
3. Hitung skor relevansi (irisan kata + bonus kategori keyword)
4. Ambil Top-K chunk dengan skor tertinggi
5. Gabungkan menjadi satu blok "Context" yang dikirim ke Gemini

Kategori yang didukung: `profile`, `halaman_informasi`, `acara_mendatang`, `berita`,
`infografis`, `dokumen_publik`, `faqs`, `inovasi_program`, `ai_assistant_identity`.

---

## 🔄 Flow AI — Klasifikasi Pengaduan

```
Masyarakat submit pengaduan (via Website Laravel)
      │
      ▼
Laravel dispatch ClassifyPengaduanJob (queue)
      │
      ▼
Job memanggil POST /api/v1/admin/classify-complaint
  Header: X-Api-Key: <INTERNAL_API_KEY>
  Body:   { pengaduan_id, subjek, isi }
      │
      ▼
classify_complaint.py:
  1. Verifikasi INTERNAL_API_KEY
  2. Build prompt klasifikasi (prompt_classify.py)
  3. Kirim ke Gemini API (structured output / JSON schema)
  4. Jika Gemini gagal → fallback ke keyword classification lokal
      │
      ▼
Response: { pengaduan_id, kategori, urgensi, alasan }
      │
      ▼
Laravel menyimpan hasil ke database & menampilkan di dashboard admin
```

**Kategori pengaduan** (sesuai `taxonomy.py`):
- Pendaftaran & Administrasi
- Pelayanan Petugas/Medis
- Waktu Tunggu & Antrean
- Kebersihan & Fasilitas
- Ketersediaan Obat
- Sarana & Prasarana
- Lainnya

**Tingkat urgensi**: `rendah` · `sedang` · `tinggi`

---

## 🏗️ Arsitektur

```
┌──────────────────────────────────────────────────────────┐
│                     WEBSITE LARAVEL                      │
│  (ChatbotController, ClassifyPengaduanJob, OcrService)   │
└──────┬──────────────────────────┬───────────────┬────────┘
       │ proc_open                │ HTTP POST      │ proc_open
       ▼                         ▼                ▼
┌─────────────┐   ┌──────────────────────────┐  ┌──────────────┐
│  chat_api.py│   │  classify_complaint.py   │  │extract_ocr.py│
│  (CLI)      │   │  (FastAPI Router)        │  │  (CLI)       │
└──────┬──────┘   └───────────┬──────────────┘  └──────┬───────┘
       │                      │                         │
       ▼                      │                         │
┌─────────────┐               │                         │
│   main.py   │               │                         │
│  (core AI)  │               │                         │
└──────┬──────┘               │                         │
       │                      │                         │
       ├── .env               │                         │
       ├── knowledge/         │                         │
       │   ├── database_knowledge.json                  │
       │   └── puskesmas.json                           │
       ├── prompt.py          │                         │
       └──────────────────────┴─────────────────────────┘
                              │
                              ▼
                    Google Gemini API
                    (google-genai SDK)
```

---

## 🚫 Batasan AI — Chatbot Publik (Guardrails)

AI ini **tidak** akan:
- Melakukan diagnosis atau menentukan penyakit
- Memberikan resep atau anjuran obat
- Menggantikan peran dan penilaian medis dokter
- Mengakses atau mengarang data rekam medis / data pasien
- Mengakses data pribadi pegawai Puskesmas
- Menjawab pertanyaan di luar informasi resmi Puskesmas Marunggi

Seluruh batasan ini didefinisikan secara eksplisit pada `SYSTEM_INSTRUCTION`
di `prompt.py` dan diterapkan pada setiap permintaan ke Gemini.

---

## 💬 Contoh Pertanyaan Chatbot

**Pertanyaan yang relevan (akan dijawab AI):**
- "Jam pelayanan Puskesmas Marunggi jam berapa?"
- "Dokter gigi praktik hari apa?"
- "Apakah Puskesmas Marunggi melayani BPJS?"
- "Dimana alamat Puskesmas Marunggi?"
- "Apa saja syarat berobat menggunakan BPJS?"
- "Ada program kesehatan apa saja bulan ini?"
- "Kamu siapa?" — AI memperkenalkan diri sebagai AI Assistant Puskesmas

**Pertanyaan di luar konteks (akan ditolak AI):**
- "Bagaimana cara membuat paspor?"
- "Siapa presiden Indonesia sekarang?"
- "Ceritakan resep membuat rendang."

Respons penolakan:
```
Maaf, saya hanya dapat membantu informasi yang berkaitan dengan Puskesmas Marunggi.
```

---

## 🛠️ Troubleshooting

| Masalah | Penyebab | Solusi |
|---|---|---|
| `GEMINI_API_KEY tidak ditemukan` | File `.env` kosong | Isi `GEMINI_API_KEY` pada `.env` |
| Error API Key | API Key salah/kedaluarsa | Periksa kembali di https://aistudio.google.com/apikey |
| `Knowledge Base Hilang` | `database_knowledge.json` & `puskesmas.json` tidak ada | Generate ulang: `php artisan knowledge:generate` |
| `Knowledge Base Rusak` | Format JSON tidak valid | Periksa sintaks file JSON (gunakan JSON validator) |
| `401 Unauthorized` pada endpoint klasifikasi | `INTERNAL_API_KEY` tidak cocok | Samakan `INTERNAL_API_KEY` di `.env` ai-service dengan `INTERNAL_AI_KEY` di `.env` Laravel |
| FastAPI tidak jalan | `uvicorn` belum terinstall | `pip install -r requirements.txt` |
| Tidak dapat terhubung ke Gemini | Internet mati/tidak stabil | Periksa koneksi internet, coba lagi |
| Timeout | Koneksi lambat / server sibuk | Ulangi permintaan beberapa saat kemudian |

---

## 📌 Catatan Penting

- **Knowledge Base dinamis**: `database_knowledge.json` di-generate otomatis oleh Laravel
  setiap kali admin memperbarui data (profil, jadwal, berita, dokumen, FAQ, dll.)
  melalui perintah `php artisan knowledge:generate`. Tidak perlu edit manual.
- **Fallback**: Jika `database_knowledge.json` belum ada, sistem otomatis menggunakan
  `puskesmas.json` (data statis).
- **Context Retrieval**: Menggunakan keyword matching sederhana, **bukan** embedding,
  vector database, FAISS, maupun LangChain — sesuai kebutuhan project ini.
- **Keamanan Endpoint Klasifikasi**: Endpoint `/api/v1/admin/classify-complaint` dilindungi
  `X-Api-Key` header dan hanya boleh dipanggil oleh Laravel (tidak dari publik/frontend).
- **Privasi Data**: `classify_complaint.py` hanya menerima `subjek` dan `isi` pengaduan —
  data identitas pelapor (nama, nomor HP, email) tidak boleh dikirim ke Gemini API.
