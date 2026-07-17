# AGENTS.md — Instruksi Eksekusi: Klasifikasi Otomatis Pengaduan

Baca `PRD_KLASIFIKASI_PENGADUAN.md` dulu sebelum mulai. File ini berisi aturan teknis wajib saat implementasi.

## Konteks Proyek yang Sudah Ada

Ini adalah **penambahan fitur** ke project Laravel + FastAPI (`ai-service`) yang sudah berjalan (chatbot publik sudah live, memakai `chatbot_settings`, `prompt.py`, `main.py` di folder `ai-service/`). **Jangan ubah/hapus apapun yang berkaitan dengan chatbot publik yang sudah ada** — fitur ini murni penambahan modul baru yang terisolasi.

Sesuaikan namespace, nama model Eloquent, dan path folder di kode contoh berikut dengan struktur project asli (`app/Http/Controllers/Admin/`, `app/Models/`, dll) — kode di paket ini adalah kerangka kerja siap pakai, cek dulu nama Model `Pengaduan` dan tabel `pengaduans` yang sudah ada sebelum overwrite apapun.

## Urutan Eksekusi (Wajib Berurutan)

1. **Jalankan migration** di `migrations/2026_07_16_000001_add_ai_classification_to_pengaduans_table.php` — tambah kolom ke tabel `pengaduans` yang SUDAH ADA, jangan buat tabel baru.
2. **Tambahkan endpoint FastAPI** dari `ai-service/classify_complaint.py` ke aplikasi FastAPI yang sudah ada di `ai-service/main.py` — daftarkan route barunya, JANGAN duplikat setup FastAPI app baru.
3. **Tambahkan prompt** dari `ai-service/prompt_classify.py` — file terpisah dari `prompt.py` milik chatbot publik, supaya tidak tercampur.
4. **Buat Job** `app/Jobs/ClassifyPengaduanJob.php` — pastikan queue driver sudah aktif di `.env` (`QUEUE_CONNECTION=database` minimal, jalankan `php artisan queue:table && php artisan migrate` kalau belum ada tabel jobs, lalu `php artisan queue:work` saat development).
5. **Update Controller** pengaduan yang sudah ada — tambahkan dispatch job setelah `store()`, dan tambahkan method baru untuk PATCH override kategori/urgensi (lihat `app/Http/Controllers/Admin/PengaduanController.php` di paket ini sebagai referensi, gabungkan ke controller asli, jangan timpa method lain yang sudah ada).
6. **Update View** — tambahkan badge di list, dan chip selector di halaman detail (lihat `resources/views/admin/pengaduan/_klasifikasi_chip.blade.php` sebagai partial yang di-include).
7. **Tambahkan route** dari `routes/pengaduan-ai.php` ke `routes/web.php` atau `routes/admin.php` yang sudah ada.

## Aturan Keras

1. **Taksonomi kategori & urgensi HARUS persis sama** di 3 tempat: enum migration SQL, `CATEGORIES` list di `prompt_classify.py`, dan opsi chip di Blade view. Kalau salah satu diubah, tiga lainnya wajib ikut diubah — jangan biarkan tidak sinkron.
2. **Gemini WAJIB dipanggil dengan structured output/JSON schema** (`response_mime_type: "application/json"`), bukan parsing teks bebas — supaya kategori yang dikembalikan selalu valid salah satu dari 7 opsi, tidak pernah mengarang kategori baru.
3. **Tabel `pengaduans` tidak boleh ditambahkan ke whitelist Context Builder chatbot publik.** Kalau ada file konfigurasi whitelist (`context_builder_tables.json` atau sejenis) di project, JANGAN tambahkan `pengaduans` ke situ.
4. **Endpoint klasifikasi ini harus di-protect dari akses publik** — hanya bisa dipanggil dari server Laravel (pakai API key internal yang sama polanya dengan endpoint chat, atau middleware auth admin kalau endpoint ini juga diekspos ke frontend admin).
5. **Job harus punya retry & timeout wajar** (`$tries = 2`, `$timeout = 30`) dan **wajib menangani kegagalan dengan baik** — kalau job gagal permanen, set `status_klasifikasi = 'gagal'`, jangan biarkan pengaduan stuck selamanya di `pending`.
6. **Jangan kirim data pelapor (nama, no HP, email) ke prompt Gemini** — cuma kirim `subjek` dan `isi` pengaduan. Klasifikasi cuma butuh isi keluhan, bukan identitas pelapor.
7. **Form pengaduan publik TIDAK diubah** untuk menambah field kategori wajib. Kalaupun mau tambah kategori opsional dari user, itu di luar scope PRD ini — konfirmasi dulu sebelum menambah.

## Definition of Done

- [ ] Migration jalan tanpa error, kolom baru muncul di tabel `pengaduans`
- [ ] Submit pengaduan baru dari form publik tetap sukses walau Gemini API down/lambat (tidak blocking)
- [ ] Dalam <30 detik setelah submit (kondisi normal), kolom `status_klasifikasi` berubah dari `pending` ke `selesai` dan kategori/urgensi terisi
- [ ] List admin menampilkan badge kategori+urgensi dengan warna sesuai level urgensi
- [ ] Halaman detail menampilkan 7 chip kategori, 1 aktif (hijau+centang), sisanya abu-abu, bisa diklik untuk override
- [ ] Baris "🤖 Disarankan AI: ..." tetap tampil dan tidak berubah meski chip sudah di-override
- [ ] Override kategori/urgensi tersimpan via PATCH tanpa reload halaman penuh (atau minimal tersimpan dengan benar ke DB)
- [ ] Endpoint klasifikasi tidak bisa diakses tanpa API key/auth yang sesuai
- [ ] Tidak ada perubahan pada behavior chatbot publik yang sudah ada
