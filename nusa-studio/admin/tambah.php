<?php
require dirname(__DIR__) . '/includes/functions.php';
require_admin();
db();
$project = ['judul' => '', 'kategori' => '', 'deskripsi' => '', 'gambar' => 'assets/images/placeholder.svg'];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $project['judul'] = posted_text('judul');
    $project['kategori'] = posted_text('kategori');
    $project['deskripsi'] = posted_text('deskripsi');
    $errors = validate_project($project);
    if (!$errors) {
        $newImage = $project['gambar'];
        try {
            $newImage = upload_image($project['gambar']);
            $query = db()->prepare('INSERT INTO proyek (judul, kategori, deskripsi, gambar) VALUES (?, ?, ?, ?)');
            $query->execute([$project['judul'], $project['kategori'], $project['deskripsi'], $newImage]);
            flash('Proyek berhasil ditambahkan.');
            redirect('admin/index.php');
        } catch (RuntimeException $exception) {
            if ($newImage !== $project['gambar']) {
                delete_uploaded_image($newImage);
            }
            $errors[] = $exception instanceof PDOException
                ? 'Data belum berhasil disimpan. Periksa koneksi database.' : $exception->getMessage();
        }
    }
}
$pageTitle = 'Tambah Proyek';
$submitLabel = 'Simpan proyek';
require ROOT_PATH . '/includes/admin-header.php';
?>
<div class="page-heading"><div><p class="eyebrow">PROYEK BARU</p><h1>Tambah proyek</h1><p class="muted">Isi informasi proyek, lalu simpan untuk menampilkannya pada website.</p></div></div>
<?php require ROOT_PATH . '/includes/project-form.php'; ?>
<?php require ROOT_PATH . '/includes/admin-footer.php'; ?>
