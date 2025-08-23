import { initOffcanvas } from './modules/offcanvas.js';
import { initVideoPlayer } from './modules/videoPlayer.js';
import { initStickyHeader } from './modules/stickyHeader.js';
import { initSmoothScroll } from './modules/smoothScroll.js';
import { initClickableElements } from './modules/clickableElements.js';
import { initFloatingLabels } from './modules/floatingLabels.js';
import { initMobileMenu } from './modules/mobileMenu.js';
import { initTestimonialSlider } from './modules/testimonialSlider.js';

document.addEventListener('DOMContentLoaded', () => {
  initOffcanvas();
  initVideoPlayer();
  initStickyHeader();
  initSmoothScroll();
  initClickableElements();
  initFloatingLabels();
  initMobileMenu();
  initTestimonialSlider();
});
