"""
Script untuk generate PDF berisi source code project Laravel EbookStore.
Cara pakai:
    1. Install dependency: pip install reportlab
    2. Letakkan file ini di root folder project (C:\\laragon\\www\\ebook-store)
    3. Jalankan: python generate_source_pdf.py
    4. Hasil: source_code_ebookstore.pdf
"""

import os
from reportlab.lib.pagesizes import A4
from reportlab.lib.units import cm
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer, PageBreak, Preformatted
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.lib import colors

# ── KONFIGURASI ──────────────────────────────────────────────
# Folder & file yang akan disertakan (sesuaikan jika perlu)
INCLUDE_DIRS = [
    "app/Http/Controllers",
    "app/Http/Middleware",
    "app/Models",
    "database/migrations",
    "database/seeders",
    "routes",
]

# Ekstensi file yang diambil
INCLUDE_EXT = [".php"]

OUTPUT_FILE = "source_code_ebookstore.pdf"
PROJECT_TITLE = "Source Code - EbookStore (Sistem Penjualan Ebook Digital)"
# ──────────────────────────────────────────────────────────────


def collect_files():
    files = []
    for d in INCLUDE_DIRS:
        if not os.path.exists(d):
            continue
        for root, _, filenames in os.walk(d):
            for f in filenames:
                if any(f.endswith(ext) for ext in INCLUDE_EXT):
                    files.append(os.path.join(root, f))
    return sorted(files)


def build_pdf(files):
    doc = SimpleDocTemplate(
        OUTPUT_FILE,
        pagesize=A4,
        leftMargin=1.5 * cm,
        rightMargin=1.5 * cm,
        topMargin=1.5 * cm,
        bottomMargin=1.5 * cm,
    )

    styles = getSampleStyleSheet()

    title_style = ParagraphStyle(
        "TitleCustom", parent=styles["Title"], fontSize=18, spaceAfter=20
    )
    heading_style = ParagraphStyle(
        "HeadingCustom",
        parent=styles["Heading2"],
        fontSize=12,
        textColor=colors.HexColor("#e94560"),
        spaceBefore=10,
        spaceAfter=6,
    )
    code_style = ParagraphStyle(
        "Code",
        fontName="Courier",
        fontSize=7.5,
        leading=9,
        leftIndent=0,
        backColor=colors.HexColor("#f8f7f4"),
    )

    story = []

    # Cover
    story.append(Spacer(1, 6 * cm))
    story.append(Paragraph(PROJECT_TITLE, title_style))
    story.append(Paragraph("Lampiran Source Code", styles["Normal"]))
    story.append(PageBreak())

    # Daftar file
    story.append(Paragraph("Daftar File", heading_style))
    for f in files:
        story.append(Paragraph(f.replace("\\", "/"), styles["Normal"]))
    story.append(PageBreak())

    # Isi tiap file
    for f in files:
        story.append(Paragraph(f.replace("\\", "/"), heading_style))
        try:
            with open(f, "r", encoding="utf-8", errors="ignore") as fp:
                content = fp.read()
        except Exception as e:
            content = f"[Tidak bisa membaca file: {e}]"

        # Pecah jadi baris agar tidak overflow
        story.append(Preformatted(content, code_style))
        story.append(PageBreak())

    doc.build(story)
    print(f"Selesai! File tersimpan sebagai: {OUTPUT_FILE}")
    print(f"Total file: {len(files)}")


if __name__ == "__main__":
    files = collect_files()
    if not files:
        print("Tidak ada file ditemukan. Pastikan script ini diletakkan di root project Laravel.")
    else:
        build_pdf(files)
