# Konfigurasi yang Perlu Ditambahkan

## 1. `.env` (Laravel) — tambahkan kalau belum ada

```env
# AI Service (kemungkinan sudah ada untuk chatbot, cek dulu sebelum duplikat)
AI_SERVICE_URL=http://127.0.0.1:8000
AI_SERVICE_INTERNAL_KEY=isi-dengan-random-string-yang-sama-persis-dengan-INTERNAL_API_KEY-di-ai-service

# Queue wajib aktif (bukan 'sync') supaya klasifikasi tidak blocking submit form
QUEUE_CONNECTION=database
```

## 2. `config/services.php` (Laravel) — tambahkan entri baru

```php
'ai' => [
    'base_url' => env('AI_SERVICE_URL'),
    'internal_key' => env('AI_SERVICE_INTERNAL_KEY'),
],
```

## 3. `ai-service/.env` (FastAPI) — tambahkan kalau belum ada

```env
INTERNAL_API_KEY=isi-dengan-random-string-yang-sama-persis-dengan-AI_SERVICE_INTERNAL_KEY-di-laravel
GEMINI_CLASSIFY_MODEL=gemini-2.5-flash-lite
```

## 4. Setup Queue (kalau belum pernah dipakai di project ini)

```bash
php artisan queue:table
php artisan migrate
php artisan queue:work
```

Untuk production, `queue:work` perlu dijalankan sebagai background process (pakai Supervisor atau sejenisnya), bukan cuma dijalankan manual di terminal.

## 5. Install dependency Python (kalau belum ada di ai-service)

```bash
pip install google-generativeai fastapi pydantic
```
