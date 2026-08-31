<?php
require_once __DIR__ . '/bootstrap.php';
verify_csrf();

$name = trim($_POST['name'] ?? '');
$email = strtolower(trim($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
    $_SESSION['error'] = 'Data pendaftaran tidak valid. Password minimal 8 karakter.';
    header('Location: register.php'); exit;
}

try {
    $stmt = db()->prepare('INSERT INTO users (name,email,password) VALUES (?,?,?)');
    $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
    $_SESSION['user_id'] = (int)db()->lastInsertId();
    header('Location: dashboard.php');
} catch (PDOException $e) {
    $_SESSION['error'] = 'Email sudah digunakan atau database belum dikonfigurasi.';
    header('Location: register.php');
}
