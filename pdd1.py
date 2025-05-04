import os

# Define folders and files to exclude
EXCLUDED_FOLDERS = {'node_modules', '.git', '.vscode', '__pycache__', 'migrations'}
EXCLUDED_FILES = {'.DS_Store', 'package-lock.json', 'CreateP.py', 'tproco_schema.sql'}

# Limit the depth of recursion to avoid deep folder structures causing issues
MAX_DEPTH = 3  # Set a limit for recursion depth

def get_project_structure(path, indent="", depth=0):
    """Recursively gets the project structure as a formatted string."""
    if depth > MAX_DEPTH:
        return ""
    structure = f"{indent}{os.path.basename(path)}/\n"
    
    try:
        for item in sorted(os.listdir(path)):
            item_path = os.path.join(path, item)
            
            if item in EXCLUDED_FOLDERS or item in EXCLUDED_FILES:
                continue
            
            if os.path.isdir(item_path):
                structure += get_project_structure(item_path, indent + "    ", depth + 1)
            else:
                structure += f"{indent}    {item}\n"
    except Exception as e:
        structure += f"Error reading {path}: {e}\n"
    
    return structure

def main():
    project_path = os.getcwd()  # Get the current working directory (project root)
    structure = get_project_structure(project_path)
    print(structure)

if __name__ == "__main__":
    main()
