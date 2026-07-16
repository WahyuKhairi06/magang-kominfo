import sys
import json
import traceback
import os
from pathlib import Path

# Pastikan working directory adalah folder ai-service agar import dan file .env bisa dibaca
BASE_DIR = Path(__file__).resolve().parent
os.chdir(str(BASE_DIR))
sys.path.append(str(BASE_DIR))

# Kita suppress stdout dari rich kalau ada error di main.py agar output tetap JSON bersih
class DummyConsole:
    def print(self, *args, **kwargs):
        pass
    def status(self, *args, **kwargs):
        class DummyStatus:
            def __enter__(self): pass
            def __exit__(self, exc_type, exc_val, exc_tb): pass
        return DummyStatus()

import main
main.console = DummyConsole()  # Override console biar ga print aneh-aneh

try:
    from main import build_corpus, load_knowledge_base, retrieve_context, load_api_key, load_model_name, init_gemini_client, ask_gemini
    from prompt import build_prompt

    def process_chat(user_message, ai_name, puskesmas_name):
        api_key = load_api_key()
        model_name = load_model_name()
        knowledge_base = load_knowledge_base()
        corpus = build_corpus(knowledge_base)
        client = init_gemini_client(api_key)

        context = retrieve_context(user_message, corpus)
        full_prompt = build_prompt(user_message, context, ai_name, puskesmas_name)
        
        answer = ask_gemini(client, model_name, full_prompt)
        return {"status": "success", "answer": answer}

    if __name__ == "__main__":
        if len(sys.argv) < 2:
            print(json.dumps({"status": "error", "message": "No message provided"}))
            sys.exit(1)
            
        user_message = sys.argv[1]
        ai_name = sys.argv[2] if len(sys.argv) > 2 else "Asisten AI Puskesmas"
        puskesmas_name = sys.argv[3] if len(sys.argv) > 3 else "Puskesmas Marunggi"
        result = process_chat(user_message, ai_name, puskesmas_name)
        
        # Pastikan hanya print json string
        print(json.dumps(result))

except SystemExit as e:
    # Error dari load_api_key dll yang panggil sys.exit
    print(json.dumps({"status": "error", "message": "Setup AI Service tidak valid. Cek .env atau knowledge base. Code: " + str(e), "trace": traceback.format_exc()}))
except Exception as e:
    print(json.dumps({"status": "error", "message": str(e), "trace": traceback.format_exc()}))
