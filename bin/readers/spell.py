import fitz
import re
import json

def extract_text_from_pdf(pdf_path):
    doc = fitz.open(pdf_path)
    return "\n".join(page.get_text() for page in doc)

def find_spell_blocks(text):
    pattern = re.compile(r'([A-Z][A-Z\s\-]+)\n(?:Level \d+|.*Cantrip)', re.MULTILINE)
    matches = list(pattern.finditer(text))

    spells = []
    for i, match in enumerate(matches):
        start = match.start()
        end = matches[i + 1].start() if i + 1 < len(matches) else len(text)
        block = text[start:end].strip()
        spells.append(block)

    return spells

def clean_ocr_errors(text):
    text = text.replace("l hour", "1 hour")
    text = text.replace("{", "(").replace("}", ")")
    text = re.sub(r"\bO\b", "0", text)  # 'O' as digit zero
    return text

def normalize_title_line(line):
    # Fix things like: "H UNTER'S MARK" → "Hunter's Mark"
    line = re.sub(r"\b([A-Z])\s+([A-Z])", r"\1\2", line)
    return line.title()

def parse_spell_block(block):
    lines = clean_ocr_errors(block.strip()).split("\n")
    lines = [line.strip() for line in lines if line.strip()]

    # Normalize spell name
    name = normalize_title_line(lines[0])

    # Detect and fix the level + school line
    level_school_line = lines[1]
    level_match = re.search(r'Level (\d+)', level_school_line)
    cantrip = "Cantrip" in level_school_line
    school_match = re.search(r'(Cantrip|Level \d+)\s+([A-Za-z]+)', level_school_line)
    classes_match = re.findall(r'\((.*?)\)', level_school_line)

    # Extract known fields
    def get_value(field):
        for line in lines:
            if field.lower() in line.lower() and ":" in line:
                return line.split(":", 1)[1].strip()
        return ""

    casting_time = get_value("Casting Time")
    range_ = get_value("Range")
    duration = get_value("Duration")
    components_line = get_value("Components")

    # Parse components and optional material
    components = []
    component_material = None
    if components_line:
        material_match = re.search(r'M\s*\((.*?)\)', components_line)
        component_material = material_match.group(1).strip() if material_match else None
        components = re.sub(r'\(.*?\)', '', components_line)
        components = [c.strip() for c in components.split(",") if c.strip()]

    # Description starts after "Duration:"
    try:
        start_desc_idx = next(i for i, line in enumerate(lines) if "Duration" in line)
        desc_lines = lines[start_desc_idx + 1:]
        description = " ".join(desc_lines).strip()
    except StopIteration:
        description = ""

    return {
        "name": name,
        "level": 0 if cantrip else int(level_match.group(1)) if level_match else -1,
        "school": school_match.group(2).lower() if school_match else "Unknown",
        "actionType": (
                          "bonus" if "Bonus Action" in casting_time
                          else "reaction" if "Reaction" in casting_time
                          else "action"
                      ),
        "castingTime": casting_time,
        "range": range_,
        "duration": duration,
        "components": components,
        "componentMaterial": component_material,
        "description": description,
        "classes": classes_match[0].lower().split(", ") if classes_match else [],
        "concentration": "Concentration" in duration,
        "ritual": "ritual" in casting_time.lower() or "ritual" in description.lower(),
        "accepted": False,
        "nameGeneric": name.replace(" ", "_").lower()
    }

def get_value_from_prefix(lines, prefix):
    for line in lines:
        if line.startswith(prefix):
            return line.replace(prefix, "").strip()
    return ""

if __name__ == "__main__":
    pdf_path = "./pdf_cut.pdf"
    raw_text = extract_text_from_pdf(pdf_path)
    blocks = find_spell_blocks(raw_text)

    parsed_spells = []
    for block in blocks:
        spell = parse_spell_block(block)
        if spell:
            parsed_spells.append(spell)

    with open("../../var/spells.json", "w", encoding="utf-8") as f:
        json.dump(parsed_spells, f, indent=4, ensure_ascii=True)

    print(f"Extracted {len(parsed_spells)} spells to spells.json")
