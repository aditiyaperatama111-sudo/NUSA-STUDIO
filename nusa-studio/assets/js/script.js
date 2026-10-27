'use strict';

const nav = document.getElementById('navigasi');
const menuToggle = document.querySelector('.menu-toggle');
const compactScreen = window.matchMedia('(max-width: 1023px)');
const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

function setMenu(open, restoreFocus = false) {
  const isOpen = Boolean(open && compactScreen.matches);
  nav.dataset.open = String(isOpen);
  nav.inert = compactScreen.matches && !isOpen;
  menuToggle.setAttribute('aria-expanded', String(isOpen));
  menuToggle.setAttribute('aria-label', isOpen ? 'Tutup menu navigasi' : 'Buka menu navigasi');
  if (restoreFocus) menuToggle.focus();
}

menuToggle.addEventListener('click', () => {
  setMenu(menuToggle.getAttribute('aria-expanded') !== 'true');
});

document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape' && nav.dataset.open === 'true') setMenu(false, true);
});

document.addEventListener('click', (event) => {
  if (!event.target.closest('.site-header') && nav.dataset.open === 'true') setMenu(false);
});

nav.addEventListener('focusout', (event) => {
  if (nav.dataset.open === 'true' && event.relatedTarget &&
      !nav.contains(event.relatedTarget) && !menuToggle.contains(event.relatedTarget)) {
    setMenu(false);
  }
});

compactScreen.addEventListener('change', () => setMenu(false));
setMenu(false);

document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener('click', (event) => {
    const href = anchor.getAttribute('href');
    if (!href || href === '#') return;
    const target = document.getElementById(href.slice(1));
    if (!target) return;
    event.preventDefault();
    setMenu(false);
    target.scrollIntoView({behavior: reducedMotion.matches ? 'auto' : 'smooth', block: 'start'});
    target.focus({preventScroll: true});
    try { window.history.replaceState(null, '', href); } catch (_) { /* File preview still supports scrolling. */ }
  });
});

const navLinks = [...document.querySelectorAll('.nav-link')];
const trackedSections = ['beranda', 'tentang', 'layanan', 'proyek', 'kontak']
  .map((id) => document.getElementById(id));
let scrollScheduled = false;

function updateNavigation() {
  let current = 'beranda';
  const headerHeight = document.querySelector('.site-header').offsetHeight;
  const threshold = Math.max(headerHeight + 35, window.innerHeight * 0.28);
  trackedSections.forEach((section) => {
    if (section.getBoundingClientRect().top <= threshold) current = section.id;
  });
  navLinks.forEach((link) => {
    const selected = link.hash === '#' + current;
    link.classList.toggle('is-active', selected);
    if (selected) link.setAttribute('aria-current', 'location');
    else link.removeAttribute('aria-current');
  });
  scrollScheduled = false;
}

window.addEventListener('scroll', () => {
  if (!scrollScheduled) {
    scrollScheduled = true;
    window.requestAnimationFrame(updateNavigation);
  }
}, {passive: true});
window.addEventListener('resize', updateNavigation);
updateNavigation();
document.getElementById('tahun').textContent = String(new Date().getFullYear());

/* Proyek bergerak terus ke kanan dan berulang */
(() => {
    const grid = document.querySelector('.project-grid');
    if (!grid || !grid.children.length) return;

    const wrapper = document.createElement('div');
    wrapper.className = 'project-slider';
    grid.before(wrapper);
    wrapper.append(grid);

    const asli = [...grid.children];
    let panjang = 0;
    let x = 0;          // posisi geser, boleh pecahan
    let jeda = false;   // true = berhenti sementara
    let geser = null;   // data gerakan saat panah ditekan
    const durasiPanah = 900; // ms, makin besar makin pelan

    // Salinan kartu membuat gerakan menyambung
    function salinKartu() {
        asli.forEach(kartu => {
            const salinan = kartu.cloneNode(true);
            salinan.setAttribute('aria-hidden', 'true');
            salinan.setAttribute('tabindex', '-1');
            grid.append(salinan);
        });
    }

    salinKartu();

    function ukur() {
        const pertama = grid.children[0].getBoundingClientRect();
        const salinan = grid.children[asli.length].getBoundingClientRect();

        panjang = salinan.left - pertama.left;

        if (panjang <= 0) return;

        // Pastikan cukup kartu untuk memenuhi layar
        while (grid.scrollWidth < panjang + grid.clientWidth + 2) {
            salinKartu();
        }

        x = panjang;
        grid.scrollLeft = x;

        const gambar = grid.querySelector('img');

        if (gambar) {
            const posisi = gambar.getBoundingClientRect();
            const wadah = wrapper.getBoundingClientRect();

            wrapper.style.setProperty(
                '--arrow-top',
                `${posisi.top - wadah.top + posisi.height / 2}px`
            );
        }
    }

    function panah(teks, kelas, label, arah) {
        const tombol = document.createElement('button');
        tombol.type = 'button';
        tombol.className = 'project-slider-arrow ' + kelas;
        tombol.textContent = teks;
        tombol.setAttribute('aria-label', label);

        tombol.addEventListener('click', () => {
            if (!panjang) return;

            const kartu = grid.firstElementChild;
            const jarak = parseFloat(getComputedStyle(grid).columnGap) || 0;
            const langkah = kartu.getBoundingClientRect().width + jarak;

            if (geser) return; // tunggu gerakan sebelumnya selesai

            geser = {
                dari: x,
                jarak: arah * langkah,
                mulai: performance.now()
            };
        });

        wrapper.append(tombol);
    }

    panah('❮', 'prev', 'Geser ke kiri', 1);
    panah('❯', 'next', 'Geser ke kanan', -1);

    // Berhenti saat kursor di atas proyek atau saat tombol/kartu difokus
    wrapper.addEventListener('mouseenter', () => { jeda = true; });
    wrapper.addEventListener('mouseleave', () => { jeda = false; });
    wrapper.addEventListener('focusin', () => { jeda = true; });
    wrapper.addEventListener('focusout', () => { jeda = false; });

    let sebelumnya = 0;
    const kecepatan = 35; // Piksel per detik

    function animasi(waktu) {
        const selisih = sebelumnya
            ? Math.min((waktu - sebelumnya) / 1000, 0.05)
            : 0;

        sebelumnya = waktu;

        if (geser) {
            // Gerakan halus saat panah ditekan (awal dan akhir pelan)
            let t = Math.min((waktu - geser.mulai) / durasiPanah, 1);
            if (reducedMotion.matches) t = 1;
            const halus = t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;

            x = ((geser.dari + geser.jarak * halus) % panjang + panjang) % panjang;
            grid.scrollLeft = x;

            if (t >= 1) geser = null;
        } else if (panjang > 0 && !document.hidden && !jeda && !reducedMotion.matches) {
            x -= kecepatan * selisih;

            if (x < 0) x += panjang;
            grid.scrollLeft = x;
        }

        requestAnimationFrame(animasi);
    }

    grid.querySelectorAll('img').forEach(gambar => {
        gambar.addEventListener('load', ukur, { once: true });
    });

    new ResizeObserver(ukur).observe(grid);

    ukur();
    requestAnimationFrame(animasi);
})();