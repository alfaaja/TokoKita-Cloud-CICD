# Checklist Bukti Laporan UAS

- [ ] Docker dan Docker Compose tersedia.
- [ ] Dockerfile berisi ekstensi PDO MySQL.
- [ ] `docker compose config` menampilkan `web`, `db`, network, dan named volume.
- [ ] `docker compose ps` menampilkan `db` healthy dan web aktif di 8080.
- [ ] `/health.php` mengembalikan 200 serta `database: connected`.
- [ ] Katalog menampilkan seed data MySQL.
- [ ] Seller Center menunjukkan create, update, dan delete.
- [ ] `./tests/test_app.sh` berhasil.
- [ ] Produk tetap ada setelah `docker compose down` lalu `up -d` tanpa `-v`.
- [ ] Web kembali sehat setelah stop/start.
- [ ] Workflow GitHub Actions menunjukkan config, build, Compose, health, test, dan cleanup.
- [ ] Bukti pipeline gagal dan berhasil direkam setelah push manual.

Lihat detail perintah di `testing-and-evidence.md` dan naskah video di `demo-video-script.md`.
