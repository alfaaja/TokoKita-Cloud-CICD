# Struktur Laporan UAS

1. **Pendahuluan** — tujuan containerisasi dan CI/CD TokoKita.
2. **Arsitektur** — diagram web → db → named volume; screenshot Compose dan `ps`.
3. **Implementasi** — Dockerfile, environment tanpa credential asli, schema seed, PDO, CRUD, dan health check.
4. **Pengujian** — output automated test, health JSON, validasi input, dan CI workflow.
5. **Ketahanan** — screenshot persistence dan restart service beserta hasilnya.
6. **Kesimpulan** — manfaat Compose, volume, health check, serta CI untuk aplikasi dua-container.

Rujuk `architecture.md`, `testing-and-evidence.md`, dan `failure-recovery.md` agar narasi sesuai implementasi.
