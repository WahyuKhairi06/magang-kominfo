import sys
import os
import json
from pathlib import Path
from dotenv import load_dotenv

BASE_DIR = Path(__file__).resolve().parent
load_dotenv(BASE_DIR / ".env", override=True)

def load_api_key() -> str:
    return os.getenv("GEMINI_API_KEY", "").strip()

def load_model_name() -> str:
    return os.getenv("GEMINI_MODEL", "gemini-2.5-flash").strip()

def run_ocr(image_path: str) -> str:
    api_key = load_api_key()
    if not api_key:
        raise ValueError("GEMINI_API_KEY tidak ditemukan di file .env")

    model_name = load_model_name()
    
    from google import genai
    from google.genai import types
    
    client = genai.Client(api_key=api_key)
    
    path = Path(image_path)
    if not path.exists():
        raise FileNotFoundError(f"Gambar tidak ditemukan di path: {image_path}")

    suffix = path.suffix.lower()
    mime_type = "image/jpeg"
    if suffix == ".png":
        mime_type = "image/png"
    elif suffix == ".webp":
        mime_type = "image/webp"
    elif suffix == ".gif":
        mime_type = "image/gif"

    with open(path, "rb") as f:
        img_data = f.read()

    part = types.Part.from_bytes(data=img_data, mime_type=mime_type)
    
    prompt = (
        "Lakukan OCR mendetail pada gambar ini. Anda harus memahami konteks visual gambar "
        "(seperti jadwal pelayanan, poster, infografis, banner, SOP, alur pelayanan, pengumuman, dll.). "
        "Ekstrak semua informasi dalam format yang terstruktur, lengkap, dan kontekstual (misalnya tabel Markdown, daftar, header). "
        "Pertahankan hubungan antarjudul, isi, tabel, daftar, tanggal, jam, lokasi, nomor kontak, serta semua informasi penting lainnya. "
        "Jangan menambahkan, mengubah, atau mengasumsikan informasi yang tidak terdapat pada gambar. Tulis murni berdasarkan konten gambar. "
        "Optimalkan tata letak dan kata-kata agar mudah dipahami LLM (Large Language Model) sehingga chatbot AI "
        "dapat menjawab berbagai pertanyaan pengguna mengenai gambar ini dengan sangat akurat. "
        "Keluarkan hasilnya dalam Bahasa Indonesia."
    )

    response = client.models.generate_content(
        model=model_name,
        contents=[part, prompt]
    )

    answer = getattr(response, "text", None)
    if not answer:
        raise ValueError("Response kosong dari Gemini API")

    return answer.strip()

if __name__ == "__main__":
    if len(sys.argv) < 2:
        print(json.dumps({"status": "error", "message": "Penggunaan: python extract_ocr.py <image_path>"}))
        sys.exit(1)

    image_path = sys.argv[1]
    try:
        ocr_result = run_ocr(image_path)
        print(json.dumps({"status": "success", "ocr_text": ocr_result}))
    except Exception as e:
        print(json.dumps({"status": "error", "message": str(e)}))
        sys.exit(1)
