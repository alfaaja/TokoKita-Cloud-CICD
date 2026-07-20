<?php
require_once __DIR__ . '/config/products.php';
$page_title = 'Produk'; $q = trim((string) ($_GET['q'] ?? ''));
try {
    $pdo = database();
    $categories = $pdo->query('SELECT DISTINCT category FROM products ORDER BY category')->fetchAll(PDO::FETCH_COLUMN);
    $statement = $pdo->prepare('SELECT id, name, price, category, stock, description FROM products WHERE name LIKE :q OR category LIKE :q ORDER BY id');
    $statement->execute(['q' => '%' . $q . '%']); $products = $statement->fetchAll();
    $total_products = (int) $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
} catch (RuntimeException $exception) { $products = []; $categories = []; $total_products = 0; $database_error = $exception->getMessage(); }
include __DIR__ . '/header.php';
?>
<main class="wrap page"><section class="page-hero"><div class="page-title"><p class="eyebrow">Katalog</p><h1>Produk TokoKita</h1><p>Koleksi barang pilihan yang dibaca langsung dari database MySQL.</p></div><div class="hero-metrics compact"><div class="metric-tile"><span>Total produk</span><strong><?= $total_products ?></strong></div><div class="metric-tile"><span>Kategori aktif</span><strong><?= count($categories) ?></strong></div><div class="metric-tile"><span>Hasil pencarian</span><strong><?= count($products) ?></strong></div></div></section>
<?php if (isset($database_error)): ?><div class="notice warning"><strong>Database belum siap.</strong><p><?= htmlspecialchars($database_error) ?></p></div><?php endif; ?>
<form class="search-box" method="GET"><input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Cari kopi, keyboard, adapter..."><button type="submit">Cari</button></form><div class="result-toolbar"><p class="result-count">Menampilkan <strong><?= count($products) ?></strong> dari <strong><?= $total_products ?></strong> produk.</p><div class="chip-row"><?php foreach ($categories as $category): ?><span class="chip"><?= htmlspecialchars($category) ?></span><?php endforeach; ?></div></div>
<div class="product-grid"><?php foreach ($products as $product): ?><a class="product-card" href="/product.php?id=<?= (int) $product['id'] ?>"><div class="product-image"><?= product_image($product['category']) ?></div><div class="product-info"><div class="product-meta"><span><?= htmlspecialchars($product['category']) ?></span><small>Stok <?= (int) $product['stock'] ?></small></div><h3><?= htmlspecialchars($product['name']) ?></h3><div class="price-row"><p><?= htmlspecialchars(format_rupiah((float) $product['price'])) ?></p><strong>Buka</strong></div></div></a><?php endforeach; ?></div>
<?php if (!$products && !isset($database_error)): ?><section class="panel empty-state"><h2>Produk tidak ditemukan</h2><p>Coba kata kunci lain untuk melihat produk yang tersedia.</p></section><?php endif; ?></main><?php include __DIR__ . '/footer.php'; ?>
