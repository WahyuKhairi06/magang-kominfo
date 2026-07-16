# PRD — Klasifikasi Otomatis Pengaduan (AI-Assisted Complaint Triage)

**Proyek**: Sistem Informasi Puskesmas Marunggi — Modul AI Internal (bukan chatbot publik)
**Fitur ke-2 setelah Voice-to-Voice Chatbot**
**Status**: Siap implementasi

---

## 1. Latar Belakang

Saat ini pengaduan yang masuk lewat form publik (tabel `pengaduans`) hanya tersimpan sebagai teks mentah tanpa kategori maupun prioritas. Admin harus membaca satu per satu untuk menentukan mana yang mendesak dan mana yang sekadar masukan ringan. Ini tidak scalable dan berisiko pengaduan urgent (misal terkait keselamatan pasien) terlewat/telat ditangani karena tenggelam di antara pengaduan lain.

Fitur ini menambahkan **AI Ops Tool internal** — sama sekali terpisah dari chatbot publik yang sudah ada — yang otomatis membaca tiap pengaduan baru, mengklasifikasikan kategori & urgensi, dan menyajikannya ke admin dalam bentuk yang mudah direview dan dikoreksi.

## 2. Tujuan

1. Setiap pengaduan baru otomatis punya kategori + tingkat urgensi dalam hitungan detik setelah masuk, tanpa menunggu admin baca manual.
2. Admin bisa langsung lihat prioritas di level list (tidak perlu buka detail satu-satu untuk tahu mana yang urgent).
3. Admin tetap punya kendali penuh — bisa koreksi kategori/urgensi kapan saja kalau AI salah baca, dan sistem menyimpan jejak audit (apa saran AI vs apa keputusan final admin).
4. Sama sekali tidak menyentuh atau memengaruhi chatbot publik yang sudah berjalan (isolasi total).

## 3. Non-Tujuan (Out of Scope untuk versi ini)

- Dashboard tren/insight agregat mingguan (fitur terpisah, dikerjakan nanti)
- Auto-draft FAQ dari pengaduan (fitur terpisah, dikerjakan nanti)
- Balasan otomatis ke pelapor (fitur ini murni internal triage, tidak ada komunikasi keluar ke pelapor)
- Perubahan pada form pengaduan publik (tetap sederhana: subjek + isi, tanpa kategori wajib dari user)

## 4. User Stories

**Sebagai pelapor (publik):**
> Saya mengisi form pengaduan cukup dengan subjek dan isi keluhan, tanpa perlu bingung memilih kategori — saya cukup tulis keluhan saya apa adanya.

**Sebagai admin:**
> Saya membuka dashboard pengaduan dan langsung melihat kategori serta level urgensi tiap pengaduan tanpa harus membaca isi lengkapnya satu-satu. Kalau AI salah menebak kategorinya, saya bisa klik kategori yang benar dan sistem langsung menyimpan perubahan itu.

## 5. Spesifikasi Fungsional

### F01 — Form Pengaduan Publik (tidak berubah signifikan)
- Field: `subjek` (wajib), `isi` (wajib), data pelapor sesuai yang sudah ada
- **Tidak ada field kategori wajib dari user**
- Setelah submit: tersimpan dengan `status_klasifikasi = 'pending'`

### F02 — Klasifikasi Otomatis (Trigger Real-Time)
- Begitu pengaduan baru tersimpan, sistem dispatch job asinkron (queue) ke AI Service
- AI Service memanggil Gemini dengan prompt klasifikasi terstruktur (JSON mode)
- Output: `kategori`, `urgensi`, `alasan` (1 kalimat penjelasan)
- Hasil disimpan ke kolom `*_ai` **dan** disalin ke kolom `*_final` (AI suggestion langsung jadi nilai aktif sampai admin override)
- Kalau API gagal/timeout: `status_klasifikasi = 'gagal'`, tidak ada badge AI ditampilkan, admin klasifikasi manual 100%

### F03 — Tampilan List Pengaduan (Admin)
- Kolom tambahan: badge Kategori, badge Urgensi (warna sesuai level: merah/kuning/hijau), ikon status (✓ murni AI / ✏️ sudah dikoreksi admin / ⏳ diproses)
- Bisa difilter/diurutkan berdasarkan urgensi

### F04 — Tampilan Detail Pengaduan (Admin) — Chip Selector
- Menampilkan semua opsi kategori sebagai chip: **1 chip aktif (hijau + centang)**, sisanya abu-abu
- Klik chip lain → langsung `PATCH` (auto-save, tanpa tombol submit terpisah), `kategori_final` berubah, `is_overridden = true`
- Baris kecil tetap menampilkan **"🤖 Disarankan AI: {kategori_ai} — {alasan_ai}"** meski sudah di-override — ini jejak audit permanen
- Urgensi pakai pola chip yang sama (Rendah/Sedang/Tinggi)

### F05 — Isolasi dari Chatbot Publik
- Endpoint baru terpisah total dari endpoint chat publik
- Prompt terpisah total dari system prompt chatbot publik
- Tabel `pengaduans` **tidak pernah** masuk whitelist Context Builder chatbot publik (aturan ini sudah berlaku sebelumnya, dipertahankan)

## 6. Spesifikasi Non-Fungsional

- **Async wajib**: klasifikasi tidak boleh membuat user publik menunggu saat submit form — pakai Laravel queue
- **Graceful degradation**: kalau Gemini API gagal/kuota habis, form tetap berhasil submit, cuma klasifikasi yang tertunda/manual
- **Kuota rendah**: 1 request Gemini per 1 pengaduan baru (bukan per-halaman-load), volume realistis rendah dibanding chatbot publik
- **Kategori tertutup (enum)**: AI wajib pilih dari 7 kategori yang sudah ditetapkan, tidak boleh mengarang kategori baru (pakai `response_schema` Gemini)

## 7. Taksonomi (Sumber Kebenaran — dipakai di FE, BE, dan prompt AI)

**Kategori:**
1. Pendaftaran & Administrasi
2. Pelayanan Petugas/Medis
3. Waktu Tunggu & Antrean
4. Kebersihan & Fasilitas
5. Ketersediaan Obat
6. Sarana & Prasarana
7. Lainnya

**Urgensi:** `rendah` | `sedang` | `tinggi`

## 8. Skema Database

Lihat `migrations/2026_07_16_000001_add_ai_classification_to_pengaduans_table.php`

## 9. Alur Teknis

```
[Form Publik] → submit → INSERT pengaduans (status_klasifikasi=pending)
        ↓
[PengaduanController::store] → ClassifyPengaduanJob::dispatch($pengaduan->id)
        ↓ (queue, async)
[ClassifyPengaduanJob] → HTTP POST ke ai-service /api/v1/admin/classify-complaint
        ↓
[ai-service] → Gemini (JSON mode, structured output) → {kategori, urgensi, alasan}
        ↓
[ClassifyPengaduanJob] → UPDATE pengaduans (kategori_ai/final, urgensi_ai/final, alasan_ai, status_klasifikasi=selesai)
        ↓
[Admin Dashboard] → tampil badge & chip, admin bisa override via PATCH endpoint terpisah
```

## 10. Metrik Keberhasilan

1. **Kecepatan klasifikasi**: >90% pengaduan baru terklasifikasi otomatis dalam <30 detik setelah submit
2. **Akurasi (dievaluasi manual periodik)**: bandingkan `kategori_ai` vs `kategori_final` pada pengaduan yang sudah direview admin — hitung persentase kecocokan (metrik ini bisa jadi bahan evaluasi kuantitatif di laporan, mirip evaluasi WER/CER)
3. **Adopsi**: admin tidak perlu klasifikasi manual dari nol untuk >80% pengaduan (cukup konfirmasi/override sesekali)

## 11. Batasan Keamanan & Etika (Wajib Dipatuhi)

- Modul ini **tidak pernah** berinteraksi dengan pelapor/publik — output klasifikasi hanya untuk konsumsi internal admin
- **Tidak ada** rekomendasi tindakan medis, diagnosa, atau saran obat dalam bentuk apapun — AI di sini murni mengklasifikasi teks pengaduan, bukan menjawab pertanyaan kesehatan
- Tidak ada data pelapor (nama, kontak) yang dikirim ke luar sistem selain ke Gemini API untuk keperluan klasifikasi teks pengaduan itu sendiri
- Kredensial API key AI Service tidak boleh sama dengan yang dipakai chatbot publik kalau memungkinkan diberi scope terpisah (opsional, tapi lebih aman untuk audit)
