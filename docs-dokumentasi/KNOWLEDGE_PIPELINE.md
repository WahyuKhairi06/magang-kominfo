# Alur Pembangunan Basis Pengetahuan (Knowledge Pipeline)

> Referensi silang: [`AI_CHATBOT_PRD.md`](./AI_CHATBOT_PRD.md) | [`AGENTS.md`](./AGENTS.md) | [`AI_GUARDRAILS.md`](./AI_GUARDRAILS.md)

---

## 1. Konsep Dasar

Chatbot tidak diajarkan menggunakan metode Machine Learning tradisional (tidak ada training model). Sebaliknya, chatbot menggunakan pendekatan **Retrieval-Augmented Generation (RAG)**:

1. **Retrieval:** Sebelum setiap percakapan, sistem mengambil informasi yang relevan dari "basis pengetahuan" (knowledge base).
2. **Augmented:** Informasi tersebut dimasukkan ke dalam prompt sebagai "konteks".
3. **Generation:** Gemini menghasilkan jawaban berdasarkan konteks yang disediakan, bukan dari pengetahuan umumnya.

Pendekatan ini memastikan chatbot selalu menjawab berdasarkan data resmi terkini dari database website, bukan dari pelatihan model yang bersifat statis.

---

## 2. Alur Lengkap Knowledge Pipeline

```
┌────────────────────────────────────────────────────────────────────┐
│                     FASE 1: PEMBUATAN KNOWLEDGE                     │
│                 (Dijalankan setiap ada permintaan chat)              │
└────────────────────────────────────────────────────────────────────┘

[Pengguna kirim pesan]
          │
          ▼
[ChatbotController::send()]
          │
          ▼
[ChatbotController::generateDatabaseKnowledge()]
    │
    ├─── Query MySQL: chatbot_settings  → ai_name, puskesmas_display_name, greeting
    ├─── Query MySQL: sambutans         → nama, judul, motto, isi (strip_tags)
    ├─── Query MySQL: halamen + join    → judul, isi (strip_tags), isi_ocr, url
    ├─── Query MySQL: agendas           → hanya status='upcoming'
    ├─── Query MySQL: beritas           → hanya status='publish'
    ├─── Query MySQL: infografis        → semua record
    ├─── Query MySQL: galeris           → hanya jenis='infografis'
    ├─── Query MySQL: dokumen           → hanya is_active=1
    ├─── Query MySQL: faqs              → semua record
    └─── Query MySQL: inovasi1          → hanya is_active=1
          │
          ▼
[Gabungkan semua hasil ke dalam array PHP $knowledge]
          │
          ▼
[Serialize ke JSON: json_encode($knowledge, JSON_PRETTY_PRINT | ...)]
          │
          ▼
[Write ke file: ai-service/knowledge/database_knowledge.json]


┌────────────────────────────────────────────────────────────────────┐
│                     FASE 2: RETRIEVAL & PENGIRIMAN                  │
│                   (Dijalankan di dalam Python service)               │
└────────────────────────────────────────────────────────────────────┘

[Symfony Process: python chat_api.py "pesan" "NamaAI" "NamaPuskesmas"]
          │
          ▼
[chat_api.py → main.py::load_knowledge_base()]
    └─── Membaca database_knowledge.json dari disk
          │
          ▼
[main.py::build_corpus(knowledge_base)]
    └─── Flatten semua list dalam JSON menjadi list 1 dimensi
    └─── Setiap item = satu "chunk" teks
          │
          ▼
[main.py::retrieve_context(user_message, corpus)]
    ├─── Tokenisasi pertanyaan pengguna
    ├─── Filter stopword Bahasa Indonesia
    ├─── Hitung skor setiap chunk:
    │       - overlap_score = jumlah token yang sama
    │       - category_bonus = +3 jika kategori chunk relevan
    │       - total = overlap + bonus
    ├─── Urutkan berdasarkan total_score DESC
    └─── Ambil Top-6 chunk dengan skor > 0
          │
          ▼
[Gabungkan 6 chunk → context_block]
          │
          ▼
[prompt.py::build_prompt(pertanyaan, context_block, ai_name, puskesmas_name)]
          │
          ▼
[main.py::ask_gemini(client, model, full_prompt)]
```

---

## 3. Struktur File `database_knowledge.json`

Berikut adalah contoh skema JSON yang dihasilkan. Nilai-nilai merupakan ilustrasi, bukan data nyata.

```json
{
    "profile": {
        "nama_puskesmas": "Puskesmas Marunggi",
        "sambutan_pejabat": {
            "nama": "dr. Budi Santoso, SKM",
            "judul": "Kepala Puskesmas Marunggi",
            "motto": "Sehat Bersama Masyarakat",
            "isi": "Selamat datang di Puskesmas Marunggi...",
            "url": "http://localhost"
        }
    },
    "ai_assistant_identity": {
        "nama_asisten": "Sari",
        "greeting_message": "Halo! Ada yang bisa saya bantu?"
    },
    "halaman_informasi": [
        {
            "kategori": "Layanan",
            "judul": "Jadwal Poli dan Layanan",
            "isi": "Poli Umum: Senin-Kamis 08.00 - 12.00...",
            "isi_ocr": "## JADWAL PELAYANAN\n| Poli | Hari | Jam |\n|-----|------|-----|\n| Umum | Senin-Kamis | 08:00-12:00 |",
            "url": "http://localhost/landing/halaman/eyJpdiI6..."
        }
    ],
    "acara_mendatang": [
        {
            "nama_kegiatan": "Posyandu Balita Dusun Selatan",
            "tanggal": "2026-07-25",
            "waktu": "08:00 s/d 11:00",
            "lokasi": "Balai Desa Selatan",
            "deskripsi": "...",
            "penyelenggara": "Bidan Desa",
            "url": "http://localhost/landing/agenda"
        }
    ],
    "berita": [...],
    "infografis": [...],
    "dokumen_publik": [...],
    "faqs": [
        {
            "pertanyaan": "Bagaimana cara mendaftar berobat?",
            "jawaban": "Masyarakat dapat mendaftar dengan membawa KTP dan kartu BPJS...",
            "url": "http://localhost/faq"
        }
    ],
    "inovasi_program": [...]
}
```

---

## 4. Daftar Whitelist Sumber Data

Hanya tabel-tabel berikut yang **diizinkan** dimasukkan ke dalam knowledge base chatbot:

| Tabel | Field yang Diambil | Kondisi Filter |
|:------|:------------------|:--------------|
| `chatbot_settings` | `puskesmas_display_name`, `ai_name`, `greeting_message` | Rekord pertama (id=1) |
| `sambutans` | `nama`, `judul`, `motto`, `isi` (strip_tags) | Rekord terbaru |
| `halamen` | `judul`, `isi` (strip_tags), `isi_ocr` | Semua rekord, join `kategori_halamen` |
| `agendas` | `judul_agenda`, `tanggal`, `jam_mulai`, `jam_selesai`, `lokasi`, `deskripsi`, `penyelenggara` | `status = 'upcoming'` |
| `beritas` | `judul`, `isi` (tanpa strip_tags — untuk summary), `tanggal_publish` | `status = 'publish'` |
| `infografis` | `nama`, `keterangan` (strip_tags) | Semua |
| `galeris` | `judul_kegiatan`, `deskripsi` (strip_tags), `lokasi` | `jenis = 'infografis'` |
| `dokumen` | `judul`, `kategori`, `deskripsi` (strip_tags) | `is_active = 1` |
| `faqs` | `pertanyaan`, `jawaban` (strip_tags) | Semua |
| `inovasi1` | `judul_inovasi`, `deskripsi_inovasi` (strip_tags), `tahun_inovasi` | `is_active = 1` |

**Tabel yang DILARANG masuk ke knowledge base:**

| Tabel | Alasan |
|:------|:-------|
| `users` | Data akun login sistem (sensitif) |
| `sessions` | Data sesi pengguna (sensitif) |
| `pengaduans` | Data pengaduan warga (sensitif, privasi pelapor) |
| `dasawismas`, `buku_catatan_datas`, dll. | Data internal PKK, bukan informasi publik Puskesmas |
| Tabel apapun yang mengandung NIK, password, alamat pribadi | Data pribadi (PII) |

---

## 5. Penanganan Error saat Pembuatan Knowledge

Method `generateDatabaseKnowledge()` dibungkus dalam blok `try-catch`:

```php
try {
    // ... semua query dan penulisan JSON
} catch (\Exception $e) {
    Log::error('Chatbot knowledge generation error: ' . $e->getMessage());
}
```

Jika pembuatan knowledge gagal (misalnya tabel belum ada, koneksi database bermasalah), error dicatat ke log Laravel dan proses chatbot tetap berlanjut. Python akan membaca knowledge JSON yang terakhir berhasil ditulis, atau gagal gracefully jika file tidak ada sama sekali.

---

## 6. Pertimbangan Performa

| Aspek | Kondisi Saat Ini | Potensi Optimasi |
|:------|:----------------|:-----------------|
| Frekuensi regenerasi | Setiap request chatbot | Cache di Redis/memori dengan TTL 5 menit |
| Ukuran JSON | Bergantung jumlah konten | Kompresi gzip sebelum ditulis |
| I/O disk | Write JSON ke disk setiap request | Kirim via stdin ke subprocess, tidak perlu disk |
| Database queries | 10 query per request chatbot | Satu koneksi DB, paralel query |

> Saat ini, performa sudah cukup untuk skala Puskesmas. Optimasi di atas direkomendasikan jika traffic chatbot meningkat signifikan.
