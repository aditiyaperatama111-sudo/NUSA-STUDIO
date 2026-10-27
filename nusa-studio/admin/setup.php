<?php
require dirname(__DIR__) . '/includes/functions.php';
header('Cache-Control: no-store');

if (admin_exists()) {
    redirect('admin/login.php');
}
// Pembuatan akun pertama hanya melalui komputer yang menjalankan server.
if (!in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true)) {
    show_error(403, 'Buat akun melalui localhost',
        'Buka halaman ini melalui localhost pada komputer Windows yang menjalankan XAMPP.');
}
$errors = [];
$username = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $username = posted_text('username');
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    $confirmation = is_string($_POST['konfirmasi'] ?? null) ? $_POST['konfirmasi'] : '';
    if (!preg_match('/^[a-zA-Z0-9_.-]{3,40}$/D', $username)) {
        $errors[] = 'Username memakai 3 sampai 40 huruf, angka, titik, garis bawah, atau tanda hubung.';
    }
    if (strlen($password) < 10 || strlen($password) > 72) {
        $errors[] = 'Password memakai minimal 10 dan maksimal 72 byte. Gunakan kalimat sandi yang mudah kamu ingat.';
    }
    if ($password !== $confirmation) {
        $errors[] = 'Konfirmasi password belum sama.';
    }
    if (!$errors) {
        try {
            // ID pertama tetap 1 supaya dua permintaan setup tidak membuat dua admin.
            $query = db()->prepare('INSERT INTO admins (id, username, password_hash) VALUES (1, ?, ?)');
            $query->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
            flash('Akun admin berhasil dibuat. Silakan login.');
            redirect('admin/login.php');
        } catch (PDOException $exception) {
            if (admin_exists()) {
                redirect('admin/login.php');
            }
            $errors[] = 'Akun belum berhasil dibuat. Periksa tabel admins pada database.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Buat Akun Admin | Nusa Studio</title>
    <link rel="stylesheet" href="<?= e(url('assets/css/admin.css')) ?>">
</head>
<body class="auth-page">
<main class="auth-card">
    <a class="admin-brand" href="<?= e(url('index.php')) ?>">NUSA STUDIO</a>
    <p class="eyebrow">PENGATURAN PERTAMA</p>
    <h1>Buat akun admin</h1>
    <p class="muted">Buat satu akun untuk mengelola proyek. Setelah akun tersedia, halaman ini mengarah ke login.</p>
    <?php if ($errors): ?>
        <div class="notice error" role="alert"><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form method="post" class="auth-form">
        <?php csrf_field(); ?>
        <label for="username">Username</label>
        <input id="username" name="username" value="<?= e($username) ?>" required minlength="3" maxlength="40" autocomplete="username">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required minlength="10" autocomplete="new-password">
        <p class="field-help">Minimal 10 karakter. Jangan memakai password akun lain.</p>
        <label for="konfirmasi">Konfirmasi password</label>
        <input id="konfirmasi" name="konfirmasi" type="password" required minlength="10" autocomplete="new-password">
        <button class="button full-width" type="submit">Buat akun admin</button>
    </form>
    <a class="plain-link" href="<?= e(url('index.php')) ?>">Kembali ke website</a>
</main>
</body>
</html>
