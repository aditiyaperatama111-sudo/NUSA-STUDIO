<?php
require dirname(__DIR__) . '/includes/functions.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    show_error(405, 'Gunakan tombol Keluar', 'Kembali ke halaman admin lalu tekan tombol Keluar.');
}
check_csrf();
$_SESSION = [];
$cookie = session_get_cookie_params();
setcookie(session_name(), '', [
    'expires' => time() - 3600,
    'path' => $cookie['path'],
    'secure' => $cookie['secure'],
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_destroy();
redirect('admin/login.php');
