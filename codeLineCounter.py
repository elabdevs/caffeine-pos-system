#!/usr/bin/env python3
import os
import argparse
from collections import defaultdict

DEFAULT_EXTS = {".html", ".htm", ".css", ".js", ".php"}
DEFAULT_EXCLUDES = {"node_modules", "vendor", ".git", "dist", "build", ".next", ".cache"}

def iter_files(root, exts, excludes):
    for r, dirs, files in os.walk(root):
        dirs[:] = [d for d in dirs if d not in excludes]
        for fn in files:
            ext = os.path.splitext(fn)[1].lower()
            if ext in exts:
                yield os.path.join(r, fn), ext

def is_comment_or_blank(line, ext, state):
    s = line.rstrip("\n")
    stripped = s.strip()
    if not stripped:
        return True
    if ext in {".html", ".htm"}:
        if state["in_block"]:
            if "-->" in stripped:
                state["in_block"] = False
            return True
        if stripped.startswith("<!--"):
            if "-->" not in stripped:
                state["in_block"] = True
            return True
        return False
    if state["in_block"]:
        if "*/" in stripped:
            state["in_block"] = False
        return True
    if ext in {".js", ".php"} and stripped.startswith("//"):
        return True
    if ext == ".php" and stripped.startswith("#"):
        return True
    if "/*" in stripped:
        start = stripped.find("/*")
        end = stripped.find("*/", start + 2)
        if start == 0 and end == -1:
            state["in_block"] = True
            return True
        if start == 0 and end >= 0:
            before = stripped[:start].strip()
            after = stripped[end+2:].strip()
            return not before and not after
        return False
    return False

def count_file(filepath, ext):
    total = 0
    code = 0
    state = {"in_block": False}
    with open(filepath, "r", encoding="utf-8", errors="ignore") as f:
        for line in f:
            total += 1
            if not is_comment_or_blank(line, ext, state):
                code += 1
    return total, code

def main():
    ap = argparse.ArgumentParser(description="Code Line Counter (HTML/CSS/JS/PHP)")
    ap.add_argument("--dir", "-d", default=".", help="Taranacak klasör (default: .)")
    ap.add_argument("--exts", "-e", nargs="*", help="Taranacak uzantılar (örn: .php .js .css)")
    ap.add_argument("--exclude", "-x", nargs="*", help="Atlanacak klasörler")
    ap.add_argument("--only-code", action="store_true", help="Sadece kod satırlarını yazdır")
    ap.add_argument("--no-summary", action="store_true", help="Uzantı bazlı özeti yazdırma")
    args = ap.parse_args()

    exts = set(e.lower() for e in (args.exts or DEFAULT_EXTS))
    excludes = set(args.exclude or DEFAULT_EXCLUDES)

    per_file = []
    totals = {"total_lines": 0, "code_lines": 0}
    by_ext = defaultdict(lambda: {"total": 0, "code": 0})

    for path, ext in iter_files(args.dir, exts, excludes):
        t, c = count_file(path, ext)
        per_file.append((path, t, c, ext))
        totals["total_lines"] += t
        totals["code_lines"] += c
        by_ext[ext]["total"] += t
        by_ext[ext]["code"] += c

    for path, t, c, _ in sorted(per_file, key=lambda x: x[0].lower()):
        if args.only_code:
            print(f"{path}: {c} code lines")
        else:
            print(f"{path}: {t} lines | {c} code")

    print("\n=== TOTAL ===")
    if args.only_code:
        print(f"Code lines: {totals['code_lines']}")
    else:
        print(f"All lines:  {totals['total_lines']}")
        print(f"Code lines: {totals['code_lines']}")

    if not args.no_summary:
        print("\n=== BY EXTENSION ===")
        for ext in sorted(by_ext.keys()):
            info = by_ext[ext]
            if args.only_code:
                print(f"{ext}: {info['code']} code lines")
            else:
                print(f"{ext}: {info['total']} lines | {info['code']} code")

if __name__ == "__main__":
    main()
