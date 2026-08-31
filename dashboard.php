<?php
require_once __DIR__ . '/bootstrap.php';
require_login();

$stmt = db()->prepare('SELECT name,email FROM users WHERE id=?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

$stmt = db()->prepare('SELECT * FROM servers WHERE user_id=? ORDER BY id DESC');
$stmt->execute([$_SESSION['user_id']]);
$servers = $stmt->fetchAll();

$msg = $_SESSION['message'] ?? null; unset($_SESSION['message']);
$error = $_SESSION['error'] ?? null; unset($_SESSION['error']);
?>
<!doctype html>
<html lang="id"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard - Ptero Web</title><link rel="stylesheet" href="assets/style.css">
</head><body><div class="container">
<header class="top"><div><h1>Dashboard</h1><p class="muted">Halo, <?= e($user['name']) ?></p></div><a class="button secondary" href="logout.php">Logout</a></header>
<?php if ($msg): ?><div class="alert success"><?= e($msg) ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>

<div class="grid">
<div class="card">
<h2>Buat Server</h2>
<form method="post" action="create-server.php">
<input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<label>Nama Server</label><input name="name" maxlength="100" required>
<label>RAM (MB)</label><input type="number" name="memory" value="1024" min="128" max="65536" required>
<label>Disk (MB)</label><input type="number" name="disk" value="10240" min="512" max="1048576" required>
<label>CPU (%)</label><input type="number" name="cpu" value="100" min="10" max="10000" required>
<button>Buat Server</button>
</form>
</div>

<div class="card">
<h2>Server Saya</h2>
<?php if (!$servers): ?><p class="muted">Belum ada server.</p><?php endif; ?>
<?php foreach ($servers as $s): ?>
<div class="server">
<strong><?= e($s['name']) ?></strong>
<div class="muted"><?= e($s['identifier'] ?: 'belum tersedia') ?></div>
<div class="actions">
<?php if ($s['identifier']): ?>
<form method="post" action="server-action.php"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="server_id" value="<?= (int)$s['id'] ?>"><button name="action" value="start">Start</button><button name="action" value="restart">Restart</button><button class="danger" name="action" value="stop">Stop</button></form>
<?php endif; ?>
</div></div>
<?php endforeach; ?>
</div>
</div>
</div></body></html>
