#!/usr/bin/env sh
# Run every portable Integration smoke shipped by installed wonderwp/* packages.
#
# Requires a booted WordPress (WP-CLI). From a Bedrock/DDEV host:
#   ddev exec bash vendor/wonderwp/wonderwp/bin/run-all-integration.sh
#   WP_BIN="ddev wp" bash vendor/wonderwp/wonderwp/bin/run-all-integration.sh   # from host
#
# Optional:
#   WP_BIN=wp ONLY=repository ./bin/run-all-integration.sh

set -eu

ROOT="$(CDPATH= cd -- "$(dirname "$0")/.." && pwd)"
VENDOR_WWP="$(CDPATH= cd -- "$ROOT/.." && pwd)"

WP_BIN="${WP_BIN:-wp}"

if ! command -v "${WP_BIN%% *}" >/dev/null 2>&1 && [ "$WP_BIN" = "wp" ]; then
  echo "WP-CLI not found (wp). Set WP_BIN='ddev wp' or run inside an environment where wp is available." >&2
  exit 1
fi

failed=0
passed=0
skipped=0

echo "WP-CLI: $WP_BIN"
echo "Scanning: $VENDOR_WWP/*/tests/Integration/smoke-*.php"
echo

# shellcheck disable=SC2044
for smoke in $(find "$VENDOR_WWP" -path '*/tests/Integration/smoke-*.php' 2>/dev/null | sort); do
  pkg="$(echo "$smoke" | sed -n 's|.*/wonderwp/\([^/]*\)/tests/Integration/.*|\1|p')"
  if [ -z "$pkg" ]; then
    pkg="$(basename "$(dirname "$(dirname "$(dirname "$smoke")")")")"
  fi

  if [ -n "${ONLY:-}" ] && [ "$pkg" != "$ONLY" ]; then
    skipped=$((skipped + 1))
    continue
  fi

  # Prefer path relative to host project when smoke lives under vendor/
  rel="$smoke"
  case "$smoke" in
    */vendor/wonderwp/*)
      rel="vendor/wonderwp/${smoke#*/vendor/wonderwp/}"
      ;;
  esac

  echo "==== Integration: wonderwp/$pkg ($(basename "$smoke")) ===="
  set +e
  # WP_BIN may be multi-word (e.g. "ddev wp")
  # shellcheck disable=SC2086
  $WP_BIN eval-file "$rel"
  code=$?
  set -e
  if [ "$code" -eq 0 ]; then
    passed=$((passed + 1))
  else
    failed=$((failed + 1))
    echo "FAIL $rel (exit $code)" >&2
  fi
  echo
done

if [ "$passed" -eq 0 ] && [ "$failed" -eq 0 ]; then
  echo "No Integration smoke-*.php files found under $VENDOR_WWP" >&2
  exit 1
fi

echo "==== Integration summary: $passed passed, $failed failed, $skipped skipped ===="
[ "$failed" -eq 0 ] || exit 1
