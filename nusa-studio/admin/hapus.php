<?php
require dirname(__DIR__) . '/includes/functions.php';
require_admin();
$id = project_id();
$project = get_project($id);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    try {
        $query = db()->prepare('DELETE FROM proyek WHERE id = ?');
        $query->execute([$id]);
        delete_uploaded_image($project['gambar']);
        flash('Proyek berhasil dihapus.');
        redirect('admin/index.php');
    } catch (PDOException $exception) {
        show_error(500, 'Proyek belum berhasil dihapus', 'Kembali ke daftar proyek dan coba lagi.');
    }
}
$pageTitle = 'Hapus Proyek';
require ROOT_PATH . '/includes/admin-header.php';
?>
<div class="page-heading"><div><p class="eyebrow">KONFIRMASI</p><h1>Hapus proyek</h1></div></div>
<div class="form-panel">
    <h2><?= e($project['judul']) ?></h2>
    <p class="muted">Tindakan ini menghapus proyek dari database dan halaman utama. Gambar unggahan proyek ini juga akan terhapus. Gambar contoh bawaan tetap tersedia.</p>
    <form method="post" class="form-actions">
        <?php csrf_field(); ?>
        <button class="button danger" type="submit">Ya, hapus proyek</button>
        <a class="button secondary" href="<?= e(url('admin/index.php')) ?>">Batal</a>
    </form>
</div>
<?php require ROOT_PATH . '/includes/admin-footer.php'; ?>
