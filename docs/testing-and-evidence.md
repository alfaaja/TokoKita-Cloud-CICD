# Testing dan Bukti

Verifikasi lokal yang telah dilakukan pada 19 Juli 2026:

```text
docker compose config -q                 berhasil
docker build -t tokokita-cloud-cicd:v1 . berhasil
curl -i /health.php                      HTTP 200, database connected
./tests/test_app.sh                      berhasil
docker compose ps                        web Up, db Up (healthy)
```

Ambil screenshot untuk laporan: build, `docker compose ps`, respons health JSON, katalog, Seller Center saat CRUD, output test, dan status workflow GitHub Actions setelah push manual.

Test otomatis membuat produk khusus, mengubahnya, lalu menghapusnya melalui API sehingga tidak mengotori seed data.
