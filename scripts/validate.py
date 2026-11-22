#!/usr/bin/env python3
"""Source-only checks. Does not claim a live WordPress integration test."""
from html.parser import HTMLParser
from pathlib import Path
from urllib.parse import unquote, urlsplit
import json
import xml.etree.ElementTree as ET

ROOT = Path(__file__).resolve().parents[1]
THEME = ROOT / 'wp-content/themes/northline'
PLUGIN = ROOT / 'wp-content/plugins/northline-core'
DOCS = ROOT / 'docs'
required = [
    THEME / 'style.css', THEME / 'index.php', THEME / 'front-page.php',
    THEME / 'screenshot.png', THEME / 'theme.json',
    THEME / 'header.php', THEME / 'footer.php',
    THEME / 'assets/css/main.css', THEME / 'assets/js/site.js',
    PLUGIN / 'northline-core.php', PLUGIN / 'assets/js/projects-block.js',
    PLUGIN / 'blocks/project-grid/block.json',
    DOCS / 'index.html', DOCS / 'projects.html',
]
errors = [f'Missing file: {p.relative_to(ROOT)}' for p in required if not p.is_file()]
try:
    theme_json = json.loads((THEME / 'theme.json').read_text())
    assert theme_json['version'] == 3
    block_json = json.loads((PLUGIN / 'blocks/project-grid/block.json').read_text())
    assert block_json['name'] == 'northline/project-grid'
except (json.JSONDecodeError, AssertionError, KeyError) as e:
    errors.append(f'Invalid theme.json: {e}')

class Links(HTMLParser):
    def __init__(self):
        super().__init__()
        self.refs=[]
    def handle_starttag(self, tag, attrs):
        if tag in ('a', 'img', 'script', 'link'):
            a=dict(attrs)
            value=a.get('href') if tag in ('a','link') else a.get('src')
            if value:
                self.refs.append(value)

for page in DOCS.rglob('*.html'):
    parser=Links()
    parser.feed(page.read_text(encoding='utf-8'))
    for ref in parser.refs:
        parsed=urlsplit(ref)
        if parsed.scheme or ref.startswith(('#','//','mailto:','tel:')):
            continue
        dest=(page.parent/unquote(parsed.path)).resolve()
        if not dest.is_relative_to(DOCS.resolve()) or not dest.is_file():
            errors.append(f'Broken local preview link: {page.relative_to(ROOT)} -> {ref}')
for asset in (THEME/'assets/images').glob('*.svg'):
    try: ET.parse(asset)
    except ET.ParseError as e:errors.append(f'Invalid SVG: {asset.name}: {e}')

if errors:
    print('\n'.join(errors))
    raise SystemExit(1)
print('PASS: Required files, theme.json, SVG images and local GitHub Pages links.')
