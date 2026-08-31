<?php
// ================================
// PTERODACTYL WEB CONFIGURATION
// ================================
// Isi nilai berikut sebelum digunakan.

define('DB_HOST', 'localhost');
define('DB_NAME', 'ptero_web');
define('DB_USER', 'cpanel_db_user');
define('DB_PASS', 'GANTI_PASSWORD_DATABASE');

define('PTERODACTYL_URL', 'https://okiy.pterocloud.my.id');
define('PTERODACTYL_API_KEY', 'ptla_xj2h8d1DQOnF2ecI2sKxgTR9NqRgdX2PVEboX5KGjSH');

// ID Pterodactyl yang digunakan saat provisioning.
// Ambil dari panel Pterodactyl / API. Jangan menebak ID ini.
define('PTERO_NODE_ID', 5);
define('PTERO_EGG_ID', 15);
define('PTERO_ALLOCATION_ID', 1);

// Docker image dan startup harus cocok dengan Egg Anda.
define('PTERO_DOCKER_IMAGE', 'ghcr.io/pterodactyl/yolks:java_21');
define('PTERO_STARTUP', 'java -Xms128M -Xmx{{SERVER_MEMORY}}M -jar {{SERVER_JARFILE}} nogui');
define('PTERO_SERVER_JARFILE', 'server.jar');
