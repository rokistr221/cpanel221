<?php
require_once __DIR__ . '/bootstrap.php';
if (!empty($_SESSION['user_id'])) { header('Location: dashboard.php'); exit; }
$error = $_SESSION['error'] ?? null; unset($_SESSION['error']);
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Register - Ptero Web</title><link rel="stylesheet" href="assets/style.css">
</head>
<body><div class="container small"><div class="card">
<h1>Daftar</h1>
<?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
<form method="post" action="register-action.php">
<input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
<label>Nama</label><input name="name" maxlength="100" required>
<label>Email</label><input type="email" name="email" maxlength="190" required>
<label>Password</label><input type="password" name="password" minlength="8" required>
<button>Daftar</button>
</form>
<p class="center"><a href="index.php">Kembali ke login</a></p>
</div></div></body></html>
