export function initTestimonialSlider() {
  const slider = document.getElementById('testimonial-slider');
  if (!slider) return;
  const slides = Array.from(slider.querySelectorAll('.testimonial'));
  if (slides.length === 0) return;
  let index = 0;
  const dots = document.createElement('div');
  dots.className = 'dots';
  slides.forEach((slide, i) => {
    slide.style.display = i === 0 ? 'block' : 'none';
    const btn = document.createElement('button');
    btn.addEventListener('click', () => showSlide(i));
    dots.appendChild(btn);
  });
  slider.appendChild(dots);
  function showSlide(i) {
    slides[index].style.display = 'none';
    dots.children[index].classList.remove('active');
    index = i;
    slides[index].style.display = 'block';
    dots.children[index].classList.add('active');
  }
  function nextSlide() {
    showSlide((index + 1) % slides.length);
  }
  let timer = setInterval(nextSlide, 4000);
  slider.addEventListener('mouseenter', () => clearInterval(timer));
  slider.addEventListener('mouseleave', () => { timer = setInterval(nextSlide, 4000); });
  dots.children[0].classList.add('active');
  slider.style.display = 'block';
}
