# Struktur Laporan

Kerangka ini dapat dipakai untuk laporan sekitar 6 sampai 10 halaman.

## Halaman Judul

Isi:
- Judul praktikum: Integrasi Docker, Docker Compose, dan CI/CD menggunakan GitHub Actions.
- Nama project: TokoKita Cloud CI/CD.
- Nama, NIM, kelas, dosen, dan tanggal.

Screenshot:
- Tidak wajib, cukup format halaman judul.

## Bab 1 Pendahuluan

Isi:
- Latar belakang penggunaan container dalam pengembangan aplikasi.
- Alasan Docker membantu menjalankan aplikasi secara konsisten.
- Alasan CI/CD membantu mendeteksi error otomatis.
- Tujuan praktikum.

Screenshot:
- Screenshot repository GitHub atau struktur project sebagai pengantar.

## Bab 2 Deskripsi Aplikasi

Isi:
- Penjelasan aplikasi TokoKita Cloud CI/CD.
- Teknologi yang dipakai: PHP, Apache, Docker, Docker Compose, Bash, curl, GitHub Actions.
- Endpoint utama: `/`, `/products.php`, `/product.php?id=1`, `/promo.php`, dan `/info.php`.
- Alasan aplikasi sederhana cukup untuk praktikum.

Screenshot:
- Homepage aplikasi di browser.
- Halaman produk atau halaman info CI/CD.

## Bab 3 Implementasi Docker

Isi:
- Penjelasan isi Dockerfile.
- Base image `php:8.2-apache`.
- Proses copy source code ke `/var/www/html/`.
- Perintah build image.

Screenshot:
- Isi `Dockerfile`.
- Output `docker build -t tokokita-cloud-cicd:v1 .`.
- Output `docker images`.

## Bab 4 Implementasi Docker Compose

Isi:
- Penjelasan service `web`.
- Build dari Dockerfile.
- Image `tokokita-cloud-cicd:v1`.
- Port mapping `8080:80`.
- Volume `./logs:/var/log/apache2`.
- Environment `TZ=Asia/Jakarta`.
- Restart policy `unless-stopped`.

Screenshot:
- Isi `docker-compose.yml`.
- Output `docker compose up -d`.
- Output `docker compose ps`.
- Aplikasi diakses melalui browser atau curl.

## Bab 5 Implementasi CI/CD

Isi:
- Penjelasan automated test di `tests/test_app.sh`.
- Penjelasan workflow `.github/workflows/ci.yml`.
- Tahapan pipeline: checkout, build image, compose up, wait, test, logs, compose down.
- Simulasi pipeline gagal dengan endpoint palsu.
- Perbaikan pipeline dengan menghapus endpoint palsu.

Screenshot:
- Isi `tests/test_app.sh`.
- Output test lokal berhasil.
- Isi workflow GitHub Actions.
- GitHub Actions gagal.
- Log error pipeline gagal.
- GitHub Actions berhasil.
- Log build dan test pipeline berhasil.

## Bab 6 Kesimpulan

Isi:
- Docker membuat aplikasi mudah dibungkus menjadi image.
- Docker Compose memudahkan menjalankan service dengan konfigurasi yang jelas.
- Automated test membantu memvalidasi endpoint utama.
- GitHub Actions mengotomatisasi proses build dan test setiap ada perubahan.
- Pipeline gagal dan berhasil membuktikan CI/CD berjalan sesuai tujuan.

Screenshot:
- Screenshot ringkasan pipeline berhasil dapat ditambahkan sebagai penutup.
