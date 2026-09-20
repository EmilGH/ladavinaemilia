from __future__ import annotations

import csv
import sys
import xml.etree.ElementTree as element_tree
import zipfile
from datetime import datetime
from pathlib import Path

source_path = Path(sys.argv[1])
output_path = Path(sys.argv[2])
namespace = {'w': 'http://schemas.openxmlformats.org/wordprocessingml/2006/main'}

with zipfile.ZipFile(source_path) as archive:
    root = element_tree.fromstring(archive.read('word/document.xml'))

paragraphs = [
    ''.join(node.text or '' for node in paragraph.findall('.//w:t', namespace)).strip()
    for paragraph in root.findall('.//w:p', namespace)
]

def safe_cell(value: str) -> str:
    value = value.strip()
    return "'" + value if value.startswith(('=', '+', '-', '@')) else value

rows = []
for index, value in enumerate(paragraphs):
    if not value.startswith('by '):
        continue
    date_index = next(
        (candidate for candidate in range(index + 1, min(index + 8, len(paragraphs))) if paragraphs[candidate].startswith('Borrowed on: ')),
        None,
    )
    if date_index is None:
        continue
    title_index = index - 1
    while title_index >= 0 and not paragraphs[title_index]:
        title_index -= 1
    borrowed = paragraphs[date_index].replace('Borrowed on: ', '', 1)
    borrowed_date = datetime.strptime(borrowed, '%b %d, %Y').date().isoformat()
    status = 'Current' if 'Return' in paragraphs[index + 1:date_index + 1] else 'Returned'
    rows.append([
        len(rows) + 1,
        safe_cell(paragraphs[title_index]),
        safe_cell(value.removeprefix('by ')),
        borrowed_date,
        status,
        'Kindle Unlimited',
    ])

if not rows:
    raise RuntimeError('No Kindle Unlimited records were found in the supplied document.')

output_path.parent.mkdir(parents=True, exist_ok=True)
with output_path.open('w', encoding='utf-8-sig', newline='') as destination:
    writer = csv.writer(destination)
    writer.writerow(['Record Number', 'Title', 'Author', 'Date Borrowed', 'Borrow Status', 'Collection'])
    writer.writerows(rows)

print(f'Wrote {len(rows)} Kindle Unlimited records to {output_path}')
