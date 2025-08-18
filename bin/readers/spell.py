import requests
from bs4 import BeautifulSoup
import json
import re
from time import sleep
from random import uniform


def parse_spell_page(url):
    try:
        response = requests.get(url)
        response.raise_for_status()
    except Exception as e:
        print(f"Failed to fetch {url}: {e}")
        return None

    soup = BeautifulSoup(response.text, "html.parser")
    main = soup.find("div", class_="col1")
    if not main:
        print(f"No spell data found in {url}")
        return None

    # --- Name ---
    name_tag = main.find("h1")
    name = name_tag.get_text(strip=True) if name_tag else "Unknown"

    # --- Level + school (+ possible class restriction) ---
    ecole_tag = main.find("div", class_="ecole")
    level = 0
    school = ""
    classes = []
    if ecole_tag:
        text = ecole_tag.get_text(" ", strip=True)
        m = re.match(r"Level\s+(\d+)\s+([A-Za-z]+)(?:\s*\((.*?)\))?", text)
        if m:
            level = int(m.group(1))
            school = m.group(2).lower()
            if m.group(3):
                # class restriction in parentheses
                classes = [c.strip().lower() for c in m.group(3).split(",")]

    # --- Casting Time ---
    casting_tag = main.find("div", class_="t")
    casting_time = casting_tag.get_text(" ", strip=True).replace("Casting Time:", "").strip() if casting_tag else ""
    casting_time = casting_time.replace("Casting Time :", "").strip()
    # --- Range ---
    range_tag = main.find("div", class_="r")
    spell_range = range_tag.get_text(" ", strip=True).replace("Range:", "").strip() if range_tag else ""
    spell_range = spell_range.replace("Range :", "").strip()

    # --- Components ---
    comp_tag = main.find("div", class_="c")
    components_list = []
    component_material = None
    if comp_tag:
        comp_text = comp_tag.get_text(" ", strip=True).replace("Components:", "").strip()
        comp_text = comp_text.replace("Components :", "").strip()
        m = re.match(r"^(.*?)\s*(?:\((.*?)\))?$", comp_text)
        if m:
            comps = [c.strip() for c in m.group(1).split(",") if c.strip()]
            components_list = comps
            if m.group(2):
                component_material = m.group(2).strip()

    # --- Duration ---
    duration_tag = main.find("div", class_="d")
    duration = duration_tag.get_text(" ", strip=True).replace("Duration:", "").strip() if duration_tag else ""
    duration = duration.replace("Duration :", "").strip()
    # Ritual / Concentration detection
    ritual = "ritual" in duration.lower() or "ritual" in casting_time.lower()
    concentration = "concentration" in duration.lower()

    # --- Description ---
    descr_tag = main.find("div", class_="description")
    description = ""
    if descr_tag:
        # Replace <br> with line breaks
        for br in descr_tag.find_all("br"):
            br.replace_with("\n")
        description = descr_tag.get_text(" ", strip=True)

    # --- Source ---
    source_tag = main.find("div", class_="source")
    source = source_tag.get_text(" ", strip=True) if source_tag else ""

    # Build JSON
    data = {
        "name": name,
        "level": level,
        "school": school,
        "actionType": (
                                                "bonus" if "Bonus Action" in casting_time
                                                else "reaction" if "Reaction" in casting_time
                                                else "action"
                                            ),
        "castingTime": casting_time,
        "range": spell_range,
        "duration": duration,
        "components": components_list,
        "componentMaterial": component_material,
        "description": description,
        "classes": classes,
        "concentration": concentration,
        "ritual": ritual,
        "accepted": False,
        "nameGeneric": name.replace(" ", "_").lower(),
        "source": source,
        "url": url
    }

    return data


if __name__ == "__main__":
    with open("../../var/scraped_links_spells.json", "r", encoding="utf-8") as f:
        urls = json.load(f)

    all_spells = []
    for i, url in enumerate(urls):
        print(f"Scraping {i+1}/{len(urls)}: {url}")
        data = parse_spell_page(url)
        if data:
            all_spells.append(data)
        sleep(uniform(0.5, 1.2))

    with open("../../var/spells.json", "w", encoding="utf-8") as f:
        json.dump(all_spells, f, indent=4, ensure_ascii=False)

    print(f"Scraped {len(all_spells)} spells to spells.json")
