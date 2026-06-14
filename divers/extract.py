import os
from pdf2image import convert_from_path

os.makedirs("images", exist_ok=True)

pages = convert_from_path("Dossier_inscription_tournoi_inter_entreprise.pdf", dpi=300, poppler_path=r"C:\poppler\poppler-26.02.0\Library\bin")

for i, page in enumerate(pages):
    page.save(f"page_{i+1}.jpg", "JPEG" , quality=90 )

print(f"{len(pages)} pages converties en images !")