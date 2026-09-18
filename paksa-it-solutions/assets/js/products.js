/**
 * Paksa Theme — Products JavaScript
 * Category filter pill interaction for the products listing page.
 * Vanilla JS, no jQuery, no external libraries.
 *
 * @package paksa-it-solutions
 */

( function () {
    'use strict';

    // =========================================================
    // Category Filter
    // Filters .pk-product-card items by data-categories attribute.
    // =========================================================
    function initProductFilter() {
        var pills = document.querySelectorAll( '.pk-prod-cat-pill' );
        var cards = document.querySelectorAll( '.pk-prod-cpt-grid [data-categories]' );

        if ( ! pills.length || ! cards.length ) return;

        pills.forEach( function ( pill ) {
            pill.addEventListener( 'click', function () {
                var filter = pill.getAttribute( 'data-filter' );

                // Update active pill
                pills.forEach( function ( p ) {
                    p.classList.remove( 'is-active' );
                    p.setAttribute( 'aria-pressed', 'false' );
                } );
                pill.classList.add( 'is-active' );
                pill.setAttribute( 'aria-pressed', 'true' );

                // Show/hide cards
                cards.forEach( function ( card ) {
                    if ( filter === 'all' ) {
                        card.hidden = false;
                    } else {
                        var cats = card.getAttribute( 'data-categories' ) || '';
                        card.hidden = cats.split( ' ' ).indexOf( filter ) === -1;
                    }
                } );
            } );
        } );

        // Set initial aria-pressed state
        pills.forEach( function ( p ) {
            p.setAttribute( 'aria-pressed', p.classList.contains( 'is-active' ) ? 'true' : 'false' );
        } );
    }

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', initProductFilter );
    } else {
        initProductFilter();
    }

} )();
