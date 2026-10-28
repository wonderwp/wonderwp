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

echo "PHPUnit: $PHPUNIT_BIN"
echo "Scanning: $VENDOR_WWP/*/phpunit.xml.dist"
echo

for config in "$VENDOR_WWP"/*/phpunit.xml.dist; do
  [ -f "$config" ] || continue
  pkg="$(basename "$(dirname "$config")")"
  echo "==== Unit: wonderwp/$pkg ===="
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
  else
    failed=$((failed + 1))
    echo "FAIL wonderwp/$pkg (exit $code)" >&2
  fi
  echo
done

# Include the meta package itself when run from a checkout that has its own phpunit.xml.dist
# and is not already covered as a sibling named "wonderwp" under vendor/wonderwp/.
if [ -f "$ROOT/phpunit.xml.dist" ] && [ ! -f "$VENDOR_WWP/wonderwp/phpunit.xml.dist" ]; then
  echo "==== Unit: wonderwp/wonderwp (meta checkout) ===="
  set +e
  "$PHP_BIN" "$PHPUNIT_BIN" --configuration "$ROOT/phpunit.xml.dist"
  code=$?
  set -e
  if [ "$code" -eq 0 ]; then
    passed=$((passed + 1))
  else
    failed=$((failed + 1))
  fi
fi

echo "==== Unit summary: $passed passed, $failed failed, $skipped skipped ===="
[ "$failed" -eq 0 ] || exit 1
