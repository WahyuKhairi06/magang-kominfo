# 🏥 Sistem Informasi Website Puskesmas (Multi-Puskesmas & AI Triage/Chatbot)

Sistem Informasi Website Puskesmas merupakan portal informasi layanan kesehatan terpadu yang dilengkapi dengan asisten virtual kecerdasan buatan (AI) serta sistem manajemen internal PKK & Dasawisma. 

Website ini dirancang menggunakan konsep **Single Codebase**, sehingga satu basis kode yang sama dapat diduplikasi dan digunakan oleh 9 puskesmas berbeda secara mandiri hanya dengan menyesuaikan konfigurasi identitas melalui Admin Panel.

---

## 📖 Fitur Utama
git 
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
*   **Frontend Engine:** HTML5, Alpine.js, Tailwind CSS, Vite, Vanilla CSS
*   **Database:** MySQL 
*   **LLM API:** Google Gemini API (`gemini-2.5-flash`)

---

## 📁 Struktur Utama Proyek

```
sitariktageh/
│
├── ai-service/                   # Modul AI berbasis Python
│   ├── knowledge/                
│   │   ├── database_knowledge.json  # Sinkronisasi basis data dinamis Laravel
│   │   └── puskesmas.json        # Knowledge base awal (statis)
│   ├── chat_api.py               # Pemroses CLI chatbot asisten
│   └── requirements.txt          # Dependensi library Python
│
├── app/
│   ├── Http/Controllers/
│   │   ├── ChatbotController.php # Controller chatbot asisten
│   │   └── Admin/
│   │       ├── PuskesmasSettingController.php # Pengaturan identitas dinamis
│   │       ├── ChatbotSettingController.php   # Pengaturan widget chatbot
│   │       └── PengaduanController.php        # Triage aduan admin
│   ├── Jobs/
│   │   └── ClassifyPengaduanJob.php           # Job asinkron klasifikasi Gemini
│   └── Models/
│       ├── PuskesmasSetting.php
│       ├── ChatbotSetting.php
│       └── Pengaduan.php
│
├── docs/                         # Berkas dokumentasi lengkap fitur
│   ├── DOKUMENTASI-PENGATURAN-DINAMIS-PUSKESMAS.md # Dokumentasi multi-puskesmas
│   ├── DOKUMENTASI-KLASIFIKASI-PENGADUAN.md       # Dokumentasi triage pengaduan
│   └── DOKUMENTASI-SISTEM-LENGKAP.md              # Dokumentasi arsitektur sistem
│
├── resources/views/              # Tampilan layout Blade Laravel
│
└── .env                          # Konfigurasi kunci API dan database
```

---

## ⚙️ Petunjuk Instalasi & Menjalankan Aplikasi

1.  **Clone Repository:**
    ```bash
    git clone https://github.com/WahyuKhairi06/magang-kominfo.git
    cd magang-kominfo
    ```
2.  **Instalasi Dependensi Laravel:**
    ```bash
    composer install
    npm install
    ```
3.  **Setup Environment File:**
    Salin file `.env.example` menjadi `.env` dan konfigurasikan koneksi database MySQL Anda.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
4.  **Konfigurasi API Key Gemini:**
    Tambahkan token Gemini API resmi Anda pada file `.env` di direktori root dan folder `ai-service/`:
    ```env
    # Di file .env root Laravel
    GEMINI_API_KEY=YOUR_GEMINI_API_KEY
    QUEUE_CONNECTION=database

    # Di file ai-service/.env
    GEMINI_API_KEY=YOUR_GEMINI_API_KEY
    GEMINI_MODEL=gemini-2.5-flash
    ```
5.  **Migrasi Database:**
    ```bash
    php artisan migrate
    ```
6.  **Instalasi Dependensi Python (Modul AI):**
    ```bash
    cd ai-service
    pip install -r requirements.txt
    cd ..
    ```
7.  **Menjalankan Server Pengembangan Lokal:**
    Jalankan tiga perintah berikut di terminal/tab terpisah:
    *   **Server Web Laravel:**
        ```bash
        php artisan serve
        ```
    *   **Vite Compiler:**
        ```bash
        npm run dev
        ```
    *   **Queue Worker (Penting untuk memproses Klasifikasi AI):**
        ```bash
        php artisan queue:work
        ```
    Website dapat diakses di browser melalui tautan `http://127.0.0.1:8000`.

---

## 👨‍💻 Pengembang

**Wahyu Khairi**
Praktik Kerja Lapangan (PKL)
Dinas Komunikasi dan Informatika Kota Pariaman

© 2026 Puskesmas - Dinas Kesehatan Kota Pariaman.
