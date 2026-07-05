# Panduan Presentasi

## Pembukaan

Selamat pagi/siang. Pada praktikum ini saya membuat project bernama TokoKita Cloud CI/CD. Project ini adalah aplikasi toko sederhana berbasis PHP dan Apache yang dipakai untuk mendemonstrasikan Docker, Docker Compose, automated testing, dan CI/CD menggunakan GitHub Actions.

## Aplikasi yang Digunakan

Aplikasinya berupa website toko sederhana. Ada homepage, katalog produk, detail produk, promo, keranjang, login, seller center, dan halaman info CI/CD. Aplikasi ini sengaja dibuat sederhana supaya fokus praktikum tetap pada proses containerization dan pipeline, bukan pada kompleksitas fitur toko.

## Alasan Aplikasi Sederhana Cukup

Untuk membuktikan konsep Cloud CI/CD, yang penting adalah aplikasi bisa berjalan, bisa dibuild menjadi image, bisa dijalankan sebagai container, dan punya endpoint yang bisa diuji otomatis. Karena itu aplikasi sederhana sudah cukup untuk menunjukkan alur dari source code sampai pipeline berhasil.

## Fungsi Dockerfile

Dockerfile berisi instruksi untuk membuat image aplikasi. Base image yang dipakai adalah `php:8.2-apache`. Folder `src/` disalin ke `/var/www/html/`, lalu permission disesuaikan untuk user Apache. Dengan Dockerfile ini, aplikasi bisa dibuild menggunakan perintah `docker build -t tokokita-cloud-cicd:v1 .`.

## Fungsi Docker Image

Docker image adalah paket aplikasi yang sudah berisi runtime PHP, Apache, dan source code TokoKita. Image ini membuat aplikasi lebih konsisten karena environment-nya sama di laptop lokal maupun di GitHub Actions.

## Fungsi Container

Container adalah instance yang berjalan dari Docker image. Saat container aktif, Apache melayani aplikasi TokoKita di port 80 container, lalu dipublish ke port 8080 di komputer lokal.

## Fungsi Docker Compose

Docker Compose digunakan untuk menjalankan service secara deklaratif. Di file `docker-compose.yml`, service bernama `web` dibuild dari Dockerfile, memakai image `tokokita-cloud-cicd:v1`, memakai container name `tokokita-cloud-cicd`, memetakan port `8080:80`, dan menyimpan log Apache ke folder `logs/`.

## Fungsi Automated Test

Automated test ada di `tests/test_app.sh`. Script ini memakai Bash dan curl untuk mengecek endpoint utama seperti homepage, katalog produk, detail produk, promo, dan info CI/CD. Jika salah satu endpoint gagal, script akan exit non-zero dan pipeline ikut gagal.

## Fungsi GitHub Actions

GitHub Actions menjalankan proses CI setiap ada push atau pull request ke branch `main`. Workflow melakukan checkout, build Docker image, menjalankan Docker Compose, menunggu aplikasi siap, menjalankan test, menampilkan container dan log, lalu mematikan service.

## Simulasi Pipeline Gagal

Untuk membuktikan pipeline bisa mendeteksi error, saya menambahkan endpoint palsu ke `tests/test_app.sh`, yaitu `/halaman-tidak-ada.php`. Karena endpoint itu tidak ada, curl gagal dan GitHub Actions menjadi merah atau failed.

## Pipeline Berhasil

Setelah bukti gagal didapat, endpoint palsu dihapus. Test dijalankan ulang dan semua endpoint valid berhasil diakses. Setelah commit dan push ulang, GitHub Actions kembali hijau atau success.

## Kesimpulan

Kesimpulannya, project TokoKita Cloud CI/CD menunjukkan bahwa aplikasi web sederhana dapat dikemas dengan Docker, dikelola dengan Docker Compose, diuji otomatis dengan Bash dan curl, serta divalidasi otomatis melalui GitHub Actions. Alur ini membantu memastikan perubahan kode tidak langsung dianggap benar sebelum build dan test berhasil.
