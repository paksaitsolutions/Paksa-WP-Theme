/**
 * Paksa Theme — Homepage JavaScript
 * FAQ accordion — accessible, vanilla JS, no jQuery
 *
 * @package paksa-it-solutions
 */

( function () {
    'use strict';

    // =========================================================
    // FAQ Accordion
    // =========================================================
    function initFaq() {
        var triggers = document.querySelectorAll( '.pk-faq-trigger' );
        if ( ! triggers.length ) return;

        triggers.forEach( function ( trigger ) {
            trigger.addEventListener( 'click', function () {
                var item    = trigger.closest( '.pk-faq-item' );
                var panelId = trigger.getAttribute( 'aria-controls' );
                var panel   = document.getElementById( panelId );
                var isOpen  = item.classList.contains( 'is-open' );

                if ( isOpen ) {
                    item.classList.remove( 'is-open' );
                    trigger.setAttribute( 'aria-expanded', 'false' );
                    panel.setAttribute( 'hidden', '' );
                } else {
                    item.classList.add( 'is-open' );
                    trigger.setAttribute( 'aria-expanded', 'true' );
                    panel.removeAttribute( 'hidden' );
                }
            } );
        } );
    }

    // =========================================================
    // Init on DOM ready
    // =========================================================
    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', initFaq );
    } else {
        initFaq();
    }

} )();
