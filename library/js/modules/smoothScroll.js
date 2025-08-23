export function initSmoothScroll() {
  document.querySelectorAll('a:not(.nav-link):not(.collapse-link):not(.menu-item a)').forEach(anchor => {
    anchor.addEventListener('click', function (event) {
      if (this.hash !== '') {
        event.preventDefault();
        const target = document.querySelector(this.hash);
        if (target) {
          target.scrollIntoView({ behavior: 'smooth' });
          history.pushState(null, '', this.hash);
        }
      }
    });
  });
}
