/**
 * Paksa IT Solutions — Scroll Animations & Interactions
 */
( function () {
    'use strict';

    document.documentElement.classList.add( 'js' );

    if ( ! window.IntersectionObserver ) return;
    if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
        document.querySelectorAll( '.pk-animate-on-scroll' ).forEach( function ( el ) {
            el.classList.add( 'is-visible' );
        } );
        return;
    }

    /* ── Scroll-reveal ─────────────────────────────────────── */
    var revealObserver = new IntersectionObserver( function ( entries ) {
        entries.forEach( function ( entry ) {
            if ( ! entry.isIntersecting ) return;
            var el    = entry.target;
            var delay = parseInt( el.dataset.delay, 10 ) || 0;
            setTimeout( function () {
                el.classList.add( 'is-visible' );
            }, delay );
            revealObserver.unobserve( el );
        } );
    }, { rootMargin: '0px 0px -60px 0px', threshold: 0.08 } );

    document.querySelectorAll( '.pk-animate-on-scroll' ).forEach( function ( el ) {
        revealObserver.observe( el );
    } );

    /* ── Stagger children ──────────────────────────────────── */
    document.querySelectorAll( '[data-stagger]' ).forEach( function ( parent ) {
        var base  = parseInt( parent.dataset.stagger, 10 ) || 80;
        var items = parent.querySelectorAll( ':scope > *' );
        items.forEach( function ( child, i ) {
            child.classList.add( 'pk-animate-on-scroll' );
            child.dataset.delay = i * base;
            revealObserver.observe( child );
        } );
    } );

    /* ── Counter animation ─────────────────────────────────── */
    function animateCounter( el ) {
        var target   = parseFloat( el.dataset.count );
        var suffix   = el.dataset.suffix || '';
        var prefix   = el.dataset.prefix || '';
        var duration = 1600;
        var start    = performance.now();
        var isFloat  = target % 1 !== 0;

        function step( now ) {
            var progress = Math.min( ( now - start ) / duration, 1 );
            var ease     = 1 - Math.pow( 1 - progress, 3 );
            var value    = target * ease;
            el.textContent = prefix + ( isFloat ? value.toFixed( 1 ) : Math.floor( value ) ) + suffix;
            if ( progress < 1 ) requestAnimationFrame( step );
        }
        requestAnimationFrame( step );
    }

    var counterObserver = new IntersectionObserver( function ( entries ) {
        entries.forEach( function ( entry ) {
            if ( ! entry.isIntersecting ) return;
            animateCounter( entry.target );
            counterObserver.unobserve( entry.target );
        } );
    }, { threshold: 0.5 } );

    document.querySelectorAll( '[data-count]' ).forEach( function ( el ) {
        counterObserver.observe( el );
    } );

    /* ── Typing effect ─────────────────────────────────────── */
    document.querySelectorAll( '[data-typewriter]' ).forEach( function ( el ) {
        var words   = el.dataset.typewriter.split( '|' );
        var cursor  = el.querySelector( '.pk-cursor' );
        var display = el.querySelector( '.pk-typewriter-text' );
        if ( ! display ) return;

        var wi = 0, ci = 0, deleting = false;

        function tick() {
            var word = words[ wi ];
            if ( deleting ) {
                display.textContent = word.substring( 0, --ci );
                if ( ci === 0 ) { deleting = false; wi = ( wi + 1 ) % words.length; setTimeout( tick, 400 ); return; }
                setTimeout( tick, 60 );
            } else {
                display.textContent = word.substring( 0, ++ci );
                if ( ci === word.length ) { deleting = true; setTimeout( tick, 1800 ); return; }
                setTimeout( tick, 90 );
            }
        }
        setTimeout( tick, 800 );
    } );

    /* ── Dashboard bar animation ───────────────────────────── */
    var dashObserver = new IntersectionObserver( function ( entries ) {
        entries.forEach( function ( entry ) {
            if ( ! entry.isIntersecting ) return;
            entry.target.querySelectorAll( '.pk-dash-bar' ).forEach( function ( bar, i ) {
                bar.style.transformOrigin = 'bottom';
                bar.style.transform       = 'scaleY(0)';
                setTimeout( function () {
                    bar.style.transition = 'transform 0.6s cubic-bezier(0.34,1.56,0.64,1)';
                    bar.style.transform  = 'scaleY(1)';
                }, 300 + i * 80 );
            } );
            dashObserver.unobserve( entry.target );
        } );
    }, { threshold: 0.3 } );

    document.querySelectorAll( '.pk-hero-dashboard' ).forEach( function ( el ) {
        dashObserver.observe( el );
    } );

} )();
