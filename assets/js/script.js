// Mobile Menu Toggle - Enhanced version
document.addEventListener('DOMContentLoaded', () => {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navLinks = document.getElementById('navLinks') || document.querySelector('.nav-links');

    if (mobileMenuBtn && navLinks) {
        // Toggle menu on button click
        mobileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();
            navLinks.classList.toggle('mobile-active');
            mobileMenuBtn.classList.toggle('active');

            // Force display
            if (navLinks.classList.contains('mobile-active')) {
                navLinks.style.display = 'flex';
            } else {
                navLinks.style.display = 'none';
            }
        });

        // Close menu ONLY on mobile when a nav link is clicked
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 968 && navLinks.classList.contains('mobile-active')) {
                    navLinks.classList.remove('mobile-active');
                    mobileMenuBtn.classList.remove('active');
                }
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.navbar') && !e.target.closest('.nav-links')) {
                navLinks.classList.remove('mobile-active');
                mobileMenuBtn.classList.remove('active');
                if (window.innerWidth <= 968) {
                    navLinks.style.display = 'none';
                }
            }
        });
    }
});

// Smooth scroll for navigation links - handle both internal anchors and page navigation
document.addEventListener('DOMContentLoaded', () => {
    // Handle anchor links with smooth scrolling
    document.querySelectorAll('a[href*="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            const hashIndex = href.indexOf('#');

            if (hashIndex > -1) {
                const hash = href.substring(hashIndex);

                // If the hash exists on this page, smooth scroll to it
                if (document.querySelector(hash)) {
                    e.preventDefault();
                    const target = document.querySelector(hash);
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
});

// Intersection Observer for fade-in animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe all cards and sections
document.addEventListener('DOMContentLoaded', () => {
    const elementsToAnimate = document.querySelectorAll(
        '.about-card, .service-card, .course-card, .tool-card, .event-card, .team-card'
    );

    elementsToAnimate.forEach(el => {
        observer.observe(el);
    });
});

// Navbar background on scroll - Updated for light mode
let lastScroll = 0;
const navbar = document.querySelector('.navbar');

if (navbar) {
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        const isLightMode = document.body.classList.contains('light-mode');

        if (currentScroll > 100) {
            if (isLightMode) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 5px 30px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.background = 'rgba(13, 13, 13, 0.98)';
                navbar.style.boxShadow = '0 5px 30px rgba(0, 0, 0, 0.3)';
            }
        } else {
            if (isLightMode) {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            } else {
                navbar.style.background = 'rgba(13, 13, 13, 0.95)';
            }
            navbar.style.boxShadow = 'none';
        }

        lastScroll = currentScroll;
    });
}

// Form submission (prevent default for demo)
const contactForm = document.querySelector('.contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', (e) => {
        e.preventDefault();
        alert('Thank you for your message! We will get back to you soon.');
        contactForm.reset();
    });
}

// Parallax effect for hero blobs
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const blobs = document.querySelectorAll('.blob');

    blobs.forEach((blob, index) => {
        const speed = (index + 1) * 0.1;
        blob.style.transform = `translateY(${scrolled * speed}px)`;
    });
});

// Add hover effect sound (optional - can be enabled with audio files)
const cards = document.querySelectorAll('.service-card, .course-card, .tool-card');
cards.forEach(card => {
    card.addEventListener('mouseenter', () => {
        card.style.transition = 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
    });
});

// Loading animation
window.addEventListener('load', () => {
    document.body.classList.add('loaded');
});

// Light/Dark Mode Toggle - Enhanced with immediate execution
(function () {
    'use strict';

    function initThemeToggle() {
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const body = document.body;

        if (!themeToggle || !themeIcon) {
            // Retry after a short delay if elements not found
            setTimeout(initThemeToggle, 100);
            return;
        }

        // Check for saved theme preference or default to dark mode
        const currentTheme = localStorage.getItem('theme') || 'dark';
        if (currentTheme === 'light') {
            body.classList.add('light-mode');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
        } else {
            body.classList.remove('light-mode');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
        }

        // Add click event listener
        themeToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            body.classList.toggle('light-mode');

            if (body.classList.contains('light-mode')) {
                localStorage.setItem('theme', 'light');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                localStorage.setItem('theme', 'dark');
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        });
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initThemeToggle);
    } else {
        initThemeToggle();
    }
})();

function initTypewriter() {
    const typewriter = document.getElementById('typewriter');
    if (!typewriter) return;

    const phrases = [
        "Learn • Earn • Grow • Innovate",
        "Student-Led Innovation Lab",
        "Building Tools for Youth",
        "Empowering Future Creators"
    ];

    let index = 0;
    let char = 0;
    let deleting = false;

    function type() {
        let current = phrases[index];

        if (!deleting) {
            typewriter.textContent = current.substring(0, char + 1);
            char++;

            if (char === current.length) {
                deleting = true;
                setTimeout(type, 2200);
                return;
            }
        } else {
            typewriter.textContent = current.substring(0, char - 1);
            char--;

            if (char === 0) {
                deleting = false;
                index = (index + 1) % phrases.length;
            }
        }

        setTimeout(type, deleting ? 60 : 120);
    }

    setTimeout(type, 1000);
}

initTypewriter();
