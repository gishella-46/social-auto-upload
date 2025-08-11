from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from typing import Optional
import os
import random

# Inisialisasi FastAPI
app = FastAPI(title="AI Caption & Content Generator API")

# Model request untuk endpoint generate-caption
class PostRequest(BaseModel):
    caption: Optional[str] = None
    topic: Optional[str] = None
    platform: str

# Model response untuk endpoint generate-caption
class CaptionResponse(BaseModel):
    generated_caption: str
    platform: str

# Endpoint root
@app.get("/")
async def root():
    return {"message": "Server is running 🚀"}

# Endpoint untuk generate caption
@app.post("/generate-caption/", response_model=CaptionResponse)
async def generate_caption(post: PostRequest):
    try:
        topic = post.topic or "general content"

        # Contoh caption (dummy)
        sample_captions = [
            f"🔥 Tips hari ini: {topic.capitalize()}! #inspirasi",
            f"Siap sukses di {post.platform}? Mulai dari {topic} 💡",
            f"{topic.capitalize()} adalah kunci untuk berkembang! 🚀",
        ]
        generated = random.choice(sample_captions)

        return CaptionResponse(
            generated_caption=generated,
            platform=post.platform
        )
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))

# Endpoint health check
@app.get("/health")
async def health_check():
    return {"status": "ok"}

# Endpoint favicon (biar gak 404 di browser)
@app.get("/favicon.ico")
async def favicon():
    return {}
