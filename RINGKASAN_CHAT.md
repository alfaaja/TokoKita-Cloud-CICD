# Ringkasan Chat TokoKita Cloud CI/CD

## Konteks Awal

Repository lokal:

```text
/home/alfa/TokoKita-Cloud-CICD
```

Repository berasal dari project lama TokoKita/Praktikum-CyberSec-10, tetapi instruksi tugas di `InstruksiCodex.md` meminta repo diubah menjadi project praktikum Cloud Computing dengan tema:

```text
Integrasi Docker, Docker Compose, dan CI/CD menggunakan GitHub Actions
```

Remote GitHub:

```text
https://github.com/alfaaja/TokoKita-Cloud-CICD.git
```

## Yang Sudah Dikerjakan

### 1. Membaca Instruksi dan Repository

File `InstruksiCodex.md` dibaca penuh. Repository juga diperiksa:

- `README.md`
- `docker-compose.yml`
- semua file `src/`
- semua file `scripts/`
- struktur folder
- status git
- remote git

Aplikasi teridentifikasi sebagai:

- PHP
- Apache
- web toko sederhana
- dijalankan via Docker/Compose

### 2. Perubahan Aplikasi

Aplikasi dirapikan menjadi:

```text
TokoKita Cloud CI/CD
```

Perubahan penting:

- Homepage menampilkan nama `TokoKita Cloud CI/CD`
- Navigasi ditambah halaman `Info`
- Ditambahkan endpoint baru `src/info.php`
- Sisa fungsi/pola security lama di `data.php` dan `product.php` dihapus agar konteks tidak membingungkan laporan Cloud CI/CD

Endpoint utama aplikasi:

- `/`
- `/products.php`
- `/product.php?id=1`
- `/promo.php`
- `/info.php`

### 3. File Infrastruktur Dibuat

File yang dibuat/diubah:

```text
Dockerfile
docker-compose.yml
.gitignore
logs/.gitkeep
tests/test_app.sh
.github/workflows/ci.yml
README.md
docs/checklist_laporan.md
docs/panduan_presentasi.md
docs/struktur_laporan.md
docs/alur_demo_video.md
```

### 4. Dockerfile

Konsep Dockerfile:

```dockerfile
FROM php:8.2-apache

WORKDIR /var/www/html

COPY src/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
```

### 5. Docker Compose

`docker-compose.yml` dibuat sesuai tugas:

```yaml
services:
  web:
    build: .
    image: tokokita-cloud-cicd:v1
    container_name: tokokita-cloud-cicd
    ports:
      - "8080:80"
    volumes:
      - ./logs:/var/log/apache2
    environment:
      TZ: Asia/Jakarta
    restart: unless-stopped
```

### 6. Automated Test

`tests/test_app.sh` dibuat executable.

Isi normalnya mengecek:

- homepage
- produk
- detail produk
- promo
- info CI/CD

Menggunakan:

- Bash
- `set -e`
- `curl -fsS`
- `BASE_URL="${BASE_URL:-http://localhost:8080}"`

### 7. GitHub Actions

Workflow dibuat di:

```text
.github/workflows/ci.yml
```

Pipeline berjalan pada:

- push ke `main`
- pull request ke `main`

Tahapan:

1. Checkout source code
2. Docker build
3. Docker Compose up
4. Wait aplikasi siap
5. Run automated test
6. Docker ps
7. Docker Compose logs
8. Docker Compose down dengan `if: always()`

### 8. Dokumentasi

README dibuat ulang berisi:

- deskripsi project
- tujuan praktikum
- teknologi
- struktur folder
- cara menjalankan lokal
- automated test
- GitHub Actions
- simulasi pipeline gagal
- memperbaiki pipeline
- hubungan Docker, Docker Compose, dan CI/CD

Folder `docs/` berisi:

- checklist laporan
- panduan presentasi
- struktur laporan
- alur demo video 5-7 menit

### 9. Verifikasi Lokal

Sudah dijalankan:

- `php -l` semua file PHP: berhasil
- `docker --version`: tersedia
- `docker compose version`: tersedia
- `docker build -t tokokita-cloud-cicd:v1 .`: berhasil
- `docker compose up -d`: berhasil
- `docker compose ps`: container running di port 8080
- `./tests/test_app.sh`: berhasil saat dijalankan dengan akses host normal
- `docker compose down`: berhasil

Catatan:

- Test curl pertama sempat gagal dari sandbox karena tidak bisa akses localhost container.
- Setelah dijalankan di luar sandbox, test berhasil.

### 10. Commit Awal

Branch diganti dari `master` ke `main`.

Commit yang sudah dibuat:

```text
6063925 Menambahkan aplikasi TokoKita Cloud
8988c2f Menambahkan Dockerfile untuk build image aplikasi
452be8e Menambahkan Docker Compose untuk menjalankan service
e76e606 Menambahkan automated test endpoint aplikasi
60b713d Menambahkan workflow GitHub Actions untuk CI
a447dcf Menambahkan dokumentasi tugas dan panduan presentasi
```

### 11. Masalah Push Awal

Push pertama gagal karena token GitHub tidak punya scope `workflow`.

Error:

```text
refusing to allow a Personal Access Token to create or update workflow `.github/workflows/ci.yml` without `workflow` scope
```

Solusi yang diberikan:

- gunakan token GitHub dengan scope `repo`
- gunakan token GitHub dengan scope `workflow`

User akhirnya berhasil push setelah memakai credential/token yang benar.

### 12. Agar Push Tidak Minta Username/Password Terus

Diberikan solusi:

```bash
git config --global credential.helper store
```

Lalu push sekali lagi dan masukkan:

- username: `alfaaja`
- password: Personal Access Token GitHub

Catatan:

- `gh` tidak tersedia di sistem user.
- `sudo apt install gh` gagal karena package `gh` tidak ditemukan.
- Solusi yang dipakai adalah credential helper `store`.

### 13. Push Awal Berhasil

Setelah user push manual, dicek lokal:

```text
a447dcf (HEAD -> main, origin/main) Menambahkan dokumentasi tugas dan panduan presentasi
```

Artinya local `main` sudah sinkron dengan `origin/main`.

### 14. Simulasi Pipeline Gagal

Assistant menambahkan endpoint palsu ke `tests/test_app.sh`:

```bash
echo "[TEST] Simulasi endpoint gagal..."
curl -fsS "$BASE_URL/halaman-tidak-ada.php" > /dev/null
```

Lalu commit:

```text
2f27a38 Simulasi pipeline gagal
```

Push berhasil:

```text
a447dcf..2f27a38 main -> main
```

Instruksi terakhir:

- buka GitHub repository
- masuk tab Actions
- tunggu workflow terbaru selesai
- workflow harus merah/gagal karena endpoint `/halaman-tidak-ada.php`
- ambil screenshot/link workflow gagal
- setelah itu user harus bilang `udah merah`
- selanjutnya endpoint palsu akan dihapus, lalu dibuat commit `Memperbaiki test agar pipeline berhasil`

## Status Terakhir

Status terakhir repository remote saat ringkasan ini dibuat:

```text
Commit terakhir: 2f27a38 Simulasi pipeline gagal
```

`tests/test_app.sh` saat ini sengaja dalam kondisi gagal karena ada endpoint palsu:

```bash
curl -fsS "$BASE_URL/halaman-tidak-ada.php" > /dev/null
```

## Yang Masih Perlu Dilakukan

1. User cek GitHub Actions.
2. Pastikan workflow commit `Simulasi pipeline gagal` berwarna merah/gagal.
3. Ambil screenshot/link pipeline gagal.
4. Hapus endpoint palsu dari `tests/test_app.sh`.
5. Commit perbaikan:

```bash
git add tests/test_app.sh
git commit -m "Memperbaiki test agar pipeline berhasil"
git push
```

6. Cek GitHub Actions lagi.
7. Pastikan workflow terbaru hijau/berhasil.
8. Ambil screenshot/link pipeline berhasil.
9. Final repository harus ditinggalkan dalam kondisi test normal dan pipeline berhasil.

## Checklist Screenshot untuk Laporan

Ambil screenshot:

- `docker --version`
- `docker compose version`
- `docker run hello-world`
- `docker build -t tokokita-cloud-cicd:v1 .`
- `docker images`
- `docker compose up -d`
- `docker compose ps`
- aplikasi di browser `http://localhost:8080`
- `./tests/test_app.sh` berhasil
- repository GitHub
- commit history
- file `.github/workflows/ci.yml`
- GitHub Actions gagal
- log error pipeline gagal
- GitHub Actions berhasil
- log build dan test pipeline berhasil
