# 🏥 AI Healthcare Assistant — Puskesmas Marunggi Kota Pariaman

Prototype AI Assistant berbasis **Google Gemini API** untuk membantu masyarakat
mencari informasi seputar pelayanan **Puskesmas Marunggi, Kota Pariaman**.

AI ini **bukan chatbot umum**. AI hanya menjawab berdasarkan Knowledge Base
resmi Puskesmas Marunggi (`knowledge/puskesmas.json`) dan akan menolak
pertanyaan di luar konteks tersebut, termasuk permintaan diagnosis penyakit,
resep obat, atau hal-hal yang menggantikan peran dokter.

---

## 📁 Struktur Project

```
ai-healthcare-assistant/
│
├── knowledge/
│   └── puskesmas.json      # Knowledge Base (data resmi Puskesmas)
│
├── .env                     # Konfigurasi API Key & model Gemini
├── main.py                  # Entry point aplikasi (chat terminal)
├── prompt.py                # Prompt engineering (system instruction)
├── requirements.txt         # Daftar dependency Python
└── README.md                # Dokumentasi ini
```

---

## ⚙️ Instalasi

### 1. Buat Virtual Environment

Buka terminal di VS Code pada folder project ini, lalu jalankan:

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
- `google-genai` — SDK resmi Google untuk Gemini API
- `python-dotenv` — memuat variabel dari file `.env`
- `rich` — tampilan terminal yang lebih rapi dan interaktif

### 3. Mengisi API Key Gemini

1. Dapatkan API Key gratis di **https://aistudio.google.com/apikey**
2. Buka file `.env` di folder project ini
3. Isi baris berikut dengan API Key Anda:

```
GEMINI_API_KEY=isi_api_key_anda_disini
GEMINI_MODEL=gemini-2.5-flash
```

> `GEMINI_MODEL` dapat diganti dengan model Gemini lain sesuai kebutuhan
> (misalnya `gemini-2.5-pro`), tanpa perlu mengubah kode program.

### 4. Menjalankan Project

```bash
python main.py
```

Jika berhasil, terminal akan menampilkan:

```
=================================================
🏥 AI Healthcare Assistant
Puskesmas Marunggi
Powered by Gemini
=================================================

Anda :
```

Ketik pertanyaan Anda, lalu tekan Enter. Program akan terus berjalan sampai
Anda mengetik salah satu dari: `exit`, `quit`, atau `keluar`.

---

## 💬 Contoh Pertanyaan

**Pertanyaan yang relevan (akan dijawab AI):**
- "Jam pelayanan Puskesmas Marunggi jam berapa?"
- "Dokter gigi praktik hari apa?"
- "Apakah Puskesmas Marunggi melayani BPJS?"
- "Dimana alamat Puskesmas Marunggi?"
- "Apa saja syarat berobat menggunakan BPJS?"
- "Apa visi dan misi Puskesmas Marunggi?"
- "Ada program kesehatan apa saja bulan ini?"
- "Kamu siapa?" / "Apakah kamu AI?" / "Kamu robot ya?" — AI akan memperkenalkan
  dirinya sebagai Asisten AI Puskesmas Marunggi (bukan manusia/tenaga medis).

**Pertanyaan di luar konteks (akan ditolak AI):**
- "Bagaimana cara membuat paspor?"
- "Siapa presiden Indonesia sekarang?"
- "Ceritakan resep membuat rendang."

Contoh respons untuk pertanyaan di luar konteks:

```
Maaf, saya hanya dapat membantu informasi yang berkaitan dengan Puskesmas Marunggi.
```

---

## 🔄 Flow AI (Context Engineering)

Program ini **tidak** mengirim seluruh isi `puskesmas.json` ke Gemini pada
setiap permintaan. Sebagai gantinya, digunakan mekanisme **Context Retrieval
sederhana berbasis keyword matching** (belum menggunakan embedding, vector
database, atau LangChain), dengan alur sebagai berikut:

```
User bertanya
      │
      ▼
Tokenisasi pertanyaan (hapus stopword, ubah ke huruf kecil)
      │
      ▼
Cocokkan token pertanyaan dengan setiap "chunk" data pada Knowledge Base
(setiap dokter, jadwal, layanan, FAQ, dsb. diperlakukan sebagai chunk terpisah)
      │
      ▼
Hitung skor relevansi tiap chunk (irisan kata + bonus kategori kata kunci)
      │
      ▼
Ambil beberapa chunk dengan skor tertinggi (Top-K)
      │
      ▼
Susun menjadi satu blok "Context"
      │
      ▼
Gabungkan Context + Pertanyaan ke dalam Prompt (lihat prompt.py)
      │
      ▼
Kirim Prompt ke Gemini API
      │
      ▼
Gemini menjawab HANYA berdasarkan Context yang diberikan
      │
      ▼
Jawaban ditampilkan ke pengguna di terminal
```

Jika tidak ada chunk yang relevan ditemukan, atau pertanyaan berada di luar
topik Puskesmas, AI akan menjawab sesuai instruksi pada `prompt.py`
(menyatakan informasi belum tersedia atau menolak pertanyaan di luar konteks).

---

## 🏗️ Arsitektur

```
┌────────────────────┐
│      main.py        │  ← Entry point, chat loop, retrieval, error handling
└─────────┬───────────┘
          │
          ├── membaca ──► .env  (konfigurasi API Key & nama model)
          │
          ├── membaca ──► knowledge/puskesmas.json (Knowledge Base)
          │
          ├── memanggil ──► prompt.py (menyusun System Instruction + Context + Pertanyaan)
          │
          └── memanggil ──► Google Gemini API (google-genai SDK)
                                   │
                                   ▼
                          Jawaban dikembalikan ke main.py
                                   │
                                   ▼
                        Ditampilkan ke pengguna via rich console
```

**Komponen:**
- **`main.py`** — Mengelola alur aplikasi: memuat konfigurasi & Knowledge Base,
  melakukan context retrieval, memanggil Gemini API, menampilkan hasil, serta
  menangani seluruh skenario error (API key kosong/salah, JSON rusak/hilang,
  koneksi internet mati, timeout, error dari Gemini).
- **`prompt.py`** — Berisi System Instruction (peran & batasan AI) dan fungsi
  `build_prompt()` yang menyusun prompt akhir sebelum dikirim ke Gemini.
- **`knowledge/puskesmas.json`** — Sumber data tunggal (single source of truth)
  yang berisi seluruh informasi resmi Puskesmas Marunggi yang boleh diketahui AI.

---

## 🚫 Batasan AI (Guardrails)

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

## 🛠️ Troubleshooting

| Masalah | Penyebab | Solusi |
|---|---|---|
| `GEMINI_API_KEY tidak ditemukan` | File `.env` kosong | Isi `GEMINI_API_KEY` pada `.env` |
| Pesan error terkait API Key | API Key salah/kadaluarsa | Periksa kembali API Key di https://aistudio.google.com/apikey |
| `Knowledge Base Rusak` | Format JSON tidak valid | Periksa sintaks `knowledge/puskesmas.json` (gunakan JSON validator) |
| `Knowledge Base Hilang` | File `puskesmas.json` terhapus/dipindah | Pastikan file berada di `knowledge/puskesmas.json` |
| Tidak dapat terhubung ke Gemini | Internet mati/tidak stabil | Periksa koneksi internet, coba lagi |
| Timeout | Koneksi lambat / server sibuk | Coba ulangi pertanyaan beberapa saat kemudian |

---

## 📌 Catatan Penting

- Project ini masih berupa **prototype berbasis terminal**, belum terhubung
  ke website maupun database MySQL.
- Knowledge Base masih menggunakan file JSON statis (`knowledge/puskesmas.json`)
  dan dapat diperbarui secara manual sesuai kebutuhan.
- Context Retrieval menggunakan pendekatan **keyword matching sederhana**,
  belum menggunakan embedding, vector database, FAISS, maupun LangChain,
  sesuai kebutuhan tahap prototype ini.
