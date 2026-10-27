<?php $notice = take_flash(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($pageTitle) ?> | Admin Nusa Studio</title>
    <link rel="icon" href="<?= e(url('assets/images/favicon.svg')) ?>">
    <link rel="stylesheet" href="<?= e(url('assets/css/admin.css')) ?>">
</head>
<body>
    <a class="skip-link" href="#konten-admin">Lewati ke konten</a>
    <header class="admin-header">
        <div class="admin-container header-content">
            <a class="admin-brand" href="<?= e(url('admin/index.php')) ?>">NUSA STUDIO <span>ADMIN</span></a>
            <nav class="admin-nav" aria-label="Navigasi admin">
                <a href="<?= e(url('admin/index.php')) ?>">Daftar proyek</a>
                <a href="<?= e(url('index.php')) ?>">Lihat website</a>
                <form action="<?= e(url('admin/logout.php')) ?>" method="post">
                    <?php csrf_field(); ?>
                    <button class="button secondary small" type="submit">Keluar</button>
                </form>
            </nav>
        </div>
    </header>
    <main class="admin-container admin-main" id="konten-admin" tabindex="-1">
        <?php if ($notice !== ''): ?>
            <div class="notice success" role="status"><?= e($notice) ?></div>
        <?php endif; ?>
