// Hand2Hand — page transition + scroll reveal + header scroll
(function () {
  const overlay = document.getElementById('h2h-overlay');

  // Exit animation on load
  if (overlay) {
    overlay.classList.remove('enter');
    overlay.classList.add('exit');
    setTimeout(() => overlay.classList.remove('exit'), 460);
  }

  // Intercept internal link clicks
  document.addEventListener('click', function (e) {
    const link = e.target.closest('a[href]');
    if (!link || !overlay) return;
    const href = link.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('mailto') || href.startsWith('javascript')) return;
    if (link.target === '_blank') return;
    // Skip confirm dialogs — let PHP handle those
    e.preventDefault();
    overlay.classList.remove('exit');
    overlay.classList.add('enter');
    setTimeout(() => { window.location.href = href; }, 480);
  });

  // Header scroll effect
  const header = document.querySelector('.h2h-header');
  if (header) {
    const onScroll = () => header.classList.toggle('scrolled', window.scrollY > 50);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // Scroll reveal
  const reveals = document.querySelectorAll('.h2h-reveal');
  if (reveals.length) {
    const obs = new IntersectionObserver((entries) => {
      entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
          setTimeout(() => entry.target.classList.add('up'), i * 70);
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });
    reveals.forEach(el => obs.observe(el));
  }
})();
