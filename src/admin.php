<?php
require_once __DIR__ . '/config/products.php';
$page_title = 'Seller Center'; $errors = []; $message = ''; $form = ['id' => '', 'name' => '', 'price' => '', 'category' => '', 'stock' => '', 'description' => ''];
try {
    $pdo = database();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        if ($action === 'delete') { $pdo->prepare('DELETE FROM products WHERE id = :id')->execute(['id' => (int) ($_POST['id'] ?? 0)]); $message = 'Produk berhasil dihapus.'; }
        else {
            [$errors, $form] = validate_product($_POST);
            if (!$errors) {
                if ($action === 'update') { $form['id'] = (int) ($_POST['id'] ?? 0); $pdo->prepare('UPDATE products SET name=:name, price=:price, category=:category, stock=:stock, description=:description WHERE id=:id')->execute($form); $message = 'Produk berhasil diperbarui.'; }
                else { $pdo->prepare('INSERT INTO products (name, price, category, stock, description) VALUES (:name, :price, :category, :stock, :description)')->execute($form); $message = 'Produk baru berhasil ditambahkan.'; $form = ['id' => '', 'name' => '', 'price' => '', 'category' => '', 'stock' => '', 'description' => '']; }
            }
        }
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' && ($editId = filter_input(INPUT_GET, 'edit', FILTER_VALIDATE_INT))) { $statement = $pdo->prepare('SELECT id, name, price, category, stock, description FROM products WHERE id=:id'); $statement->execute(['id' => $editId]); $form = $statement->fetch() ?: $form; }
    $products = $pdo->query('SELECT id, name, price, category, stock, description FROM products ORDER BY id DESC')->fetchAll();
} catch (RuntimeException|PDOException $exception) { $products = []; $database_error = 'Operasi database belum tersedia. Pastikan service db sehat.'; }
include __DIR__ . '/header.php';
?>
<main class="wrap page"><section class="page-hero"><div class="page-title"><p class="eyebrow">Seller Center</p><h1>Kelola katalog produk</h1><p>Tambah, ubah, dan hapus data produk yang tersimpan secara persisten di MySQL.</p></div><div class="hero-metrics compact"><div class="metric-tile"><span>Produk aktif</span><strong><?= count($products) ?></strong></div><div class="metric-tile"><span>CRUD</span><strong>Aktif</strong></div><div class="metric-tile"><span>Database</span><strong>MySQL 8</strong></div></div></section>
<?php if ($message): ?><div class="notice success"><strong><?= htmlspecialchars($message) ?></strong></div><?php endif; ?><?php if (isset($database_error)): ?><div class="notice warning"><strong>Database belum siap.</strong><p><?= htmlspecialchars($database_error) ?></p></div><?php endif; ?>
<section class="panel admin-form"><h2><?= $form['id'] ? 'Ubah Produk' : 'Tambah Produk' ?></h2><form method="POST" class="form-grid product-form"><input type="hidden" name="action" value="<?= $form['id'] ? 'update' : 'create' ?>"><input type="hidden" name="id" value="<?= (int) $form['id'] ?>"><label>Nama Produk<input name="name" value="<?= htmlspecialchars((string) $form['name']) ?>" required></label><label>Harga<input type="number" min="0" step="1" name="price" value="<?= htmlspecialchars((string) $form['price']) ?>" required></label><label>Kategori<input name="category" value="<?= htmlspecialchars((string) $form['category']) ?>" required></label><label>Stok<input type="number" min="0" step="1" name="stock" value="<?= htmlspecialchars((string) $form['stock']) ?>" required></label><label class="full-width">Deskripsi<textarea name="description" required><?= htmlspecialchars((string) $form['description']) ?></textarea></label><?php if ($errors): ?><div class="notice danger full-width"><strong>Periksa input:</strong><p><?= htmlspecialchars(implode(' ', $errors)) ?></p></div><?php endif; ?><div class="hero-actions full-width"><button type="submit"><?= $form['id'] ? 'Simpan Perubahan' : 'Tambah Produk' ?></button><?php if ($form['id']): ?><a class="btn ghost" href="/admin.php">Batal</a><?php endif; ?></div></form></section>
<section class="panel admin-list"><h2>Daftar Produk</h2><?php foreach ($products as $product): ?><article class="admin-product"><div><strong><?= htmlspecialchars($product['name']) ?></strong><span><?= htmlspecialchars($product['category']) ?> · <?= htmlspecialchars(format_rupiah((float) $product['price'])) ?> · stok <?= (int) $product['stock'] ?></span></div><div class="admin-actions"><a class="btn ghost" href="/admin.php?edit=<?= (int) $product['id'] ?>">Ubah</a><form method="POST" onsubmit="return confirm('Hapus produk ini?');"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int) $product['id'] ?>"><button class="danger-button" type="submit">Hapus</button></form></div></article><?php endforeach; ?></section></main><?php include __DIR__ . '/footer.php'; ?>
