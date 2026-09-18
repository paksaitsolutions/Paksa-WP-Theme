/**
 * Paksa Theme — Main JavaScript
 * Header scroll state + desktop dropdown navigation
 */

(function () {
    'use strict';

    document.documentElement.classList.add('js');

    // =========================================================
    // Header scroll state + sticky behavior
    // =========================================================
    var header = document.querySelector('.site-header, .pk-site-editor-header');
    var ticking = false;
    var lastScrollY = 0;
    var body = document.body;

    var isStickyCompact  = body.classList.contains('paksa-header-behavior--sticky-compact');
    var isHideOnScroll   = body.classList.contains('paksa-header-behavior--hide-on-scroll');
    var isStatic         = body.classList.contains('paksa-header-behavior--static');

    // Compensate for sticky header height so anchors don't hide under it
    function setScrollPadding() {
        if ( !header || isStatic ) return;
        var h = header.getBoundingClientRect().height;
        document.documentElement.style.scrollPaddingTop = h + 'px';
    }

    function updateHeaderState() {
        if (!header) return;
        var scrollY = window.scrollY || window.pageYOffset;
        var scrollingDown = scrollY > lastScrollY;

        header.classList.toggle('is-scrolled', scrollY > 10);

        if ( isStickyCompact ) {
            header.classList.toggle('is-compact', scrollY > 80);
        }

        if ( isHideOnScroll ) {
            if ( scrollY > 120 && scrollingDown ) {
                header.classList.add('is-hidden');
            } else if ( !scrollingDown ) {
                header.classList.remove('is-hidden');
            }
        }

        lastScrollY = scrollY;
        setScrollPadding();
        ticking = false;
    }

    window.addEventListener('scroll', function () {
        if (!ticking) {
            window.requestAnimationFrame(updateHeaderState);
            ticking = true;
        }
    }, { passive: true });

    updateHeaderState();
    setScrollPadding();

    // =========================================================
    // Desktop dropdown navigation
    // =========================================================
    var toggles = document.querySelectorAll('.main-nav .pk-dropdown-toggle');

    function closeAllDropdowns(except) {
        toggles.forEach(function (btn) {
            if (btn === except) return;
            var submenuId = btn.getAttribute('aria-controls');
            var submenu = submenuId ? document.getElementById(submenuId) : null;
            if (!submenu) {
                // Fallback: find sibling .pk-submenu
                submenu = btn.parentElement ? btn.parentElement.querySelector('.pk-submenu') : null;
            }
            btn.setAttribute('aria-expanded', 'false');
            if (submenu) submenu.classList.remove('is-open');
        });
    }

    function getSubmenu(toggle) {
        var submenuId = toggle.getAttribute('aria-controls');
        if (submenuId) {
            var el = document.getElementById(submenuId);
            if (el) return el;
        }
        // Fallback: sibling .pk-submenu within the same li
        return toggle.parentElement ? toggle.parentElement.querySelector('.pk-submenu') : null;
    }

    function assignSubmenuId(toggle, submenu) {
        // Ensure the submenu has the id the toggle references
        var id = toggle.getAttribute('aria-controls');
        if (id && !submenu.id) {
            submenu.id = id;
        }
    }

    toggles.forEach(function (toggle) {
        var submenu = getSubmenu(toggle);
        if (!submenu) return;
        assignSubmenuId(toggle, submenu);

        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            var isOpen = toggle.getAttribute('aria-expanded') === 'true';
            closeAllDropdowns(toggle);
            if (!isOpen) {
                toggle.setAttribute('aria-expanded', 'true');
                submenu.classList.add('is-open');
            } else {
                toggle.setAttribute('aria-expanded', 'false');
                submenu.classList.remove('is-open');
            }
        });

        // Close on Escape — return focus to toggle
        submenu.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                toggle.setAttribute('aria-expanded', 'false');
                submenu.classList.remove('is-open');
                toggle.focus();
            }
        });

        toggle.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                toggle.setAttribute('aria-expanded', 'false');
                submenu.classList.remove('is-open');
            }
        });

        // Close when Tab leaves the submenu
        submenu.addEventListener('focusout', function (e) {
            if (!submenu.contains(e.relatedTarget) && e.relatedTarget !== toggle) {
                toggle.setAttribute('aria-expanded', 'false');
                submenu.classList.remove('is-open');
            }
        });
    });

    // Close dropdowns on outside click
    document.addEventListener('click', function () {
        closeAllDropdowns(null);
    });

    // =========================================================
    // Mobile submenu toggles (reuse same .pk-dropdown-toggle)
    // =========================================================
    var mobileToggles = document.querySelectorAll('.mobile-nav .pk-dropdown-toggle');

    mobileToggles.forEach(function (toggle) {
        var submenu = getSubmenu(toggle);
        if (!submenu) return;
        assignSubmenuId(toggle, submenu);

        toggle.addEventListener('click', function () {
            var isOpen = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
            submenu.classList.toggle('is-open', !isOpen);
        });
    });

})();
