/**
 * Paksa IT Solutions — Scroll Animations & Interactions
 */
( function () {
    'use strict';

    document.documentElement.classList.add( 'js' );

    /* Block-style motion choices are converted into the same central reveal
       contract used by PHP sections. No animation state is stored in content. */
    var motionStyles = {
        'is-style-paksa-motion-fade': 'fade-in',
        'is-style-paksa-motion-fade-up': 'fade-up',
        'is-style-paksa-motion-fade-down': 'fade-down',
        'is-style-paksa-motion-fade-left': 'fade-left',
        'is-style-paksa-motion-fade-right': 'fade-right',
        'is-style-paksa-motion-scale': 'scale-in',
        'is-style-paksa-motion-reveal': 'reveal'
    };

    /* Motion block styles also drive the CSS-native pk-motion-visible class
       so the block-style CSS in blocks.css activates on scroll. */
    var motionBlockClasses = [
        'is-style-paksa-motion-fade', 'is-style-paksa-motion-fade-up',
        'is-style-paksa-motion-fade-down', 'is-style-paksa-motion-fade-left',
        'is-style-paksa-motion-fade-right', 'is-style-paksa-motion-scale',
        'is-style-paksa-motion-reveal', 'is-style-paksa-motion-stagger'
    ];

    Object.keys( motionStyles ).forEach( function( className ) {
        document.querySelectorAll( '.' + className ).forEach( function( el ) {
            if ( ! el.classList.contains( 'pk-animate-on-scroll' ) ) {
                el.classList.add( 'pk-animate-on-scroll' );
            }
            if ( ! el.dataset.anim ) {
                el.dataset.anim = motionStyles[ className ];
            }
            el.dataset.motionBlock = '1';
        } );
    } );

    document.querySelectorAll( '.is-style-paksa-motion-stagger' ).forEach( function( el ) {
        if ( ! el.dataset.stagger ) {
            el.dataset.stagger = '80';
        }
        el.dataset.motionBlock = '1';
    } );

    if ( ! window.IntersectionObserver ) {
        document.querySelectorAll( '.pk-animate-on-scroll' ).forEach( function ( el ) {
            el.classList.add( 'is-visible' );
        } );
        return;
    }
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
                if ( el.dataset.motionBlock ) {
                    el.classList.add( 'pk-motion-visible' );
                }
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
            if ( ! child.classList.contains( 'pk-animate-on-scroll' ) ) {
                child.classList.add( 'pk-animate-on-scroll' );
            }
            if ( ! child.dataset.anim ) {
                child.dataset.anim = 'fade-up';
            }
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
