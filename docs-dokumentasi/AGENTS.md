# AGENTS.md — Panduan Teknis untuk AI Coding Assistant

Dokumen ini berisi aturan dan konteks yang wajib dipahami oleh AI coding assistant (seperti Gemini, Copilot, atau sejenisnya) sebelum memodifikasi kode apapun yang berkaitan dengan modul AI di repositori ini.

---

## Konteks Proyek

Proyek ini adalah sistem informasi website Puskesmas berbasis Laravel 13 (PHP) dengan layanan AI terpisah berbasis Python. Modul AI dikembangkan sebagai **fitur tambahan** di atas codebase yang sudah ada. Jangan pernah mengubah atau menghapus fitur lama yang tidak ada dalam ruang lingkup modul AI.

---

## Tata Letak File AI yang Wajib Diketahui

| File | Peran |
|:-----|:------|
| `app/Http/Controllers/ChatbotController.php` | Orkestrasi chatbot: generate knowledge JSON, panggil Python, parse respons |
| `app/Http/Controllers/Admin/ChatbotSettingController.php` | CRUD konfigurasi chatbot (nama AI, warna, greeting, status) |
| `app/Http/Controllers/Admin/PengaduanController.php` | Manajemen pengaduan + override klasifikasi AI |
| `app/Http/Controllers/Admin/HalamanController.php` | Halaman informasi + trigger OCR saat simpan/update |
| `app/Http/Controllers/Admin/PuskesmasSettingController.php` | Konfigurasi identitas Puskesmas (nama, alamat, jam, media sosial) |
| `app/Jobs/ClassifyPengaduanJob.php` | Async job klasifikasi pengaduan via Gemini REST API |
| `app/Models/ChatbotSetting.php` | Model tabel `chatbot_settings` |
| `app/Models/Pengaduan.php` | Model tabel `pengaduans` |
| `ai-service/chat_api.py` | Entry point CLI untuk chatbot (dipanggil oleh Laravel Process) |
| `ai-service/main.py` | Core AI: retrieval, corpus builder, Gemini client |
| `ai-service/prompt.py` | System instruction & prompt builder untuk chatbot publik |
| `ai-service/prompt_classify.py` | Prompt builder untuk klasifikasi pengaduan (TERPISAH dari chatbot) |
| `ai-service/taxonomy.py` | **Sumber kebenaran tunggal** kategori & urgensi pengaduan |
| `ai-service/extract_ocr.py` | Ekstraksi teks dari gambar menggunakan Gemini Vision |
| `ai-service/knowledge/database_knowledge.json` | Output JSON dari Laravel untuk dikonsumsi Python (dihasilkan saat runtime, bukan di-commit) |

---

## Aturan Keras (Wajib Dipatuhi)

1. **Jangan ubah file chatbot jika hanya memodifikasi fitur klasifikasi pengaduan, dan sebaliknya.** Kedua fitur ini terisolasi secara desain.

2. **Taksonomi kategori pengaduan adalah Single Source of Truth di `ai-service/taxonomy.py`.**
   Jika daftar `CATEGORIES` atau `URGENCY_LEVELS` diubah, berikut ini juga WAJIB diperbarui secara bersamaan:
   - Kolom enum di migration `2026_07_16_000001_add_ai_classification_to_pengaduans_table.php`
   - Opsi chip di `resources/views/admin/pengaduan/_klasifikasi_chip.blade.php`
   - List `kategoriOptions()` di `PengaduanController.php`

3. **Gemini WAJIB dipanggil dengan `responseSchema` / structured output** untuk klasifikasi pengaduan. Jangan ubah ke parsing teks bebas.

4. **Jangan pernah memasukkan data sensitif ke dalam knowledge JSON.** Data yang dilarang: tabel `users`, `sessions`, data pribadi pasien, data login, data internal keuangan. Lihat daftar whitelist tabel di [`KNOWLEDGE_PIPELINE.md`](./KNOWLEDGE_PIPELINE.md).

5. **Jangan pernah mengirim data identitas pelapor (nama, nomor HP) ke prompt Gemini untuk klasifikasi.** Hanya `isi_pengaduan` yang dikirim. Lihat `prompt_classify.py` untuk konfirmasi.

6. **Endpoint klasifikasi pengaduan adalah endpoint internal.** Jangan ekspos ke publik tanpa autentikasi yang sesuai.

7. **`database_knowledge.json` dihasilkan secara otomatis saat runtime** oleh `ChatbotController::generateDatabaseKnowledge()`. Jangan pernah edit file ini secara manual. Perubahan pada isi knowledge harus dilakukan melalui admin panel website.

8. **Python executable dikonfigurasi melalui variabel lingkungan** `PYTHON_EXECUTABLE` di file `.env` Laravel (default: `python`). Jangan hardcode path Python langsung di controller.

---

## Urutan Sinkronisasi Jika Menambah Sumber Data Baru ke Chatbot

1. Tambahkan query ke dalam method `generateDatabaseKnowledge()` di `ChatbotController.php`.
2. Tambahkan mapping key baru ke array `$knowledge`.
3. Tambahkan kata kunci kategori baru ke `CATEGORY_KEYWORDS` di `main.py` jika dibutuhkan untuk retrieval.
4. Perbarui tabel "Sumber Data Chatbot" di [`KNOWLEDGE_PIPELINE.md`](./KNOWLEDGE_PIPELINE.md).

---

## Referensi Silang Dokumen

| Topik | Dokumen |
|:------|:--------|
| Arsitektur lengkap | [`PROJECT_OVERVIEW.md`](./PROJECT_OVERVIEW.md) |
| Alur knowledge | [`KNOWLEDGE_PIPELINE.md`](./KNOWLEDGE_PIPELINE.md) |
| Alur OCR | [`OCR_PIPELINE.md`](./OCR_PIPELINE.md) |
| Guardrails AI | [`AI_GUARDRAILS.md`](./AI_GUARDRAILS.md) |
| Business rules klasifikasi | [`AI_COMPLAINT_CLASSIFICATION_PRD.md`](./AI_COMPLAINT_CLASSIFICATION_PRD.md) |
