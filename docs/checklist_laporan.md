# Checklist Bukti Laporan

Gunakan checklist ini untuk memastikan semua bukti praktikum sudah terdokumentasi.

## Bukti Environment

- [ ] Screenshot `docker --version`
- [ ] Screenshot `docker compose version`
- [ ] Screenshot `docker run hello-world`

## Bukti Docker

- [ ] Screenshot `docker build -t tokokita-cloud-cicd:v1 .` berhasil
- [ ] Screenshot `docker images` yang menampilkan image `tokokita-cloud-cicd`
- [ ] Screenshot isi `Dockerfile`

## Bukti Docker Compose

- [ ] Screenshot `docker compose up -d`
- [ ] Screenshot `docker compose ps`
- [ ] Screenshot isi `docker-compose.yml`
- [ ] Screenshot aplikasi dapat diakses dari browser atau `curl http://localhost:8080`

## Bukti Automated Test

- [ ] Screenshot isi `tests/test_app.sh`
- [ ] Screenshot `./tests/test_app.sh` berhasil di lokal
- [ ] Screenshot output `[SUCCESS] Semua endpoint utama berhasil diakses.`

## Bukti GitHub dan CI/CD

- [ ] Screenshot repository GitHub aktif
- [ ] Screenshot commit history terlihat
- [ ] Screenshot file `.github/workflows/ci.yml`
- [ ] Screenshot GitHub Actions gagal
- [ ] Screenshot log error pipeline gagal
- [ ] Screenshot GitHub Actions berhasil
- [ ] Screenshot log test dan build pipeline berhasil

## Bukti Simulasi Gagal dan Perbaikan

- [ ] Screenshot commit `Simulasi pipeline gagal`
- [ ] Screenshot endpoint palsu di `tests/test_app.sh`
- [ ] Screenshot pipeline merah atau failed
- [ ] Screenshot commit `Memperbaiki test agar pipeline berhasil`
- [ ] Screenshot pipeline hijau atau success
