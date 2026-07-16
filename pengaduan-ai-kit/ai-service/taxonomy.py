"""
Taksonomi Kategori & Urgensi Pengaduan — SUMBER KEBENARAN TUNGGAL.

PENTING: Kalau daftar ini diubah, WAJIB disinkronkan manual ke:
1. Migration enum `urgensi_ai`/`urgensi_final` (kategori tidak perlu enum di DB, cukup varchar)
2. Opsi chip di resources/views/admin/pengaduan/_klasifikasi_chip.blade.php
3. Dokumentasi PRD_KLASIFIKASI_PENGADUAN.md bagian 7

Jangan hardcode ulang daftar kategori di file lain — selalu import dari sini.
"""

CATEGORIES = [
    "Pendaftaran & Administrasi",
    "Pelayanan Petugas/Medis",
    "Waktu Tunggu & Antrean",
    "Kebersihan & Fasilitas",
    "Ketersediaan Obat",
    "Sarana & Prasarana",
    "Lainnya",
]

URGENCY_LEVELS = ["rendah", "sedang", "tinggi"]

URGENCY_RUBRIC = {
    "tinggi": "berpotensi membahayakan keselamatan/kesehatan, butuh tindakan kurang dari 24 jam",
    "sedang": "mengganggu kualitas layanan, perlu ditindaklanjuti dalam beberapa hari ke depan",
    "rendah": "masukan atau kritik ringan, tidak mendesak",
}

# JSON Schema untuk structured output Gemini — memaksa model hanya boleh
# mengembalikan salah satu dari opsi yang sudah ditetapkan, tidak bisa mengarang.
CLASSIFICATION_SCHEMA = {
    "type": "object",
    "properties": {
        "kategori": {
            "type": "string",
            "enum": CATEGORIES,
        },
        "urgensi": {
            "type": "string",
            "enum": URGENCY_LEVELS,
        },
        "alasan": {
            "type": "string",
            "description": "Penjelasan singkat 1 kalimat kenapa kategori & urgensi ini dipilih",
        },
    },
    "required": ["kategori", "urgensi", "alasan"],
}
