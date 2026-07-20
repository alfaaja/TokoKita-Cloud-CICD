<?php
declare(strict_types=1);
require_once __DIR__ . '/config/database.php';

header('Content-Type: application/json; charset=utf-8');
try {
    database()->query('SELECT 1')->fetchColumn();
    http_response_code(200);
    echo json_encode(['status' => 'ok', 'database' => 'connected']);
} catch (Throwable $exception) {
    http_response_code(503);
    echo json_encode(['status' => 'unavailable', 'database' => 'unavailable']);
}
