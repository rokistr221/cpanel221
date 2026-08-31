PTERODACTYL WEB - CARA INSTALASI

1. Upload isi folder ini ke public_html/pterodactyl-web/ (atau langsung public_html/).
2. Buat database + database user di cPanel.
3. Import database.sql melalui phpMyAdmin.
4. Edit config.php:
   - DB_HOST, DB_NAME, DB_USER, DB_PASS
   - PTERODACTYL_URL
   - PTERODACTYL_API_KEY
   - PTERO_NODE_ID
   - PTERO_EGG_ID
   - PTERO_ALLOCATION_ID
   - PTERO_DOCKER_IMAGE
   - PTERO_STARTUP
5. API key harus Application API key dari Pterodactyl. Jangan taruh API key di HTML/JS.
6. Pada template ini, PTERO_USER_ID belum ditetapkan di config. Tambahkan:
   define('PTERO_USER_ID', 1);
   dengan ID user Pterodactyl yang memang boleh memiliki server.
7. Buka index.php dan daftar/login.
8. Pastikan hosting cPanel memiliki PHP PDO MySQL dan cURL.

CATATAN PENTING
- Nilai nest/egg/environment/startup berbeda-beda antar Egg. Sesuaikan config/payload dengan Egg Anda.
- create-server.php memakai Application API.
- Tombol power (start/stop/restart) sengaja belum memakai Application API karena endpoint power adalah Client API. Jangan memasukkan satu Client API key bersama untuk semua user.
- Untuk produksi, gunakan autentikasi Client API per-user atau backend service yang aman, plus validasi ownership.
- Aktifkan HTTPS.
