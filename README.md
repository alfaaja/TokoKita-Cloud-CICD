# TokoKita Cloud CI/CD

TokoKita Cloud CI/CD adalah aplikasi web toko sederhana yang digunakan untuk mempraktikkan Docker, Docker Compose, automated testing, dan CI/CD GitHub Actions.

Fokus project ini bukan membuat fitur toko yang kompleks, tetapi membuktikan aplikasi sederhana bisa dibuild menjadi Docker image, dijalankan sebagai container, dites otomatis, dan diproses oleh pipeline CI/CD.

## Tujuan Praktikum

- Membangun Docker image dari source code aplikasi.
- Menjalankan aplikasi di dalam container.
- Mengelola service web dengan Docker Compose.
- Menjalankan automated test berbasis Bash dan curl.
- Menjalankan pipeline GitHub Actions pada setiap push atau pull request ke branch `main`.
- Membuktikan pipeline bisa gagal secara terkontrol dan berhasil lagi setelah test diperbaiki.

## Teknologi

- PHP
- Apache
- Docker
- Docker Compose
- Bash
- curl
- GitHub Actions

## Struktur Folder

```text
.
├── src/
│   ├── index.php
│   ├── products.php
│   ├── product.php
│   ├── promo.php
│   ├── info.php
│   └── ...
├── tests/
│   └── test_app.sh
├── logs/
│   └── .gitkeep
├── docs/
│   ├── checklist_laporan.md
│   ├── panduan_presentasi.md
│   ├── struktur_laporan.md
│   └── alur_demo_video.md
├── .github/
│   └── workflows/
│       └── ci.yml
├── Dockerfile
├── docker-compose.yml
├── .gitignore
└── README.md
```

## Cara Menjalankan Lokal

Build Docker image:

```bash
docker build -t tokokita-cloud-cicd:v1 .
```

Jalankan aplikasi dengan Docker Compose:

```bash
docker compose up -d
```

Cek container:

```bash
docker compose ps
```

Akses aplikasi:

```bash
curl http://localhost:8080
```

Jalankan automated test:

```bash
chmod +x tests/test_app.sh
./tests/test_app.sh
```

Matikan service:

```bash
docker compose down
```

## Cara Automated Test Bekerja

File `tests/test_app.sh` memakai Bash, `set -e`, dan `curl -fsS`.

Default target test:

```bash
BASE_URL="${BASE_URL:-http://localhost:8080}"
```

Endpoint yang dicek:

- `/`
- `/products.php`
- `/product.php?id=1`
- `/promo.php`
- `/info.php`

Jika salah satu endpoint gagal diakses, script akan berhenti dengan exit code non-zero. Kondisi ini membuat pipeline GitHub Actions gagal.

## Cara GitHub Actions Bekerja

Workflow ada di `.github/workflows/ci.yml`.

Pipeline berjalan saat:

- push ke branch `main`
- pull request ke branch `main`

Urutan pipeline:

1. Checkout source code.
2. Build Docker image.
3. Jalankan aplikasi dengan Docker Compose.
4. Tunggu aplikasi siap.
5. Jalankan automated test.
6. Tampilkan daftar container.
7. Tampilkan log aplikasi.
8. Matikan container dengan `docker compose down`.

## Simulasi Pipeline Gagal

Edit `tests/test_app.sh`, lalu tambahkan endpoint palsu:

```bash
curl -fsS "$BASE_URL/halaman-tidak-ada.php" > /dev/null
```

Commit dan push perubahan tersebut. GitHub Actions akan gagal karena endpoint tidak ada.

## Memperbaiki Pipeline

Hapus baris endpoint palsu dari `tests/test_app.sh`, lalu commit dan push ulang. Pipeline akan kembali berhasil karena semua endpoint valid bisa diakses.

## Hubungan Docker, Docker Compose, dan CI/CD

Docker membungkus aplikasi menjadi image dan container agar runtime PHP Apache konsisten.

Docker Compose mengelola service secara deklaratif, termasuk build image, nama container, port, timezone, restart policy, dan volume log.

CI/CD mengotomatisasi proses build dan test setiap ada perubahan kode, sehingga error bisa terdeteksi sebelum aplikasi dianggap siap.
