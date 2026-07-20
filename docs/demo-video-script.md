# Naskah Demo Video UAS (5–7 menit)

1. Perkenalkan TokoKita sebagai PHP/Apache yang memakai MySQL 8 dalam Docker Compose.
2. Tunjukkan Dockerfile, Compose, network, `depends_on`, named volume, dan `.env.example` (tanpa membuka `.env`).
3. Jalankan `docker compose up -d` lalu `docker compose ps`; jelaskan `db` harus `healthy` dan web berada di port 8080.
4. Buka katalog dan Seller Center. Tambahkan satu produk, ubah stoknya, lalu hapus produk contoh lain bila perlu.
5. Tampilkan `curl -i http://localhost:8080/health.php` dan jalankan `./tests/test_app.sh`.
6. Buktikan persistence: buat produk, `docker compose down`, `up -d`, lalu cari lagi produk tersebut.
7. Jalankan restart web sesuai `failure-recovery.md` dan tunjukkan health tetap 200.
8. Tampilkan workflow GitHub Actions: config, build, Compose, health wait, test, log, cleanup. Rekam bukti run merah dan hijau setelah push manual.
