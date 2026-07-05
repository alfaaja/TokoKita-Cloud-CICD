<?php
$page_title = "Info CI/CD";
include __DIR__ . "/header.php";
?>
<main class="wrap page">
  <section class="page-hero">
    <div class="page-title">
      <p class="eyebrow">Cloud CI/CD</p>
      <h1>Informasi Praktikum</h1>
      <p>Halaman ini menjelaskan hubungan aplikasi TokoKita dengan Docker, Docker Compose, automated testing, dan GitHub Actions.</p>
    </div>

    <div class="hero-metrics compact">
      <div class="metric-tile">
        <span>Runtime</span>
        <strong>PHP 8.2</strong>
      </div>
      <div class="metric-tile">
        <span>Server</span>
        <strong>Apache</strong>
      </div>
      <div class="metric-tile">
        <span>Port lokal</span>
        <strong>8080</strong>
      </div>
    </div>
  </section>

  <div class="command-grid two-column">
    <section class="command-card">
      <span class="chip">Docker</span>
      <h3>Image aplikasi dibuat dari Dockerfile</h3>
      <p>Source di folder <code>src/</code> disalin ke image berbasis <code>php:8.2-apache</code> supaya aplikasi bisa dijalankan sebagai container.</p>
    </section>

    <section class="command-card">
      <span class="chip">Compose</span>
      <h3>Service web dikelola secara deklaratif</h3>
      <p><code>docker-compose.yml</code> menentukan nama service, image, port, timezone, restart policy, dan volume log Apache.</p>
    </section>

    <section class="command-card">
      <span class="chip">Automated Test</span>
      <h3>Endpoint dicek memakai bash dan curl</h3>
      <p>File <code>tests/test_app.sh</code> mengakses homepage, katalog produk, detail produk, promo, dan halaman info. Test gagal jika ada endpoint yang tidak bisa diakses.</p>
    </section>

    <section class="command-card">
      <span class="chip">GitHub Actions</span>
      <h3>Pipeline berjalan setiap push dan pull request</h3>
      <p>Workflow membangun Docker image, menjalankan aplikasi dengan Compose, menunggu service siap, menjalankan test, lalu menampilkan log untuk bukti praktikum.</p>
    </section>
  </div>
</main>
<?php include __DIR__ . "/footer.php"; ?>
