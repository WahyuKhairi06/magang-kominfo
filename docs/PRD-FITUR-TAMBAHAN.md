# Product Requirements Document (PRD)
## Modul AI Terpadu (Chatbot, Pengaturan Admin, dan Klasifikasi Pengaduan)

| Informasi Dokumen        |                                                   |
| :----------------------- | :------------------------------------------------ |
| **Nama Proyek**          | Sistem Informasi Puskesmas Marunggi — Fitur AI    |
| **Versi**                | 1.0.0                                             |
| **Tanggal**              | 17 Juli 2026                                      |
| **Status**               | Implemented & Verified                            |

---

## 1. Latar Belakang & Tujuan (Background & Objective)

Sistem Informasi Puskesmas Marunggi saat ini telah melayani penyampaian informasi dan publikasi kegiatan kepada masyarakat. Namun, terdapat tantangan dalam memberikan respon yang cepat dan tepat terhadap pertanyaan publik, serta proses pemilahan (triage) keluhan masyarakat yang masuk melalui website masih dilakukan secara manual yang memakan waktu.

**Tujuan dari pengembangan modul ini adalah:**
1. Menyediakan asisten virtual (AI Chatbot) yang selalu siaga 24/7 untuk menjawab pertanyaan masyarakat berdasarkan data resmi Puskesmas.
2. Memberikan kontrol penuh kepada Administrator untuk mengatur identitas dan tema antarmuka chatbot dengan mudah tanpa mengubah kode sumber.
3. Mempercepat proses penanganan pengaduan dengan mengklasifikasikan kategori dan tingkat urgensi aduan masyarakat secara otomatis menggunakan kecerdasan buatan.

---

## 2. Sasaran Pengguna (Target Users)

1. **Masyarakat Umum / Pengunjung Website**: Pengguna yang membutuhkan informasi layanan Puskesmas dengan cepat, atau ingin menyampaikan keluhan terkait layanan.
2. **Administrator Puskesmas**: Staf yang bertugas mengelola konten website, mengatur identitas chatbot, dan meninjau serta menindaklanjuti pengaduan yang masuk.

---

## 3. Ruang Lingkup (Scope)

Modul ini **hanya** mencakup pengembangan fitur kecerdasan buatan (AI) yang dibangun di atas sistem yang sudah ada. Ruang lingkupnya terbagi menjadi tiga modul utama:

### Modul A: AI Chatbot Publik
Asisten virtual cerdas yang dapat menjawab pertanyaan masyarakat. Chatbot ini tidak menggunakan pengetahuan umum di luar konteks puskesmas, melainkan "membaca" dari database website secara langsung (berita, profil, jadwal, layanan, dokumen, dsb).

### Modul B: Pengaturan AI Chatbot (Admin Panel)
Antarmuka bagi admin untuk menyesuaikan nama asisten AI, nama institusi, pesan sapaan awal, hingga warna tema chatbot agar sesuai dengan identitas instansi. 

### Modul C: Pengaduan Masyarakat & Klasifikasi Otomatis
Sistem penerimaan aduan publik di mana setiap aduan yang dikirim akan dipilah (triage) secara otomatis oleh AI ke dalam salah satu kategori spesifik dan diberikan tingkat urgensi (rendah, sedang, tinggi).

---

## 4. Persyaratan Fungsional (Functional Requirements)

### RF-01: AI Chatbot Publik
- **Tanya Jawab Kontekstual**: AI harus menjawab pertanyaan berdasarkan *knowledge base* dinamis yang diambil dari database aplikasi (berita, FAQ, halaman, inovasi).
- **Penolakan Konteks Luar**: AI harus menolak menjawab pertanyaan medis (diagnosis/resep) atau topik umum yang tidak terkait layanan puskesmas.
- **Multimodal (OCR)**: Chatbot dapat menjawab informasi yang terdapat di dalam gambar (misal jadwal poli) yang teksnya telah diekstrak sebelumnya oleh sistem.
- **Voice Chat**: Pengunjung dapat menekan tombol *microphone* untuk berbicara (Speech-to-Text) dan AI akan merespon dengan suara (Text-to-Speech).
- **Tautan Aksi**: Chatbot dapat menyertakan link berupa tombol yang mengarahkan pengunjung ke halaman yang relevan.

### RF-02: Pengaturan AI Chatbot (Admin)
- **Identitas**: Admin dapat mengubah "Nama AI" dan "Nama Puskesmas" (yang akan otomatis mensinkronkan instruksi/kepribadian AI).
- **Kustomisasi Visual**: Admin dapat memilih *preset* warna atau menentukan warna HEX sendiri untuk antarmuka chatbot.
- **Live Preview**: Tersedia simulator antarmuka *smartphone* di samping *form* pengaturan untuk melihat perubahan warna dan teks secara instan sebelum disimpan.
- **Toggle Layanan**: Admin dapat menonaktifkan sementara layanan chatbot (Status: *Inactive*).

### RF-03: Form Pengaduan Publik
- **Input Data**: Masyarakat dapat mengisi form pengaduan dengan atribut: Nama, No. HP, dan Isi Pengaduan.

### RF-04: Klasifikasi Pengaduan AI (Asinkron)
- **Automated Triage**: Saat pengaduan masuk, sistem akan mengirim *background job* untuk menganalisa teks keluhan menggunakan Gemini API.
- **Kategori & Urgensi**: AI harus mengelompokkan keluhan ke dalam tepat 1 dari 7 kategori (contoh: Pendaftaran, Fasilitas, Ketersediaan Obat) dan menentukan urgensi (Tinggi, Sedang, Rendah).
- **Sistem Cadangan (Fallback)**: Jika integrasi AI gagal (kuota API habis atau gangguan jaringan), sistem akan melakukan klasifikasi lokal sederhana berdasarkan pencocokan kata kunci.

### RF-05: Manajemen Pengaduan (Admin)
- **Dashboard Pengaduan**: Admin dapat melihat daftar pengaduan beserta "Lencana/Badge" visual hasil klasifikasi AI.
- **Detail & Override**: Admin dapat membaca alasan AI mengklasifikasikan aduan tersebut. Admin memiliki wewenang untuk mengubah (override) kategori dan urgensi jika dirasa tidak tepat, namun hasil tebakan asli AI tetap tersimpan sebagai *audit trail*.

---

## 5. Persyaratan Non-Fungsional (Non-Functional Requirements)

### RNF-01: Performa & Arsitektur
- Pemanggilan API untuk Klasifikasi Pengaduan harus dieksekusi di belakang layar (*background/queue job*) agar pengunjung tidak mengalami *loading* yang lama saat men-submit form aduan.
- Pemuatan (*loading*) halaman utama website tidak boleh melambat karena inisialisasi chatbot.

### RNF-02: Aksesibilitas
- **Kontras Dinamis (YIQ)**: Teks di atas warna utama chatbot harus secara otomatis menyesuaikan diri (putih atau hitam) tergantung seberapa terang atau gelap warna latar belakang yang dipilih oleh Admin, untuk menjamin keterbacaan (WCAG Compliance).

### RNF-03: Keamanan & Privasi
- Data sensitif seperti data *user* atau sesi *login* **tidak boleh** disertakan ke dalam ekstraksi *knowledge base* AI.
- Respons dari AI klasifikasi pengaduan harus diatur menggunakan skema (*responseSchema* JSON) yang ketat untuk menghindari kesalahan format atau halusinasi teks.

---

## 6. Antarmuka Pengguna & Interaksi (UI/UX)

1. **Widget Melayang**: Terdapat tombol ikon *chat* melayang (Floating Action Button) di kanan bawah layar yang bisa dibuka/tutup tanpa pindah halaman.
2. **Sinkronisasi Sesi**: Riwayat obrolan di widget melayang tidak boleh hilang jika pengunjung melakukan *refresh* atau pindah ke halaman lain (disimpan via `sessionStorage`).
3. **Chip Interaktif (Triage)**: Di halaman detail pengaduan admin, status kategori dan urgensi ditampilkan menggunakan "Chip" yang dapat diklik untuk diubah tanpa harus memuat ulang (*refresh*) halaman (AJAX).
4. **Indikator Voice Chat**: Saat pengunjung menggunakan mikrofon, tombol *mic* berubah warna merah (berkedip) untuk menandakan sedang merekam.

---

## 7. Kriteria Keberhasilan (Acceptance Criteria)

1. **Chatbot Akurasi**: Saat ditanya "Apa jadwal layanan puskesmas?", AI menjawab dengan benar sesuai data dari CMS, dan bukan menjawab dengan tebakan.
2. **Chatbot Pembatasan**: Saat ditanya "Obat apa untuk sakit kepala?", AI menolak menjawab dan menyarankan ke dokter, serta mengingatkan perannya sebagai asisten informasi.
3. **Admin Setting Sinkron**: Jika admin mengubah warna menjadi `#ff0000` (merah), widget chat publik langsung berubah merah dalam *refresh* berikutnya, dan warna teks di atasnya berubah jadi putih.
4. **Klasifikasi Otomatis**: Jika warga melapor "Toiletnya bau sekali", di panel admin keluhan tersebut otomatis mendapat tag kategori "Kebersihan & Fasilitas" dengan urgensi "Sedang/Rendah" tanpa campur tangan manusia.
5. **Fallback Aktif**: Jika kunci API AI rusak/dihapus secara sengaja untuk uji coba, dan ada laporan masuk, keluhan tetap diproses melalui klasifikasi berbasis kata kunci dan admin melihat notifikasi bahwa "Sistem menggunakan klasifikasi cadangan".

---

## 8. Asumsi & Ketergantungan (Assumptions & Dependencies)

- Proyek ini berjalan pada *environment* PHP 8.2 (Laravel 12) dan Python 3.10+.
- Membutuhkan layanan **Google Gemini API** (`gemini-2.5-flash`) yang aktif.
- Membutuhkan proses `php artisan queue:work` yang berjalan terus-menerus (*daemon*) di server untuk menangani klasifikasi pengaduan secara otomatis.
- Browser pengunjung mendukung *Web Speech API* untuk fitur Voice Chat. Jika tidak, fitur mikrofon otomatis disembunyikan.
