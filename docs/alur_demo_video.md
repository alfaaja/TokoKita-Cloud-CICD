# Alur Demo Video 5-7 Menit

## 1. Identitas

Durasi: 20-30 detik.

Sampaikan nama, kelas, dan judul praktikum: Integrasi Docker, Docker Compose, dan CI/CD menggunakan GitHub Actions.

## 2. Buka Repository

Durasi: 30 detik.

Buka repository `TokoKita-Cloud-CICD` di editor dan GitHub. Jelaskan bahwa project ini adalah aplikasi toko sederhana untuk demonstrasi Cloud CI/CD.

## 3. Tunjukkan Struktur Folder

Durasi: 30 detik.

Tunjukkan folder penting:
- `src/`
- `tests/`
- `docs/`
- `logs/`
- `.github/workflows/`
- `Dockerfile`
- `docker-compose.yml`

## 4. Tunjukkan Dockerfile

Durasi: 30-45 detik.

Jelaskan base image `php:8.2-apache`, proses copy folder `src/`, permission Apache, dan expose port 80.

## 5. Tunjukkan docker-compose.yml

Durasi: 30-45 detik.

Jelaskan service `web`, build dari Dockerfile, image, container name, port `8080:80`, volume log, timezone, dan restart policy.

## 6. Cek Docker

Durasi: 40 detik.

Jalankan:

```bash
docker --version
docker compose version
docker run hello-world
```

Jelaskan bahwa ini membuktikan Docker dan Compose tersedia.

## 7. Jalankan Aplikasi

Durasi: 60 detik.

Jalankan:

```bash
docker compose up -d
docker compose ps
```

Buka:

```text
http://localhost:8080
```

Tunjukkan homepage TokoKita Cloud CI/CD dan halaman produk atau info.

## 8. Jalankan Automated Test

Durasi: 45 detik.

Jalankan:

```bash
./tests/test_app.sh
```

Jelaskan bahwa script mengecek endpoint utama memakai curl. Jika semua endpoint bisa diakses, test berhasil.

## 9. Tunjukkan GitHub Actions Gagal

Durasi: 60 detik.

Buka tab Actions di GitHub. Tunjukkan workflow yang gagal dari commit `Simulasi pipeline gagal`. Jelaskan bahwa penyebabnya adalah endpoint palsu `/halaman-tidak-ada.php` di test.

## 10. Tunjukkan GitHub Actions Berhasil

Durasi: 60 detik.

Buka workflow terbaru yang berhasil dari commit `Memperbaiki test agar pipeline berhasil`. Tunjukkan langkah build, compose up, test, logs, dan compose down.

## 11. Penutup

Durasi: 20-30 detik.

Simpulkan bahwa Docker membungkus aplikasi, Docker Compose menjalankan service, automated test memvalidasi endpoint, dan GitHub Actions mengotomatisasi build serta test setiap perubahan kode.
