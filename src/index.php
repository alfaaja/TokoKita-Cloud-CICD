<?php
require_once __DIR__ . "/data.php";
$page_title = "TokoKita Cloud CI/CD";
$total_products = count($products);
$total_categories = count(array_unique(array_column($products, "category")));
$featured_products = array_slice($products, 0, 3, true);
include __DIR__ . "/header.php";
?>
<main>
  <section class="hero">
    <div class="wrap hero-grid">
      <div class="hero-copy">
        <div class="hero-badges">
          <span class="hero-badge">Gratis Ongkir</span>
          <span class="hero-badge">Kurasi Mingguan</span>
          <span class="hero-badge">Pilihan Pelanggan</span>
        </div>
        <p class="eyebrow">Demo Cloud Computing</p>
        <h1>TokoKita Cloud CI/CD</h1>
        <p class="lead">Aplikasi toko sederhana untuk membuktikan alur Docker image, Docker Compose, automated test, dan pipeline GitHub Actions berjalan dari kode sampai container.</p>
        <div class="hero-actions">
          <a class="btn primary" href="/products.php">Lihat Produk</a>
          <a class="btn ghost" href="/info.php">Info CI/CD</a>
        </div>
        <div class="hero-metrics-inline">
          <div>
            <strong><?= htmlspecialchars((string) $total_products) ?></strong>
          <span>produk demo</span>
          </div>
          <div>
            <strong><?= htmlspecialchars((string) $total_categories) ?></strong>
          <span>kategori toko</span>
          </div>
          <div>
            <strong>4.9</strong>
          <span>endpoint utama</span>
          </div>
        </div>
      </div>
      <div class="hero-panel">
        <div class="hero-card">
          <div class="hero-card-header">
            <div>
              <strong>Favorit Minggu Ini</strong>
              <span>Kurasi produk yang paling sering dipilih ulang</span>
            </div>
            <span class="hero-chip">Best Seller</span>
          </div>
          <div class="hero-metrics compact">
            <div class="metric-tile">
              <span>Pengiriman</span>
              <strong>Same Day</strong>
            </div>
            <div class="metric-tile">
              <span>Pembayaran</span>
              <strong>Aman</strong>
            </div>
            <div class="metric-tile">
              <span>Support</span>
              <strong>Responsif</strong>
            </div>
          </div>
          <div class="activity-list">
            <?php foreach ($featured_products as $product): ?>
              <div class="activity-item">
                <div>
                  <strong><?= htmlspecialchars($product["name"]) ?></strong>
                  <span><?= htmlspecialchars($product["description"]) ?></span>
                </div>
                <span class="activity-endpoint"><?= htmlspecialchars($product["price"]) ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="wrap section">
    <div class="section-head">
      <div>
        <p class="eyebrow">Kenapa Aplikasi Ini Dipakai</p>
        <h2>Sederhana, mudah dites, dan cukup untuk praktik CI/CD</h2>
      </div>
    </div>

    <div class="feature-grid">
      <article class="feature-card">
        <span class="feature-icon">01</span>
        <h3>Endpoint jelas</h3>
        <p>Homepage, katalog produk, detail produk, promo, dan halaman info bisa dicek dengan browser maupun curl.</p>
      </article>
      <article class="feature-card">
        <span class="feature-icon">02</span>
        <h3>Siap container</h3>
        <p>Source PHP ditempatkan di image Apache sehingga aplikasi bisa dijalankan konsisten di lokal dan GitHub Actions.</p>
      </article>
      <article class="feature-card">
        <span class="feature-icon">03</span>
        <h3>Mudah dipresentasikan</h3>
        <p>Alurnya ringkas: build image, jalankan service, test endpoint, lalu lihat pipeline berhasil atau gagal.</p>
      </article>
    </div>
  </section>

  <section class="wrap section">
    <div class="section-head">
      <div>
        <p class="eyebrow">Produk Pilihan</p>
        <h2>Barang yang sering dicari</h2>
      </div>
      <a href="/products.php">Lihat semua →</a>
    </div>

    <div class="product-grid">
      <?php foreach (array_slice($products, 0, 4, true) as $id => $product): ?>
        <a class="product-card" href="/product.php?id=<?= urlencode($id) ?>">
          <div class="product-image"><?= htmlspecialchars($product["image"]) ?></div>
          <div class="product-info">
            <div class="product-meta">
              <span><?= htmlspecialchars($product["category"]) ?></span>
              <small>Stok <?= htmlspecialchars((string) $product["stock"]) ?></small>
            </div>
            <h3><?= htmlspecialchars($product["name"]) ?></h3>
            <div class="price-row">
              <p><?= htmlspecialchars($product["price"]) ?></p>
              <strong>Lihat Detail</strong>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="wrap section">
    <div class="section-head">
      <div>
        <p class="eyebrow">Alur Praktikum</p>
        <h2>Yang dibuktikan dari repository ini</h2>
      </div>
    </div>

    <div class="command-grid">
      <article class="command-card">
        <span class="chip">Work Setup</span>
        <h3>Docker build</h3>
        <p>Dockerfile membungkus aplikasi PHP ke image bernama tokokita-cloud-cicd agar siap dijalankan sebagai container.</p>
      </article>
      <article class="command-card">
        <span class="chip">Coffee Break</span>
        <h3>Docker Compose</h3>
        <p>Compose menjalankan service web di port 8080 dan memasang folder logs lokal ke log Apache container.</p>
      </article>
      <article class="command-card">
        <span class="chip">Gift Ideas</span>
        <h3>CI/CD</h3>
        <p>GitHub Actions membangun image, menyalakan container, menjalankan test curl, lalu mematikan service otomatis.</p>
      </article>
    </div>
  </section>
</main>
<?php include __DIR__ . "/footer.php"; ?>
