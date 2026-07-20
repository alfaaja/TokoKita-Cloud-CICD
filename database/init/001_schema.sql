CREATE TABLE IF NOT EXISTS products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(12, 2) UNSIGNED NOT NULL,
    category VARCHAR(100) NOT NULL,
    stock INT UNSIGNED NOT NULL DEFAULT 0,
    description TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO products (name, price, category, stock, description) VALUES
    ('Kopi Susu Aren 1 Liter', 42000, 'Minuman', 18, 'Kopi susu aren creamy dengan rasa seimbang, cocok untuk teman meeting, kerja sore, atau stok kulkas di rumah.'),
    ('Keyboard Mechanical Sagara', 329000, 'Aksesoris', 7, 'Keyboard mechanical dengan rasa ketik mantap untuk meja kerja yang rapi, fokus, dan nyaman dipakai lama.'),
    ('Mouse Wireless Orbit', 119000, 'Aksesoris', 21, 'Mouse wireless ringan dengan genggaman nyaman untuk kerja harian, browsing santai, dan setup meja minimalis.'),
    ('USB WiFi Adapter Mini', 89000, 'Network', 12, 'Adapter WiFi ringkas untuk backup koneksi di rumah, kos, atau meja kerja yang butuh perangkat serba praktis.'),
    ('Hoodie DevSecOps', 185000, 'Fashion', 5, 'Hoodie nyaman dengan potongan santai untuk ruang kerja dingin, perjalanan malam, atau sekadar outfit simpel.'),
    ('Notebook Incident Report', 35000, 'Stationery', 40, 'Notebook compact untuk catatan cepat, ide harian, daftar tugas, atau teman rapat yang tetap enak dilihat.');
