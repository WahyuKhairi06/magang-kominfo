# Peta Jalan Pengembangan (Roadmap)

> Dokumen ini mencatat rencana dan ide pengembangan modul AI di masa depan.
> Status item dapat berubah seiring perkembangan kebutuhan proyek.
>
> Referensi silang: [`CHANGELOG.md`](./CHANGELOG.md) | [`DESIGN_DECISIONS.md`](./DESIGN_DECISIONS.md)

---

## Legenda Status

| Ikon | Status |
|:-----|:-------|
| ✅ | Selesai |
| 🚧 | Sedang dikerjakan |
| 📋 | Direncanakan |
| 💡 | Ide / Usulan |

---

## Versi 1.0.0 — Selesai ✅

Modul inti yang sudah diimplementasikan:

- ✅ AI Chatbot Healthcare Assistant (RAG-based, keyword retrieval)
- ✅ Klasifikasi Pengaduan Otomatis (Gemini structured output + local fallback)
- ✅ AI Settings (chatbot config + puskesmas identity)
- ✅ Pre-extraction OCR Pipeline
- ✅ Knowledge Pipeline (dynamic DB → JSON → Python)
- ✅ Guardrails: system instruction, data whitelist, privacy data isolation

---

## Versi 1.1.0 — Peningkatan Performa 📋

### RD-01: Cache Knowledge Base dengan TTL

**Deskripsi:** Saat ini, knowledge JSON di-generate ulang pada **setiap** permintaan chatbot. Ini menyebabkan 10 query database per percakapan, bahkan jika tidak ada data yang berubah.

**Solusi Diusulkan:**
- Tambahkan caching menggunakan Laravel Cache (Redis/file) dengan TTL 5 menit.
- Jika admin menyimpan perubahan konten melalui CMS, cache di-invalidate secara manual.
- Implementasi: `Cache::remember('chatbot_knowledge', 300, fn() => $this->generateKnowledge())`.

**Estimasi Dampak:** Mengurangi query database hingga ~90%, meningkatkan kecepatan respons chatbot secara signifikan pada traffic tinggi.

---

### RD-02: Streaming Response Chatbot

**Deskripsi:** Saat ini, chatbot baru menampilkan respons setelah teks dari Gemini sepenuhnya selesai dihasilkan. Ini terasa lambat karena pengguna menunggu diam tanpa feedback.

**Solusi Diusulkan:**
- Implementasi Server-Sent Events (SSE) atau WebSocket untuk streaming respons karakter demi karakter.
- Di sisi Python, gunakan `generate_content(..., stream=True)` dari SDK `google-genai`.
- Di sisi frontend, tampilkan "efek mengetik" saat teks datang.

---

## Versi 1.2.0 — Peningkatan Akurasi AI 📋

### RD-03: Vector Embedding untuk Retrieval

**Deskripsi:** Retrieval berbasis keyword saat ini tidak bisa menangani pertanyaan semantik (sinonim, frasa berbeda dengan makna sama).

**Contoh Masalah:**
- Pengguna tanya: "kapan bisa periksa kandungan?"
- KB berisi: "Jadwal Poli KIA (Kesehatan Ibu dan Anak)"
- Keyword "kandungan" tidak overlap dengan "KIA" — retrieval bisa miss.

**Solusi Diusulkan:**
- Buat embedding untuk setiap chunk knowledge base menggunakan Google Text Embedding API.
- Simpan vektor di database (PostgreSQL + pgvector, atau file FAISS lokal).
- Pada setiap pertanyaan: buat embedding, lakukan cosine similarity search, ambil Top-K.
- Regenerasi embedding hanya saat konten berubah (bukan setiap request).

---

### RD-04: Integrasi Data `puskesmas_settings` ke Knowledge Base

**Deskripsi:** Data jam operasional yang admin masukkan di `puskesmas_settings` belum dimasukkan ke knowledge base chatbot.

**Solusi Diusulkan:**
- Tambahkan query `puskesmas_settings` ke dalam `generateDatabaseKnowledge()`.
- Masukkan data jam layanan, nomor telepon, email, dan media sosial ke dalam JSON sebagai section baru `info_kontak_operasional`.

---

## Versi 1.3.0 — Fitur Lanjutan 💡

### RD-05: Dashboard Analitik Pengaduan AI

**Deskripsi:** Admin saat ini hanya bisa melihat daftar pengaduan. Tidak ada visualisasi tren.

**Fitur Diusulkan:**
- Grafik distribusi kategori pengaduan per bulan.
- Grafik distribusi urgensi (tinggi/sedang/rendah) per minggu.
- Persentase pengaduan yang di-override admin (untuk evaluasi akurasi AI).
- Export data ke CSV/Excel untuk pelaporan.

---

### RD-06: Multi-Turn Conversation Memory

**Deskripsi:** Saat ini, setiap pesan chatbot adalah percakapan mandiri — AI tidak mengingat konteks pesan sebelumnya dalam satu sesi.

**Contoh Masalah:**
- Pengguna: "Ada agenda apa bulan ini?"
- AI: "Ada agenda Posyandu Balita pada 25 Juli 2026 di Balai Desa..."
- Pengguna: "Siapa penyelenggaranya?"
- AI: _Tidak tahu penyelenggara yang mana karena tidak mengingat respons sebelumnya_

**Solusi Diusulkan:**
- Simpan riwayat percakapan di `sessionStorage` browser (sisi client).
- Kirim riwayat percakapan sebagai context tambahan ke Python service.
- Batasi jumlah pesan history yang dikirim (misal 5 pesan terakhir) untuk menghindari prompt terlalu panjang.

---

### RD-07: Notifikasi Real-Time Pengaduan Urgensi Tinggi

**Deskripsi:** Saat ada pengaduan dengan urgensi "tinggi" masuk, admin tidak mendapat notifikasi khusus.

**Fitur Diusulkan:**
- Kirim notifikasi email/WhatsApp ke admin saat pengaduan urgensi "tinggi" terdeteksi.
- Implementasi: Event + Listener Laravel + Mail/WhatsApp API.
- Tampilkan badge merah berkedip di sidebar admin jika ada pengaduan tinggi yang belum ditinjau.

---

### RD-08: Fine-tuning Prompt dari Data Override

**Deskripsi:** Data `is_overridden = true` yang terakumulasi adalah aset berharga untuk meningkatkan kualitas prompt klasifikasi.

**Aktivitas Diusulkan:**
- Analisis rekord dengan `is_overridden = true` untuk menemukan pola: kategori mana yang sering salah diklasifikasi?
- Tambahkan contoh kasus nyata (few-shot examples) ke dalam prompt klasifikasi untuk kategori yang sering salah.
- Re-evaluasi akurasi setelah setiap perubahan prompt.

---

## Catatan Arsitektur untuk Pengembangan Selanjutnya

Jika proyek ini diteruskan, berikut adalah catatan arsitektur penting:

> [!IMPORTANT]
> **Pertimbangkan migrasi ke HTTP Server Python** (FastAPI) jika traffic chatbot melebihi 100 sesi concurrent per menit. Saat ini, model Process Executor menyebabkan N proses Python aktif secara bersamaan, yang bisa membebani server. Dengan FastAPI, Python berjalan sebagai satu server yang melayani banyak request secara asinkron.

> [!TIP]
> **Vector Embedding (RD-03) adalah upgrade terbesar yang bisa dilakukan.** Ini akan meningkatkan akurasi retrieval secara signifikan terutama untuk pertanyaan panjang atau menggunakan frasa tidak langsung.
