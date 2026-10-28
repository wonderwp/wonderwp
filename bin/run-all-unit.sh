#!/usr/bin/env sh
# Run Unit suites for every installed wonderwp/* package that ships phpunit.xml.dist.
#
# From a WordPress/Bedrock host that requires wonderwp/wonderwp:
#   ddev exec bash vendor/wonderwp/wonderwp/bin/run-all-unit.sh
#   bash vendor/wonderwp/wonderwp/bin/run-all-unit.sh   # PHP must satisfy platform reqs
#
# Optional:
#   PHPUNIT=/path/to/phpunit FILTER=PostRepository ./bin/run-all-unit.sh

set -eu

ROOT="$(CDPATH= cd -- "$(dirname "$0")/.." && pwd)"
# When installed as vendor/wonderwp/wonderwp, siblings live next door.
VENDOR_WWP="$(CDPATH= cd -- "$ROOT/.." && pwd)"
# Host vendor/bin (…/vendor/bin) or package-local vendor/bin after composer install in meta.
HOST_VENDOR="$(CDPATH= cd -- "$VENDOR_WWP/.." && pwd)"

PHPUNIT_BIN="${PHPUNIT:-}"
if [ -z "$PHPUNIT_BIN" ]; then
  if [ -x "$HOST_VENDOR/bin/phpunit" ]; then
    PHPUNIT_BIN="$HOST_VENDOR/bin/phpunit"
  elif [ -x "$ROOT/vendor/bin/phpunit" ]; then
    PHPUNIT_BIN="$ROOT/vendor/bin/phpunit"
  elif command -v phpunit >/dev/null 2>&1; then
    PHPUNIT_BIN="$(command -v phpunit)"
  else
    echo "phpunit not found. Set PHPUNIT= or install phpunit in the host project." >&2
    exit 1
  fi
fi

PHP_BIN="${PHP_BIN:-php}"
failed=0
passed=0
skipped=0

if [ -z "${NO_COLOR:-}" ]; then
  C_RESET='\033[0m'; C_BOLD='\033[1m'; C_DIM='\033[2m'
  C_GREEN='\033[32m'; C_RED='\033[31m'; C_CYAN='\033[36m'
  C_BG_GREEN='\033[42m'; C_BG_RED='\033[41m'; C_WHITE='\033[37m'
else
  C_RESET=''; C_BOLD=''; C_DIM=''; C_GREEN=''; C_RED=''; C_CYAN=''
  C_BG_GREEN=''; C_BG_RED=''; C_WHITE=''
fi

printf '%bPHPUnit:%b %s\n' "$C_DIM" "$C_RESET" "$PHPUNIT_BIN"
printf '%bScanning:%b %s/*/phpunit.xml.dist\n\n' "$C_DIM" "$C_RESET" "$VENDOR_WWP"

for config in "$VENDOR_WWP"/*/phpunit.xml.dist; do
  [ -f "$config" ] || continue
  pkg="$(basename "$(dirname "$config")")"
  printf '%b==== Unit: wonderwp/%s ====%b\n' "$C_CYAN$C_BOLD" "$pkg" "$C_RESET"
  set +e
  if [ -n "${FILTER:-}" ]; then
    "$PHP_BIN" "$PHPUNIT_BIN" --configuration "$config" --filter "$FILTER"
  else
    "$PHP_BIN" "$PHPUNIT_BIN" --configuration "$config"
  fi
  code=$?
  set -e
  if [ "$code" -eq 0 ]; then
    passed=$((passed + 1))
    printf '%b%b PASS %b wonderwp/%s%b\n' "$C_BG_GREEN" "$C_WHITE$C_BOLD" "$C_RESET$C_GREEN" "$pkg" "$C_RESET"
  else
    failed=$((failed + 1))
    printf '%b%b FAIL %b wonderwp/%s (exit %s)%b\n' "$C_BG_RED" "$C_WHITE$C_BOLD" "$C_RESET$C_RED" "$pkg" "$code" "$C_RESET" >&2
  fi
  echo
done

# Include the meta package itself when run from a checkout that has its own phpunit.xml.dist
# and is not already covered as a sibling named "wonderwp" under vendor/wonderwp/.
if [ -f "$ROOT/phpunit.xml.dist" ] && [ ! -f "$VENDOR_WWP/wonderwp/phpunit.xml.dist" ]; then
  printf '%b==== Unit: wonderwp/wonderwp (meta checkout) ====%b\n' "$C_CYAN$C_BOLD" "$C_RESET"
  set +e
  "$PHP_BIN" "$PHPUNIT_BIN" --configuration "$ROOT/phpunit.xml.dist"
  code=$?
  set -e
  if [ "$code" -eq 0 ]; then
    passed=$((passed + 1))
    printf '%b%b PASS %b wonderwp/wonderwp%b\n' "$C_BG_GREEN" "$C_WHITE$C_BOLD" "$C_RESET$C_GREEN" "$C_RESET"
  else
    failed=$((failed + 1))
  fi
fi

if [ "$failed" -eq 0 ]; then
  printf '%b%b==== Unit summary: %s passed, %s failed, %s skipped ====%b\n' \
    "$C_BG_GREEN" "$C_WHITE$C_BOLD" "$passed" "$failed" "$skipped" "$C_RESET"
  exit 0
fi

printf '%b%b==== Unit summary: %s passed, %s failed, %s skipped ====%b\n' \
  "$C_BG_RED" "$C_WHITE$C_BOLD" "$passed" "$failed" "$skipped" "$C_RESET" >&2
exit 1
