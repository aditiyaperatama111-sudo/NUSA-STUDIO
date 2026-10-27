<?php
require dirname(__DIR__) . '/includes/functions.php';
header('Cache-Control: no-store');
if (!admin_exists()) {
    redirect('admin/setup.php');
}
if (!empty($_SESSION['admin_id'])) {
    redirect('admin/index.php');
}
$error = '';
$username = '';
$notice = take_flash();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $username = posted_text('username');
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    if (time() < (int) ($_SESSION['login_locked_until'] ?? 0)) {
        $error = 'Terlalu banyak percobaan pada sesi ini. Coba lagi setelah satu menit.';
    } else {
        $query = db()->prepare('SELECT id, username, password_hash FROM admins WHERE username = ?');
        $query->execute([$username]);
        $admin = $query->fetch();
        if ($admin && password_verify($password, $admin['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = (int) $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['last_active'] = time();
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            unset($_SESSION['login_attempts'], $_SESSION['login_locked_until']);
            redirect('admin/index.php');
        }
        $_SESSION['login_attempts'] = (int) ($_SESSION['login_attempts'] ?? 0) + 1;
        if ($_SESSION['login_attempts'] >= 5) {
            $_SESSION['login_locked_until'] = time() + 60;
            $_SESSION['login_attempts'] = 0;
        }
        $error = 'Username atau password belum benar.';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Login Admin | Nusa Studio</title>
    <link rel="stylesheet" href="<?= e(url('assets/css/admin.css')) ?>">
</head>
<body class="auth-page">
<main class="auth-card">
    <a class="admin-brand" href="<?= e(url('index.php')) ?>">NUSA STUDIO</a>
    <p class="eyebrow">PENGELOLAAN WEBSITE</p>
    <h1>Login admin</h1>
    <p class="muted">Kelola contoh proyek yang muncul pada website.</p>
    <?php if ($notice !== ''): ?><div class="notice success" role="status"><?= e($notice) ?></div><?php endif; ?>
    <?php if ($error !== ''): ?><div class="notice error" role="alert"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="auth-form">
        <?php csrf_field(); ?>
        <label for="username">Username</label>
        <input id="username" name="username" value="<?= e($username) ?>" maxlength="40" required autocomplete="username">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required autocomplete="current-password">
        <button class="button full-width" type="submit">Masuk</button>
    </form>
    <a class="plain-link" href="<?= e(url('index.php')) ?>">Kembali ke website</a>
</main>
</body>
</html>
