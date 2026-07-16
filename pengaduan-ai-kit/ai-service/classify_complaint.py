"""
Endpoint klasifikasi pengaduan.

CARA INTEGRASI ke main.py yang sudah ada:
    from classify_complaint import router as complaint_router
    app.include_router(complaint_router)

JANGAN buat instance FastAPI baru di sini — modul ini cuma menyediakan router
yang didaftarkan ke aplikasi FastAPI yang sudah berjalan di main.py.
"""

import os
import json
import logging
from fastapi import APIRouter, HTTPException, Header
from pydantic import BaseModel
import google.generativeai as genai

from taxonomy import CLASSIFICATION_SCHEMA
from prompt_classify import build_classification_prompt

logger = logging.getLogger("classify_complaint")

router = APIRouter(prefix="/api/v1/admin", tags=["admin-ai"])

INTERNAL_API_KEY = os.getenv("INTERNAL_API_KEY")
GEMINI_API_KEY = os.getenv("GEMINI_API_KEY")
# Model ringan cukup untuk tugas klasifikasi teks pendek — hemat kuota,
# jangan pakai model besar untuk tugas sesederhana ini.
CLASSIFY_MODEL_NAME = os.getenv("GEMINI_CLASSIFY_MODEL", "gemini-2.5-flash-lite")

genai.configure(api_key=GEMINI_API_KEY)


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
        model = genai.GenerativeModel(CLASSIFY_MODEL_NAME)
        response = model.generate_content(
            prompt,
            generation_config=genai.types.GenerationConfig(
                response_mime_type="application/json",
                response_schema=CLASSIFICATION_SCHEMA,
                temperature=0.2,  # rendah — tugas klasifikasi butuh konsistensi, bukan kreativitas
            ),
        )
        result = json.loads(response.text)
    except Exception as exc:
        logger.error(f"Gagal klasifikasi pengaduan {payload.pengaduan_id}: {exc}")
        raise HTTPException(status_code=502, detail=f"Gemini API error: {exc}")

    return ClassifyResponse(
        pengaduan_id=payload.pengaduan_id,
        kategori=result["kategori"],
        urgensi=result["urgensi"],
        alasan=result["alasan"],
    )
