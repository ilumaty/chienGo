// copnfig de la navigation
const NAV_CONFIG = {
    scrollThreshold: 50,
    smoothScrollOffset: 80,
    mobileBreakpoint: 768
};

document.addEventListener('DOMContentLoaded', function() {
    initMobileMenu();
    initSmoothScroll();
    initStickyNavigation();
    initNavAnimations();
});



// menu mobile
function initMobileMenu() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (!mobileMenuBtn || !mobileMenu) {
        console.warn('Mobile menu elements not found');
        return;
    }

    // toggle du menu mobile
    mobileMenuBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleMobileMenu();
    });

    // fermer le menu en cliquant ailleurs
    document.addEventListener('click', function(event) {
        if (!mobileMenuBtn.contains(event.target) &&
            !mobileMenu.contains(event.target)) {
            closeMobileMenu();
        }
    });

    // fermer le menu avec Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMobileMenu();
        }
    });

    // fermer le menu redimensionnement vers desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth > NAV_CONFIG.mobileBreakpoint) {
            closeMobileMenu();
        }
    });
}

// toggle du menu
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');

    if (mobileMenu.classList.contains('hidden')) {
        openMobileMenu();
    } else {
        closeMobileMenu();
    }
}

// ouvrire avec menu
function openMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');

    mobileMenu.classList.remove('hidden');
    mobileMenuBtn.setAttribute('aria-expanded', 'true');

    // animation d'entrée
    setTimeout(() => {
        mobileMenu.style.transform = 'translateY(0)';
        mobileMenu.style.opacity = '1';
    }, 10);

    // block le scroll du body
    document.body.style.overflow = 'hidden';
}

// fermer le scroll menu
function closeMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');

    if (!mobileMenu || mobileMenu.classList.contains('hidden')) return;

    // animation de sortie
    mobileMenu.style.transform = 'translateY(-10px)';
    mobileMenu.style.opacity = '0';

    setTimeout(() => {
        mobileMenu.classList.add('hidden');
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
    }, 200);

    // unlock le scroll du body
    document.body.style.overflow = '';
}


// init smoothScroll
function initSmoothScroll() {
    // sélécetionne tous les liens d'ancrage
    const anchorLinks = document.querySelectorAll('a[href^="#"]');

    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');

            // ingorer les liens vides ou #
            if (!href || href === '#') return;

            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                smoothScrollTo(target);

                // fermer le menu mobile si ouvert
                closeMobileMenu();
            }
        });
    });
}

// fluidité vers menu to scrool
function smoothScrollTo(target) {
    const targetPosition = target.offsetTop - NAV_CONFIG.smoothScrollOffset;

    window.scrollTo({
        top: targetPosition,
        behavior: 'smooth'
    });
}

// init nav
function initStickyNavigation() {
    let lastScrollY = window.scrollY;
    let isScrollingDown = false;

    window.addEventListener('scroll', function() {
        const currentScrollY = window.scrollY;
        isScrollingDown = currentScrollY > lastScrollY;

        updateNavigationAppearance(currentScrollY, isScrollingDown);
        lastScrollY = currentScrollY;
    });
}

// MAJ selon scroll
function updateNavigationAppearance(scrollY, isScrollingDown) {
    const header = document.querySelector('header');
    if (!header) return;

    // change d'apparence selon la position
    if (scrollY > NAV_CONFIG.scrollThreshold) {
        // Navigation scrollée
        header.classList.add('nav-scrolled');
        header.classList.remove('nav-top');
    } else {
        // nav en haut
        header.classList.remove('nav-scrolled');
        header.classList.add('nav-top');
    }

    // cacher/montrer la navigation selon la direction
    if (scrollY > 200) { // seulement après un certain scroll
        if (isScrollingDown) {
            header.style.transform = 'translateY(-100%)';
        } else {
            header.style.transform = 'translateY(0)';
        }
    }
}


// init la nav
function initNavAnimations() {
    initLinkHoverEffects();
    initLogoAnimation();
    initDropdownAnimations();
}

// hover sur lien
function initLinkHoverEffects() {
    const navLinks = document.querySelectorAll('nav a');

    navLinks.forEach(link => {
        // effet de surbrillance fluide
        link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-1px)';
        });

        link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

// anime logo
function initLogoAnimation() {
    const logo = document.querySelector('header a img');

    if (logo) {
        logo.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05) rotate(2deg)';
        });

        logo.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotate(0deg)';
        });
    }
}

// anim drop
function initDropdownAnimations() {
    const dropdowns = document.querySelectorAll('.relative.group');

    dropdowns.forEach(dropdown => {
        const menu = dropdown.querySelector('.absolute');

        if (menu) {
            // Animation d'entrée plus fluide
            dropdown.addEventListener('mouseenter', function() {
                menu.style.animation = 'slideDown 0.3s ease forwards';
            });

            dropdown.addEventListener('mouseleave', function() {
                menu.style.animation = 'slideUp 0.3s ease forwards';
            });
        }
    });
}

// si sur mobile
function isMobile() {
    return window.innerWidth <= NAV_CONFIG.mobileBreakpoint;
}

// debounce pour optimisé sur mobile
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// optimise le scroll avec debounce
const optimizedScrollHandler = debounce(function() {
    // logic de scroll optimisée
}, 10);