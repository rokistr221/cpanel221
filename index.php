<?php
require_once __DIR__ . '/bootstrap.php';
if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Ptero Web</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container small">
    <div class="card">
        <h1>Ptero Web</h1>
        <p class="muted">Login untuk mengelola server.</p>
        <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
        <form method="post" action="login.php">
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <label>Email</label>
            <input type="email" name="email" required autocomplete="email">
            <label>Password</label>
            <input type="password" name="password" required autocomplete="current-password">
            <button>Login</button>
        </form>
        <p class="center"><a href="register.php">Buat akun</a></p>
    </div>
</div>
</body>
</html>
