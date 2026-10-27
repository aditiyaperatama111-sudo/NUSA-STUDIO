<?php
require dirname(__DIR__) . '/includes/functions.php';
require_admin();
$projects = db()->query('SELECT * FROM proyek ORDER BY id DESC')->fetchAll();
$pageTitle = 'Daftar Proyek';
require ROOT_PATH . '/includes/admin-header.php';
?>
<div class="page-heading">
    <div>
        <p class="eyebrow">PORTOFOLIO WEBSITE</p>
        <h1>Daftar proyek</h1>
        <p class="muted">Halo, <?= e($_SESSION['admin_username']) ?>. Ada <?= count($projects) ?> proyek pada website.</p>
    </div>
    <a class="button" href="<?= e(url('admin/tambah.php')) ?>">+ Tambah proyek</a>
</div>
<?php if (!$projects): ?>
    <div class="empty-state"><h2>Belum ada proyek</h2><p>Tambahkan proyek pertama melalui tombol di atas.</p></div>
<?php else: ?>
<div class="table-wrap">
    <table>
        <caption class="sr-only">Daftar proyek yang tampil pada halaman utama</caption>
        <thead><tr><th scope="col">Gambar</th><th scope="col">Proyek</th><th scope="col">Kategori</th><th scope="col">Tindakan</th></tr></thead>
        <tbody>
        <?php foreach ($projects as $project): ?>
            <tr>
                <td><img class="table-image" src="<?= e(url(image_path($project['gambar']))) ?>" alt="<?= e($project['judul']) ?>" width="100" height="75"></td>
                <td><strong><?= e($project['judul']) ?></strong><p class="table-description"><?= e($project['deskripsi']) ?></p></td>
                <td><span class="badge"><?= e($project['kategori']) ?></span></td>
                <td><div class="row-actions"><a class="button secondary small" href="<?= e(url('admin/edit.php?id=' . $project['id'])) ?>">Ubah</a><a class="button danger-outline small" href="<?= e(url('admin/hapus.php?id=' . $project['id'])) ?>">Hapus</a></div></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<p class="bottom-note">Perubahan yang kamu simpan langsung muncul pada bagian Proyek di halaman utama.</p>
<?php require ROOT_PATH . '/includes/admin-footer.php'; ?>
