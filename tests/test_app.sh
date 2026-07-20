#!/usr/bin/env bash
set -euo pipefail

BASE_URL="${BASE_URL:-http://localhost:8080}"
created_id=""

cleanup() {
  if [[ -n "$created_id" ]]; then
    curl -fsS -X DELETE "$BASE_URL/api/products.php?id=$created_id" > /dev/null || true
  fi
}
trap cleanup EXIT

expect_status() {
  local expected="$1"
  shift
  local actual
  actual="$(curl -sS -o /tmp/tokokita-test-response.json -w '%{http_code}' "$@")"
  [[ "$actual" == "$expected" ]] || { cat /tmp/tokokita-test-response.json >&2; echo "Expected HTTP $expected, got $actual" >&2; exit 1; }
}

echo "[TEST] Health check aplikasi dan database..."
expect_status 200 "$BASE_URL/health.php"
grep -q '"database":"connected"' /tmp/tokokita-test-response.json

echo "[TEST] Membaca daftar produk..."
expect_status 200 "$BASE_URL/api/products.php"
grep -q '"data"' /tmp/tokokita-test-response.json

echo "[TEST] Menolak produk invalid..."
expect_status 400 -X POST -H 'Content-Type: application/json' --data '{"name":"","price":-1,"category":"","stock":-1,"description":""}' "$BASE_URL/api/products.php"

test_name="Produk Test UAS $(date +%s)"
payload="{\"name\":\"$test_name\",\"price\":12345,\"category\":\"Test\",\"stock\":3,\"description\":\"Produk sementara untuk automated test.\"}"
echo "[TEST] Membuat produk valid..."
expect_status 201 -X POST -H 'Content-Type: application/json' --data "$payload" "$BASE_URL/api/products.php"
created_id="$(sed -n 's/.*"id":\([0-9][0-9]*\).*/\1/p' /tmp/tokokita-test-response.json | head -n 1)"
[[ -n "$created_id" ]] || { echo "ID produk hasil create tidak ditemukan." >&2; exit 1; }

echo "[TEST] Mengubah produk..."
expect_status 200 -X PUT -H 'Content-Type: application/json' --data "{\"name\":\"$test_name Update\",\"price\":23456,\"category\":\"Test\",\"stock\":4,\"description\":\"Produk test setelah diubah.\"}" "$BASE_URL/api/products.php?id=$created_id"

echo "[TEST] Menghapus produk..."
expect_status 200 -X DELETE "$BASE_URL/api/products.php?id=$created_id"
created_id=""

echo "[TEST] Smoke test halaman utama..."
expect_status 200 "$BASE_URL/"
expect_status 200 "$BASE_URL/products.php"
expect_status 200 "$BASE_URL/promo.php"


echo "[SUCCESS] Health check, CRUD produk, validasi, dan halaman utama berhasil diuji."
