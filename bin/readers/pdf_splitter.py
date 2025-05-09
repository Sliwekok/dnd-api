from pypdf import PdfReader, PdfWriter

def extract_pdf_pages(input_path, output_path, start_page, end_page):
    reader = PdfReader(input_path)
    writer = PdfWriter()

    for i in range(start_page - 1, end_page):
        writer.add_page(reader.pages[i])

    with open(output_path, "wb") as f:
        writer.write(f)

extract_pdf_pages("book.pdf", "output.pdf", start_page=10, end_page=20)
