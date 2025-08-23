export function initVideoPlayer() {
  const button = document.getElementById('play-video');
  if (!button) return;
  button.addEventListener('click', ev => {
    ev.preventDefault();
    button.style.display = 'none';
    const video = document.getElementById('video');
    if (video) {
      video.src += '&autoplay=1';
    }
  });
}
