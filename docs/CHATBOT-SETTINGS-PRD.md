# Product Requirement Document (PRD)
## Modul Setting AI Chatbot — Puskesmas Marunggi

| Informasi Dokumen | |
| :--- | :--- |
| **Nama Proyek** | Modul Setting AI Chatbot |
| **Versi** | 1.0.0 |
| **Tanggal Pembuatan** | 14 Juli 2026 |
| **Status** | Approved & Implemented |

---

## 1. Latar Belakang & Tujuan (Background & Objective)
Puskesmas Marunggi memiliki asisten virtual berbasis kecerdasan buatan (Google Gemini API) untuk melayani tanya jawab masyarakat mengenai informasi layanan kesehatan. Sebelumnya, identitas chatbot (seperti nama bot, nama puskesmas) dan tema visual (seperti warna primer) bersifat statis (*hardcoded* di dalam kode program).

Tujuan dari modul ini adalah **memberikan kontrol penuh kepada Administrator** untuk mengonfigurasi identitas chatbot, menyinkronkan kepribadian kecerdasan buatan AI, serta mengubah tampilan warna antarmuka chatbot secara instan langsung melalui Panel Admin tanpa memerlukan intervensi tim pengembang atau memodifikasi kode sumber.

---

## 2. Sasaran Pengguna (Target Users)
- **Administrator Puskesmas**: Pengguna yang bertanggung jawab mengelola situs web resmi, memperbarui informasi instansi, serta menyesuaikan identitas visual chatbot agar selaras dengan promosi layanan puskesmas saat ini.
- **Pengunjung/Masyarakat Umum**: Pengguna akhir (*end-user*) yang berinteraksi dengan chatbot dan menikmati tampilan antarmuka obrolan yang konsisten, responsif, kontras, serta representatif dengan nama instansi resmi.

---

## 3. Persyaratan Fungsional (Functional Requirements)

### RF-01: Manajemen Identitas Chatbot
- Admin dapat mengubah **Nama AI** (Virtual Assistant). Contoh: *"Asisten Puskesmas"*, *"Si-Peka AI"*.
- Admin dapat mengubah **Nama Puskesmas** yang disinkronkan ke dalam sistem instruksi (*system instructions*) AI Gemini.
- Admin dapat mengubah **Pesan Sambutan (Greeting)** awal yang muncul pertama kali saat halaman chat dibuka.

### RF-02: Manajemen Visual & Tema Warna
- Admin dapat memilih salah satu **Template Warna (Preset)** yang telah disiapkan:
  - Hijau Puskesmas (`#1e6b4d`)
  - Merah (`#ef4444`)
  - Biru (`#3b82f6`)
  - Ungu (`#8b5cf6`)
  - Oranye (`#f97316`)
- Admin dapat memasukkan warna kustom secara manual melalui tombol **Color Picker** atau dengan **mengetikkan Kode HEX** (misal: `#000000` s.d `#ffffff`).
- Warna manual, tombol picker, dan pilihan template harus **sinkron secara dua arah** (*two-way binding*).

### RF-03: Validasi Format HEX Real-time
- Sistem harus memvalidasi format warna HEX secara langsung (*real-time*).
- Jika format valid (contoh: `#1e6b4d`): Menampilkan lencana hijau bertuliskan **"Format Warna Valid: [Pratinjau Bulatan Warna]"**.
- Jika format tidak valid: Menampilkan lencana merah bertuliskan **"Format warna tidak valid"** dan mencegah submit form jika data tidak sesuai.

### RF-04: Kontrol Status Keaktifan Chatbot
- Admin dapat mengatur status chatbot: **Aktif** atau **Nonaktif** (untuk pemeliharaan).
- Jika status **Nonaktif**, halaman chatbot pengunjung diblokir dan menampilkan pesan pemeliharaan yang ramah.

### RF-05: Live Preview Simulator
- Halaman panel pengaturan admin harus memiliki simulator berupa **mockup handphone (Live Preview)** di sisi kanan form.
- Setiap perubahan pada isian form (Nama AI, Nama Puskesmas, Pesan Sambutan, Warna Tema, Status Aktif) harus langsung ter-update di simulator secara instan tanpa memuat ulang halaman (*real-time preview*).

---

## 4. Persyaratan Non-Fungsional (Non-Functional Requirements)

### RNF-01: Kontras Warna & Aksesibilitas (WCAG Compliance)
- Untuk menjamin aksesibilitas bagi semua pengguna (termasuk penderita gangguan penglihatan), sistem harus menghitung kontras warna teks di atas warna latar belakang utama secara dinamis menggunakan rumus tingkat kecerahan YIQ.
- Jika warna utama yang dipilih terang (Luminance YIQ $\ge$ 128), teks di atasnya harus otomatis berwarna gelap (`#0f172a`).
- Jika warna utama yang dipilih gelap (Luminance YIQ $<$ 128), teks di atasnya harus otomatis berwarna putih (`#ffffff`).

### RNF-02: Sinkronisasi Kepribadian AI
- Nama AI dan Nama Puskesmas yang diubah di panel admin harus disuplai sebagai parameter kontekstual ke dalam prompt system AI Python (`prompt.py`). AI harus menjawab dengan identitas yang sesuai dengan pengaturan admin (bukan data statis).

---

## 5. Antarmuka Pengguna & Interaksi (User Interface Requirements)
- **Menu Navigasi Admin**: Terdapat menu tambahan **"Setting AI Chatbot"** di bagian sidebar kiri admin panel.
- **Form Kiri**: Form masukan input data identitas, template warna, input warna manual, validasi warna, dan status keaktifan chatbot.
- **Mockup Kanan**: Tampilan visual handphone mini yang mensimulasikan ruang obrolan pengunjung, merefleksikan perubahan warna, nama bot, nama puskesmas, dan warna teks secara dinamis.

---

## 6. Kriteria Keberimaan (Acceptance Criteria)

1. **Pengaturan Tersimpan**: Ketika admin mengklik tombol "Simpan Pengaturan", data berhasil disimpan ke tabel database `chatbot_settings` baris pertama.
2. **Sinkronisasi Web Pengunjung**: Membuka `/chat` setelah mengubah pengaturan di admin langsung menampilkan warna tema baru di header, tombol kirim, dan balon pesan, tanpa ada bagian hijau statis yang tertinggal.
3. **Keakuratan Respon AI**: Saat pengguna bertanya *"Kamu siapa?"* atau *"Ini puskesmas apa?"*, AI Gemini membalas secara konsisten dengan Nama AI dan Nama Puskesmas yang diatur terakhir kali oleh admin.
4. **Kontras Berfungsi**: Saat memilih warna tema kuning terang (`#ffff00`), teks di header obrolan dan balon pesan secara otomatis berwarna gelap (hitam) dan tetap mudah dibaca.
