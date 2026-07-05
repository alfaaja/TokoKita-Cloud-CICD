<?php
if (!isset($page_title)) {
    $page_title = "TokoKita Cloud CI/CD";
}

$current_path = parse_url($_SERVER["REQUEST_URI"] ?? "/", PHP_URL_PATH) ?: "/";
$page_slug = strtolower(trim((string) preg_replace("/[^a-z0-9]+/i", "-", $page_title), "-"));
$nav_items = [
    [ "href" => "/", "label" => "Home" ],
    [ "href" => "/products.php", "label" => "Produk" ],
    [ "href" => "/promo.php", "label" => "Promo" ],
    [ "href" => "/info.php", "label" => "Info" ],
    [ "href" => "/cart.php", "label" => "Keranjang" ],
    [ "href" => "/login.php", "label" => "Masuk" ],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="TokoKita Cloud CI/CD adalah toko online sederhana untuk praktik Docker, Docker Compose, automated testing, dan GitHub Actions.">
  <title><?= htmlspecialchars($page_title) ?> - TokoKita Cloud CI/CD</title>
  <link rel="stylesheet" href="/style.css">
</head>
<body class="page-<?= htmlspecialchars($page_slug) ?>">
  <div class="topbar">
    <div class="wrap topbar-inner">
      <div class="topbar-status">
        <span class="status-dot"></span>
        <span>Gratis ongkir untuk belanja min. Rp90.000</span>
      </div>
      <div class="topbar-links">
        <span>Belanja nyaman setiap hari 08.00 - 22.00</span>
        <span>Customer Care: 08xx-1234-5678</span>
      </div>
    </div>
  </div>

  <header class="site-header">
    <div class="wrap nav">
      <a class="brand" href="/">
        <span class="brand-mark">TK</span>
          <span class="brand-copy">
          <strong>TokoKita Cloud CI/CD</strong>
          <small>Demo Docker, Compose, dan GitHub Actions</small>
        </span>
      </a>

      <nav class="menu">
        <?php foreach ($nav_items as $item): ?>
          <?php $is_active = $item["href"] === "/" ? $current_path === "/" : $current_path === $item["href"]; ?>
          <a class="<?= $is_active ? "active" : "" ?>" href="<?= htmlspecialchars($item["href"]) ?>">
            <?= htmlspecialchars($item["label"]) ?>
          </a>
        <?php endforeach; ?>
      </nav>

      <a class="header-cta" href="/admin.php">Seller Center</a>
    </div>
  </header>
