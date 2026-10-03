/**
 * Paksa Theme — Main JavaScript
 * Header scroll state + desktop dropdown navigation
 */

(function () {
    'use strict';

    document.documentElement.classList.add('js');

    // =========================================================
    // Header scroll state + sticky behavior
    // Uses IntersectionObserver sentinels to avoid scroll-jank.
    // Falls back to rAF scroll listener when IO is unavailable.
    // =========================================================
    var header = document.querySelector('.site-header, .pk-site-editor-header');
    var body = document.body;

    var isStickyCompact  = body.classList.contains('paksa-header-behavior--sticky-compact');
    var isHideOnScroll   = body.classList.contains('paksa-header-behavior--hide-on-scroll');
    var isStatic         = body.classList.contains('paksa-header-behavior--static');
    var prefersReduced   = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function setScrollPadding() {
        if ( !header || isStatic ) return;
        document.documentElement.style.scrollPaddingTop = header.getBoundingClientRect().height + 'px';
    }

    if ( header && !isStatic && window.IntersectionObserver ) {
        // Sentinel at top of page — when it leaves viewport, header is scrolled
        var sentinel = document.createElement('div');
        sentinel.style.cssText = 'position:absolute;top:0;left:0;width:1px;height:1px;pointer-events:none;';
        sentinel.setAttribute('aria-hidden', 'true');
        document.body.insertBefore(sentinel, document.body.firstChild);

        // Sentinel for compact threshold (80px)
        var sentinelCompact = document.createElement('div');
        sentinelCompact.style.cssText = 'position:absolute;top:80px;left:0;width:1px;height:1px;pointer-events:none;';
        sentinelCompact.setAttribute('aria-hidden', 'true');
        document.body.insertBefore(sentinelCompact, document.body.firstChild);

        new IntersectionObserver(function(entries) {
            var isScrolled = !entries[0].isIntersecting;
            header.classList.toggle('is-scrolled', isScrolled);
            setScrollPadding();
        }).observe(sentinel);

        if ( isStickyCompact ) {
            new IntersectionObserver(function(entries) {
                header.classList.toggle('is-compact', !entries[0].isIntersecting);
                setScrollPadding();
            }).observe(sentinelCompact);
        }

        // hide-on-scroll still needs scroll direction — use rAF for this only
        if ( isHideOnScroll && !prefersReduced ) {
            var lastScrollY = 0;
            var ticking = false;
            window.addEventListener('scroll', function() {
                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        var scrollY = window.scrollY || window.pageYOffset;
                        if ( scrollY > 120 && scrollY > lastScrollY ) {
                            header.classList.add('is-hidden');
                        } else if ( scrollY < lastScrollY ) {
                            header.classList.remove('is-hidden');
                        }
                        lastScrollY = scrollY;
                        ticking = false;
                    });
                    ticking = true;
                }
            }, { passive: true });
        }

    } else if ( header && !isStatic ) {
        // Fallback: rAF scroll listener
        var lastScrollY = 0;
        var ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    var scrollY = window.scrollY || window.pageYOffset;
                    var scrollingDown = scrollY > lastScrollY;
                    header.classList.toggle('is-scrolled', scrollY > 10);
                    if ( isStickyCompact ) header.classList.toggle('is-compact', scrollY > 80);
                    if ( isHideOnScroll && !prefersReduced ) {
                        if ( scrollY > 120 && scrollingDown ) header.classList.add('is-hidden');
                        else if ( !scrollingDown ) header.classList.remove('is-hidden');
                    }
                    lastScrollY = scrollY;
                    setScrollPadding();
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    }

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

// =========================================================
// Back to Top
// =========================================================
(function () {
    var btn = document.getElementById('pk-back-to-top');
    if (!btn) return;

    var visible = false;

    function update() {
        var shouldShow = (window.scrollY || window.pageYOffset) > 400;
        if (shouldShow === visible) return;
        visible = shouldShow;
        if (visible) {
            btn.removeAttribute('hidden');
        } else {
            btn.setAttribute('hidden', '');
        }
    }

    window.addEventListener('scroll', update, { passive: true });
    update();

    btn.addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
        // Move focus to top landmark for accessibility
        var main = document.getElementById('main-content') || document.querySelector('main');
        if (main) main.focus({ preventScroll: true });
    });
})();
