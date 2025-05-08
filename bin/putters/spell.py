import os
import json
from dotenv import load_dotenv
from pymongo import MongoClient

# Load MongoDB config from .env
load_dotenv("../../.env")
MONGODB_URI = os.getenv("MONGODB_URL")
DB_NAME = os.getenv("MONGODB_DB")
COLLECTION_NAME = "Spell"

# Connect to MongoDB
client = MongoClient(MONGODB_URI)
db = client[DB_NAME]
collection = db[COLLECTION_NAME]

# Load your JSON spell data
with open("../../var/spells.json", "r", encoding="utf-8") as f:
    spells = json.load(f)  # Should be a list of dicts


# Insert new spells
result = collection.insert_many(spells)
print(f"Inserted {len(result.inserted_ids)} spells into MongoDB.")
