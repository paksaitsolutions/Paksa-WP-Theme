/* Single Service Page — FAQ accordion + scroll animations */
(function () {
    'use strict';

    /* ── FAQ accordion ── */
    document.querySelectorAll('.pk-ssvc-faq-q').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var expanded = this.getAttribute('aria-expanded') === 'true';
            /* Close all */
            document.querySelectorAll('.pk-ssvc-faq-q').forEach(function (b) {
                b.setAttribute('aria-expanded', 'false');
                var a = b.nextElementSibling;
                if (a) a.classList.remove('is-open');
            });
            /* Open clicked if it was closed */
            if (!expanded) {
                this.setAttribute('aria-expanded', 'true');
                var answer = this.nextElementSibling;
                if (answer) answer.classList.add('is-open');
            }
        });
    });

    /* ── Scroll-triggered fade-up ── */
    if (!window.IntersectionObserver) return;
    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                var el = entry.target;
                var delay = el.dataset.delay ? parseInt(el.dataset.delay, 10) : 0;
                setTimeout(function () { el.classList.add('is-visible'); }, delay);
                observer.unobserve(el);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.pk-fade-up').forEach(function (el) {
        observer.observe(el);
    });
}());
