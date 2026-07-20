# Arsitektur UAS Cloud

`web` dibangun dari Dockerfile berbasis `php:8.2-apache`. Ekstensi `pdo_mysql` dipakai oleh `src/config/database.php` untuk membuka koneksi PDO ke hostname `db` di jaringan Docker.

`db` memakai `mysql:8.0`, menjalankan seed `database/init/001_schema.sql` hanya ketika volume baru dibuat, dan menyimpan data di named volume `tokokita_db_data`. Health check memakai `mysqladmin ping`; `web` memiliki `depends_on` dengan kondisi database sehat.

Database tidak dipublikasikan ke host. Hanya Apache yang dipublikasikan pada `8080:80`. Log Apache tetap di-mount ke folder `logs/`.
