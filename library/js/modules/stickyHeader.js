export function initStickyHeader() {
  const header = document.getElementById('header-tools');
  if (!header || window.innerWidth <= 991) return;
  const onScroll = () => {
    if (window.scrollY >= 165) {
      header.classList.add('fixed');
    } else {
      header.classList.remove('fixed');
    }
  };
  window.addEventListener('scroll', onScroll);
}
