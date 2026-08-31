<?php
require_once __DIR__ . '/bootstrap.php';
require_login();
verify_csrf();

$id = (int)($_POST['server_id'] ?? 0);
$action = $_POST['action'] ?? '';

if (!in_array($action, ['start','stop','restart'], true)) {
    $_SESSION['error'] = 'Aksi tidak valid.';
    header('Location: dashboard.php'); exit;
}

$stmt = db()->prepare('SELECT identifier FROM servers WHERE id=? AND user_id=?');
$stmt->execute([$id, $_SESSION['user_id']]);
$server = $stmt->fetch();

if (!$server || !$server['identifier']) {
    $_SESSION['error'] = 'Server tidak ditemukan.';
    header('Location: dashboard.php'); exit;
}

try {
    // Application API tidak menjalankan power action. Endpoint ini
    // menggunakan Client API sehingga diperlukan client identifier/key.
    // Untuk produksi, simpan client API key per user dan gunakan endpoint
    // /api/client/servers/{identifier}/power.
    throw new RuntimeException('Power action belum diaktifkan pada template ini. Gunakan Client API dengan autentikasi per-user.');
} catch (Throwable $e) {
    $_SESSION['error'] = $e->getMessage();
}
header('Location: dashboard.php');
