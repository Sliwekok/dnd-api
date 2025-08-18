import requests
from bs4 import BeautifulSoup
import json
from urllib.parse import urljoin
import os
from dotenv import load_dotenv

load_dotenv("../../.env")

BASE_URL = "https://www.aidedd.org/spell/"

def scrape_table_links(url):
    response = requests.get(url)
    response.raise_for_status()

    soup = BeautifulSoup(response.text, 'html.parser')
    table = soup.find('table', id='liste')

    if not table:
        print("Table with ID 'liste' not found.")
        return []

    links = []
    for td in table.find_all('td', class_='item'):
        a_tag = td.find('a', href=True)
        if a_tag:
            full_url = urljoin(url, a_tag['href'])
            links.append(full_url)

    return links

if __name__ == "__main__":
    urls = scrape_table_links(BASE_URL)


    with open('../../var/scraped_links_spells.json', 'w', encoding='utf-8') as f:
        json.dump(urls, f, indent=4, ensure_ascii=False)

    print(f"Saved {len(urls)} URLs to scraped_links_spells.json")
