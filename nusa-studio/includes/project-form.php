<?php if ($errors): ?>
    <div class="notice error" role="alert">
        <p><strong>Periksa kembali formulir.</strong></p>
        <ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul>
    </div>
<?php endif; ?>
<form class="form-panel" method="post" enctype="multipart/form-data">
    <?php csrf_field(); ?>
    <label for="judul">Judul proyek</label>
    <input id="judul" name="judul" type="text" value="<?= e($project['judul']) ?>" maxlength="120" required>

    <label for="kategori">Kategori</label>
    <select id="kategori" name="kategori" required>
        <option value="">Pilih kategori</option>
        <?php foreach (categories() as $category): ?>
            <option value="<?= e($category) ?>" <?= $project['kategori'] === $category ? 'selected' : '' ?>><?= e($category) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="deskripsi">Deskripsi</label>
    <textarea id="deskripsi" name="deskripsi" rows="5" maxlength="2000" required><?= e($project['deskripsi']) ?></textarea>
    <p class="field-help">Jelaskan proyek dalam maksimal 2.000 karakter.</p>

    <label for="gambar">Gambar proyek <span class="muted">opsional</span></label>
    <input id="gambar" name="gambar" type="file" accept="image/jpeg,image/png,image/webp" aria-describedby="gambar-bantuan">
    <p class="field-help" id="gambar-bantuan">JPG, PNG, atau WebP maksimal 2 MB. Kosongkan untuk mempertahankan gambar saat ini.</p>
    <img class="image-preview" src="<?= e(url(image_path($project['gambar']))) ?>" alt="Gambar proyek saat ini" width="320" height="240">

    <div class="form-actions">
        <button class="button" type="submit"><?= e($submitLabel) ?></button>
        <a class="button secondary" href="<?= e(url('admin/index.php')) ?>">Batal</a>
    </div>
</form>
