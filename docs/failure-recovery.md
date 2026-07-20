# Failure dan Recovery

## Database belum siap

`web` menunggu `db` sehat melalui `depends_on`. Jika database kemudian tidak tersedia, `/health.php` mengembalikan HTTP 503 dan JSON tanpa credential. Pulihkan dengan `docker compose start db`, tunggu `docker compose ps` menunjukkan `healthy`, lalu cek health endpoint kembali.

## Web restart

```bash
docker compose stop web
docker compose start web
docker compose ps
curl -i http://localhost:8080/health.php
```

Service menggunakan `restart: unless-stopped`, sehingga Docker dapat memulai ulang service bila proses gagal, kecuali pengguna sengaja menghentikannya.

## Persistence

Gunakan `docker compose down` tanpa `-v`; named volume tetap ada. Setelah `up -d`, data produk yang dibuat sebelumnya harus tetap terbaca. Jangan gunakan `down -v` kecuali memang ingin menghapus seluruh data lokal.
