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

| No. | Modul | File Dokumentasi |
|:----|:------|:----------------|
| 1 | AI Chatbot Healthcare Assistant | [`AI_CHATBOT_PRD.md`](./AI_CHATBOT_PRD.md) |
| 2 | Klasifikasi Otomatis Pengaduan | [`AI_COMPLAINT_CLASSIFICATION_PRD.md`](./AI_COMPLAINT_CLASSIFICATION_PRD.md) |
| 3 | Pengaturan AI (AI Settings) | [`AI_SETTINGS_PRD.md`](./AI_SETTINGS_PRD.md) |
| 4 | Alur Pembangunan Basis Pengetahuan | [`KNOWLEDGE_PIPELINE.md`](./KNOWLEDGE_PIPELINE.md) |
| 5 | Pipeline Ekstraksi OCR | [`OCR_PIPELINE.md`](./OCR_PIPELINE.md) |
| 6 | Batasan & Guardrails AI | [`AI_GUARDRAILS.md`](./AI_GUARDRAILS.md) |
| 7 | Keputusan Desain Teknis | [`DESIGN_DECISIONS.md`](./DESIGN_DECISIONS.md) |
| 8 | Pengujian | [`TESTING.md`](./TESTING.md) |
| 9 | Riwayat Perubahan | [`CHANGELOG.md`](./CHANGELOG.md) |
| 10 | Peta Jalan Pengembangan | [`ROADMAP.md`](./ROADMAP.md) |

---

## Panduan Membaca Dokumentasi Ini

Urutan baca yang disarankan bagi pembaca baru (seperti pembimbing atau penguji laporan magang):

1. **[`PROJECT_OVERVIEW.md`](./PROJECT_OVERVIEW.md)** — Baca ini pertama untuk memahami konteks besar proyek dan arsitektur keseluruhan modul AI.
2. **[`AI_CHATBOT_PRD.md`](./AI_CHATBOT_PRD.md)** — Detail teknis modul chatbot.
3. **[`KNOWLEDGE_PIPELINE.md`](./KNOWLEDGE_PIPELINE.md)** — Cara AI memperoleh pengetahuannya.
4. **[`OCR_PIPELINE.md`](./OCR_PIPELINE.md)** — Teknik ekstraksi gambar untuk AI.
5. **[`AI_COMPLAINT_CLASSIFICATION_PRD.md`](./AI_COMPLAINT_CLASSIFICATION_PRD.md)** — Sistem triage pengaduan otomatis.
6. **[`AI_SETTINGS_PRD.md`](./AI_SETTINGS_PRD.md)** — Konfigurasi dan multi-puskesmas.
7. **[`AI_GUARDRAILS.md`](./AI_GUARDRAILS.md)** — Keamanan dan batasan AI.
8. **[`DESIGN_DECISIONS.md`](./DESIGN_DECISIONS.md)** — Alasan di balik setiap keputusan teknis.
9. **[`TESTING.md`](./TESTING.md)** — Pengujian yang telah dilakukan.
10. **[`CHANGELOG.md`](./CHANGELOG.md)** — Kronologi perubahan.
11. **[`ROADMAP.md`](./ROADMAP.md)** — Rencana pengembangan masa depan.

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
├── README.md                              (dokumen ini)
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
├── DESIGN_DECISIONS.md                    (keputusan desain teknis)
│
├── TESTING.md                             (catatan pengujian)
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
