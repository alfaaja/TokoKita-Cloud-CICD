# Instruksi Codex — Upgrade TokoKita untuk UAS Cloud Computing

## Peran kamu

Kamu adalah coding agent yang bekerja langsung pada repository lokal proyek **TokoKita-Cloud-CICD**. Tugasmu adalah melanjutkan proyek praktikum sebelumnya menjadi proyek UAS Cloud Computing yang memenuhi seluruh komponen wajib dosen.

Jangan membuat proyek baru dari nol dan jangan mengganti tema TokoKita. Pertahankan tampilan dan halaman yang sudah bagus sejauh tidak menghambat implementasi. Fokus utama adalah membuat aplikasi benar-benar terhubung ke database dan dapat dibuktikan berjalan dalam arsitektur multi-container.

## Aturan kerja wajib

1. Baca seluruh repository sebelum mengubah file.
2. Tampilkan struktur folder ringkas dan ringkasan kondisi awal.
3. Baca minimal `README.md`, `Dockerfile`, `docker-compose.yml`, workflow GitHub Actions, semua file `src/`, file `tests/`, dan dokumentasi pada `docs/`.
4. Cocokkan kondisi aktual repository dengan checklist UAS.
5. Buat rencana perubahan singkat sebelum coding.
6. Kerjakan perubahan bertahap dan verifikasi setiap tahap.
7. Jangan menghapus tampilan lama atau file penting tanpa alasan teknis.
8. Jangan menyimpan password, token, private key, atau credential asli di repository.
9. Jangan mengubah remote Git dan jangan melakukan `git push` tanpa diminta.
10. Jangan memakai Kubernetes, VPS, atau layanan cloud berbayar.
11. Jangan menggunakan perintah destruktif seperti `git reset --hard` atau menghapus volume pengguna tanpa persetujuan.
12. Jika ada asumsi teknis, tulis asumsi tersebut di ringkasan perubahan.
13. Setelah setiap tahap selesai, jalankan test yang relevan dan laporkan hasilnya.

## Target arsitektur akhir

Proyek harus memiliki arsitektur berikut:

```text
Pengguna
   |
   v
Container web: PHP 8.2 + Apache + aplikasi TokoKita
   |
   | network Docker Compose
   v
Container database: MySQL 8
   |
   v
Named volume: data MySQL persisten
```

Service wajib:

- `web`: aplikasi PHP + Apache.
- `db`: MySQL.

Komponen pendukung wajib:

- Dockerfile.
- Docker Compose.
- Explicit network.
- `depends_on` dengan kondisi database sehat.
- Restart policy.
- Persistent volume database.
- Environment variable melalui `.env` dan `.env.example`.
- Health check.
- Automated test minimal tiga test relevan.
- GitHub Actions.

Adminer, phpMyAdmin, Redis, Docker Hub, deployment cloud, reverse proxy, dan load balancing hanya boleh ditambahkan setelah komponen wajib selesai dan seluruh test lulus.

## Kondisi proyek yang perlu diasumsikan

Proyek lama menggunakan PHP + Apache dan memiliki halaman TokoKita, Dockerfile, Docker Compose satu service, script `tests/test_app.sh`, serta workflow GitHub Actions. Data produk lama masih berada di array PHP atau file statis.

Tetap verifikasi kondisi aktual repository; jangan mengandalkan asumsi ini jika isi file berbeda.

---

## Tahap 1 — Audit dan baseline

Lakukan hal berikut tanpa mengubah source code:

1. Tampilkan struktur folder tanpa menampilkan `.git`, `vendor`, atau file berukuran besar.
2. Baca file konfigurasi dan source code penting.
3. Jalankan pemeriksaan awal jika Docker tersedia:

```bash
docker --version
docker compose version
docker compose config
```

4. Catat fitur yang sudah ada dan fitur UAS yang belum ada.
5. Buat checklist status dengan tiga kategori: `sudah`, `sebagian`, dan `belum`.

Jangan mulai implementasi sebelum audit ini selesai.

## Tahap 2 — Database dan konfigurasi environment

Gunakan MySQL 8 sebagai database. Implementasikan sebagai berikut.

### File yang perlu dibuat atau diperbarui

```text
database/
└── init/
    └── 001_schema.sql
src/
└── config/
    └── database.php
.env.example
.gitignore
```

Buat tabel `products` dengan minimal kolom:

- `id` sebagai primary key auto increment.
- `name`.
- `price`.
- `category`.
- `stock`.
- `description`.
- `created_at`.
- `updated_at` jika diperlukan.

Masukkan beberapa data awal melalui `database/init/001_schema.sql` agar aplikasi langsung dapat digunakan setelah pertama kali dijalankan.

Gunakan PDO atau MySQLi dengan prepared statement. PDO lebih disarankan.

File `.env.example` minimal memuat:

```env
MYSQL_DATABASE=tokokita
MYSQL_USER=tokokita_user
MYSQL_PASSWORD=change_me_local
MYSQL_ROOT_PASSWORD=change_me_root
DB_HOST=db
DB_PORT=3306
DB_NAME=tokokita
DB_USER=tokokita_user
DB_PASSWORD=change_me_local
```

Buat `.env` lokal hanya jika diperlukan untuk menjalankan aplikasi. Jangan pernah menulis credential asli di `.env.example`, README, source code, screenshot publik, atau GitHub Actions.

Tambahkan `.env` ke `.gitignore` dan pastikan `.env.example` tetap terlacak Git.

## Tahap 3 — Upgrade Dockerfile

Perbarui Dockerfile agar ekstensi database PHP tersedia. Gunakan pola yang sederhana dan mudah dijelaskan:

```dockerfile
FROM php:8.2-apache

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql mysqli

COPY src/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
```

Pertahankan default command Apache dari base image kecuali ada alasan teknis yang jelas.

Pastikan Dockerfile dapat dibuild dengan:

```bash
docker build -t tokokita-cloud-cicd:v1 .
```

## Tahap 4 — Upgrade Docker Compose menjadi dua container

Perbarui `docker-compose.yml` dengan ketentuan berikut:

- Service aplikasi bernama `web`.
- Service database bernama `db`.
- Port host aplikasi tetap `8080:80`.
- Database tidak perlu diekspos ke host kecuali untuk debugging.
- Gunakan explicit network, misalnya `tokokita_net`.
- Gunakan `depends_on` dari `web` ke `db` dengan kondisi `service_healthy`.
- Gunakan restart policy `unless-stopped`.
- Gunakan named volume database, misalnya `tokokita_db_data`.
- Gunakan file `.env` melalui interpolasi Compose.
- Pertahankan volume log Apache bila masih relevan.
- Tambahkan health check untuk database dengan `mysqladmin ping`.

Struktur konfigurasi minimal yang diharapkan:

```yaml
services:
  db:
    image: mysql:8.0
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: ${MYSQL_DATABASE}
      MYSQL_USER: ${MYSQL_USER}
      MYSQL_PASSWORD: ${MYSQL_PASSWORD}
      MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
    volumes:
      - tokokita_db_data:/var/lib/mysql
      - ./database/init:/docker-entrypoint-initdb.d:ro
    healthcheck:
      test: ["CMD-SHELL", "mysqladmin ping -h localhost -u root -p$${MYSQL_ROOT_PASSWORD}"]
      interval: 5s
      timeout: 5s
      retries: 20
    networks:
      - tokokita_net

  web:
    build: .
    image: tokokita-cloud-cicd:v1
    container_name: tokokita-cloud-cicd
    ports:
      - "8080:80"
    environment:
      TZ: Asia/Jakarta
      DB_HOST: ${DB_HOST}
      DB_PORT: ${DB_PORT}
      DB_NAME: ${DB_NAME}
      DB_USER: ${DB_USER}
      DB_PASSWORD: ${DB_PASSWORD}
    depends_on:
      db:
        condition: service_healthy
    restart: unless-stopped
    volumes:
      - ./logs:/var/log/apache2
    networks:
      - tokokita_net

volumes:
  tokokita_db_data:

networks:
  tokokita_net:
    driver: bridge
```

Sesuaikan sintaks jika versi Docker Compose lokal berbeda, tetapi semua konsep di atas harus tetap ada.

## Tahap 5 — Koneksi aplikasi ke database

Buat satu helper koneksi database yang terpusat, misalnya `src/config/database.php`.

Ketentuan:

- Ambil konfigurasi dari environment variable.
- Host database harus menggunakan nama service Compose `db`, bukan `localhost`.
- Gunakan exception untuk kegagalan koneksi.
- Jangan menampilkan password pada pesan error.
- Gunakan prepared statement untuk query dengan input pengguna.
- Tambahkan timeout atau retry ringan bila diperlukan ketika database baru mulai.

Jika koneksi gagal, aplikasi harus memberi respons yang jelas untuk debugging tanpa membocorkan credential.

## Tahap 6 — Implementasi CRUD produk

Jangan menghapus desain TokoKita yang sudah ada. Ubah sumber data produk agar membaca database.

Minimal implementasikan:

1. **Read** — `products.php` menampilkan daftar produk dari tabel `products`.
2. **Create** — halaman/form admin dapat menambahkan produk.
3. **Update** — admin dapat mengubah nama, harga, kategori, stok, dan deskripsi.
4. **Delete** — admin dapat menghapus produk dengan konfirmasi.
5. **Validation** — nama wajib diisi, harga dan stok harus numerik serta tidak negatif.

Boleh menggunakan halaman PHP biasa dengan form `GET`/`POST`. Jika lebih mudah untuk testing, tambahkan endpoint JSON:

```text
GET    /api/products.php
POST   /api/products.php
PUT    /api/products.php?id=...
DELETE /api/products.php?id=...
```

Jika endpoint JSON dibuat, gunakan status HTTP yang benar (`200`, `201`, `400`, `404`, `500`) dan response JSON yang konsisten.

Pastikan halaman yang sudah ada seperti homepage, promo, login, dan cart tidak rusak.

## Tahap 7 — Health check aplikasi

Buat endpoint `src/health.php` yang:

- Mengembalikan HTTP `200` jika aplikasi hidup dan query sederhana ke database berhasil.
- Mengembalikan HTTP `503` jika koneksi database gagal.
- Mengembalikan response JSON sederhana, misalnya status aplikasi dan database.
- Tidak menampilkan password, DSN lengkap, atau stack trace ke pengguna.

Contoh pengujian lokal:

```bash
curl -i http://localhost:8080/health.php
```

## Tahap 8 — Automated testing minimal tiga test

Pertahankan `tests/test_app.sh` atau refactor secara aman. Test harus:

- Menggunakan Bash.
- Menggunakan `set -euo pipefail` jika kompatibel.
- Menggunakan `BASE_URL="${BASE_URL:-http://localhost:8080}"`.
- Gagal dengan exit code non-zero jika ada test gagal.
- Tidak memakai credential yang ditulis langsung di script.

Minimal test yang harus ada:

1. `GET /health.php` berhasil.
2. Daftar produk dapat dibaca.
3. Produk valid dapat dibuat atau endpoint create berhasil.
4. Input invalid ditolak.
5. Produk dapat diubah atau dihapus.

Gunakan data test yang mudah dikenali dan, jika membuat data baru, bersihkan data tersebut setelah test bila tidak mengganggu demonstrasi persistence.

Test lama untuk homepage, katalog, promo, dan info tetap boleh dipertahankan sebagai smoke test.

## Tahap 9 — GitHub Actions

Perbarui `.github/workflows/ci.yml` agar pipeline:

1. Checkout source code.
2. Validasi konfigurasi Compose.
3. Build Docker image.
4. Menjalankan `docker compose up -d`.
5. Menunggu database dan aplikasi sehat.
6. Menjalankan automated test.
7. Menampilkan `docker compose ps`.
8. Menampilkan log ketika terjadi kegagalan.
9. Selalu menjalankan `docker compose down` pada tahap cleanup.

Jangan memasukkan password sungguhan ke workflow. Gunakan nilai dummy khusus CI atau GitHub Secrets jika memang diperlukan.

Jika proyek tidak memiliki dependency manager seperti Composer, jelaskan di README bahwa dependency runtime berasal dari base image PHP dan ekstensi yang dipasang saat build. Jangan menambahkan dependency palsu hanya untuk memenuhi formalitas.

## Tahap 10 — Simulasi pipeline gagal dan berhasil

Setelah pipeline utama yang baru sudah stabil:

1. Buat perubahan terkontrol pada test, misalnya memanggil endpoint yang memang tidak ada.
2. Commit dengan pesan yang jelas, misalnya:

```text
Simulasi UAS: pipeline gagal karena test endpoint invalid
```

3. Pastikan GitHub Actions gagal dan log error dapat dibuka.
4. Perbaiki test.
5. Commit lagi, misalnya:

```text
Perbaikan UAS: test endpoint valid dan pipeline berhasil
```

6. Pastikan pipeline kembali hijau.
7. Jangan meninggalkan repository pada kondisi pipeline gagal.

Riwayat pipeline lama boleh dipertahankan sebagai bukti praktikum, tetapi buat bukti baru yang menggunakan arsitektur dua container agar relevan dengan UAS.

## Tahap 11 — Uji persistence dan ketahanan layanan

Lakukan dan dokumentasikan:

```bash
docker compose up -d
docker compose ps
# Tambahkan satu produk lewat aplikasi
docker compose down
docker compose up -d
# Pastikan produk tadi masih ada
```

Lakukan minimal satu simulasi tambahan, misalnya:

```bash
docker compose stop web
docker compose start web
docker compose ps
```

atau hentikan database, amati health check, lalu nyalakan kembali. Catat dampak kegagalan service dan cara pemulihannya.

## Tahap 12 — Dokumentasi repository

Perbarui `README.md` agar berisi:

- Deskripsi TokoKita.
- Arsitektur dua container.
- Daftar fitur CRUD.
- Daftar environment variable tanpa credential asli.
- Cara menjalankan proyek.
- Cara menjalankan test.
- Cara memeriksa health check.
- Cara membuktikan persistence.
- Cara memahami workflow GitHub Actions.
- Peringatan agar `.env` tidak di-upload.

Buat atau perbarui dokumentasi berikut:

```text
docs/
├── architecture.md
├── uas-checklist.md
├── testing-and-evidence.md
├── failure-recovery.md
└── demo-video-script.md
```

Dokumentasi harus sesuai dengan implementasi aktual. Jangan menulis klaim atau screenshot yang belum pernah diverifikasi.

## Kriteria penerimaan akhir

Pekerjaan dianggap selesai hanya jika semua poin berikut terpenuhi:

- [ ] Aplikasi TokoKita dapat dibuild tanpa error.
- [ ] Docker Compose menjalankan minimal `web` dan `db`.
- [ ] Aplikasi dapat terhubung ke database.
- [ ] Produk berasal dari database, bukan array statis sebagai sumber utama.
- [ ] CRUD produk dapat didemonstrasikan.
- [ ] Validasi input berjalan.
- [ ] Named volume database digunakan.
- [ ] Data tetap ada setelah `docker compose down` lalu `up -d`.
- [ ] `.env.example` tersedia.
- [ ] `.env` diabaikan Git.
- [ ] Ada health check database atau aplikasi.
- [ ] Minimal tiga automated test berjalan lokal.
- [ ] GitHub Actions menjalankan build dan test dua container.
- [ ] Ada bukti pipeline gagal secara terkontrol.
- [ ] Ada bukti pipeline berhasil setelah perbaikan.
- [ ] Ada simulasi gangguan atau restart service.
- [ ] README dan dokumentasi sesuai kondisi aktual.
- [ ] Tidak ada credential asli di repository.
- [ ] Tidak ada perubahan remote atau push tanpa izin pengguna.

## Format laporan setelah coding

Setelah implementasi selesai, berikan ringkasan dengan format berikut:

1. File yang dibuat atau diubah.
2. Fitur yang berhasil ditambahkan.
3. Perintah verifikasi yang sudah dijalankan.
4. Hasil automated test lokal.
5. Status setiap service Docker Compose.
6. Hasil uji persistence.
7. Hasil health check.
8. Hal yang belum dapat diverifikasi.
9. Saran screenshot yang harus direkam untuk laporan dan video.

Jangan menyatakan UAS selesai jika salah satu kriteria penerimaan masih gagal.
