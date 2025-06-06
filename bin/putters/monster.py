import os
import json
from dotenv import load_dotenv
from pymongo import MongoClient

# Load MongoDB config from .env
load_dotenv("../../.env")
# MONGODB_URI = os.getenv("MONGODB_URL").replace("@", "%40")
MONGODB_URI = os.getenv("MONGODB_URL")
DB_NAME = os.getenv("MONGODB_DB")
COLLECTION_NAME = "Monster"

# Connect to MongoDB
client = MongoClient(MONGODB_URI)
db = client[DB_NAME]
collection = db[COLLECTION_NAME]

# Load your JSON monsters data
with open("../../var/monsters.json", "r", encoding="utf-8") as f:
    monsters = json.load(f)  # Should be a list of dicts

# Ensure the collection is empty before inserting new data
collection.delete_many({})
# Set the 'accepted' field to false and normalize 'nameGeneric'
for monster in monsters:
    monster['accepted'] = False
    monster['nameGeneric'] = monster['name'].replace(" ", "_").lower()
# Insert new monsters
result = collection.insert_many(monsters)
print(f"Inserted {len(result.inserted_ids)} monsters into MongoDB.")
