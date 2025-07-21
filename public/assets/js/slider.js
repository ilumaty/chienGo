// config du slider
const SLIDER_CONFIG = {
    totalSlides: 5,
    autoPlayInterval: 5000,
    swipeThreshold: 50
};

// var globales
let currentSlideIndex = 0;
let autoPlay;
let startX = 0;
let endX = 0;

document.addEventListener('DOMContentLoaded', function() {
    initSlider();
});


function initSlider() {
    // vérifie que les éléments existent
    const slider = document.getElementById('slider');
    const sliderContainer = document.querySelector('.slider-container');

    if (!slider || !sliderContainer) {
        console.warn('Slider elements not found');
        return;
    }

    // initialise les événements
    setupEventListeners();

    // démarre l'auto-play
    startAutoPlay();

    // initialise les dots
    updateSlider();
}

// config des événements
function setupEventListeners() {
    const sliderContainer = document.querySelector('.slider-container');

    if (!sliderContainer) return;

    // événements tactiles pour mobile
    sliderContainer.addEventListener('touchstart', handleTouchStart, { passive: true });
    sliderContainer.addEventListener('touchend', handleTouchEnd, { passive: true });

    // Pause/reprise de l'auto-play
    sliderContainer.addEventListener('mouseenter', stopAutoPlay);
    sliderContainer.addEventListener('mouseleave', startAutoPlay);

    // gestion du focus pour l'accessibilité
    sliderContainer.addEventListener('focusin', stopAutoPlay);
    sliderContainer.addEventListener('focusout', startAutoPlay);
}

// next slide
function nextSlide() {
    currentSlideIndex = (currentSlideIndex + 1) % SLIDER_CONFIG.totalSlides;
    updateSlider();
}

// previous slide
function previousSlide() {
    currentSlideIndex = (currentSlideIndex - 1 + SLIDER_CONFIG.totalSlides) % SLIDER_CONFIG.totalSlides;
    updateSlider();
}

// slide spécifique
function currentSlide(slideNumber) {
    if (slideNumber < 1 || slideNumber > SLIDER_CONFIG.totalSlides) {
        console.warn('Invalid slide number:', slideNumber);
        return;
    }

    currentSlideIndex = slideNumber - 1;
    updateSlider();
}

// MAJ slider
function updateSlider() {
    const slider = document.getElementById('slider');
    const dots = document.querySelectorAll('.dot');

    if (!slider) return;

    // déplacer le slider
    slider.style.transform = `translateX(-${currentSlideIndex * 100}%)`;

    // MAJ des dots
    dots.forEach((dot, index) => {
        if (index === currentSlideIndex) {
            dot.classList.add('active');
            dot.setAttribute('aria-current', 'true');
        } else {
            dot.classList.remove('active');
            dot.removeAttribute('aria-current');
        }
    });
}

// start auto-play
function startAutoPlay() {
    stopAutoPlay();
    autoPlay = setInterval(nextSlide, SLIDER_CONFIG.autoPlayInterval);
}

// stop auto-play
function stopAutoPlay() {
    if (autoPlay) {
        clearInterval(autoPlay);
        autoPlay = null;
    }
}

// gestion du touch
function handleTouchStart(e) {
    startX = e.touches[0].clientX;
    stopAutoPlay();
}

// gestion fin du touch
function handleTouchEnd(e) {
    endX = e.changedTouches[0].clientX;
    handleSwipe();
    startAutoPlay();
}

// traite le swipe
function handleSwipe() {
    const diff = startX - endX;

    if (Math.abs(diff) > SLIDER_CONFIG.swipeThreshold) {
        if (diff > 0) {
            nextSlide();
        } else {
            previousSlide();
        }
    }
}

// gère les erreurs img
function handleImageError(img) {
    console.warn('Image failed to load:', img.src);
    if (!img.src.includes('placeholder')) {
        img.src = '/assets/img/placeholder.webp';
    } else {
        img.style.backgroundColor = '#f0f0f0';
        img.style.display = 'flex';
        img.style.alignItems = 'center';
        img.style.justifyContent = 'center';
        img.alt = 'Image non disponible';
    }
}

// pré-charge les img
function preloadSliderImages() {
    for (let i = 1; i <= SLIDER_CONFIG.totalSlides; i++) {
        const img = new Image();
        img.src = `/assets/img/slider/slide${i}.webp`;
        img.onerror = () => handleImageError(img);
    }
}

// pré-charge les img au charging page
document.addEventListener('DOMContentLoaded', preloadSliderImages);