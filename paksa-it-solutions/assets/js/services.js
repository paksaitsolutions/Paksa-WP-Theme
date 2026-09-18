/* Paksa IT Solutions — Services Page JS */
( function () {
    'use strict';

    // Category filter
    function initServiceFilter() {
        var filterWrap = document.querySelector( '.pk-svc-filter' );
        if ( ! filterWrap ) return;

        var btns  = filterWrap.querySelectorAll( '.pk-svc-filter-btn' );
        var cards = document.querySelectorAll( '.pk-svc-cards-grid .pk-svc-card-v2' );

        filterWrap.addEventListener( 'click', function ( e ) {
            var btn = e.target.closest( '.pk-svc-filter-btn' );
            if ( ! btn ) return;

            var filter = btn.dataset.filter;

            btns.forEach( function ( b ) {
                b.classList.remove( 'is-active' );
                b.setAttribute( 'aria-selected', 'false' );
            } );
            btn.classList.add( 'is-active' );
            btn.setAttribute( 'aria-selected', 'true' );

            cards.forEach( function ( card ) {
                if ( filter === 'All' || card.dataset.category === filter ) {
                    card.classList.remove( 'is-hidden' );
                } else {
                    card.classList.add( 'is-hidden' );
                }
            } );
        } );
    }

    document.addEventListener( 'DOMContentLoaded', initServiceFilter );
} )();
