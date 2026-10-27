<?php
declare(strict_types=1);

// Fungsi bersama agar halaman PHP tidak mengulang kode yang sama.
define('ROOT_PATH', dirname(__DIR__));
date_default_timezone_set('Asia/Jakarta');

function url(string $path = ''): string
{
    $folder = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
    if (basename($folder) === 'admin') {
        $folder = dirname($folder);
    }
    $folder = ($folder === '/' || $folder === '.') ? '' : rtrim($folder, '/');
    return $folder . '/' . ltrim($path, '/');
}

// Cookie sesi tidak dapat dibaca JavaScript. HTTPS otomatis memakai cookie secure.
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    session_name('nusa_studio_session');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => url(),
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}
header('Content-Type: text/html; charset=UTF-8');
header('X-Content-Type-Options: nosniff');

// Escape teks sebelum menaruhnya pada HTML untuk mencegah eksekusi script.
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . url($path), true, 303);
    exit;
}

function show_error(int $status, string $title, string $message): void
{
    http_response_code($status);
    require ROOT_PATH . '/includes/error-page.php';
    exit;
}

function db(): PDO
{
    static $connection = null;
    if ($connection instanceof PDO) {
        return $connection;
    }
    if (!extension_loaded('pdo_mysql')) {
        show_error(503, 'Ekstensi database belum aktif',
            'Aktifkan pdo_mysql pada PHP. Jika memakai XAMPP, jalankan Apache dan MySQL, lalu buka website melalui localhost.');
    }
    $config = require ROOT_PATH . '/config/database.php';
    $dsn = 'mysql:host=' . $config['host'] . ';port=' . $config['port']
        . ';dbname=' . $config['database'] . ';charset=utf8mb4';
    try {
        $connection = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        // Pastikan kedua tabel sudah tersedia setelah proses impor.
        $connection->query('SELECT id FROM admins LIMIT 1');
        $connection->query('SELECT id FROM proyek LIMIT 1');
    } catch (PDOException $exception) {
        error_log('Nusa Studio: koneksi atau tabel database belum siap.');
        show_error(503, 'Database belum siap',
            'Jalankan MySQL di XAMPP, impor database/nusa_studio.sql melalui phpMyAdmin, lalu periksa config/database.php. Setelah itu, muat ulang halaman ini.');
    }
    return $connection;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): void
{
    echo '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function check_csrf(): void
{
    $token = $_POST['csrf_token'] ?? null;
    if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
        show_error(403, 'Permintaan tidak valid',
            'Muat ulang formulir dan coba lagi. Jika mengunggah gambar, pastikan ukurannya tidak lebih dari 2 MB.');
    }
}

function require_admin(): void
{
    header('Cache-Control: no-store');
    if (empty($_SESSION['admin_id'])) {
        redirect('admin/login.php');
    }
    // Sesi admin berakhir setelah satu jam tanpa aktivitas.
    if (isset($_SESSION['last_active']) && time() - $_SESSION['last_active'] > 3600) {
        unset($_SESSION['admin_id'], $_SESSION['admin_username']);
        redirect('admin/login.php');
    }
    $_SESSION['last_active'] = time();
}

function flash(string $message): void
{
    $_SESSION['flash'] = $message;
}

function take_flash(): string
{
    $message = (string) ($_SESSION['flash'] ?? '');
    unset($_SESSION['flash']);
    return $message;
}

function admin_exists(): bool
{
    return (int) db()->query('SELECT COUNT(*) FROM admins')->fetchColumn() > 0;
}

function get_project(int $id): array
{
    $query = db()->prepare('SELECT * FROM proyek WHERE id = ?');
    $query->execute([$id]);
    $project = $query->fetch();
    if (!$project) {
        show_error(404, 'Proyek tidak ditemukan', 'Data proyek ini tidak tersedia. Kembali ke daftar proyek untuk memilih data yang lain.');
    }
    return $project;
}

function project_id(): int
{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1],
    ]);
    if (!$id) {
        show_error(404, 'Alamat proyek tidak valid', 'Pilih proyek melalui halaman daftar proyek.');
    }
    return $id;
}

function categories(): array
{
    return ['Desain Website', 'Identitas Brand', 'Konten Digital'];
}

function posted_text(string $key): string
{
    $value = $_POST[$key] ?? '';
    return is_string($value) ? trim($value) : '';
}

function validate_project(array $project): array
{
    $errors = [];
    $titleLength = preg_match_all('/./us', $project['judul']);
    $descriptionLength = preg_match_all('/./us', $project['deskripsi']);
    if (!$titleLength || $titleLength > 120) {
        $errors[] = 'Isi judul proyek dengan 1 sampai 120 karakter.';
    }
    if (!in_array($project['kategori'], categories(), true)) {
        $errors[] = 'Pilih salah satu kategori yang tersedia.';
    }
    if (!$descriptionLength || $descriptionLength > 2000) {
        $errors[] = 'Isi deskripsi dengan 1 sampai 2.000 karakter.';
    }
    return $errors;
}

// Database hanya menyimpan lokasi gambar; berkasnya berada di folder assets/uploads.
function image_path(string $path): string
{
    if (preg_match('~^(assets/images/|uploads/proyek/)[a-zA-Z0-9_-]+\.(webp|png|jpg|jpeg|svg)$~D', $path)
        && is_file(ROOT_PATH . '/' . $path)) {
        return $path;
    }
    return 'assets/images/placeholder.svg';
}

function upload_image(string $previous): string
{
    $file = $_FILES['gambar'] ?? null;
    if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $previous;
    }
    if (!is_array($file) || !isset($file['error'], $file['tmp_name'], $file['size'])
        || is_array($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Unggahan gagal. Pilih gambar JPG, PNG, atau WebP maksimal 2 MB.');
    }
    if (!is_int($file['size']) || $file['size'] > 2 * 1024 * 1024 || $file['size'] <= 0) {
        throw new RuntimeException('Ukuran gambar harus lebih dari 0 dan maksimal 2 MB.');
    }
    $info = @getimagesize($file['tmp_name']);
    $extensions = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    if (!$info || !isset($extensions[$info['mime'] ?? '']) || $info[0] * $info[1] > 24000000) {
        throw new RuntimeException('Pilih gambar JPG, PNG, atau WebP dengan resolusi maksimal 24 megapiksel.');
    }
    $directory = ROOT_PATH . '/uploads/proyek';
    if (!is_dir($directory) || !is_writable($directory)) {
        throw new RuntimeException('Folder uploads/proyek belum tersedia atau belum memiliki izin tulis.');
    }
    $filename = bin2hex(random_bytes(16)) . '.' . $extensions[$info['mime']];
    $relativePath = 'uploads/proyek/' . $filename;
    if (!move_uploaded_file($file['tmp_name'], ROOT_PATH . '/' . $relativePath)) {
        throw new RuntimeException('Server tidak berhasil menyimpan gambar. Periksa izin folder uploads/proyek.');
    }
    return $relativePath;
}

function delete_uploaded_image(string $path): void
{
    // Hanya gambar unggahan dengan nama acak yang boleh dihapus.
    if (preg_match('~^uploads/proyek/[a-f0-9]{32}\.(jpg|png|webp)$~D', $path)) {
        $absolutePath = ROOT_PATH . '/' . $path;
        if (is_file($absolutePath) && !is_link($absolutePath)) {
            unlink($absolutePath);
        }
    }
}
