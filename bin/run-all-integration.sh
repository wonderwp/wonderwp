#!/usr/bin/env sh
# Run every portable Integration smoke shipped by installed wonderwp/* packages.
#
# Requires a booted WordPress (WP-CLI). From a Bedrock/DDEV host:
#   ddev exec bash vendor/wonderwp/wonderwp/bin/run-all-integration.sh
#   WP_BIN="ddev wp" bash vendor/wonderwp/wonderwp/bin/run-all-integration.sh   # from host
#
# Optional:
#   WP_BIN=wp ONLY=repository NO_COLOR=1 ./bin/run-all-integration.sh

set -eu

ROOT="$(CDPATH= cd -- "$(dirname "$0")/.." && pwd)"
VENDOR_WWP="$(CDPATH= cd -- "$ROOT/.." && pwd)"

WP_BIN="${WP_BIN:-wp}"

if ! command -v "${WP_BIN%% *}" >/dev/null 2>&1 && [ "$WP_BIN" = "wp" ]; then
  echo "WP-CLI not found (wp). Set WP_BIN='ddev wp' or run inside an environment where wp is available." >&2
  exit 1
fi

# ANSI colors (disabled when NO_COLOR is set or stdout is not a TTY)
if [ -n "${NO_COLOR:-}" ] || [ ! -t 1 ]; then
  # Still colorize under DDEV/pipes unless NO_COLOR is set — opt-in FORCE_COLOR=1
  if [ -n "${FORCE_COLOR:-}" ] && [ -z "${NO_COLOR:-}" ]; then
    C_RESET='\033[0m'
    C_BOLD='\033[1m'
    C_DIM='\033[2m'
    C_GREEN='\033[32m'
    C_RED='\033[31m'
    C_YELLOW='\033[33m'
    C_CYAN='\033[36m'
    C_BG_GREEN='\033[42m'
    C_BG_RED='\033[41m'
    C_WHITE='\033[37m'
  else
    C_RESET=''; C_BOLD=''; C_DIM=''; C_GREEN=''; C_RED=''; C_YELLOW=''
    C_CYAN=''; C_BG_GREEN=''; C_BG_RED=''; C_WHITE=''
  fi
else
  C_RESET='\033[0m'
  C_BOLD='\033[1m'
  C_DIM='\033[2m'
  C_GREEN='\033[32m'
  C_RED='\033[31m'
  C_YELLOW='\033[33m'
  C_CYAN='\033[36m'
  C_BG_GREEN='\033[42m'
  C_BG_RED='\033[41m'
  C_WHITE='\033[37m'
fi

# DDEV exec pipes stdout — default to colors unless NO_COLOR=1
if [ -z "${NO_COLOR:-}" ] && [ -z "${FORCE_COLOR:-}" ] && [ ! -t 1 ]; then
  C_RESET='\033[0m'
  C_BOLD='\033[1m'
  C_DIM='\033[2m'
  C_GREEN='\033[32m'
  C_RED='\033[31m'
  C_YELLOW='\033[33m'
  C_CYAN='\033[36m'
  C_BG_GREEN='\033[42m'
  C_BG_RED='\033[41m'
  C_WHITE='\033[37m'
fi

failed=0
passed=0
skipped=0

printf '%bWP-CLI:%b %s\n' "$C_DIM" "$C_RESET" "$WP_BIN"
printf '%bScanning:%b %s/*/tests/Integration/smoke-*.php (no nested vendor trees)\n\n' "$C_DIM" "$C_RESET" "$VENDOR_WWP"

# Only direct package children — never recurse into vendor/wonderwp/*/vendor/...
# shellcheck disable=SC2231
for smoke in "$VENDOR_WWP"/*/tests/Integration/smoke-*.php; do
  [ -f "$smoke" ] || continue
  pkg="$(basename "$(dirname "$(dirname "$(dirname "$smoke")")")")"

  if [ -n "${ONLY:-}" ] && [ "$pkg" != "$ONLY" ]; then
    skipped=$((skipped + 1))
    continue
  fi

  rel="$smoke"
  case "$smoke" in
    */vendor/wonderwp/*)
      rel="vendor/wonderwp/${smoke#*/vendor/wonderwp/}"
      ;;
  esac

  printf '%b==== Integration: wonderwp/%s (%s) ====%b\n' "$C_CYAN$C_BOLD" "$pkg" "$(basename "$smoke")" "$C_RESET"
  set +e
  # shellcheck disable=SC2086
  out="$($WP_BIN eval-file "$rel" 2>&1)"
  code=$?
  set -e

  # Colorize common PASS/FAIL/SKIP/OK lines from smoke scripts
  printf '%s\n' "$out" | while IFS= read -r line || [ -n "$line" ]; do
    case "$line" in
      *PASS*|OK\ *)
        printf '%b%s%b\n' "$C_GREEN" "$line" "$C_RESET"
        ;;
      *FAIL*|Error:*|Fatal\ error:*)
        printf '%b%s%b\n' "$C_RED" "$line" "$C_RESET"
        ;;
      *SKIP*|Warning:*)
        printf '%b%s%b\n' "$C_YELLOW" "$line" "$C_RESET"
        ;;
      ---*|===*)
        printf '%b%s%b\n' "$C_DIM" "$line" "$C_RESET"
        ;;
      *)
        printf '%s\n' "$line"
        ;;
    esac
  done

  if [ "$code" -eq 0 ]; then
    passed=$((passed + 1))
    printf '%b%b PASS %b wonderwp/%s%b\n' "$C_BG_GREEN" "$C_WHITE$C_BOLD" "$C_RESET$C_GREEN" "$pkg" "$C_RESET"
  else
    failed=$((failed + 1))
    printf '%b%b FAIL %b %s (exit %s)%b\n' "$C_BG_RED" "$C_WHITE$C_BOLD" "$C_RESET$C_RED" "$rel" "$code" "$C_RESET" >&2
  fi
  echo
done

if [ "$passed" -eq 0 ] && [ "$failed" -eq 0 ]; then
  printf '%bNo Integration smoke-*.php files found under %s%b\n' "$C_RED" "$VENDOR_WWP" "$C_RESET" >&2
  exit 1
fi

if [ "$failed" -eq 0 ]; then
  printf '%b%b==== Integration summary: %s passed, %s failed, %s skipped ====%b\n' \
    "$C_BG_GREEN" "$C_WHITE$C_BOLD" "$passed" "$failed" "$skipped" "$C_RESET"
  exit 0
fi

printf '%b%b==== Integration summary: %s passed, %s failed, %s skipped ====%b\n' \
  "$C_BG_RED" "$C_WHITE$C_BOLD" "$passed" "$failed" "$skipped" "$C_RESET" >&2
exit 1
