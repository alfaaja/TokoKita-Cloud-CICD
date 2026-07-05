#!/bin/bash
set -e

BASE_URL="${BASE_URL:-http://localhost:8080}"

echo "[TEST] Mengecek homepage..."
curl -fsS "$BASE_URL/" > /dev/null

echo "[TEST] Mengecek katalog produk..."
curl -fsS "$BASE_URL/products.php" > /dev/null

echo "[TEST] Mengecek detail produk..."
curl -fsS "$BASE_URL/product.php?id=1" > /dev/null

echo "[TEST] Mengecek halaman promo..."
curl -fsS "$BASE_URL/promo.php" > /dev/null

echo "[TEST] Mengecek halaman info CI/CD..."
curl -fsS "$BASE_URL/info.php" > /dev/null


echo "[SUCCESS] Semua endpoint utama berhasil diakses."
