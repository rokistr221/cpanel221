<?php
require_once __DIR__ . '/bootstrap.php';
verify_csrf();
$email = strtolower(trim($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';

$stmt = db()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['error'] = 'Email atau password salah.';
    header('Location: index.php'); exit;
}
session_regenerate_id(true);
$_SESSION['user_id'] = (int)$user['id'];
header('Location: dashboard.php');
