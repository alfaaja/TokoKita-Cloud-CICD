# Checklist UAS

- [x] Dockerfile PHP/Apache dengan ekstensi MySQL.
- [x] Compose `web` dan `db`, explicit network, restart policy, health dependency.
- [x] Named volume `tokokita_db_data` dan seed schema produk.
- [x] `.env.example`; `.env` diabaikan Git.
- [x] Produk dibaca dari MySQL dengan PDO/prepared statement.
- [x] CRUD dan validasi melalui Seller Center serta API.
- [x] `/health.php` menguji aplikasi dan database.
- [x] Test Bash mencakup health, read, create, invalid input, update, delete.
- [x] Workflow CI menjalankan validasi Compose, build, health wait, test, status/log, cleanup.
- [x] Build, Compose, health, dan test lokal telah diverifikasi pada 19 Juli 2026.
- [ ] Bukti GitHub Actions dua-container perlu direkam setelah pengguna melakukan push sendiri.
- [ ] Bukti screenshot perlu direkam oleh pengguna saat demo/laporan.
