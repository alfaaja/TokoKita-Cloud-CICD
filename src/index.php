<?php
require_once __DIR__ . '/config/products.php';
$page_title = 'Home';
try {
    $pdo = database();
    $total_products = (int) $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
    $total_categories = (int) $pdo->query('SELECT COUNT(DISTINCT category) FROM products')->fetchColumn();
    $featured_products = $pdo->query('SELECT id, name, price, category, stock, description FROM products ORDER BY id LIMIT 4')->fetchAll();
} catch (RuntimeException $exception) {
    $database_error = $exception->getMessage(); $total_products = 0; $total_categories = 0; $featured_products = [];
}
include __DIR__ . '/header.php';
?>
<main>
  <section class="hero"><div class="wrap hero-grid"><div class="hero-copy">
    <div class="hero-badges"><span class="hero-badge">Database MySQL</span><span class="hero-badge">Gratis Ongkir</span><span class="hero-badge">Pilihan Pelanggan</span></div>
    <p class="eyebrow">Kebutuhan kerja, ngopi, dan daily setup</p><h1>Belanja barang favorit yang bikin meja kerja terasa lebih hidup.</h1>
    <p class="lead">TokoKita menyimpan katalog produk di database MySQL agar daftar produk selalu siap dikelola dari Seller Center.</p>
    <div class="hero-actions"><a class="btn primary" href="/products.php">Lihat Produk</a><a class="btn ghost" href="/admin.php">Kelola Produk</a></div>
    <div class="hero-metrics-inline"><div><strong><?= $total_products ?></strong><span>produk pilihan</span></div><div><strong><?= $total_categories ?></strong><span>kategori favorit</span></div><div><strong>4.9</strong><span>rating pelanggan</span></div></div>
  </div><div class="hero-panel"><div class="hero-card"><div class="hero-card-header"><div><strong>Favorit Minggu Ini</strong><span>Kurasi produk dari database TokoKita</span></div><span class="hero-chip">Best Seller</span></div>
  <div class="activity-list"><?php foreach (array_slice($featured_products, 0, 3) as $product): ?><div class="activity-item"><div><strong><?= htmlspecialchars($product['name']) ?></strong><span><?= htmlspecialchars($product['category']) ?> · Stok <?= (int) $product['stock'] ?></span></div><span class="activity-endpoint"><?= htmlspecialchars(format_rupiah((float) $product['price'])) ?></span></div><?php endforeach; ?></div></div></div></div></section>
  <?php if (isset($database_error)): ?><section class="wrap"><div class="notice warning"><strong>Database belum siap.</strong><p><?= htmlspecialchars($database_error) ?></p></div></section><?php endif; ?>
  <section class="wrap section"><div class="section-head"><div><p class="eyebrow">Produk Pilihan</p><h2>Barang yang sering dicari</h2></div><a href="/products.php">Lihat semua →</a></div><div class="product-grid"><?php foreach ($featured_products as $product): ?><a class="product-card" href="/product.php?id=<?= (int) $product['id'] ?>"><div class="product-image"><?= product_image($product['category']) ?></div><div class="product-info"><div class="product-meta"><span><?= htmlspecialchars($product['category']) ?></span><small>Stok <?= (int) $product['stock'] ?></small></div><h3><?= htmlspecialchars($product['name']) ?></h3><div class="price-row"><p><?= htmlspecialchars(format_rupiah((float) $product['price'])) ?></p><strong>Lihat Detail</strong></div></div></a><?php endforeach; ?></div></section>
</main>
<?php include __DIR__ . '/footer.php'; ?>
