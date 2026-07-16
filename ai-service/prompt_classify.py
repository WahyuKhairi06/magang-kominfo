"""
Prompt builder untuk klasifikasi pengaduan.

SENGAJA DIPISAH dari prompt.py milik chatbot publik — modul ini adalah AI Ops
tool internal, tidak pernah berinteraksi dengan pelapor/publik, dan tidak boleh
tercampur dengan system prompt "asisten virtual Puskesmas" yang dipakai chatbot.
"""

from taxonomy import CATEGORIES, URGENCY_RUBRIC


def build_classification_prompt(subjek: str, isi: str) -> str:
    """
    Bangun prompt untuk klasifikasi 1 pengaduan.

    PENTING: Hanya kirim `subjek` dan `isi`. JANGAN sertakan nama pelapor,
    nomor HP, email, atau data identitas lain — klasifikasi tidak butuh itu,
    dan mengirimkannya ke API eksternal tanpa perlu adalah risiko privasi
    yang tidak ada gunanya (lihat AGENTS.md aturan #6).
    """
    kategori_list = "\n".join(f"- {k}" for k in CATEGORIES)
    urgensi_rubric = "\n".join(f"- {level}: {desc}" for level, desc in URGENCY_RUBRIC.items())

    return f"""Kamu adalah sistem klasifikasi internal untuk pengaduan masyarakat di sebuah Puskesmas.
Ini BUKAN chatbot publik — hasil klasifikasi ini HANYA dilihat oleh admin/staff internal,
tidak pernah ditampilkan atau dikirim balik ke pelapor.

TUGAS: Klasifikasikan pengaduan berikut ke TEPAT SATU kategori dari daftar ini (gunakan
nama kategori PERSIS seperti tertulis, jangan diubah/disingkat):
{kategori_list}

Tentukan tingkat urgensi berdasarkan rubrik berikut:
{urgensi_rubric}

Berikan alasan singkat (maksimal 1 kalimat, bahasa Indonesia natural, jelaskan kenapa
kategori dan urgensi ini yang paling tepat).

ATURAN PENTING:
- Jangan berikan saran tindakan medis, diagnosa, atau rekomendasi obat dalam bentuk apapun,
  walau isi pengaduan menyebut soal kesehatan/obat — tugasmu HANYA mengklasifikasi teks,
  bukan menjawab atau memberi saran medis.
- Kalau isi pengaduan tidak jelas, kosong, atau tidak bisa dipahami, pilih kategori
  "Lainnya" dan urgensi "rendah", dengan alasan "Konten tidak jelas, perlu ditinjau manual".

PENGADUAN:
Subjek: {subjek}
Isi: {isi}
"""
