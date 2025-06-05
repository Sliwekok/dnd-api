import requests
from bs4 import BeautifulSoup
import json
import re
from time import sleep
from random import uniform

def parse_monster_page(url):
    try:
        response = requests.get(url)
        response.raise_for_status()
    except Exception as e:
        print(f"Failed to fetch {url}: {e}")
        return None

    soup = BeautifulSoup(response.text, 'html.parser')
    main = soup.find('div', class_='jaune')
    if not main:
        print(f"No monster data found in {url}")
        return None

    # Basic Info
    name = main.find('h1').text.strip()
    type_line = main.find('div', class_='type').text.strip()
    content = main.get_text(separator="\n", strip=True)
    init_match = re.search(r'Initiative\s+([^\n]+)', content, re.IGNORECASE)
    init = init_match.group(1).strip() if init_match else None

    ac = re.search(r'AC\s+(\d+)', content)
    hp = re.search(r'HP\s+([^\n]+)', content)
    speed = re.search(r'Speed\s+([^\n]+)', content)
    skills = re.search(r'Skills\s+([^\n]+)', content)
    senses = re.search(r'Senses\s+([^\n]+)', content)
    languages = re.search(r'Languages\s+([^\n]+)', content)
    cr = re.search(r'CR\s+([^\n]+)', content)

    # Abilities
    abilities = {}
    for abbr in ['Str', 'Dex', 'Con', 'Int', 'Wis', 'Cha']:
        match = re.search(fr'{abbr}\s+(\d+)\s+([+-]?\d+)', content)
        if match:
            abilities[abbr] = {
                "score": int(match.group(1)),
                "mod": int(match.group(2))
            }

    # Actions and Reactions
    actions, reactions = [], []
    rubrics = main.find_all('div', class_='rub')
    for rub in rubrics:
        label = rub.text.strip().lower()
        texts = []
        for sib in rub.next_siblings:
            if sib.name == 'div' and 'rub' in sib.get('class', []):
                break
            if sib.name is None and sib.strip():
                texts.append(sib.strip())
        if "reaction" in label:
            reactions.extend(texts)
        elif "action" in label:
            actions.extend(texts)

    # Extras
    description = soup.find('div', class_='description')
    habitat = soup.find_all('div', class_='habitat')
    source = soup.find('div', class_='source')

    return {
        "name": name,
        "type": type_line,
        "initiative": init,
        "ac": ac.group(1) if ac else None,
        "hp": hp.group(1) if hp else None,
        "speed": speed.group(1) if speed else None,
        "abilities": abilities,
        "skills": skills.group(1) if skills else None,
        "senses": senses.group(1) if senses else None,
        "languages": languages.group(1) if languages else None,
        "cr": cr.group(1) if cr else None,
        "actions": actions,
        "reactions": reactions,
        "description": description.get_text(strip=True) if description else None,
        "habitat": {
            "habitat": habitat[0].get_text(strip=True).replace("Habitat:", "").strip() if len(habitat) > 0 else None,
            "treasure": habitat[1].get_text(strip=True).replace("Treasure:", "").strip() if len(habitat) > 1 else None,
        },
        "source": source.get_text(strip=True) if source else None,
        "url": url
    }

if __name__ == "__main__":
    with open("../../var/scraped_links.json", "r", encoding="utf-8") as f:
        urls = json.load(f)

    all_monsters = []
    for i, url in enumerate(urls):
        print(f"Scraping {i+1}/{len(urls)}: {url}")
        data = parse_monster_page(url)
        if data:
            all_monsters.append(data)
        sleep(uniform(0.5, 1.2))  # polite scraping

    with open("../../var/monsters.json", "w", encoding="utf-8") as f:
        json.dump(all_monsters, f, indent=4, ensure_ascii=False)

    print(f"Scraped {len(all_monsters)} monsters to monsters.json")
