#!/usr/bin/env bash
set -euo pipefail

source_dir=$(cd "$1" && pwd)
assets_url=$2
mode=${3:---preview}
if [[ "$mode" != --preview && "$mode" != --commit ]]; then
  echo "Use --preview or --commit." >&2
  exit 1
fi

working_copy=$(mktemp -d)
trap 'rm -rf "$working_copy"' EXIT
svn checkout --quiet --non-interactive "$assets_url" "$working_copy"
cd "$working_copy"

rsync -rc --delete --exclude='.svn' --exclude='.DS_Store' "$source_dir/" ./
svn add --quiet --force --no-ignore .
python3 - <<'PY'
import subprocess
import xml.etree.ElementTree as ET
from pathlib import Path

status = ET.fromstring(subprocess.check_output(["svn", "status", "--xml"]))
mime_types = {".jpg": "image/jpeg", ".png": "image/png", ".gif": "image/gif", ".svg": "image/svg+xml"}
for entry in status.findall(".//entry"):
    path = entry.get("path")
    item = entry.find("wc-status").get("item")
    if item == "missing":
        subprocess.run(["svn", "delete", "--force", "--", path], check=True)
    elif item in {"added", "replaced"} and Path(path).is_file():
        mime_type = mime_types.get(Path(path).suffix.lower())
        if mime_type:
            subprocess.run(["svn", "propset", "--quiet", "svn:mime-type", mime_type, "--", path], check=True)
PY

if [[ -z "$(svn status)" ]]; then
  echo "WordPress.org assets already match the repository."
  exit 0
fi

svn diff --summarize
if [[ "$mode" == --commit ]]; then
  : "${SVN_USERNAME:?Set the SVN_USERNAME GitHub Actions secret}"
  : "${SVN_PASSWORD:?Set the SVN_PASSWORD GitHub Actions secret}"
  printf '%s\n' "$SVN_PASSWORD" | svn commit --non-interactive --no-auth-cache \
    --username "$SVN_USERNAME" --password-from-stdin \
    -m "Update My Plugin Information directory assets from GitHub"
fi
