<?php
// 1. Pakai fungsi koneksi database dan bantuan yang sama dengan index.php.
require __DIR__ . '/includes/functions.php';

// 2. Baca dan periksa ID dari URL. Contoh: detail-proyek.php?id=1.
$id = project_id();

// 3. Cari satu proyek berdasarkan ID. Fungsi ini ada di includes/functions.php.
// Jika proyek tidak ada, fungsi tersebut menampilkan halaman 404.
$project = get_project($id);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#1d4ed8">
  <title><?= e($project['judul']) ?> | Nusa Studio</title>
  <link rel="icon" href="<?= e(url('assets/images/favicon.svg')) ?>" type="image/svg+xml">
  <link rel="stylesheet" href="<?= e(url('assets/css/style.css')) ?>">
  <link rel="stylesheet" href="<?= e(url('assets/css/proyek.css')) ?>">
</head>
<body class="detail-page">
  <a class="skip-link" href="#detail-utama">Lewati ke konten utama</a>
  <header class="site-header detail-header">
    <div class="container header-inner">
      <a class="brand" href="<?= e(url('index.php')) ?>" aria-label="Nusa Studio, kembali ke beranda">
        <span class="brand-mark" aria-hidden="true"><span></span><span></span><span></span><span></span></span>
        <span class="brand-name">NUSA<span>STUDIO</span></span>
      </a>
      <a class="detail-header-back" href="<?= e(url('index.php#proyek')) ?>">
        <span aria-hidden="true">&larr;</span> Kembali
      </a>
    </div>
  </header>

  <main class="container detail-main" id="detail-utama" tabindex="-1">
    <nav class="detail-breadcrumb" aria-label="Jejak navigasi">
      <a href="<?= e(url('index.php')) ?>">Beranda</a>
      <span aria-hidden="true">/</span>
      <a href="<?= e(url('index.php#proyek')) ?>">Proyek</a>
      <span aria-hidden="true">/</span>
      <span aria-current="page">Detail proyek</span>
    </nav>

    <!-- 4. Tampilkan data proyek pada HTML. e() menjaga teks agar aman. -->
    <div class="detail-heading">
      <p class="detail-category"><?= e($project['kategori']) ?></p>
      <h1><?= e($project['judul']) ?></h1>
    </div>

    <div class="detail-grid">
      <figure class="detail-image-wrap">
        <img class="detail-image"
             src="<?= e(url(image_path($project['gambar']))) ?>"
             alt="<?= e('Gambar proyek ' . $project['judul']) ?>"
             width="1448" height="1086" decoding="async">
      </figure>
      <section class="detail-description" aria-labelledby="judul-deskripsi">
        <p class="detail-label">TENTANG PROYEK</p>
        <h2 id="judul-deskripsi">Deskripsi proyek</h2>
        <p class="detail-text"><?= nl2br(e($project['deskripsi'])) ?></p>
        <a class="button detail-return" href="<?= e(url('index.php#proyek')) ?>">
          <span aria-hidden="true">&larr;</span> Kembali ke semua proyek
        </a>
      </section>
    </div>
  </main>

  <footer class="detail-footer">
    <div class="container">
      <p>&copy; <?= date('Y') ?> Nusa Studio. </p>
    </div>
  </footer>
</body>
</html>
