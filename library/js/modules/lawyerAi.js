export function initLawyerAi() {
  const buttons = document.querySelectorAll('.ask-lawyer');
  buttons.forEach((button) => {
    button.addEventListener('click', async () => {
      try {
        const response = await fetch(aeroAi.ajaxUrl, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
          body: new URLSearchParams({
            action: 'aero_ai_lawyerfaq',
            nonce: aeroAi.nonce,
            lawyer: button.dataset.lawyer || ''
          })
        });
        const data = await response.json();
        console.log(data);
      } catch (err) {
        console.error(err);
      }
    });
  });
}
