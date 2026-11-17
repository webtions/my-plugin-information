#!/usr/bin/env bash
# Copy readme.txt to SVN trunk and to the released Stable tag folder.
# Does not touch plugin code and never creates a tag.
set -euo pipefail

readme=$1
svn_url=${2%/}
mode=${3:---preview}
if [[ "$mode" != --preview && "$mode" != --commit ]]; then
  echo "Use --preview or --commit." >&2
  exit 1
fi

stable_tag=$(sed -nE 's/^Stable [Tt]ag:[[:space:]]*([^[:space:]]+).*/\1/p' "$readme")
if [[ -z "$stable_tag" ]]; then
  echo "No Stable tag found in $readme." >&2
  exit 1
fi

# Only sync once the version is released. Until then the tag release handles the readme.
if ! svn ls --non-interactive "$svn_url/tags/$stable_tag" >/dev/null 2>&1; then
  echo "Stable tag $stable_tag is not released on WordPress.org yet. Skipping readme sync."
  exit 0
fi

working_copy=$(mktemp -d)
trap 'rm -rf "$working_copy"' EXIT
svn checkout --quiet --non-interactive --depth empty "$svn_url" "$working_copy"
cd "$working_copy"
svn update --quiet --non-interactive --depth empty trunk tags
svn update --quiet --non-interactive --depth empty "tags/$stable_tag"
svn update --quiet --non-interactive trunk/readme.txt "tags/$stable_tag/readme.txt"

readme_path=$(cd - >/dev/null && realpath "$readme")
cp "$readme_path" trunk/readme.txt
cp "$readme_path" "tags/$stable_tag/readme.txt"

if [[ -z "$(svn status)" ]]; then
  echo "WordPress.org readme already matches the repository."
  exit 0
fi

svn status
svn diff --summarize
if [[ "$mode" == --commit ]]; then
  : "${SVN_USERNAME:?Set the SVN_USERNAME GitHub Actions secret}"
  : "${SVN_PASSWORD:?Set the SVN_PASSWORD GitHub Actions secret}"
  printf '%s\n' "$SVN_PASSWORD" | svn commit --non-interactive --no-auth-cache \
    --username "$SVN_USERNAME" --password-from-stdin \
    -m "Update My Plugin Information readme from GitHub"
fi
