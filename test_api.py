import requests

BASE_URL = "http://127.0.0.1:8000"

def test_generate_caption(caption, topic, platform):
    """
    Mengirim request ke FastAPI untuk generate caption
    """
    url = f"{BASE_URL}/generate-caption/"
    payload = {
        "caption": caption,
        "topic": topic,
        "platform": platform
    }

    try:
        response = requests.post(url, json=payload, timeout=10)
        response.raise_for_status()  # error kalau status code != 200
        data = response.json()
        print(f"[{platform.upper()}] Generated Caption: {data['generated_caption']}")
    except requests.exceptions.RequestException as e:
        print(f"❌ Request failed for platform {platform}: {e}")
    except KeyError:
        print(f"⚠ Unexpected response format: {response.text}")

if __name__ == "__main__":
    # Contoh test tunggal
    test_generate_caption(
        caption="Foto pemandangan pantai yang indah saat matahari terbenam",
        topic="travel",
        platform="instagram"
    )

    # Contoh test multiple platform
    print("\n--- Multiple Test ---")
    test_data = [
        ("Foto meja kerja minimalis dengan laptop dan kopi", "productivity", "linkedin"),
        ("Pemandangan gunung dan danau saat pagi hari", "nature", "instagram"),
        ("Poster acara seminar AI nasional", "technology", "linkedin"),
    ]

    for caption, topic, platform in test_data:
        test_generate_caption(caption, topic, platform)
