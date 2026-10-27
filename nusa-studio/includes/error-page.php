<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?> | Nusa Studio</title>
    <link rel="stylesheet" href="<?= e(url('assets/css/admin.css')) ?>">
</head>
<body class="auth-page">
    <main class="auth-card">
        <a class="admin-brand" href="<?= e(url('index.php')) ?>">NUSA STUDIO</a>
        <p class="eyebrow">INFORMASI WEBSITE</p>
        <h1><?= e($title) ?></h1>
        <p class="muted"><?= e($message) ?></p>
        <div class="form-actions">
            <a class="button" href="<?= e(url('index.php')) ?>">Buka beranda</a>            
        </div>
    </main>
</body>
</html>
