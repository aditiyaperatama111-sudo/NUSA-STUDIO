<?php
require dirname(__DIR__) . '/includes/functions.php';
require_admin();
$id = project_id();
$project = get_project($id);
$oldImage = $project['gambar'];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $project['judul'] = posted_text('judul');
    $project['kategori'] = posted_text('kategori');
    $project['deskripsi'] = posted_text('deskripsi');
    $errors = validate_project($project);
    if (!$errors) {
        $newImage = $oldImage;
        try {
            $newImage = upload_image($oldImage);
            $query = db()->prepare('UPDATE proyek SET judul = ?, kategori = ?, deskripsi = ?, gambar = ? WHERE id = ?');
            $query->execute([$project['judul'], $project['kategori'], $project['deskripsi'], $newImage, $id]);
            if ($newImage !== $oldImage) {
                delete_uploaded_image($oldImage);
            }
            flash('Perubahan proyek berhasil disimpan.');
            redirect('admin/index.php');
        } catch (RuntimeException $exception) {
            if ($newImage !== $oldImage) {
                delete_uploaded_image($newImage);
            }
            $errors[] = $exception instanceof PDOException
                ? 'Perubahan belum berhasil disimpan. Periksa koneksi database.' : $exception->getMessage();
        }
    }
}
$pageTitle = 'Ubah Proyek';
$submitLabel = 'Simpan perubahan';
require ROOT_PATH . '/includes/admin-header.php';
?>
<div class="page-heading"><div><p class="eyebrow">PERBARUI PORTOFOLIO</p><h1>Ubah proyek</h1><p class="muted">Ubah informasi atau pilih gambar baru. Kosongkan unggahan untuk menjaga gambar saat ini.</p></div></div>
<?php require ROOT_PATH . '/includes/project-form.php'; ?>
<?php require ROOT_PATH . '/includes/admin-footer.php'; ?>
