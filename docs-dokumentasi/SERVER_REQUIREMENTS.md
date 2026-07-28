# 🖥️ Server Requirements & Deployment Guide
**Sitariktageh — Sistem Informasi Kesehatan Puskesmas Marunggi Kota Pariaman**

> Dokumen ini menjelaskan semua kebutuhan server, arsitektur infrastruktur, dan langkah-langkah
> lengkap untuk men-deploy project ini ke hosting atau VPS.
>
> Referensi silang: [`PROJECT_OVERVIEW.md`](./PROJECT_OVERVIEW.md) · [`DESIGN_DECISIONS.md`](./DESIGN_DECISIONS.md)

---

## Daftar Isi

1. [Arsitektur Sistem](#1-arsitektur-sistem)
2. [Spesifikasi Server](#2-spesifikasi-server)
3. [Software yang Dibutuhkan](#3-software-yang-dibutuhkan)
4. [PHP Extensions yang Wajib Ada](#4-php-extensions-yang-wajib-ada)
5. [Python Packages (AI Service)](#5-python-packages-ai-service)
6. [Konfigurasi Database](#6-konfigurasi-database)
7. [Variabel Environment (.env)](#7-variabel-environment-env)
8. [Struktur File & Direktori](#8-struktur-file--direktori)
9. [Langkah Deploy ke VPS / Server](#9-langkah-deploy-ke-vps--server)
10. [Konfigurasi Web Server (Nginx)](#10-konfigurasi-web-server-nginx)
11. [Menjalankan Queue Worker & Scheduler](#11-menjalankan-queue-worker--scheduler)
12. [Setup SSL / HTTPS](#12-setup-ssl--https)
13. [Shared Hosting (Alternatif VPS)](#13-shared-hosting-alternatif-vps)
14. [Checklist Pre-Launch](#14-checklist-pre-launch)
15. [Troubleshooting Umum](#15-troubleshooting-umum)

---

## 1. Arsitektur Sistem

Project ini terdiri dari **dua runtime yang berjalan secara bersamaan** di satu server:

```
┌──────────────────────────────────────────────────────────────────────────────┐
│                            SERVER PRODUCTION                                  │
│                                                                              │
│  ┌─────────────────────────────────┐   ┌──────────────────────────────────┐  │
│  │        LARAVEL (PHP 8.3+)       │   │    AI SERVICE (Python 3.11+)     │  │
│  │                                 │   │                                  │  │
│  │  Port: 80/443 (via Nginx)       │   │  Dipanggil Laravel via:          │  │
│  │                                 │   │  • proc_open (chat_api.py)       │  │
│  │  ┌─────────────────────────┐    │   │  • proc_open (extract_ocr.py)    │  │
│  │  │   PHP-FPM / FrankenPHP  │    │   │                                  │  │
│  │  │   Web Application       │    │   └──────────────────────────────────┘  │
│  │  └─────────────────────────┘    │                    │                     │
│  │                                 │                    │                     │
│  │  ┌─────────────────────────┐    │                    │                     │
│  │  │   Queue Worker          │    │                    │                     │
│  │  │   (php artisan queue:   │    │                    │                     │
│  │  │    work)                │    │                    │                     │
│  │  └─────────────────────────┘    │                    │                     │
│  │                                 │                    │                     │
│  │  ┌─────────────────────────┐    │                    │                     │
│  │  │   Scheduler (Cron)      │    │                    │                     │
│  │  │   (php artisan          │    │                    ▼                     │
│  │  │    schedule:run)        │    │   ┌──────────────────────────────────┐  │
│  │  └─────────────────────────┘    │   │       GOOGLE GEMINI API          │  │
│  └─────────────────────────────────┘   │   Model: gemini-2.5-flash        │  │
│                   │                    └──────────────────────────────────┘  │
│                   ▼                                                           │
│  ┌─────────────────────────────────┐                                         │
│  │         MySQL 8.0               │                                         │
│  │         Database Server         │                                         │
│  └─────────────────────────────────┘                                         │
└──────────────────────────────────────────────────────────────────────────────┘
                   │
                   │ Reverse Proxy (HTTPS)
                   ▼
┌──────────────────────────────────────────────────────────────────────────────┐
│                          NGINX (Web Server)                                   │
│  • Reverse proxy ke PHP-FPM                                                  │
│  • Serve static assets (CSS, JS, gambar)                                     │
│  • SSL termination (Let's Encrypt)                                            │
└──────────────────────────────────────────────────────────────────────────────┘
```

### Alur Chatbot (proc_open — tidak butuh server Python aktif)

```
User chat di website
        │
        ▼
ChatbotController::send()
  ├─ generateDatabaseKnowledge()   ← Query 9+ tabel → tulis JSON ke disk
  └─ AiProcessService::createProcess() ← Spawn: python chat_api.py "pesan" "nama_ai" "nama_puskesmas"
                                           │
                                           ▼
                                   chat_api.py → main.py
                                     ├─ load JSON knowledge base
                                     ├─ keyword retrieval (Top-K chunks)
                                     ├─ build_prompt()
                                     └─ ask_gemini() → Google Gemini API
                                           │
                                           ▼
                                   Output: JSON {"status":"success","answer":"..."}
                                           │
                                           ▼
                                   Laravel parse → HTML → Browser
```

### Alur Klasifikasi Pengaduan (Queue + HTTP)

```
Warga submit pengaduan
        │
        ▼
LandingpageController::pengaduanStore()
  └─ ClassifyPengaduanJob::dispatch()    ← Masuk queue database
                  │
                  ▼ (diproses oleh queue:work)
        ClassifyPengaduanJob::handle()
          ├─ Build prompt klasifikasi
          ├─ HTTP POST → Gemini REST API (structured JSON output)
          │     ├─ responseMimeType: application/json
          │     └─ responseSchema: {kategori, urgensi, alasan}
          ├─ UPDATE pengaduans SET kategori_ai, urgensi_ai, alasan_ai
          └─ Fallback: localKeywordClassify() jika Gemini gagal
```

---

## 2. Spesifikasi Server

### Minimum (untuk testing / staging)

| Komponen | Spesifikasi |
|----------|------------|
| **CPU** | 2 vCPU (x86_64) |
| **RAM** | 2 GB |
| **Storage** | 20 GB SSD |
| **OS** | Ubuntu 22.04 LTS |
| **Bandwidth** | 1 TB/bulan |
| **Koneksi Internet** | Wajib (untuk Gemini API) |

### Rekomendasi (production)

| Komponen | Spesifikasi |
|----------|------------|
| **CPU** | 4 vCPU |
| **RAM** | 4 GB |
| **Storage** | 40 GB SSD |
| **OS** | Ubuntu 24.04 LTS |
| **Bandwidth** | Tidak terbatas / 10 TB/bulan |
| **Koneksi Internet** | Stabil, < 50ms latency ke Google API |

> **Catatan:** RAM 4 GB sangat direkomendasikan karena proses `python chat_api.py` di-spawn per-request. Pada trafik tinggi (>10 request concurrent), setiap proses Python membutuhkan ~100-150 MB RAM.

### Contoh Hosting / Cloud yang Kompatibel

| Provider | Tier | Cocok? |
|----------|------|--------|
| DigitalOcean Droplet | Basic 2GB | ✅ (minimum) |
| DigitalOcean Droplet | Basic 4GB | ✅ (rekomendasi) |
| Vultr Cloud Compute | 2 CPU 4GB | ✅ |
| Contabo VPS S | 4 CPU 8GB | ✅ |
| Niagahoster VPS | Starter | ✅ |
| IDCloudHost VPS | Medium | ✅ |
| Shared Hosting (cPanel) | — | ⚠️ Terbatas (lihat [§13](#13-shared-hosting-alternatif-vps)) |

---

## 3. Software yang Dibutuhkan

### Wajib Ada di Server

```bash
# Update sistem
sudo apt update && sudo apt upgrade -y

# Tools dasar
sudo apt install -y curl wget git unzip zip

# ─────────────────────────────────────────────────────
# PHP 8.3 + PHP-FPM
# ─────────────────────────────────────────────────────
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.3 php8.3-fpm php8.3-cli \
    php8.3-mysql php8.3-sqlite3 php8.3-mbstring \
    php8.3-xml php8.3-curl php8.3-zip php8.3-gd \
    php8.3-bcmath php8.3-intl php8.3-opcache \
    php8.3-pcntl php8.3-exif

# Verifikasi
php -v
# PHP 8.3.x (cli)

# ─────────────────────────────────────────────────────
# Composer 2
# ─────────────────────────────────────────────────────
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version
# Composer version 2.x.x

# ─────────────────────────────────────────────────────
# Node.js 20 + npm (untuk build frontend assets)
# ─────────────────────────────────────────────────────
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
node -v   # v20.x.x
npm -v    # 10.x.x

# ─────────────────────────────────────────────────────
# MySQL 8.0
# ─────────────────────────────────────────────────────
sudo apt install -y mysql-server
sudo mysql_secure_installation

# ─────────────────────────────────────────────────────
# Nginx
# ─────────────────────────────────────────────────────
sudo apt install -y nginx

# ─────────────────────────────────────────────────────
# Python 3.11+ + pip + venv
# ─────────────────────────────────────────────────────
sudo apt install -y python3 python3-pip python3-venv

# Verifikasi (harus >= 3.11)
python3 --version
# Python 3.11.x atau 3.12.x

# ─────────────────────────────────────────────────────
# Supervisor (process manager untuk queue & AI service)
# ─────────────────────────────────────────────────────
sudo apt install -y supervisor
```

---

## 4. PHP Extensions yang Wajib Ada

Semua extension ini **wajib aktif** agar aplikasi berjalan dengan benar:

| Extension | Paket Ubuntu | Kegunaan dalam Project |
|-----------|-------------|----------------------|
| `pdo_mysql` | `php8.3-mysql` | Koneksi ke MySQL database |
| `pdo_sqlite` | `php8.3-sqlite3` | Fallback testing / SQLite |
| `mbstring` | `php8.3-mbstring` | Multi-byte string (teks bahasa Indonesia, UTF-8) |
| `gd` | `php8.3-gd` | Generate QR Code (`simplesoftwareio/simple-qrcode`) |
| `zip` | `php8.3-zip` | Ekstrak / kompres file, Composer |
| `bcmath` | `php8.3-bcmath` | Pemrosesan matematis presisi |
| `intl` | `php8.3-intl` | Internasionalisasi lokalisasi |
| `opcache` | `php8.3-opcache` | Caching bytecode PHP |
| `exif` | `php8.3-exif` | Membaca metadata gambar |
| `pcntl` | `php8.3-pcntl` | Process control queue worker |

---

## 5. Python Packages (AI Service)

File: `ai-service/requirements.txt`

```
google-genai>=0.3.0
python-dotenv>=1.0.1
rich>=13.7.1
```

> **Info Penting:** Di lingkungan production server, FastAPI (`fastapi`, `uvicorn`, `pydantic`) tidak perlu dijalankan. Hanya SDK utama `google-genai` yang dibutuhkan oleh CLI subprocess (`chat_api.py` dan `extract_ocr.py`).

---

## 6. Konfigurasi Database

### Buat Database & User MySQL

```sql
CREATE DATABASE sitariktageh CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'sitarik_user'@'localhost' IDENTIFIED BY 'password_aman_anda';
GRANT ALL PRIVILEGES ON sitariktageh.* TO 'sitarik_user'@'localhost';
FLUSH PRIVILEGES;
```

---

## 7. Variabel Environment (.env)

### A. `/.env` (Laravel Root — Wajib)

```env
APP_NAME="Sitariktageh – Puskesmas Marunggi"
APP_ENV=production
APP_KEY=                     # ← Jalankan php artisan key:generate
APP_DEBUG=false              # ← Wajib false di production
APP_URL=https://domain-anda.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sitariktageh
DB_USERNAME=sitarik_user
DB_PASSWORD=password_aman_anda

SESSION_DRIVER=database
SESSION_LIFETIME=120
QUEUE_CONNECTION=database    # ← WAJIB database agar ClassifyPengaduanJob berjalan
CACHE_STORE=database

PYTHON_EXECUTABLE=/var/www/sitariktageh/ai-service/venv/bin/python
GEMINI_API_KEY=AIzaSy...
```

### B. `/ai-service/.env` (Python AI Service — Wajib)

```env
GEMINI_API_KEY=AIzaSy...
GEMINI_MODEL=gemini-2.5-flash
```

---

## 8. Struktur File & Direktori

```
/var/www/sitariktageh/           ← root project
│
├── .env                          ← Konfigurasi Laravel
├── artisan                       ← CLI Laravel
│
├── ai-service/                   ← Python AI Service
│   ├── .env                      ← Konfigurasi Python
│   ├── requirements.txt          ← Python dependencies
│   ├── venv/                     ← Virtual environment
│   ├── chat_api.py               ← Entry point CLI chatbot (dipanggil proc_open)
│   ├── extract_ocr.py            ← CLI OCR gambar (dipanggil proc_open)
│   └── knowledge/
│       └── database_knowledge.json  ← Di-generate otomatis Laravel saat chat
│
└── public/                       ← Document root Nginx (bukan root project!)
```

---

## 9. Langkah Deploy ke VPS / Server

```bash
# 1. Clone repo
cd /var/www && git clone https://github.com/username/sitariktageh.git && cd sitariktageh

# 2. Install PHP deps
composer install --no-dev --optimize-autoloader --no-interaction

# 3. Setup .env & DB migrations
cp .env.example .env && php artisan key:generate
php artisan migrate --force

# 4. Setup Python Venv
cd ai-service && python3 -m venv venv && source venv/bin/activate
pip install -r requirements.txt
cp ".env example" .env # Isi api key

# 5. Build Assets & Optimize Cache
cd ..
npm ci --ignore-scripts && npm run build
php artisan optimize && php artisan storage:link

# 6. Permissions
sudo chown -R www-data:www-data /var/www/sitariktageh
sudo chmod -R 775 storage bootstrap/cache ai-service/knowledge
```

---

## 10. Konfigurasi Web Server (Nginx)

```nginx
server {
    listen 80;
    server_name domain-anda.com;
    root /var/www/sitariktageh/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_read_timeout 90;
    }
}
```

---

## 11. Menjalankan Queue Worker & Scheduler

Buat file konfigurasi Supervisor:
```bash
sudo nano /etc/supervisor/conf.d/sitariktageh.conf
```

```ini
[program:sitariktageh-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/sitariktageh/artisan queue:work --sleep=3 --tries=2 --timeout=35 --max-time=3600
directory=/var/www/sitariktageh
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/log/supervisor/sitariktageh-queue.log

[program:sitariktageh-scheduler]
command=bash -c "while [ true ]; do (cd /var/www/sitariktageh && php artisan schedule:run >> /dev/null 2>&1); sleep 60; done"
user=www-data
autostart=true
autorestart=true
stdout_logfile=/var/log/supervisor/sitariktageh-scheduler.log
```

Aktifkan Supervisor:
```bash
sudo supervisorctl reread && sudo supervisorctl update
```

---

## 12. Setup SSL / HTTPS

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d domain-anda.com
```

---

## 13. Shared Hosting (Alternatif VPS)

### Keterbatasan Utama:
* **Chatbot (proc_open)**: Hanya berjalan jika hosting mengaktifkan modul Python CLI dan fungsi PHP `exec()` / `proc_open`.
* **Klasifikasi (Queue)**: Perlu menjalankan cron job scheduler cPanel setiap menit:
  ```
  * * * * * cd /home/username/sitariktageh && php artisan schedule:run >> /dev/null 2>&1
  ```

---

## 14. Checklist Pre-Launch

* [ ] `APP_DEBUG=false` di `.env` Laravel.
* [ ] Virtual environment Python sudah aktif dengan dependency `google-genai`.
* [ ] Supervisor worker `sitariktageh-queue` berjalan tanpa error.
* [ ] SSL (HTTPS) terkonfigurasi.
* [ ] Database migration selesai.

---

## 15. Troubleshooting Umum

### Chatbot Error 500 / Timeout
1. Periksa path `PYTHON_EXECUTABLE` di `.env` Laravel.
2. Jalankan perintah manual test di terminal server:
   ```bash
   /var/www/sitariktageh/ai-service/venv/bin/python /var/www/sitariktageh/ai-service/chat_api.py "tes" "Asisten" "Puskesmas"
   ```

---

*Puskesmas Marunggi, Kota Pariaman, Sumatera Barat.*
