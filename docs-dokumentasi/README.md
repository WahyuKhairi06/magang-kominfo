# Dokumentasi Modul AI — Sistem Informasi Puskesmas

> **Penulis:** Wahyu Khairi — Praktik Kerja Lapangan (PKL)  
> **Instansi:** Dinas Komunikasi dan Informatika, Kota Pariaman  
> **Periode:** 2026  

---

## Tentang Dokumentasi Ini

Dokumentasi ini adalah **Single Source of Truth (SSOT)** untuk seluruh modul kecerdasan buatan (AI) yang dikembangkan selama program magang di Dinas Kominfo Kota Pariaman.

Modul AI ini dikembangkan sebagai **penambahan fitur** di atas sistem informasi website Puskesmas yang telah ada sebelumnya. Dokumentasi ini **tidak** mencakup fitur website yang sudah ada sebelum program magang dimulai, seperti sistem PKK, Dasawisma, CMS berita, manajemen halaman, atau fitur administrasi umum lainnya.

Seluruh implementasi yang terdokumentasi di sini dapat diverifikasi langsung pada source code repository di direktori `app/`, `ai-service/`, dan `database/migrations/`.

---

## Ruang Lingkup Modul AI yang Didokumentasikan

| No. | Modul / Sub-Sistem | File Dokumentasi |
|:----|:-------------------|:----------------|
| 1 | Gambaran Umum & Arsitektur | [`PROJECT_OVERVIEW.md`](./PROJECT_OVERVIEW.md) |
| 2 | AI Chatbot Healthcare Assistant | [`AI_CHATBOT_PRD.md`](./AI_CHATBOT_PRD.md) |
| 3 | Klasifikasi Otomatis Pengaduan | [`AI_COMPLAINT_CLASSIFICATION_PRD.md`](./AI_COMPLAINT_CLASSIFICATION_PRD.md) |
| 4 | Pengaturan AI (AI Settings & Multi-Puskesmas) | [`AI_SETTINGS_PRD.md`](./AI_SETTINGS_PRD.md) |
| 5 | Alur Pembangunan Basis Pengetahuan | [`KNOWLEDGE_PIPELINE.md`](./KNOWLEDGE_PIPELINE.md) |
| 6 | Pipeline Ekstraksi OCR Gambar | [`OCR_PIPELINE.md`](./OCR_PIPELINE.md) |
| 7 | Batasan & Guardrails Keamanan AI | [`AI_GUARDRAILS.md`](./AI_GUARDRAILS.md) |
| 8 | Keputusan Desain Teknis & Arsitektur | [`DESIGN_DECISIONS.md`](./DESIGN_DECISIONS.md) |
| 9 | Spesifikasi Server & Panduan Deployment | [`SERVER_REQUIREMENTS.md`](./SERVER_REQUIREMENTS.md) |
| 10 | Troubleshooting & Perbaikan AI Service | [`TROUBLESHOOTING_AI_SERVICE.md`](./TROUBLESHOOTING_AI_SERVICE.md) |
| 11 | Catatan & Metode Pengujian | [`TESTING.md`](./TESTING.md) |
| 12 | Riwayat Perubahan (Changelog) | [`CHANGELOG.md`](./CHANGELOG.md) |
| 13 | Peta Jalan Pengembangan (Roadmap) | [`ROADMAP.md`](./ROADMAP.md) |
| 14 | Panduan AI Coding Assistant | [`AGENTS.md`](./AGENTS.md) |

---

## Panduan Membaca Dokumentasi Ini

Urutan baca yang disarankan bagi pembaca baru (seperti pembimbing, penguji laporan magang, atau developer baru):

1. **[`PROJECT_OVERVIEW.md`](./PROJECT_OVERVIEW.md)** — Baca ini pertama untuk memahami konteks besar proyek dan arsitektur keseluruhan modul AI.
2. **[`AI_CHATBOT_PRD.md`](./AI_CHATBOT_PRD.md)** — Detail teknis modul chatbot publik.
3. **[`KNOWLEDGE_PIPELINE.md`](./KNOWLEDGE_PIPELINE.md)** — Cara AI memperoleh basis pengetahuannya dari database MySQL.
4. **[`OCR_PIPELINE.md`](./OCR_PIPELINE.md)** — Teknik ekstraksi teks dari gambar flyer/SOP via Gemini Vision.
5. **[`AI_COMPLAINT_CLASSIFICATION_PRD.md`](./AI_COMPLAINT_CLASSIFICATION_PRD.md)** — Sistem triage pengaduan otomatis berbasis queue.
6. **[`AI_SETTINGS_PRD.md`](./AI_SETTINGS_PRD.md)** — Konfigurasi identitas puskesmas & widget AI (Single Codebase).
7. **[`AI_GUARDRAILS.md`](./AI_GUARDRAILS.md)** — Batasan medis dan keamanan privasi AI.
8. **[`DESIGN_DECISIONS.md`](./DESIGN_DECISIONS.md)** — Alasan teknis di balik setiap pilihan arsitektur.
9. **[`SERVER_REQUIREMENTS.md`](./SERVER_REQUIREMENTS.md)** — Spesifikasi server, konfigurasi Nginx/Supervisor, dan deployment VPS.
10. **[`TROUBLESHOOTING_AI_SERVICE.md`](./TROUBLESHOOTING_AI_SERVICE.md)** — Solusi komprehensif penanganan masalah teknis dan runtime.
11. **[`TESTING.md`](./TESTING.md)** — Hasil pengujian & skenario uji.
12. **[`CHANGELOG.md`](./CHANGELOG.md)** — Kronologi perubahan dari versi awal hingga rilis final.
13. **[`ROADMAP.md`](./ROADMAP.md)** — Rencana pengembangan fitur di masa depan.
14. **[`AGENTS.md`](./AGENTS.md)** — Ruleset wajib bagi AI coding assistant dalam memelihara codebase.

---

## Konvensi Dokumen

- **Bahasa:** Indonesia Formal
- **Format:** Markdown (`.md`)
- **Referensi Silang:** Setiap dokumen merujuk ke dokumen lain menggunakan tautan relatif Markdown dan tautan file source code menggunakan path absolut.
- **Prinsip DRY:** Setiap topik hanya dibahas secara mendalam di satu dokumen. Dokumen lain yang membutuhkan informasi yang sama cukup memberikan tautan referensi.

---

## Struktur Folder

```
docs-dokumentasi/
│
├── README.md                              (dokumen ini — indeks utama)
├── AGENTS.md                              (aturan untuk AI coding assistant)
├── PROJECT_OVERVIEW.md                    (gambaran umum proyek & arsitektur)
│
├── AI_CHATBOT_PRD.md                      (PRD chatbot AI)
├── AI_COMPLAINT_CLASSIFICATION_PRD.md     (PRD klasifikasi pengaduan)
├── AI_SETTINGS_PRD.md                     (PRD pengaturan AI & multi-puskesmas)
│
├── KNOWLEDGE_PIPELINE.md                  (alur pembangunan basis pengetahuan)
├── OCR_PIPELINE.md                        (pipeline ekstraksi OCR gambar)
├── AI_GUARDRAILS.md                       (batasan dan keamanan AI)
├── DESIGN_DECISIONS.md                    (keputusan desain teknis & arsitektur)
├── SERVER_REQUIREMENTS.md                 (spesifikasi server & deployment VPS)
├── TROUBLESHOOTING_AI_SERVICE.md          (panduan perbaikan & solusi error)
│
├── TESTING.md                             (catatan & hasil pengujian)
├── CHANGELOG.md                           (riwayat perubahan)
├── ROADMAP.md                             (peta jalan pengembangan)
│
├── diagrams/                              (file diagram arsitektur)
│   ├── ai_module_architecture.drawio
│   ├── chatbot_flow.drawio
│   ├── complaint_classification_flow.drawio
│   ├── knowledge_pipeline.drawio
│   ├── ocr_pipeline.drawio
│   ├── ai_settings_flow.drawio
│   └── erd_ai_module.drawio
│
└── images/                                (gambar pendukung dokumentasi)
```

