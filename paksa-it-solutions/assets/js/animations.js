/**
 * Nexus Business Theme — Scroll Animations
 * IntersectionObserver-based reveal animations
 */

(function () {
    'use strict';

    if (!window.IntersectionObserver) return;

    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    var animatedElements = document.querySelectorAll(
        '[data-anim], .pk-animate-on-scroll'
    );

    if (animatedElements.length === 0) return;

    var observerOptions = {
        root: null,
        rootMargin: '0px 0px -60px 0px',
        threshold: 0.1,
    };

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                var el = entry.target;
                var delay = el.dataset.delay || 0;
                var animType = el.dataset.anim || 'fade-up';

                setTimeout(function () {
                    switch (animType) {
                        case 'fade-up':
                            el.classList.add('pk-animate-fade-up');
                            break;
                        case 'fade-in':
                            el.classList.add('pk-animate-fade-in');
                            break;
                        case 'scale-in':
                            el.classList.add('pk-animate-scale-in');
                            break;
                        case 'slide-right':
                            el.classList.add('pk-animate-slide-right');
                            break;
                        default:
                            el.classList.add('pk-animate-fade-up');
                    }
                }, parseInt(delay, 10) || 0);

                observer.unobserve(el);
            }
        });
    }, observerOptions);

    animatedElements.forEach(function (el) {
        observer.observe(el);
    });
})();
