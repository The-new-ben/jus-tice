export function initClickableElements() {
  document.querySelectorAll('.holder-clickable-self,.fep-odd-even > div,.fep-per-message').forEach(el => {
    el.addEventListener('click', () => {
      const link = el.querySelector('a');
      if (link) window.location = link.href;
    });
  });
  document.querySelectorAll('.holder-clickable.blank').forEach(el => {
    el.addEventListener('click', () => {
      const link = el.querySelector('a');
      if (link) window.open(link.href);
    });
  });
  document.querySelectorAll('a.collapse-link').forEach(link => {
    link.addEventListener('click', () => {
      const li = link.closest('li');
      if (li) li.classList.toggle('is-open');
    });
  });
}
