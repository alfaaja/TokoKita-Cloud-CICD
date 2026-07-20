# TokoKita Cloud CI/CD — UAS Cloud Computing

TokoKita adalah aplikasi toko PHP sederhana yang mendemonstrasikan arsitektur multi-container: aplikasi PHP 8.2/Apache membaca dan mengelola produk di MySQL 8. Proyek ini tidak memakai layanan cloud berbayar atau Kubernetes.

## Arsitektur

```text
Browser → web (PHP 8.2 + Apache, port 8080) → db (MySQL 8)
                                               └→ named volume persisten
```

Kedua service berada pada jaringan Docker `tokokita_net`. `web` hanya dimulai setelah health check `db` sukses.

## Fitur

- Katalog, detail produk, keranjang, dan beranda memakai data MySQL.
- Seller Center untuk create, update, dan delete produk.
- Validasi nama, kategori, deskripsi, harga, dan stok.
- API JSON: `GET|POST /api/products.php`, `GET|PUT|DELETE /api/products.php?id=ID`.
- Health endpoint: `GET /health.php` (200 bila aplikasi dan database siap; 503 bila database tidak tersedia).
- Named volume `tokokita_db_data`, database health check, restart policy, dan automated test Bash.

## Konfigurasi environment

Salin contoh konfigurasi lokal lalu sesuaikan hanya bila perlu:

```bash
cp .env.example .env
```

| Variable | Keterangan |
| --- | --- |
| `MYSQL_DATABASE`, `MYSQL_USER`, `MYSQL_PASSWORD`, `MYSQL_ROOT_PASSWORD` | Inisialisasi MySQL |
| `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD` | Koneksi PHP ke MySQL |

`.env` diabaikan Git. Jangan unggah credential asli; nilai di `.env.example` hanya nilai lokal contoh.

## Menjalankan aplikasi

```bash
docker build -t tokokita-cloud-cicd:v1 .
docker compose up -d
docker compose ps
curl -i http://localhost:8080/health.php
```

Buka `http://localhost:8080`, katalog di `/products.php`, dan Seller Center di `/admin.php`. Runtime dependency berasal dari image PHP dan ekstensi PDO/MySQL yang dipasang oleh Dockerfile; proyek ini tidak membutuhkan Composer.

## Automated test

```bash
chmod +x tests/test_app.sh
./tests/test_app.sh
```

Test memeriksa health check, membaca katalog API, menolak data invalid, membuat produk, mengubahnya, menghapusnya, serta smoke test halaman toko. Data test selalu dibersihkan.

## Membuktikan persistence dan recovery

1. Tambahkan produk melalui Seller Center dan catat namanya.
2. Jalankan `docker compose down` (tanpa `-v`), lalu `docker compose up -d`.
3. Cari produk tersebut kembali di katalog: data tetap ada karena named volume.
4. Uji web recovery dengan `docker compose stop web`, `docker compose start web`, lalu `docker compose ps` dan curl health endpoint.

Jangan memakai `docker compose down -v` saat membuktikan persistence karena perintah itu menghapus volume database.

## GitHub Actions

Workflow `.github/workflows/ci.yml` memvalidasi Compose menggunakan `.env.example`, build image, menjalankan `web` dan `db`, menunggu `/health.php`, menjalankan test, menampilkan status/log saat gagal, dan selalu membersihkan container dengan `docker compose down`.

Riwayat Git sudah memiliki simulasi gagal (`2f27a38`) dan perbaikannya (`88df66f`). Setelah perubahan UAS ini di-commit dan pengguna memilih untuk push, lihat tab **Actions** untuk menyimpan bukti run dua-container yang gagal/berhasil; repository lokal sengaja tidak melakukan push otomatis.
