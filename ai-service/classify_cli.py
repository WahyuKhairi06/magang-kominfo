import sys
import json
import os
from pathlib import Path

# Pastikan working directory adalah folder ai-service agar import dan file .env bisa dibaca
BASE_DIR = Path(__file__).resolve().parent
os.chdir(str(BASE_DIR))
sys.path.append(str(BASE_DIR))

import dotenv
dotenv.load_dotenv()

from google import genai
from google.genai import types
from prompt_classify import build_classification_prompt
from taxonomy import CLASSIFICATION_SCHEMA

def main():
    if len(sys.argv) < 3:
        print(json.dumps({"status": "error", "message": "Subjek dan isi pengaduan diperlukan."}))
        sys.exit(1)
    
    subjek = sys.argv[1]
    isi = sys.argv[2]
    
    api_key = os.getenv("GEMINI_API_KEY")
    model_name = os.getenv("GEMINI_CLASSIFY_MODEL", "gemini-2.0-flash")
    
    prompt = build_classification_prompt(subjek, isi)
    
    try:
        # Inisialisasi client Google GenAI
        client = genai.Client(api_key=api_key)
        response = client.models.generate_content(
            model=model_name,
            contents=prompt,
            config=types.GenerateContentConfig(
                response_mime_type="application/json",
                response_schema=CLASSIFICATION_SCHEMA,
                temperature=0.2,
            ),
        )
        result = json.loads(response.text)
        print(json.dumps({"status": "success", "data": result}))
    except Exception as e:
        # Fallback ke klasifikasi kata kunci lokal jika API gagal
        from classify_complaint import local_keyword_classify
        result = local_keyword_classify(subjek, isi)
        print(json.dumps({"status": "fallback", "data": result, "error": str(e)}))

if __name__ == "__main__":
    main()
