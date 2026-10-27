<?php
// Halaman publik membaca daftar proyek dari database MySQL.
require __DIR__ . '/includes/functions.php';
$projects = db()->query('SELECT * FROM proyek ORDER BY id ASC')->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#1d4ed8">
  <meta name="description" content="Kenali Nusa Studio, studio kreatif dengan layanan desain website, identitas brand, dan konten digital. Jelajahi layanan dan contoh karya kami.">
  <title>Nusa Studio | Desain dan Solusi Digital</title>
  <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
  <link rel="preload" as="image" href="assets/images/jihyo.jpg">
  <script>document.documentElement.classList.add('js');</script>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/proyek.css">
  <script src="assets/js/script.js" defer></script>
  <link rel="stylesheet" href="assets/css/slider.css">
  <script src="assets/js/slider.js" defer></script>
</head>
<body>
  <a class="skip-link" href="#utama">Lewati ke konten utama</a>
  <header class="site-header">
    <div class="container header-inner">
      <a class="brand" href="#beranda" aria-label="Nusa Studio, kembali ke beranda">
        <span class="brand-mark" aria-hidden="true"><span></span><span></span><span></span><span></span></span>
        <span class="brand-name">NUSA<span>STUDIO</span></span>
      </a>
      <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="navigasi" aria-label="Buka menu navigasi">
        <span class="menu-lines" aria-hidden="true"><span></span><span></span></span>
        <span class="menu-text">Menu</span>
      </button>
      <nav class="site-nav" id="navigasi" aria-label="Navigasi utama" data-open="false">
        <a class="nav-link is-active" href="#beranda" aria-current="location">Beranda</a>
        <a class="nav-link" href="#tentang">Tentang</a>
        <a class="nav-link" href="#layanan">Layanan</a>
        <a class="nav-link" href="#proyek">Proyek</a>
        <a class="button button-small" href="#kontak">Hubungi Kami <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
      </nav>
    </div>
  </header>

  <main id="utama" tabindex="-1">
    <section class="hero" id="beranda" aria-labelledby="judul-utama" tabindex="-1">
      <div class="container hero-grid">
        <div class="hero-copy">
          <p class="eyebrow hero-eyebrow"><span class="status-dot" aria-hidden="true"></span> STUDIO KREATIF INDONESIA</p>
          <h1 id="judul-utama">Solusi kreatif<br>untuk bisnis <span>Anda.</span></h1>
          <p class="hero-description">Kami membantu bisnis tampil lebih jelas melalui desain dan solusi digital.</p>
          <div class="hero-actions">
            <a class="button" href="#layanan">Lihat Layanan <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
            <a class="text-link" href="#tentang">Tentang Kami <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
          </div>

        </div>
       <figure class="hero-visual">
  <div class="hero-slider"
       role="region"
       aria-label="Galeri gambar beranda"
       tabindex="0">

    <div class="hero-slider-track">
      <img class="hero-slide"
           src="assets/images/jihyo.jpg"
           alt="Foto pertama">

      <img class="hero-slide"
           src="assets/images/jihyo1.jpg"
           alt="Foto kedua">

      <img class="hero-slide"
           src="assets/images/jihyo2.jpg"
           alt="Foto ketiga">

      <img class="hero-slide"
           src="assets/images/jihyo3.jpg"
           alt="Foto keempat">

      <img class="hero-slide"
           src="assets/images/jihyo4.jpg"
           alt="Foto kelima">
    </div>

    <div class="hero-slider-controls">
      <button type="button"
              data-slide-prev
              aria-label="Gambar sebelumnya">←</button>

      <span class="hero-slider-count">1 / 5</span>

      <button type="button"
              data-slide-play
              aria-label="Jeda slideshow"
              aria-pressed="false">Jeda</button>

      <button type="button"
              data-slide-next
              aria-label="Gambar berikutnya">→</button>
    </div>
  </div>
</figure>
        </figure>
      </div>
    </section>

    <section class="about section" id="tentang" aria-labelledby="judul-tentang" tabindex="-1">
      <div class="container about-grid">
        <div>
          <p class="eyebrow">TENTANG KAMI</p>
          <h2 id="judul-tentang">Kenali<br> Nusa Studio<span class="blue-text">.</span></h2>
        </div>
        <div class="about-copy">
          <p class="intro-text">Setiap bisnis punya cerita.<br>Kami membantu Anda menyampaikannya.</p>
          <p>Nusa Studio membantu pelaku usaha membangun identitas melalui desain website, identitas brand, dan konten digital. Kami mengutamakan tampilan yang rapi, informasi yang jelas, serta desain yang sesuai dengan kebutuhan bisnis.</p>
          <a class="text-link" href="#layanan">Kenali layanan kami <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
        </div>
      </div>
    </section>

    <section class="services section" id="layanan" aria-labelledby="judul-layanan" tabindex="-1">
      <div class="container">
        <div class="section-heading">
          <div><p class="eyebrow">LAYANAN KAMI</p><h2 id="judul-layanan">Dukungan kreatif<br>untuk bisnis Anda<span class="blue-text">.</span></h2></div>
          <p class="section-description">Dari tampilan website hingga identitas visual, temukan layanan yang sesuai dengan kebutuhan Anda.</p>
        </div>
        <div class="service-grid">
          <article class="service-card">
            <div class="service-top"><span class="service-icon"><svg viewBox="0 0 32 32" aria-hidden="true"><rect x="4" y="5" width="24" height="17" rx="2"/><path d="M11 28h10m-5-6v6M4 17h24"/></svg></span><span class="service-number" aria-hidden="true">01</span></div>
            <h3>Desain Website</h3>
            <p>Membuat website yang menampilkan informasi bisnis secara jelas dan mudah pengunjung akses melalui berbagai perangkat.</p>

          </article>
          <article class="service-card">
            <div class="service-top"><span class="service-icon"><svg viewBox="0 0 32 32" aria-hidden="true"><path d="m6 21 14-14a3.5 3.5 0 0 1 5 5L11 26l-7 2 2-7Z"/><path d="m17 10 5 5M6 21l5 5"/></svg></span><span class="service-number" aria-hidden="true">02</span></div>
            <h3>Identitas Brand</h3>
            <p>Mengembangkan logo, warna, dan elemen visual yang membantu bisnis menjaga konsistensi tampilannya.</p>

          </article>
          <article class="service-card">
            <div class="service-top"><span class="service-icon"><svg viewBox="0 0 32 32" aria-hidden="true"><rect x="4" y="5" width="24" height="22" rx="2"/><circle cx="11" cy="12" r="2"/><path d="m5 24 8-8 5 5 4-4 6 6"/></svg></span><span class="service-number" aria-hidden="true">03</span></div>
            <h3>Konten Digital</h3>
            <p>Membuat materi visual untuk mendukung komunikasi bisnis melalui media sosial dan kanal digital.</p>

          </article>
        </div>
      </div>
    </section>

    <section class="projects section" id="proyek" aria-labelledby="judul-proyek" tabindex="-1">
      <div class="container">
        <div class="section-heading project-heading">
          <div><p class="eyebrow">PORTOFOLIO</p><h2 id="judul-proyek">Beberapa Proyek Kami<span class="blue-text">.</span></h2></div>
          <p class="demo-label"><span aria-hidden="true"></span> CONTOH PROYEK</p>
        </div>
        <p class="project-intro">Eksplorasi desain untuk beragam kebutuhan bisnis. Seluruh karya berikut merupakan konsep demonstrasi.</p>
        <?php if (!$projects): ?>
        <p class="project-empty">Belum ada proyek. Contoh karya akan muncul di bagian ini setelah admin menambahkan data.</p>
        <?php else: ?>
        <div class="project-grid">
          <?php foreach ($projects as $project): ?>
          <?php // ID pada tautan menentukan proyek yang dibuka di halaman detail. ?>
          <a class="project-card project-card-link"
             href="<?= e(url('detail-proyek.php?id=' . $project['id'])) ?>"
             aria-label="<?= e('Lihat detail proyek ' . $project['judul']) ?>">
            <div class="project-image-wrap">
              <img src="<?= e(url(image_path($project['gambar']))) ?>"
                   alt="<?= e('Gambar proyek ' . $project['judul']) ?>"
                   width="1448" height="1086" loading="lazy" decoding="async">
            </div>
            <div class="project-meta">
              <p class="project-category"><?= e($project['kategori']) ?></p>
              <span class="project-tag">Konsep</span>
            </div>
            <h3><?= e($project['judul']) ?></h3>
            <p><?= e($project['deskripsi']) ?></p>
            <span class="project-card-action">Lihat detail proyek <span aria-hidden="true">&rarr;</span></span>
          </a>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
    </section>

    <section class="contact section" id="kontak" aria-labelledby="judul-kontak" tabindex="-1">
      <div class="container">
        <div class="contact-panel">
          <div class="contact-copy"><p class="eyebrow">MARI BICARA</p><h2 id="judul-kontak">Mari mulai<br>proyek Anda<span>.</span></h2><p>Ceritakan kebutuhan bisnis Anda kepada kami.</p></div>
          <div class="contact-details"><span class="contact-icon" aria-hidden="true"><svg viewBox="0 0 32 32"><rect x="4" y="7" width="24" height="18" rx="3"/><path d="m5 9 11 9L27 9"/></svg></span><h3>Ruang untuk ide berikutnya.</h3><p>Informasi kontak akan hadir di sini.</p><p class="contact-status"><span aria-hidden="true"></span>Kontak segera tersedia</p></div>
          <span class="contact-decoration" aria-hidden="true"></span>
        </div>
      </div>
    </section>
  </main>

  <footer class="site-footer">
    <div class="container">
      <div class="footer-top"><div><a class="brand" href="#beranda" aria-label="Nusa Studio, kembali ke beranda"><span class="brand-mark" aria-hidden="true"><span></span><span></span><span></span><span></span></span><span class="brand-name">NUSA<span>STUDIO</span></span></a><p>Desain dan solusi digital untuk bisnis Anda.</p></div><nav class="footer-nav" aria-label="Navigasi footer"><a href="#beranda">Beranda</a><a href="#tentang">Tentang</a><a href="#layanan">Layanan</a><a href="#proyek">Proyek</a><a href="#kontak">Kontak</a><a href="admin/login.php">Admin</a></nav></div>
      <div class="footer-bottom"><p>© <span id="tahun"><?= date('Y') ?></span> Nusa Studio. Semua hak cipta.</p></p><a class="back-top" href="#beranda">Kembali ke atas <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 19V5m-6 6 6-6 6 6"/></svg></a></div>
    </div>
  </footer>
</body>
</html>
