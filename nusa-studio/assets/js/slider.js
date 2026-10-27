'use strict';

// Tambah gambar pada hero-slider-track di index.php. Jumlahnya dibaca otomatis.
const slider = document.querySelector('.hero-slider');
if (slider) {
  const track = slider.querySelector('.hero-slider-track');
  const slides = [...track.querySelectorAll('.hero-slide')];
  const counter = slider.querySelector('.hero-slider-count');
  let current = 0;
  let timer;
  let touchX = null;

  function schedule() {
    clearInterval(timer);
    if (!document.hidden && slides.length > 1) {
      timer = setInterval(() => show(current + 1), 4500);
    }

  }

  function show(index) {
    current = (index + slides.length) % slides.length;
    track.style.transform = `translateX(-${current * 100}%)`;
    counter.textContent = `${current + 1} / ${slides.length}`;
    slides.forEach((slide, i) => slide.setAttribute('aria-hidden', String(i !== current)));
  }

  function move(step) { show(current + step); schedule(); }
  slider.querySelector('[data-slide-prev]').addEventListener('click', () => move(-1));
  slider.querySelector('[data-slide-next]').addEventListener('click', () => move(1));
  slider.addEventListener('keydown', (event) => {
    if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
      event.preventDefault(); move(event.key === 'ArrowLeft' ? -1 : 1);
    }
  });
  slider.addEventListener('touchstart', (event) => { touchX = event.touches[0].clientX; }, { passive: true });
  slider.addEventListener('touchend', (event) => {
    if (touchX === null) return;
    const distance = event.changedTouches[0].clientX - touchX;
    if (Math.abs(distance) > 45) move(distance < 0 ? 1 : -1);
    touchX = null;
  }, { passive: true });
  slider.addEventListener('touchcancel', () => { touchX = null; });
  document.addEventListener('visibilitychange', schedule);
  show(0);
  schedule();
}
