<?php
declare(strict_types=1);

require_once __DIR__ . '/database.php';

function format_rupiah(float $number): string { return 'Rp' . number_format($number, 0, ',', '.'); }

function product_image(string $category): string
{
    $images = ['Minuman' => '☕', 'Aksesoris' => '⌨️', 'Network' => '📡', 'Fashion' => '🧥', 'Stationery' => '📓'];
    return $images[$category] ?? '🛍️';
}

function validate_product(array $input): array
{
    $name = trim((string) ($input['name'] ?? ''));
    $category = trim((string) ($input['category'] ?? ''));
    $description = trim((string) ($input['description'] ?? ''));
    $price = filter_var($input['price'] ?? null, FILTER_VALIDATE_FLOAT);
    $stock = filter_var($input['stock'] ?? null, FILTER_VALIDATE_INT);
    $errors = [];
    if ($name === '') $errors['name'] = 'Nama produk wajib diisi.';
    if ($category === '') $errors['category'] = 'Kategori wajib diisi.';
    if ($description === '') $errors['description'] = 'Deskripsi wajib diisi.';
    if ($price === false || $price < 0) $errors['price'] = 'Harga harus berupa angka tidak negatif.';
    if ($stock === false || $stock < 0) $errors['stock'] = 'Stok harus berupa bilangan bulat tidak negatif.';
    return [$errors, ['name' => $name, 'category' => $category, 'description' => $description, 'price' => $price === false ? 0 : $price, 'stock' => $stock === false ? 0 : $stock]];
}
