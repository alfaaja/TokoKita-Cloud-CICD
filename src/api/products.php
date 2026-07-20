<?php
declare(strict_types=1);
require_once __DIR__ . '/../config/products.php';

header('Content-Type: application/json; charset=utf-8');
function respond(int $status, array $body): never { http_response_code($status); echo json_encode($body); exit; }
function request_data(): array { $data = json_decode(file_get_contents('php://input'), true); return is_array($data) ? $data : $_POST; }

try {
    $pdo = database(); $method = $_SERVER['REQUEST_METHOD']; $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: 0;
    if ($method === 'GET') {
        if ($id) { $statement = $pdo->prepare('SELECT id, name, price, category, stock, description FROM products WHERE id=:id'); $statement->execute(['id' => $id]); $product = $statement->fetch(); $product ? respond(200, ['data' => $product]) : respond(404, ['error' => 'Produk tidak ditemukan.']); }
        respond(200, ['data' => $pdo->query('SELECT id, name, price, category, stock, description FROM products ORDER BY id')->fetchAll()]);
    }
    if ($method === 'POST' || $method === 'PUT') {
        [$errors, $product] = validate_product(request_data()); if ($errors) respond(400, ['error' => 'Input tidak valid.', 'fields' => $errors]);
        if ($method === 'POST') { $pdo->prepare('INSERT INTO products (name, price, category, stock, description) VALUES (:name, :price, :category, :stock, :description)')->execute($product); $product['id'] = (int) $pdo->lastInsertId(); respond(201, ['data' => $product]); }
        if (!$id) respond(400, ['error' => 'ID produk wajib diisi.']);
        $product['id'] = $id; $statement = $pdo->prepare('UPDATE products SET name=:name, price=:price, category=:category, stock=:stock, description=:description WHERE id=:id'); $statement->execute($product); $statement->rowCount() ? respond(200, ['data' => $product]) : respond(404, ['error' => 'Produk tidak ditemukan.']);
    }
    if ($method === 'DELETE') { if (!$id) respond(400, ['error' => 'ID produk wajib diisi.']); $statement = $pdo->prepare('DELETE FROM products WHERE id=:id'); $statement->execute(['id' => $id]); $statement->rowCount() ? respond(200, ['message' => 'Produk dihapus.']) : respond(404, ['error' => 'Produk tidak ditemukan.']); }
    respond(405, ['error' => 'Method tidak didukung.']);
} catch (Throwable $exception) { respond(500, ['error' => 'Layanan database tidak tersedia.']); }
