# Product Requirements Document — AI Settings (Pengaturan AI)

> **Status:** Implemented & Verified
> **Versi:** 1.0.0
> **Terakhir Diperbarui:** Juli 2026
>
> Referensi silang: [`PROJECT_OVERVIEW.md`](./PROJECT_OVERVIEW.md) | [`AI_CHATBOT_PRD.md`](./AI_CHATBOT_PRD.md)

---

## 1. Tujuan

Modul AI Settings adalah antarmuka admin yang memungkinkan pengelola Puskesmas mengkustomisasi tampilan dan perilaku chatbot tanpa harus mengubah kode sumber. Desain ini memungkinkan satu codebase yang sama digunakan oleh banyak Puskesmas dengan identitas berbeda.

---

## 2. Sub-Modul Pengaturan

Modul ini terdiri dari dua sub-modul:

| Sub-Modul | Tabel Database | Controller |
|:----------|:-------------|:-----------|
| Pengaturan Chatbot | `chatbot_settings` | `ChatbotSettingController.php` |
| Identitas Puskesmas | `puskesmas_settings` | `PuskesmasSettingController.php` |

---

## 3. Pengaturan Chatbot (`chatbot_settings`)

### 3.1 Parameter yang Dapat Dikonfigurasi

| Parameter | Kolom DB | Tipe | Default | Dampak |
|:----------|:---------|:-----|:--------|:-------|
| Nama AI | `ai_name` | varchar(100) | `Asisten Puskesmas` | Mengganti nama asisten di system prompt & header widget |
| Nama Puskesmas | `puskesmas_display_name` | varchar(150) | `Puskesmas Marunggi` | Menyinkronkan nama instansi ke dalam prompt & widget |
| Pesan Sambutan | `greeting_message` | text | _Teks panjang bawaan_ | Pesan pertama yang ditampilkan saat widget dibuka |
| Warna Utama | `primary_color` | varchar(20) | `#1e6b4d` | Warna latar tombol, header widget, chip aktif |
| Logo Chatbot | `logo_chatbot` | varchar(255) | `null` | Gambar avatar yang tampil di header chatbot |
| Status Layanan | `status` | enum | `active` | `inactive` menyembunyikan widget chatbot sepenuhnya |

### 3.2 Sinkronisasi Otomatis ke Chatbot

Perubahan pada `ai_name` dan `puskesmas_display_name` langsung berdampak pada perilaku AI karena nilai ini dibaca dari database di setiap request chatbot, kemudian diteruskan sebagai argumen ke script Python:

```php
// ChatbotController.php::send()
$chatbotSetting = DB::table('chatbot_settings')->first();
$aiName = $chatbotSetting->ai_name ?? 'Asisten Puskesmas';
$puskesmasName = $chatbotSetting->puskesmas_display_name ?? 'Puskesmas Marunggi';

$process = new Process([$pythonExec, $scriptPath, $message, $aiName, $puskesmasName]);
```

Di sisi Python, nilai ini mengisi parameter `{ai_name}` dan `{puskesmas_name}` dalam sistem instruksi:

```python
# prompt.py::get_system_instruction()
def get_system_instruction(ai_name: str, puskesmas_name: str) -> str:
    return f"""
Anda adalah "{ai_name}", asisten virtual resmi milik {puskesmas_name}.
...
"""
```

### 3.3 Kontras Warna Otomatis (YIQ)

Untuk menjamin keterbacaan teks di atas warna yang dipilih admin, sistem menggunakan algoritma **YIQ Color Space**. Teks di atas warna primer akan otomatis menjadi **hitam** jika warnanya terang, atau **putih** jika warnanya gelap — memenuhi standar aksesibilitas WCAG.

Implementasi ada di blade view pengaturan chatbot melalui JavaScript:

```javascript
// Kalkulasi YIQ
function getContrastColor(hexColor) {
    const r = parseInt(hexColor.slice(1, 3), 16);
    const g = parseInt(hexColor.slice(3, 5), 16);
    const b = parseInt(hexColor.slice(5, 7), 16);
    const yiq = (r * 299 + g * 587 + b * 114) / 1000;
    return yiq >= 128 ? '#000000' : '#ffffff';
}
```

### 3.4 Live Preview Simulator

Halaman pengaturan chatbot menyediakan simulator antarmuka smartphone secara real-time di sisi kanan form. Setiap perubahan pada field warna, nama, atau pesan sambutan langsung terefleksi di simulator tanpa perlu menyimpan terlebih dahulu. Fitur ini memungkinkan admin melihat hasil akhir sebelum disimpan ke database.

---

## 4. Identitas Puskesmas (`puskesmas_settings`)

### 4.1 Parameter yang Dapat Dikonfigurasi

| Parameter | Kolom DB | Tipe | Default |
|:----------|:---------|:-----|:--------|
| Nama Puskesmas | `nama_puskesmas` | varchar | `Puskesmas Marunggi` |
| Kabupaten/Kota | `kabupaten_kota` | varchar | `Kota Pariaman` |
| Alamat | `alamat` | text | _Alamat bawaan_ |
| No. Telepon | `no_telp` | varchar | `(0751) 123-456` |
| Email | `email` | varchar | _Email bawaan_ |
| Logo Puskesmas | `logo` | varchar | `null` |
| Jam Senin-Kamis | `jam_senin_kamis` | varchar | `08:00 - 14:00` |
| Jam Jumat | `jam_jumat` | varchar | `08:00 - 11:00` |
| Jam Sabtu | `jam_sabtu` | varchar | `08:00 - 13:00` |
| Link Facebook | `link_facebook` | varchar | `null` |
| Link Instagram | `link_instagram` | varchar | `null` |

### 4.2 Hubungan dengan Knowledge Base Chatbot

Data dari `puskesmas_settings` **tidak** secara langsung dimasukkan ke dalam `database_knowledge.json` di iterasi awal. Informasi profil utama (nama puskesmas, sambutan) diambil dari `chatbot_settings` dan `sambutans`.

Namun modul ini tetap penting untuk validitas data yang ditampilkan di frontend website, yang pada akhirnya memengaruhi apa yang dianggap "benar" oleh chatbot saat menjawab.

> **Peluang Pengembangan:** Mengintegrasikan data jam operasional dari `puskesmas_settings` langsung ke `database_knowledge.json` untuk meningkatkan akurasi jawaban chatbot tentang jadwal buka Puskesmas. Lihat [`ROADMAP.md`](./ROADMAP.md).

---

## 5. Skema Database

### Tabel `chatbot_settings`

| Kolom | Tipe | Nullable | Default | Keterangan |
|:------|:-----|:---------|:--------|:-----------|
| `id` | bigint PK | — | auto | — |
| `logo_chatbot` | varchar(255) | Ya | `null` | Path relatif dari `public/` |
| `ai_name` | varchar(100) | Tidak | `Asisten Puskesmas` | — |
| `puskesmas_display_name` | varchar(150) | Tidak | `Puskesmas Marunggi` | Sinkron ke prompt |
| `greeting_message` | text | Ya | Teks bawaan | — |
| `primary_color` | varchar(20) | Tidak | `#1e6b4d` | Format HEX |
| `status` | enum | Tidak | `active` | `active` \| `inactive` |
| `created_at`, `updated_at` | timestamp | — | — | — |

### Tabel `puskesmas_settings`

| Kolom | Tipe | Nullable | Default | Keterangan |
|:------|:-----|:---------|:--------|:-----------|
| `id` | bigint PK | — | auto | — |
| `nama_puskesmas` | varchar | Tidak | — | — |
| `kabupaten_kota` | varchar | Tidak | — | — |
| `alamat` | text | Tidak | — | — |
| `no_telp` | varchar | Tidak | — | — |
| `email` | varchar | Tidak | — | — |
| `logo` | varchar | Ya | `null` | Path relatif dari `public/` |
| `jam_senin_kamis` | varchar | Tidak | `08:00 - 14:00` | — |
| `jam_jumat` | varchar | Tidak | `08:00 - 11:00` | — |
| `jam_sabtu` | varchar | Tidak | `08:00 - 13:00` | — |
| `link_facebook` | varchar | Ya | `null` | URL penuh |
| `link_instagram` | varchar | Ya | `null` | URL penuh |
| `created_at`, `updated_at` | timestamp | — | — | — |

---

## 6. Inisialisasi Record Pertama (firstOrCreate)

Kedua controller menggunakan pola `firstOrCreate` untuk menghindari halaman error jika tabel kosong (belum ada record):

```php
// ChatbotSettingController.php::index()
$setting = ChatbotSetting::firstOrCreate(['id' => 1], [
    'ai_name'                => 'Asisten Puskesmas',
    'puskesmas_display_name' => 'Puskesmas Marunggi',
    'primary_color'          => '#1e6b4d',
    'status'                 => 'active',
    // ... default lainnya
]);
```

Artinya, saat admin pertama kali membuka halaman pengaturan di environment baru, record default akan otomatis dibuat tanpa perlu seeder tambahan.

---

## 7. Validasi Input

| Field | Aturan Validasi |
|:------|:---------------|
| `ai_name` | required, string, max:100 |
| `puskesmas_display_name` | required, string, max:150 |
| `greeting_message` | nullable, string |
| `primary_color` | required, string, max:20 |
| `logo_chatbot` | nullable, image, mimes: jpeg\|png\|jpg\|gif\|svg\|webp, max:2048 KB |
| `status` | required, in:active,inactive |

---

## 8. Kriteria Penerimaan (Acceptance Criteria)

| Skenario | Hasil yang Diharapkan |
|:---------|:---------------------|
| Admin ganti warna ke `#ff0000` | Widget chatbot publik berwarna merah setelah refresh |
| Admin ganti warna ke warna terang (`#FFFF00`) | Teks di atas warna tersebut otomatis menjadi hitam (YIQ) |
| Admin set status chatbot ke `inactive` | Widget chatbot menghilang dari halaman publik |
| Admin ganti nama AI ke "Sari" | Chatbot mengenalkan diri sebagai "Sari" saat ditanya |
| Admin buka halaman pengaturan di environment baru | Halaman tampil dengan nilai default (tidak error 500) |
