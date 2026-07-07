"""
main.py
-------
AI Healthcare Assistant - Puskesmas Marunggi Kota Pariaman
Prototype berbasis Google Gemini API yang berjalan di Terminal.

Alur Program:
1. Memuat konfigurasi (.env) dan Knowledge Base (knowledge/puskesmas.json).
2. Menyiapkan koneksi ke Google Gemini API.
3. Menjalankan loop percakapan interaktif di terminal.
4. Untuk setiap pertanyaan user:
   a. Mencari informasi relevan di Knowledge Base (Context Retrieval sederhana
      berbasis keyword matching, TANPA embedding/vector database).
   b. Menyusun Context dari hasil pencarian.
   c. Mengirim Context + Pertanyaan ke Gemini melalui prompt.py.
   d. Menampilkan jawaban Gemini ke user.

Author  : Senior AI Engineer (Prototype)
Project : AI Healthcare Assistant - Puskesmas Marunggi
"""

import json
import os
import re
import sys
from pathlib import Path

from dotenv import load_dotenv
from rich.console import Console
from rich.panel import Panel
from rich.prompt import Prompt

from prompt import build_prompt, OUT_OF_CONTEXT_MESSAGE

# ==================================================
# KONFIGURASI DASAR
# ==================================================

BASE_DIR = Path(__file__).resolve().parent
KNOWLEDGE_PATH = BASE_DIR / "knowledge" / "puskesmas.json"

EXIT_COMMANDS = {"exit", "quit", "keluar"}

# Kata-kata yang tidak memberi makna signifikan saat pencarian keyword.
# Kata-kata ini akan diabaikan agar hasil pencocokan lebih relevan.
STOPWORDS = {
    "yang", "dan", "di", "ke", "dari", "untuk", "pada", "adalah", "apa",
    "apakah", "bagaimana", "cara", "saya", "kami", "anda", "ini", "itu",
    "dengan", "atau", "akan", "bisa", "dapat", "ada", "tidak", "juga",
    "the", "a", "is", "how", "what", "do", "does", "please", "tolong",
    "min", "kak", "dong", "sih", "nya", "nih", "aja", "saja", "mau",
    "ingin", "boleh", "kalau", "jika", "harus", "sudah", "belum"
}

# Kata kunci tambahan per kategori untuk membantu pencocokan sederhana,
# karena beberapa nama field JSON tidak selalu memuat kata yang lazim
# digunakan oleh pengguna awam.
CATEGORY_KEYWORDS = {
    "profile": ["profil", "tentang puskesmas", "puskesmas apa"],
    "vision_mission": ["visi", "misi", "motto"],
    "history": ["sejarah", "berdiri", "histori"],
    "operational_hours": ["jam", "operasional", "buka", "tutup", "waktu", "loket", "pelayanan"],
    "contacts": ["kontak", "telepon", "nomor", "wa", "whatsapp", "email", "instagram", "facebook", "website"],
    "emergency_contact": ["darurat", "emergency", "ambulans", "gawat", "kecelakaan"],
    "location": ["lokasi", "alamat", "dimana", "peta", "maps", "arah"],
    "doctors": ["dokter", "nama dokter"],
    "schedules": ["jadwal", "praktik", "hari praktik", "kapan"],
    "polyclinic": ["poli", "poliklinik"],
    "services": ["layanan", "pelayanan", "fasilitas"],
    "programs": ["program", "kegiatan", "posyandu", "posbindu"],
    "announcements": ["pengumuman", "info terbaru", "perubahan"],
    "articles": ["artikel", "berita", "edukasi"],
    "faq": ["faq", "tanya jawab", "pertanyaan umum"],
    "bpjs_information": ["bpjs", "jkn", "faskes"],
    "administrative_requirements": ["syarat", "administrasi", "berkas", "dokumen", "persyaratan"],
    "health_campaign": ["kampanye", "gerakan", "stunting", "dbd", "cuci tangan"],
    "ai_assistant_identity": [
        "siapa kamu", "kamu siapa", "siapa anda", "anda siapa",
        "kamu apa", "anda apa", "namamu siapa", "nama kamu siapa",
        "kamu robot", "kamu bot", "apakah kamu ai", "apakah kamu manusia",
        "kamu ai", "identitas kamu", "tentang asisten ini", "asisten ini apa",
        "kamu dibuat oleh", "siapa yang membuat kamu", "kamu buatan siapa",
        "perkenalkan dirimu", "kenalkan dirimu",
    ],
}

console = Console()


# ==================================================
# UTILITAS UMUM
# ==================================================

def tokenize(text: str) -> set:
    """Mengubah teks menjadi himpunan token kata (lowercase, tanpa simbol)."""
    words = re.findall(r"[a-zA-Z0-9]+", text.lower())
    return {w for w in words if w not in STOPWORDS and len(w) > 1}


def flatten_value(value) -> str:
    """Mengubah value (dict/list/str/number) menjadi teks yang bisa dibaca."""
    if isinstance(value, dict):
        parts = []
        for k, v in value.items():
            parts.append(f"{k.replace('_', ' ')}: {flatten_value(v)}")
        return "; ".join(parts)
    if isinstance(value, list):
        return " | ".join(flatten_value(item) for item in value)
    return str(value)


def build_corpus(knowledge_base: dict) -> list:
    """
    Memecah Knowledge Base menjadi daftar "chunk" kecil yang dapat dicari.

    Setiap chunk berisi:
    - category   : nama kategori/key JSON asal data
    - text       : representasi teks dari data (untuk dikirim sebagai konteks)
    - tokens     : token kata untuk keperluan keyword matching
    """
    corpus = []
    for category, value in knowledge_base.items():
        if isinstance(value, list):
            # Setiap item dalam list menjadi 1 chunk terpisah agar retrieval
            # lebih presisi (misalnya setiap dokter/jadwal/artikel terpisah).
            for item in value:
                text = f"[{category}] {flatten_value(item)}"
                corpus.append({
                    "category": category,
                    "text": text,
                    "tokens": tokenize(text),
                })
        else:
            text = f"[{category}] {flatten_value(value)}"
            corpus.append({
                "category": category,
                "text": text,
                "tokens": tokenize(text),
            })
    return corpus


def retrieve_context(query: str, corpus: list, top_k: int = 6) -> str:
    """
    Context Retrieval sederhana berbasis keyword matching (tanpa embedding).

    Alur:
    1. Tokenisasi pertanyaan user.
    2. Tambahkan bonus skor jika query mengandung kata kunci kategori tertentu.
    3. Hitung skor tiap chunk = jumlah irisan token + bonus kategori.
    4. Ambil top_k chunk dengan skor tertinggi (skor > 0).
    5. Gabungkan menjadi satu blok Context yang dikirim ke Gemini.
    """
    query_lower = query.lower()
    query_tokens = tokenize(query)

    # Tentukan kategori mana saja yang "dipicu" oleh kata kunci di pertanyaan.
    triggered_categories = set()
    for category, keywords in CATEGORY_KEYWORDS.items():
        for kw in keywords:
            if kw in query_lower:
                triggered_categories.add(category)
                break

    scored_chunks = []
    for chunk in corpus:
        overlap_score = len(query_tokens & chunk["tokens"])
        category_bonus = 3 if chunk["category"] in triggered_categories else 0
        total_score = overlap_score + category_bonus

        if total_score > 0:
            scored_chunks.append((total_score, chunk["text"]))

    # Urutkan berdasarkan skor tertinggi, ambil top_k
    scored_chunks.sort(key=lambda x: x[0], reverse=True)
    top_chunks = [text for _, text in scored_chunks[:top_k]]

    return "\n".join(top_chunks)


# ==================================================
# PEMUATAN KONFIGURASI & KNOWLEDGE BASE
# ==================================================

def load_api_key() -> str:
    """Memuat GEMINI_API_KEY dari file .env dan memvalidasi keberadaannya."""
    load_dotenv(BASE_DIR / ".env")
    api_key = os.getenv("GEMINI_API_KEY", "").strip()

    if not api_key:
        console.print(Panel(
            "[bold red]GEMINI_API_KEY tidak ditemukan atau kosong.[/bold red]\n\n"
            "Silakan buka file [bold].env[/bold] pada folder project ini, "
            "lalu isi baris berikut dengan API Key Gemini Anda:\n\n"
            "[yellow]GEMINI_API_KEY=isi_api_key_anda_disini[/yellow]\n\n"
            "Dapatkan API Key gratis di: https://aistudio.google.com/apikey",
            title="⚠️  Konfigurasi Belum Lengkap",
            border_style="red",
        ))
        sys.exit(1)

    return api_key


def load_model_name() -> str:
    """Memuat nama model Gemini dari .env, dengan default fallback."""
    model_name = os.getenv("GEMINI_MODEL", "").strip()
    return model_name if model_name else "gemini-2.5-flash"


def load_knowledge_base() -> dict:
    """Memuat dan memvalidasi file knowledge/puskesmas.json."""
    if not KNOWLEDGE_PATH.exists():
        console.print(Panel(
            f"[bold red]File Knowledge Base tidak ditemukan di:[/bold red]\n"
            f"{KNOWLEDGE_PATH}\n\n"
            "Pastikan file [bold]knowledge/puskesmas.json[/bold] ada dan tidak dipindahkan.",
            title="⚠️  Knowledge Base Hilang",
            border_style="red",
        ))
        sys.exit(1)

    try:
        with open(KNOWLEDGE_PATH, "r", encoding="utf-8") as f:
            data = json.load(f)
        return data
    except json.JSONDecodeError as e:
        console.print(Panel(
            f"[bold red]File knowledge/puskesmas.json tidak valid (rusak).[/bold red]\n\n"
            f"Detail error: {e}\n\n"
            "Silakan periksa kembali format JSON pada file tersebut.",
            title="⚠️  Knowledge Base Rusak",
            border_style="red",
        ))
        sys.exit(1)
    except Exception as e:
        console.print(Panel(
            f"[bold red]Gagal membaca Knowledge Base.[/bold red]\n\nDetail: {e}",
            title="⚠️  Error Tidak Terduga",
            border_style="red",
        ))
        sys.exit(1)


def init_gemini_client(api_key: str):
    """Inisialisasi client Google Gemini menggunakan SDK resmi (google-genai)."""
    try:
        from google import genai
        client = genai.Client(api_key=api_key)
        return client
    except ImportError:
        console.print(Panel(
            "[bold red]Library 'google-genai' belum terinstall.[/bold red]\n\n"
            "Jalankan perintah berikut untuk menginstall dependency:\n"
            "[yellow]pip install -r requirements.txt[/yellow]",
            title="⚠️  Dependency Belum Terinstall",
            border_style="red",
        ))
        sys.exit(1)
    except Exception as e:
        console.print(Panel(
            f"[bold red]Gagal menginisialisasi Gemini Client.[/bold red]\n\nDetail: {e}",
            title="⚠️  Error Inisialisasi",
            border_style="red",
        ))
        sys.exit(1)


# ==================================================
# KOMUNIKASI DENGAN GEMINI
# ==================================================

def ask_gemini(client, model_name: str, full_prompt: str) -> str:
    """
    Mengirim prompt ke Gemini API dan mengembalikan teks jawaban.
    Menangani berbagai kemungkinan error: API key salah, timeout,
    koneksi internet mati, kuota habis, dan error tak terduga lainnya.
    """
    try:
        response = client.models.generate_content(
            model=model_name,
            contents=full_prompt,
        )

        answer = getattr(response, "text", None)
        if not answer:
            return (
                "Maaf, saya belum bisa memberikan jawaban saat ini. "
                "Silakan coba ajukan pertanyaan Anda kembali."
            )
        return answer.strip()

    except Exception as e:
        error_text = str(e).lower()

        if "api key" in error_text or "api_key" in error_text or "permission" in error_text or "unauthorized" in error_text or "401" in error_text:
            return (
                "⚠️ Terjadi masalah dengan API Key Gemini (kemungkinan tidak valid). "
                "Silakan periksa kembali GEMINI_API_KEY pada file .env Anda."
            )
        if "quota" in error_text or "429" in error_text or "rate limit" in error_text:
            return (
                "⚠️ Kuota atau batas permintaan Gemini API telah tercapai. "
                "Silakan coba beberapa saat lagi."
            )
        if "timeout" in error_text or "timed out" in error_text:
            return (
                "⚠️ Permintaan ke Gemini API mengalami timeout. "
                "Silakan periksa koneksi internet Anda dan coba lagi."
            )
        if (
            "connection" in error_text
            or "network" in error_text
            or "resolve" in error_text
            or "unreachable" in error_text
        ):
            return (
                "⚠️ Tidak dapat terhubung ke server Gemini. "
                "Silakan periksa koneksi internet Anda dan coba lagi."
            )

        return f"⚠️ Terjadi kesalahan tak terduga saat menghubungi Gemini API: {e}"


# ==================================================
# TAMPILAN TERMINAL
# ==================================================

def print_header():
    console.print(
        "[bold cyan]=================================================[/bold cyan]\n"
        "[bold cyan]🏥 AI Healthcare Assistant[/bold cyan]\n"
        "[bold cyan]Puskesmas Marunggi[/bold cyan]\n"
        "[bold cyan]Powered by Gemini[/bold cyan]\n"
        "[bold cyan]=================================================[/bold cyan]\n"
    )
    console.print(
        "[dim]Ketik pertanyaan seputar layanan Puskesmas Marunggi. "
        "Ketik 'exit', 'quit', atau 'keluar' untuk mengakhiri.[/dim]\n"
    )


def print_answer(answer: str):
    console.print(Panel(answer, title="🏥 Asisten Puskesmas Marunggi", border_style="green"))


# ==================================================
# MAIN LOOP
# ==================================================

def main():
    print_header()

    api_key = load_api_key()
    model_name = load_model_name()
    knowledge_base = load_knowledge_base()
    corpus = build_corpus(knowledge_base)
    client = init_gemini_client(api_key)

    while True:
        try:
            user_input = Prompt.ask("[bold yellow]Anda[/bold yellow]")
        except (KeyboardInterrupt, EOFError):
            console.print("\n[bold cyan]Terima kasih telah menggunakan AI Healthcare Assistant Puskesmas Marunggi![/bold cyan]")
            break

        cleaned_input = user_input.strip()

        if not cleaned_input:
            console.print("[dim]Silakan ketik pertanyaan Anda.[/dim]\n")
            continue

        if cleaned_input.lower() in EXIT_COMMANDS:
            console.print("\n[bold cyan]Terima kasih telah menggunakan AI Healthcare Assistant Puskesmas Marunggi![/bold cyan]")
            break

        # 1. Context Retrieval berbasis keyword matching sederhana
        context = retrieve_context(cleaned_input, corpus)

        # 2. Susun prompt lengkap (system instruction + context + pertanyaan)
        full_prompt = build_prompt(cleaned_input, context)

        # 3. Kirim ke Gemini dan tampilkan jawaban
        with console.status("[bold green]Asisten sedang mengetik...[/bold green]"):
            answer = ask_gemini(client, model_name, full_prompt)

        print_answer(answer)
        console.print()


if __name__ == "__main__":
    main()
