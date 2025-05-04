import os
from fpdf import FPDF

# Define folders and files to exclude (relative paths or folder names)
EXCLUDED_FOLDERS = {
    'node_modules', '.git', '.vscode', '__pycache__',
    'vendor', 'storage', 'tests', 'public/build', 'build'
}
EXCLUDED_FILES = {
    '.DS_Store', 'package-lock.json', 'pdd.py',
    'phpunit.xml', 'postcss.config.js', 'tailwind.config.js',
    'vite.config.js', 'composer.lock', '.editorconfig',
    '.gitattributes', '.gitignore', '.htaccess', 'artisan',
    'favicon.ico', 'robots.txt'
}
EXCLUDED_EXTENSIONS = {
    '.log', '.ico', '.svg', '.png', '.jpg', '.jpeg', '.gif',
    '.pdf', '.zip', '.tar', '.gz', '.sqlite', '.env'
}

def get_project_structure(path, indent=""):
    """Recursively gets the project structure as a formatted string."""
    structure = f"{indent}{os.path.basename(path)}/\n"
    
    try:
        for item in sorted(os.listdir(path)):
            item_path = os.path.join(path, item)
            relative_path = os.path.relpath(item_path, path).replace("\\", "/")

            if (
                item in EXCLUDED_FILES or
                os.path.splitext(item)[1] in EXCLUDED_EXTENSIONS or
                any(relative_path.startswith(folder) for folder in EXCLUDED_FOLDERS)
            ):
                continue

            if os.path.isdir(item_path):
                structure += get_project_structure(item_path, indent + "    ")
            else:
                structure += f"{indent}    {item}\n"
    except Exception as e:
        structure += f"Error reading {path}: {e}\n"
    
    return structure

def get_file_contents(path):
    """Reads and returns file contents safely."""
    try:
        if os.path.getsize(path) > 100000:  # Skip files > 100KB
            return "[File too large to include]"
        with open(path, "r", encoding="utf-8", errors="ignore") as f:
            return f.read()
    except Exception as e:
        return f"Error reading file: {e}"

def remove_unsupported_characters(text):
    """Remove unsupported characters from the text (replace with '?')."""
    return ''.join([c if ord(c) < 128 else '?' for c in text])

def should_include_file(file_path, base_path):
    """Determine if a file should be included in the documentation."""
    filename = os.path.basename(file_path)
    ext = os.path.splitext(filename)[1]
    relative_path = os.path.relpath(file_path, base_path).replace("\\", "/")

    if (
        filename in EXCLUDED_FILES or
        ext in EXCLUDED_EXTENSIONS or
        any(relative_path.startswith(folder) for folder in EXCLUDED_FOLDERS)
    ):
        return False

    include_dirs = {
        'app', 'config', 'database', 'resources/views',
        'routes', 'resources/js', 'resources/css'
    }

    return any(relative_path.startswith(d) for d in include_dirs)

def generate_pdf(project_path, output_pdf):
    pdf = FPDF()
    pdf.set_auto_page_break(auto=True, margin=15)
    pdf.set_font("Courier", size=10)

    # Project structure page
    pdf.add_page()
    pdf.set_font("Arial", style='B', size=14)
    pdf.cell(200, 10, "Project Structure", ln=True, align='C')
    pdf.ln(10)
    pdf.set_font("Courier", size=10)
    structure = get_project_structure(project_path)
    structure = remove_unsupported_characters(structure)
    pdf.multi_cell(0, 5, structure)

    # File content pages
    for root, dirs, files in os.walk(project_path):
        rel_root = os.path.relpath(root, project_path).replace("\\", "/")

        # Skip entire folder if excluded
        if any(rel_root.startswith(folder) for folder in EXCLUDED_FOLDERS):
            continue

        # Prune excluded subdirectories
        dirs[:] = [
            d for d in dirs if not any(
                os.path.join(rel_root, d).replace("\\", "/").startswith(folder)
                for folder in EXCLUDED_FOLDERS
            )
        ]

        for file in files:
            file_path = os.path.join(root, file)
            if not should_include_file(file_path, project_path):
                continue

            relative_path = os.path.relpath(file_path, project_path).replace("\\", "/")
            content = get_file_contents(file_path)
            content = remove_unsupported_characters(content)

            pdf.add_page()
            pdf.set_font("Arial", style='B', size=12)
            pdf.cell(0, 10, relative_path, ln=True)
            pdf.ln(5)
            pdf.set_font("Courier", size=9)
            pdf.multi_cell(0, 5, content)

    pdf.output(output_pdf)
    print(f"PDF saved as {output_pdf}")

def main():
    project_path = os.getcwd()
    output_pdf = "project_documentation.pdf"
    generate_pdf(project_path, output_pdf)

if __name__ == "__main__":
    main()
