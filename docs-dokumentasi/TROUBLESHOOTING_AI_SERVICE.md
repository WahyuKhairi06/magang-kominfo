# 🛠️ Panduan Perbaikan & Troubleshooting AI Service

Dokumen ini mencatat analisa mendalam, akar masalah, dan langkah perbaikan teknis terkait kendala integrasi AI Service (Google Gemini SDK) pada project **Sitariktageh (Puskesmas Marunggi)**.

---

## 📋 Ringkasan Gejala / Error

Saat pengguna mengirimkan pesan pada widget **AI Chatbot** di browser, sistem mengembalikan respon kesalahan sebagai berikut:

```text
Maaf, terjadi kesalahan: Setup AI Service tidak valid. Detail: [bold red]Library 'google-genai' belum terinstall.[/bold red]
Jalankan perintah berikut untuk menginstall dependency: [yellow]pip install -r requirements.txt[/yellow] Code: 1
```

---

## 🔬 Analisa & Akar Masalah (Root Cause Analysis)

Setelah dilakukan investigasi menyeluruh pada runtime PHP (Symfony Process), Python Subprocess, dan konfigurasi `.env`, ditemukan 4 faktor utama penyebab error tersebut:

### 1. Format `.env` Tidak Valid (Literal Quotes & Leading Spaces)
* **Karakter Petik pada `PYTHON_EXECUTABLE`**: Penulisan `PYTHON_EXECUTABLE="C:/python311/python.exe"` pada file `.env` membuat Laravel membaca nilai path beserta karakter petik ganda (`"`) secara literal. Hal ini menyebabkan pengecekan `file_exists()` di PHP selalu mengembalikan `false`, sehingga sistem melakukan fallback ke `python` default OS yang belum tentu terkonfigurasi pustaka `google-genai`.
* **Spasi pada `GEMINI_API_KEY`**: Terdapat spasi di awal string API Key (`GEMINI_API_KEY= AQ.Ab8...`) baik pada `.env` root maupun `ai-service/.env`.

### 2. Hilangnya Environment Variable Windows di Symfony Process (`WinError 10106`)
* Pada OS Windows, eksekusi subprocess melalui `Symfony\Component\Process\Process` di PHP tanpa menyertakan variabel lingkungan sistem (`SystemRoot`, `WINDIR`, `PATH`) menyebabkan library dasar `asyncio` milik Python (`windows_events.py` -> `_overlapped`) gagal memuat Windows Socket Provider (`ws2_32.dll`).
* Kegagalan Winsock ini melempar error: `OSError: [WinError 10106] The requested service provider could not be loaded or initialized` saat Python mencoba melakukan `import google.genai`.

### 3. Penanganan Exception yang Terlalu Sempit pada `main.py`
* Pada `ai-service/main.py`, impor modul `fastapi` opsional dibungkus dalam `try...except ImportError:`.
* Ketika `OSError` atau `NameError: base_events` terjadi akibat kegagalan Winsock di atas, blok `except ImportError:` tidak menangkap `OSError` tersebut. Akibatnya script melempar `SystemExit(1)` dan memicu pesan kesalahan *"Library google-genai belum terinstall"*.

### 4. Cache Riwayat Percakapan Browser (`sessionStorage`)
* Komponen frontend (`chat.blade.php` dan `chatbot-widget.blade.php`) menyimpan riwayat percakapan di `sessionStorage` pengguna dengan kunci `puskesmas_chatbot_messages`.
* Ketika terjadi error sekali, respon error tersebut tersimpan di memory browser. Saat halaman di-refresh, JavaScript memuat kembali pesan error dari `sessionStorage` meskipun server sudah berhasil diperbaiki.

---

## 🛠️ Langkah-Langkah Perbaikan (Fix Details)

### 1. Perbaikan Format `.env` & `ai-service/.env`

Hapus tanda petik dan spasi di awal nilai variabel pada file `.env`:

```env
# .env (Root Laravel)
GEMINI_API_KEY=AQ.Ab8RN6JYOp3g5S_MKMstXagmzRvb7JnTVHio9Lw5ag_eAO7xQw
PYTHON_EXECUTABLE=C:/python311/python.exe

# ai-service/.env
GEMINI_API_KEY=AQ.Ab8RN6JYOp3g5S_MKMstXagmzRvb7JnTVHio9Lw5ag_eAO7xQw
```

### 2. Refactoring Eksekusi Process via Centralized `AiProcessService`

Untuk menerapkan prinsip *Clean Code* (DRY — Don't Repeat Yourself), pemanggilan executable Python dan instansiasi `Symfony\Component\Process\Process` diabstraksikan ke dalam kelas layanan terpusat [App\Services\AiProcessService](file:///c:/laragon/www/marunggi/sitariktageh/app/Services/AiProcessService.php):

```php
// Penggunaan pada Controller/Job:
use App\Services\AiProcessService;

$pythonExec = AiProcessService::getPythonExecutable();
$process = AiProcessService::createProcess([$pythonExec, $scriptPath, $message, $aiName, $puskesmasName], 60);
$process->run();
```

Layanan `AiProcessService` secara otomatis:
- Mendeteksi path Python yang valid (Memprioritaskan `PYTHON_EXECUTABLE` di `.env`, lalu `.venv/Scripts/python.exe` lokal project, dan fallback ke `python` sistem).
- Mempassing environment sistem Windows (`SystemRoot`, `WINDIR`, `PATH`) secara otomatis sehingga terhindar dari `WinError 10106` saat me-load DLL socket.
- Mengatur working directory subprocess ke `base_path('ai-service')`.

Refactoring ini diterapkan pada:
- [ChatbotController.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Http/Controllers/ChatbotController.php#L32)
- [ClassifyPengaduanJob.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Jobs/ClassifyPengaduanJob.php#L78)
- [HalamanController.php](file:///c:/laragon/www/marunggi/sitariktageh/app/Http/Controllers/Admin/HalamanController.php#L130)

### 3. Memperluas Exception Trap pada `ai-service/main.py`

Ubah blok impor FastAPI pada `ai-service/main.py` dari `except ImportError:` menjadi `except Exception:` agar kesalahan socket di lingkungan CLI tidak menghentikan runtime chatbot:

```python
# FastAPI Integration for internal admin tools
try:
    from fastapi import FastAPI
    from classify_complaint import router as complaint_router
    app = FastAPI(title="AI Healthcare Assistant Services")
    app.include_router(complaint_router)
except Exception:
    app = None
```

### 4. Pengecekan `site.getusersitepackages()` di Python CLI Scripts

Tambahkan mekanisme fallback penambahan `sys.path` untuk user site-packages pada `ai-service/chat_api.py` dan `ai-service/classify_cli.py`:

```python
import site
import sys

try:
    user_site = site.getusersitepackages()
    if user_site and user_site not in sys.path:
        sys.path.insert(0, user_site)
except Exception:
    pass
```

### 5. Pengecualian CSRF Token pada Endpoint Chatbot

Tambahkan pengecualian CSRF pada `bootstrap/app.php` untuk memastikan permintaan AJAX dari widget chatbot berjalan stabil:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->validateCsrfTokens(except: [
        'chat/send',
    ]);
})
```

---

## 🧪 Cara Verifikasi & Testing

### 1. Verifikasi via Terminal HTTP POST (PowerShell)
Jalankan perintah berikut untuk menguji endpoint HTTP secara langsung:

```powershell
Invoke-RestMethod -Uri "http://127.0.0.1:8000/chat/send" -Method POST -Headers @{"Accept"="application/json"} -Body (ConvertTo-Json @{message="jadwal dokter"}) -ContentType "application/json" | ConvertTo-Json
```

**Respon Diharapkan (`status: success`):**
```json
{
    "status": "success",
    "answer": "Mohon maaf, informasi mengenai jadwal dokter belum tersedia..."
}
```

### 2. Verifikasi pada Web Browser
1. Buka `http://127.0.0.1:8000/chat`.
2. Klik ikon **Tempat Sampah (🗑️)** pada header jendela chatbot untuk membersihkan `sessionStorage` lama.
3. Kirim pesan baru (misal: `"jadwal pelayanan"` atau `"halo"`).
4. Pastikan jawaban dari AI Gemini muncul dengan format rapi (bold, link, dan paragraf).

---

*Puskesmas Marunggi — Tim Pengembang Aplikasi Sitariktageh.*
