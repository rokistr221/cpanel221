<?php
require_once __DIR__ . '/bootstrap.php';
require_login();
verify_csrf();

$name = trim($_POST['name'] ?? '');
$memory = max(128, (int)($_POST['memory'] ?? 1024));
$disk = max(512, (int)($_POST['disk'] ?? 10240));
$cpu = max(10, (int)($_POST['cpu'] ?? 100));

if ($name === '') {
    $_SESSION['error'] = 'Nama server wajib diisi.';
    header('Location: dashboard.php'); exit;
}

try {
    $stmt = db()->prepare('SELECT name,email FROM users WHERE id=?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    // User Pterodactyl harus sudah ada. Untuk keamanan, template ini
    // menggunakan PTERO_USER_ID dari config; Anda dapat mengembangkannya
    // agar membuat user Pterodactyl otomatis.
    $pteroUserId = defined('PTERO_USER_ID') ? PTERO_USER_ID : 1;

    $payload = [
        'name' => $name,
        'user' => (int)$pteroUserId,
        'nest' => 1,
        'egg' => (int)PTERO_EGG_ID,
        'docker_image' => PTERO_DOCKER_IMAGE,
        'startup' => PTERO_STARTUP,
        'environment' => [
            'SERVER_JARFILE' => PTERO_SERVER_JARFILE,
            'MINECRAFT_VERSION' => 'latest'
        ],
        'limits' => [
            'memory' => $memory,
            'swap' => 0,
            'disk' => $disk,
            'io' => 500,
            'cpu' => $cpu
        ],
        'feature_limits' => [
            'databases' => 1,
            'allocations' => 1,
            'backups' => 1
        ],
        'deployment' => [
            'locations' => [(int)PTERO_NODE_ID],
            'dedicated_ip' => false,
            'port_range' => []
        ],
        'start_on_completion' => false
    ];

    $result = ptero_request('POST', '/servers', $payload);

    if ($result['status'] < 200 || $result['status'] >= 300) {
        $detail = $result['body']['errors'][0]['detail'] ?? 'Pterodactyl menolak permintaan.';
        throw new RuntimeException($detail);
    }

    $attributes = $result['body']['attributes'] ?? [];
    $identifier = $attributes['identifier'] ?? '';
    $pteroId = (int)($attributes['id'] ?? 0);

    $stmt = db()->prepare('INSERT INTO servers (user_id,name,ptero_id,identifier,memory,disk,cpu) VALUES (?,?,?,?,?,?,?)');
    $stmt->execute([$_SESSION['user_id'], $name, $pteroId, $identifier, $memory, $disk, $cpu]);

    $_SESSION['message'] = 'Server berhasil dibuat.';
} catch (Throwable $e) {
    $_SESSION['error'] = $e->getMessage();
}

header('Location: dashboard.php');
