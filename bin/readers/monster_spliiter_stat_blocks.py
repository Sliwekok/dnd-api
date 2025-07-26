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

    # Actions, Reactions, Legendary, Mythic
    actions, reactions, legendary, mythic = [], [], [], []
    rubrics = main.find_all('div', class_='rub')
    for rub in rubrics:

        label = rub.text.strip().lower()
        texts = []
        current = ""

        for sib in rub.next_siblings:
            if isinstance(sib, str) and sib.strip():
                current += " " + sib.strip()
            elif hasattr(sib, 'get') and 'rub' in sib.get('class', []):
                break
            elif hasattr(sib, 'get_text'):
                content = sib.get_text(separator=" ", strip=True)
                if re.match(r'^[A-Z][^.]+[.:]$', content):  # Start of new entry (e.g., "Bite.")
                    if current:
                        texts.append(current.strip())
                    current = content
                else:
                    current += " " + content

        if current:
            texts.append(current.strip())

        if "reaction" in label:
            reactions.extend(texts)
        elif "action" in label:
            actions.extend(texts)
        elif "trait" in label or "special" in label:
            traits = texts  # NEW: Save traits

    # Extras
    description = soup.find('div', class_='description')

    habitat_section = soup.find('div', class_='habitat')
    habitat_data = {}
    if habitat_section:
        for span in habitat_section.find_all('span'):
            label = span.get_text(strip=True).lower()
            next_sibling = span.find_next_sibling(text=True)
            if next_sibling:
                if "habitat" in label:
                    habitat_data["habitat"] = next_sibling.strip()
                elif "treasure" in label:
                    habitat_data["treasure"] = next_sibling.strip()

    source = soup.find('div', class_='source')

    traits = traits if 'traits' in locals() else []


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
        "legendary": legendary,
        "mythic": mythic,
        "description": description.get_text(strip=True) if description else None,
        "habitat": habitat_data if habitat_data else None,
        "traits": traits,
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
