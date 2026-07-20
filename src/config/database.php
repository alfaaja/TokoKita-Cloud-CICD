<?php
declare(strict_types=1);

function database(): PDO
{
    static $connection = null;
    if ($connection instanceof PDO) return $connection;

    $host = getenv('DB_HOST') ?: 'db';
    $port = getenv('DB_PORT') ?: '3306';
    $name = getenv('DB_NAME') ?: 'tokokita';
    $user = getenv('DB_USER') ?: 'tokokita_user';
    $password = getenv('DB_PASSWORD') ?: '';
    $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";

    for ($attempt = 1; $attempt <= 3; $attempt++) {
        try {
            $connection = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => 3,
            ]);
            return $connection;
        } catch (PDOException $exception) {
            if ($attempt === 3) {
                throw new RuntimeException('Koneksi database tidak tersedia. Periksa service database lalu coba kembali.', 0, $exception);
            }
            sleep(1);
        }
    }
    throw new RuntimeException('Koneksi database tidak tersedia.');
}
