# Keputusan Desain Teknis (Design Decisions)

> Dokumen ini menjelaskan **mengapa** desain sistem ini dibuat seperti yang ada, bukan **apa** yang dibangun.
> Untuk penjelasan **apa** yang dibangun, lihat dokumen PRD masing-masing modul.
>
> Referensi silang: [`PROJECT_OVERVIEW.md`](./PROJECT_OVERVIEW.md)

---

## DD-01: Arsitektur Process Executor (bukan HTTP API Server)

**Keputusan:** Laravel memanggil Python menggunakan `Symfony\Component\Process` (spawn subprocess), bukan melalui HTTP REST API ke server Python yang selalu aktif (FastAPI/Flask).

**Alasan:**
1. **Kesederhanaan Operasional:** Tidak perlu mengelola proses server Python yang terpisah (port, systemd, PM2). Di environment hosting shared atau Laragon/XAMPP lokal, memiliki server yang selalu hidup membutuhkan konfigurasi tambahan yang signifikan.
2. **Tidak Ada SPOF Tambahan:** Server Python yang selalu aktif menjadi *Single Point of Failure* baru — jika server Python mati, chatbot mati. Dengan Process executor, Laravel hanya butuh Python terinstall di sistem.
3. **Isolasi yang Bersih:** Setiap permintaan chatbot menjalankan Python baru dari nol, memastikan tidak ada state yang bocor antar sesi.

**Trade-off:**
- **Cold start overhead (~1-2 detik):** Setiap percakapan harus me-load semua library Python dari nol. Ini diterima karena percakapan chatbot tidak membutuhkan latensi sub-detik.
- **Tidak mendukung concurrent rate-limiting di Python:** Jika 100 pengguna chat secara bersamaan, 100 proses Python akan dijalankan. Ini bisa diselesaikan dengan menambahkan throttling di Laravel jika dibutuhkan.

---

## DD-02: Pre-extraction OCR (bukan Real-time Multimodal)

**Keputusan:** OCR gambar dilakukan **satu kali saat upload**, bukan setiap kali chatbot mendapat pertanyaan.

**Alasan:**
1. **Biaya Token:** Gambar berukuran sedang (~500KB) dapat menghabiskan 200-800 token per image di Gemini Vision. Jika dikirim di setiap percakapan, biaya akan meledak seiring jumlah pengguna chatbot.
2. **Latensi:** Mengirim gambar ke Gemini API menambah ~2-4 detik latensi per gambar. Dengan pre-extraction, latensi ini tidak ada saat pengguna chat.
3. **Akurasi Sama:** Hasil OCR pre-extracted sama akuratnya dengan real-time karena gambar tidak berubah setelah diupload admin.

**Trade-off:**
- Jika admin **mengedit gambar yang sudah di-upload** (mengganti file di folder yang sama), kolom `isi_ocr` perlu di-refresh secara manual dengan mengupdate ulang halaman di CMS. Ini adalah edge case yang jarang terjadi.

---

## DD-03: Retrieval Berbasis Keyword (bukan Embedding Vector)

**Keputusan:** Konteks relevan diambil menggunakan **keyword overlap scoring** sederhana, bukan menggunakan vector embedding dan cosine similarity.

**Alasan:**
1. **Tidak Membutuhkan Database Vektor:** Menggunakan embedding membutuhkan database seperti Pinecone, Weaviate, atau Chroma yang perlu dikelola. Ini menambah kompleksitas infrastruktur yang tidak sebanding untuk skala Puskesmas.
2. **Tidak Membutuhkan API Embedding Terpisah:** Membuat embedding membutuhkan panggilan API tambahan (OpenAI Embeddings, Google Embeddings), menambah latensi dan biaya per percakapan.
3. **Cukup untuk Domain Terbatas:** Knowledge base chatbot ini bersifat domain-specific (hanya tentang Puskesmas). Keyword retrieval sudah cukup akurat karena terminologi domain ini terbatas dan spesifik (nama layanan, nama poli, jenis dokumen, dll.).

**Trade-off:**
- Kurang akurat untuk pertanyaan yang semantiknya berbeda dari keyword literal. Contoh: "kapan bisa periksa kandungan?" mungkin tidak cocok dengan chunk yang berisi "Jadwal Poli KIA (Kesehatan Ibu dan Anak)" jika kata "kandungan" dan "KIA" tidak overlap.
- Untuk skala yang lebih besar atau pertanyaan yang lebih semantik, upgrade ke vector embedding sangat direkomendasikan. Lihat [`ROADMAP.md`](./ROADMAP.md).

---

## DD-04: Structured JSON Output untuk Klasifikasi Pengaduan

**Keputusan:** Klasifikasi pengaduan menggunakan `responseMimeType: "application/json"` dan `responseSchema` yang ketat di Gemini API, bukan parsing teks bebas.

**Alasan:**
1. **Validasi Otomatis:** Gemini dipaksa hanya mengembalikan nilai yang valid dari enum yang didefinisikan. Tidak mungkin AI mengembalikan kategori "Lain-lain" alih-alih "Lainnya", atau kategori yang tidak ada dalam daftar.
2. **Tidak Perlu Regex:** Tanpa structured output, harus ada kode regex atau string matching yang rapuh untuk mengekstrak kategori dari teks bebas. Structured output menghilangkan kebutuhan ini sepenuhnya.
3. **Konsistensi:** Setiap respons selalu memiliki field `kategori`, `urgensi`, dan `alasan` — tidak pernah ada field yang hilang atau format yang tidak terduga.

---

## DD-05: Fallback Classifier Lokal untuk Pengaduan

**Keputusan:** Jika Gemini API gagal, sistem tidak membiarkan pengaduan dengan `status_klasifikasi = 'gagal'` yang permanen. Sebaliknya, dijalankan keyword classifier lokal berbasis PHP murni.

**Alasan:**
1. **Keandalan Layanan:** Staff Puskesmas tetap mendapatkan estimasi kategori meskipun AI sedang down. Ini lebih baik daripada pengaduan yang terus-menerus "pending" tanpa hasil.
2. **Pengalaman Admin yang Baik:** Admin melihat pengaduan dengan kategori (meskipun dari fallback), bukan pengaduan kosong yang membingungkan.
3. **Transparansi:** Kolom `alasan_ai` menjelaskan bahwa klasifikasi dilakukan oleh sistem cadangan ("Klasifikasi lokal otomatis (kuota API habis)"), sehingga admin tahu akurasi bisa lebih rendah dari biasanya.

---

## DD-06: Single Source of Truth untuk Taksonomi Pengaduan

**Keputusan:** Semua definisi kategori dan urgensi didefinisikan di **satu tempat**: `ai-service/taxonomy.py`.

**Alasan:**
1. **Mencegah Inkonsistensi:** Tanpa SSoT, kategori bisa berbeda antara database (migration enum), frontend (blade view chip), dan backend AI (prompt). Ketidaksesuaian ini akan menyebabkan bug yang sulit di-debug.
2. **Single Point of Change:** Jika ingin menambah kategori baru (misalnya "Farmasi & Obat"), cukup ubah satu file, lalu ikuti checklist sinkronisasi yang terdokumentasi.
3. **Dipaksakan melalui Kode:** `CATEGORIES` di `taxonomy.py` digunakan langsung di `CLASSIFICATION_SCHEMA` untuk `responseSchema` Gemini, sehingga taksonomi di database selalu sinkron dengan taksonomi yang dikenali AI.

---

## DD-07: Prompt Engineering — Bahasa Indonesia sebagai Default

**Keputusan:** Seluruh system instruction dan prompt ditulis dalam Bahasa Indonesia.

**Alasan:**
1. **Target Pengguna:** Masyarakat Indonesia yang berinteraksi dengan chatbot menggunakan Bahasa Indonesia, termasuk dialek lokal atau bahasa campuran (Indonesia-Minang).
2. **Akurasi Konteks Lokal:** Gemini sudah sangat baik dalam Bahasa Indonesia. Menulis prompt dalam Bahasa Indonesia membantu AI memahami nuansa lokal dengan lebih baik.
3. **Konsistensi Output:** Instruksi "Gunakan Bahasa Indonesia" di dalam system instruction dalam Bahasa Indonesia sendiri memperkuat konsistensi.

---

## DD-08: `firstOrCreate` untuk Inisialisasi Pengaturan

**Keputusan:** `ChatbotSettingController` dan `PuskesmasSettingController` menggunakan `Model::firstOrCreate()` alih-alih seeder database.

**Alasan:**
1. **Idempoten:** Method ini aman dipanggil berulang kali. Jika record sudah ada, tidak ada yang berubah. Ini berbeda dengan seeder yang bisa error jika dijalankan dua kali tanpa `--force`.
2. **Self-healing:** Jika record terhapus secara tidak sengaja, membuka halaman pengaturan akan langsung membuatnya kembali dengan nilai default yang benar.
3. **Tidak Perlu `php artisan db:seed`:** Pengguna baru yang melakukan setup hanya perlu `php artisan migrate`, tanpa harus ingat menjalankan seeder tambahan.

---

## DD-09: Penolakan Data Sensitif di Endpoint Chatbot

**Keputusan:** ChatbotController tidak menerima parameter selain `message` dari pengguna.

**Alasan:**
1. **Attack Surface Minimal:** Membatasi parameter yang diterima mengurangi permukaan serangan. Tidak ada parameter tersembunyi yang bisa dimanipulasi untuk mengubah perilaku AI.
2. **Konsistensi:** Identitas AI (nama, nama puskesmas) selalu dibaca dari database yang dikelola admin, tidak bisa dimanipulasi oleh pengguna melalui request HTTP.

---

## DD-10: Timeout 60 Detik untuk Proses Python

**Keputusan:** Timeout Symfony Process untuk chatbot ditetapkan pada 60 detik.

**Alasan:**
1. **Cold Start:** Proses Python perlu load library (google-genai, dll.) dari disk, yang bisa memakan 1-3 detik di server dengan I/O lambat.
2. **Variabilitas Gemini API:** Latensi Gemini API bisa bervariasi dari 1 detik hingga 15+ detik tergantung panjang prompt dan load server Google.
3. **Buffer Keamanan:** 60 detik memberikan buffer yang cukup untuk menangani kasus terburuk tanpa terlalu lama membuat pengguna menunggu. Timeout yang terlalu pendek (misal 10 detik) bisa menyebabkan false failure.

---

## DD-11: Kolom `is_overridden` sebagai Flag Audit

**Keputusan:** Override admin pada kategori/urgensi pengaduan tidak menimpa nilai AI asli (`kategori_ai`, `urgensi_ai`), tetapi menyimpannya terpisah dan men-set flag `is_overridden = true`.

**Alasan:**
1. **Audit Trail:** Tim manajemen bisa menganalisis seberapa sering admin setuju/tidak setuju dengan AI, yang berguna untuk evaluasi kinerja model dan peningkatan prompt.
2. **Akuntabilitas:** Catatan `reviewed_by` dan `reviewed_at` mencatat siapa dan kapan override dilakukan.
3. **Umpan Balik Kualitas:** Data ini bisa digunakan untuk fine-tuning prompt di masa depan — pengaduan yang sering di-override adalah sinyal bahwa AI perlu instruksi yang lebih baik untuk kategori tersebut.
