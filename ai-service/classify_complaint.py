"""
Endpoint klasifikasi pengaduan.

CARA INTEGRASI ke main.py yang sudah ada:
    from classify_complaint import router as complaint_router
    app.include_router(complaint_router)
"""

import os
import json
import logging
from fastapi import APIRouter, HTTPException, Header
from pydantic import BaseModel
from google import genai
from google.genai import types
from dotenv import load_dotenv

# Load .env file
load_dotenv()

from taxonomy import CLASSIFICATION_SCHEMA
from prompt_classify import build_classification_prompt

logger = logging.getLogger("classify_complaint")

router = APIRouter(prefix="/api/v1/admin", tags=["admin-ai"])

INTERNAL_API_KEY = os.getenv("INTERNAL_API_KEY")
GEMINI_API_KEY = os.getenv("GEMINI_API_KEY")
CLASSIFY_MODEL_NAME = os.getenv("GEMINI_CLASSIFY_MODEL", "gemini-2.5-flash")

class ClassifyRequest(BaseModel):
    pengaduan_id: int
    subjek: str
    isi: str

class ClassifyResponse(BaseModel):
    pengaduan_id: int
    kategori: str
    urgensi: str
    alasan: str

def _verify_internal_key(x_api_key: str | None):
    if not INTERNAL_API_KEY or x_api_key != INTERNAL_API_KEY:
        raise HTTPException(status_code=401, detail="Unauthorized — internal API key tidak valid")

def local_keyword_classify(subjek: str, isi: str) -> dict:
    text = (subjek + " " + isi).lower()
    
    # Kategori resmi sesuai taxonomy.py
    keywords = {
        'Pendaftaran & Administrasi': ['daftar', 'registrasi', 'online', 'ktp', 'kk', 'bpjs', 'kartu', 'administrasi', 'loket', 'berkas', 'rujukan', 'kis', 'kartu bpjs'],
        'Pelayanan Petugas/Medis': ['dokter', 'perawat', 'bidan', 'petugas', 'suster', 'pelayanan', 'ramah', 'kasar', 'lambat', 'cuek', 'marah', 'sopan', 'medis', 'layan'],
        'Waktu Tunggu & Antrean': ['lama', 'tunggu', 'antre', 'antrean', 'jam', 'menunggu', 'antrian'],
        'Kebersihan & Fasilitas': ['kotor', 'bersih', 'bau', 'toilet', 'wc', 'sampah', 'ac', 'panas', 'kursi', 'ruang', 'bocor', 'nyamuk'],
        'Ketersediaan Obat': ['obat', 'resep', 'apotek', 'habis', 'kosong', 'puyer', 'sirup', 'vitamin', 'salep', 'alkes', 'farmasi'],
        'Sarana & Prasarana': ['parkir', 'jalan', 'gedung', 'ambulan', 'ambulance', 'ruangan', 'kursi roda', 'timbangan', 'alat', 'tensi', 'fasilitas']
    }
    
    scores = {}
    for category, words in keywords.items():
        scores[category] = sum(1 for word in words if word in text)
        
    sorted_scores = sorted(scores.items(), key=lambda x: x[1], reverse=True)
    kategori = sorted_scores[0][0] if sorted_scores[0][1] > 0 else 'Lainnya'
    
    urgensi = 'rendah'
    emergency_keywords = ['darurat', 'gawat', 'sekarat', 'pingsan', 'kecelakaan', 'pendarahan', 'sesak', 'jantung', 'kejang', 'meninggal', 'mati', 'kritis', 'parah']
    if any(word in text for word in emergency_keywords):
        urgensi = 'tinggi'
    else:
        moderate_keywords = ['sakit', 'demam', 'luka', 'nyeri', 'muntah', 'diare', 'obat habis', 'antrean panjang', 'antrian panjang', 'kasar', 'lambat']
        if any(word in text for word in moderate_keywords):
            urgensi = 'sedang'
            
    return {
        'kategori': kategori,
        'urgensi': urgensi,
        'alasan': "Klasifikasi otomatis menggunakan sistem berbasis kata kunci lokal karena kegagalan API."
    }

@router.post("/classify-complaint", response_model=ClassifyResponse)
def classify_complaint(payload: ClassifyRequest, x_api_key: str | None = Header(default=None)):
    """
    Klasifikasi 1 pengaduan. Dipanggil oleh ClassifyPengaduanJob (Laravel queue),
    bukan langsung dari frontend publik manapun.
    """
    _verify_internal_key(x_api_key)

    if not payload.subjek.strip() and not payload.isi.strip():
        raise HTTPException(status_code=400, detail="Subjek dan isi pengaduan tidak boleh kosong")

    prompt = build_classification_prompt(payload.subjek, payload.isi)

    try:
        client = genai.Client(api_key=GEMINI_API_KEY)
        response = client.models.generate_content(
            model=CLASSIFY_MODEL_NAME,
            contents=prompt,
            config=types.GenerateContentConfig(
                response_mime_type="application/json",
                response_schema=CLASSIFICATION_SCHEMA,
                temperature=0.2,
            ),
        )
        result = json.loads(response.text)
    except Exception as exc:
        logger.error(f"Gagal klasifikasi pengaduan {payload.pengaduan_id}: {exc}")
        # Beralih ke sistem cadangan lokal alih-alih melempar HTTP 502
        result = local_keyword_classify(payload.subjek, payload.isi)

    return ClassifyResponse(
        pengaduan_id=payload.pengaduan_id,
        kategori=result["kategori"],
        urgensi=result["urgensi"],
        alasan=result["alasan"],
    )
