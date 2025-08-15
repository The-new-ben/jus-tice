export function initOffcanvas() {
  document.querySelectorAll('[data-toggle="offcanvas"]').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.row-offcanvas').forEach(el => el.classList.toggle('active'));
      btn.classList.toggle('active');
      document.body.classList.toggle('no-scroll');
    });
  });
}
