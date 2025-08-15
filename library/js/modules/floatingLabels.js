export function initFloatingLabels() {
  const onClass = 'on';
  const showClass = 'show';
  const checkVal = el => {
    const label = el.previousElementSibling;
    const container = el.closest('.fep-form-field');
    if (!label || !container) return;
    if (el.value) {
      label.classList.add(showClass);
      container.classList.add(showClass);
    } else {
      label.classList.remove(showClass);
      container.classList.remove(showClass);
    }
  };
  document.querySelectorAll('input,textarea,select').forEach(el => {
    el.addEventListener('keyup', () => checkVal(el));
    el.addEventListener('focus', () => {
      const label = el.previousElementSibling;
      const container = el.closest('.fep-form-field');
      if (label) label.classList.add(onClass);
      if (container) container.classList.add(onClass);
    });
    el.addEventListener('blur', () => {
      const label = el.previousElementSibling;
      const container = el.closest('.fep-form-field');
      if (label) label.classList.remove(onClass);
      if (container) container.classList.remove(onClass);
    });
    checkVal(el);
  });
  document.querySelectorAll('.select-container select').forEach(sel => {
    sel.addEventListener('change', () => {
      const container = sel.closest('.select-container');
      if (!container) return;
      if (sel.value) container.classList.add(showClass);
      else container.classList.remove(showClass);
    });
    const container = sel.closest('.select-container');
    if (container && sel.value) container.classList.add(showClass);
  });
  document.querySelectorAll('li.gfield .gfield_label').forEach(label => {
    label.addEventListener('click', () => {
      const input = label.nextElementSibling?.querySelector('input[type="text"], textarea');
      if (input) input.focus();
    });
  });
  document.querySelectorAll('.ginput_container input[type="text"], .ginput_container textarea').forEach(el => {
    const label = el.closest('.ginput_container')?.previousElementSibling;
    el.addEventListener('focus', () => { if (label) label.classList.add('show'); });
    el.addEventListener('blur', () => { if (!el.value && label) label.classList.remove('show'); });
    if (el.value && label) label.classList.add('show');
  });
}
