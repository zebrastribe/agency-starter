#!/usr/bin/env bash
# Copy built theme/ into a clean deploy root (for the deploy branch / Repo Update zip).
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
OUT="${1:-$ROOT/.deploy-root}"

rm -rf "$OUT"
mkdir -p "$OUT"
rsync -a --delete \
	--exclude='.git' \
	--exclude='.deploy-root' \
	--exclude='node_modules' \
	--exclude='vendor' \
	--exclude='tests' \
	--exclude='test-results' \
	--exclude='javascript' \
	--exclude='tailwind' \
	--exclude='node_scripts' \
	"$ROOT/theme/" "$OUT/"

echo "Deploy root written to $OUT"
