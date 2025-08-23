export function initMobileMenu() {
  if (window.innerWidth >= 992) return;
  const panels = document.querySelectorAll('.main-menu .sub-menu');
  panels.forEach(p => p.style.display = 'none');
  panels.forEach(sub => {
    const link = sub.parentElement?.querySelector(':scope > a');
    if (link) {
      link.addEventListener('click', e => {
        e.preventDefault();
        link.classList.toggle('active');
        panels.forEach(panel => {
          if (panel !== sub) {
            panel.style.display = 'none';
            panel.classList.remove('is-open');
          }
        });
        if (sub.style.display === 'none' || sub.style.display === '') {
          sub.style.display = 'block';
          sub.classList.add('is-open');
        } else {
          sub.style.display = 'none';
          sub.classList.remove('is-open');
        }
      });
    }
  });
}
