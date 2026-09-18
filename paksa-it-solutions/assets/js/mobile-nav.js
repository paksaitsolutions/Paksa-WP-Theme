/**
 * Paksa Theme — Mobile Navigation
 * Handles off-canvas mobile menu with accessibility
 */

(function () {
    'use strict';

    var toggleButtons = document.querySelectorAll('.menu-toggle');
    var mobileNavs = document.querySelectorAll('.mobile-nav');
    var closeButtons = document.querySelectorAll('.mobile-nav-close');
    var body = document.body;
    var activeNav = null;
    var lastFocusedElement = null;

    function openMobileNav(nav, toggleBtn) {
        activeNav = nav;
        lastFocusedElement = toggleBtn || document.activeElement;

        nav.classList.add('is-open');
        body.style.overflow = 'hidden';

        if (toggleBtn) {
            toggleBtn.setAttribute('aria-expanded', 'true');
        }

        var firstFocusable = nav.querySelector(
            'a[href], button:not([disabled]), input, textarea, select, [tabindex]:not([tabindex="-1"])'
        );
        if (firstFocusable) {
            firstFocusable.focus();
        }

        document.addEventListener('keydown', handleFocusTrap);
    }

    function closeMobileNav(nav) {
        nav.classList.remove('is-open');
        body.style.overflow = '';
        document.removeEventListener('keydown', handleFocusTrap);

        if (lastFocusedElement && lastFocusedElement.focus) {
            lastFocusedElement.focus();
        }

        var toggleBtn = nav.parentElement.querySelector('.menu-toggle');
        if (toggleBtn) {
            toggleBtn.setAttribute('aria-expanded', 'false');
        }

        activeNav = null;
    }

    function handleFocusTrap(event) {
        if (!activeNav) return;

        if (event.key === 'Escape') {
            closeMobileNav(activeNav);
            return;
        }

        if (event.key !== 'Tab') return;

        var focusableElements = activeNav.querySelectorAll(
            'a[href], button:not([disabled]), input, textarea, select, [tabindex]:not([tabindex="-1"])'
        );

        if (focusableElements.length === 0) return;

        var firstElement = focusableElements[0];
        var lastElement = focusableElements[focusableElements.length - 1];

        if (event.shiftKey) {
            if (document.activeElement === firstElement) {
                event.preventDefault();
                lastElement.focus();
            }
        } else {
            if (document.activeElement === lastElement) {
                event.preventDefault();
                firstElement.focus();
            }
        }
    }

    toggleButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var targetId = button.getAttribute('aria-controls');
            var nav = targetId ? document.getElementById(targetId) : document.querySelector('.mobile-nav');
            if (nav) {
                openMobileNav(nav, button);
            }
        });
    });

    closeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var nav = button.closest('.mobile-nav');
            if (nav) {
                closeMobileNav(nav);
            }
        });
    });

    mobileNavs.forEach(function (nav) {
        nav.addEventListener('click', function (event) {
            if (event.target === nav) {
                closeMobileNav(nav);
            }
        });
    });
})();
