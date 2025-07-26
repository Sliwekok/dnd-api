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

    name_tag = main.find('h1')
    name = name_tag.get_text(strip=True) if name_tag else 'Unknown'

    type_line = main.find('div', class_='type').text.strip()
    content = main.get_text(separator="\n", strip=True)

    init_match = re.search(r'Initiative\s+([^\n]+)', content, re.IGNORECASE)
    init = init_match.group(1).strip() if init_match else None

    ac = re.search(r'AC\s+(\d+)', content)
    hp = re.search(r'HP\s+([^\n]+)', content)
    speed = re.search(r'Speed\s+([^\n]+)', content)
    skills = re.search(r'Skills\s+([^\n]+)', content)
    match = re.search(r'Skills\s+([^\n]+)', content)

    if match:
        skills_str = match.group(1)
        skills_list = [skill.strip() for skill in skills_str.split(',')]
    senses = re.search(r'Senses\s+([^\n]+)', content)
    match = re.search(r'Senses\s+([^\n]+)', content)

    if match:
        senses_str = match.group(1)
        senses_list = [sense.strip() for sense in senses_str.split(',')]

    languages = re.search(r'Languages\s+([^\n]+)', content)
    match = re.search(r'Languages\s+([^\n]+)', content)

    if match:
        languages_str = match.group(1)
        languages_list = [lang.strip() for lang in languages_str.split(',')]
    cr = re.search(r'CR\s+([^\n]+)', content)

    abilities = {}
    for abbr in ['Str', 'Dex', 'Con', 'Int', 'Wis', 'Cha']:
        match = re.search(fr'{abbr}\s+(\d+)\s+([+-]?\d+)', content)
        if match:
            abilities[abbr] = {
                "score": int(match.group(1)),
                "mod": int(match.group(2))
            }

    traits = []
    actions = []
    bonus_actions = []
    legendary_actions = []
    reactions = []

    for rub in main.find_all('div', class_='rub'):
        label = rub.get_text(strip=True).lower()
        block = []

        # iterate all siblings at the same level
        for sib in rub.next_siblings:
            # stop when we hit the next rubric header
            if getattr(sib, 'name', None) == 'div' and 'rub' in sib.get('class', []):
                break

            # 1) If it's a <p>, start a new entry
            if getattr(sib, 'name', None) == 'p':
                full_text = sib.get_text(" ", strip=True)
                m = re.match(r'^(.+?)\.\s*(.+)$', full_text)
                if m:
                    # name + initial desc
                    block.append({
                        "name": m.group(1).strip(),
                        "desc": m.group(2).strip()
                    })
                else:
                    # no clear name → continuation of last
                    if block:
                        block[-1]["desc"] += " " + full_text
                        block[-1]["desc"] = re.sub(r'\s+', ' ', block[-1]["desc"]).strip()
                    else:
                        block.append({"name": "Unnamed", "desc": full_text})

            # 2) If it's text or <br>/<em>/<a> *after* a <p>, append to last desc
            elif block and (
                isinstance(sib, str)
                or sib.name in ["br", "em", "a"]
            ):
                text = sib.get_text(" ", strip=True) if hasattr(sib, 'get_text') else sib.strip()
                text = re.sub(r'\s+', ' ', text)
                if text:
                    block[-1]["desc"] += " " + text
                    block[-1]["desc"] = block[-1]["desc"].strip()

            # else ignore everything else

        # dispatch into the right category
        if   'legendary' in label:  legendary_actions.extend(block)
        elif 'bonus'     in label:  bonus_actions.extend(block)
        elif 'reaction'  in label:  reactions.extend(block)
        elif 'action'    in label:  actions.extend(block)
        else:                       traits.extend(block)

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
        "skills": skills_list if skills else None,
        "senses": senses_list if senses else None,
        "languages": languages_list if languages else None,
        "cr": cr.group(1) if cr else None,
        "actions": actions,
        "traits": traits,
        "bonusActions": bonus_actions,
        "legendaryActions": legendary_actions,
        "reactions": reactions,
        "description": description.get_text(strip=True) if description else "",
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
