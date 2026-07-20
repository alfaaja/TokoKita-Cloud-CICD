# Panduan Presentasi Singkat

TokoKita menggunakan PHP 8.2 dan Apache pada container `web`. Produk tidak lagi berasal dari array PHP; aplikasi memakai PDO untuk membaca MySQL 8 pada service `db`.

Dockerfile membangun runtime aplikasi beserta ekstensi `pdo_mysql`. Docker Compose menyatukan web dan database pada `tokokita_net`, menyimpan MySQL di named volume, dan menunggu health check database sebelum web dimulai. Hanya web dipublikasikan ke port 8080.

Seller Center membuktikan CRUD dan validasi. Endpoint `/health.php` membuktikan bahwa Apache dan query database sama-sama siap. Script Bash menguji health, read, validasi invalid, create, update, delete, dan beberapa halaman toko.

Untuk reliability, tunjukkan data bertahan setelah `docker compose down`/`up -d` tanpa `-v`, lalu restart service web dan cek health lagi. GitHub Actions melakukan proses yang sama secara otomatis tanpa credential asli; bukti run GitHub direkam setelah push manual.
