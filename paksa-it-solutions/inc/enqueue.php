<?php
/**
 * Paksa Theme — Asset Enqueueing
 *
 * @package paksa-it-solutions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue Theme Assets
 */
function paksa_enqueue_assets() {
    $version = PAKSA_THEME_VERSION;

    // Poppins — matches live site
    wp_enqueue_style(
        'paksa-poppins',
        'https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap',
        array(),
        null
    );

    // Variables CSS (design tokens)
    wp_enqueue_style(
        'paksa-variables',
        PAKSA_THEME_URI . '/assets/css/variables.css',
        array(),
        $version
    );

    // Main CSS
    wp_enqueue_style(
        'paksa-main',
        PAKSA_THEME_URI . '/assets/css/main.css',
        array('paksa-variables'),
        $version
    );

    // Shared component primitives used by PHP parts and Gutenberg block styles.
    wp_enqueue_style(
        'paksa-components',
        PAKSA_THEME_URI . '/assets/css/components.css',
        array('paksa-main'),
        $version
    );

    // Animations CSS
    wp_enqueue_style(
        'paksa-animations',
        PAKSA_THEME_URI . '/assets/css/animations.css',
        array('paksa-main', 'paksa-components'),
        $version
    );

    // Core-block patterns and block-style variants.
    wp_enqueue_style(
        'paksa-blocks',
        PAKSA_THEME_URI . '/assets/css/blocks.css',
        array( 'paksa-main', 'paksa-animations' ),
        $version
    );

    wp_enqueue_style(
        'paksa-style-variations',
        PAKSA_THEME_URI . '/assets/css/style-variations.css',
        array( 'paksa-components', 'paksa-blocks' ),
        $version
    );

    // Main JavaScript
    wp_enqueue_script(
        'paksa-main',
        PAKSA_THEME_URI . '/assets/js/main.js',
        array(),
        $version,
        true
    );

    // Mobile Navigation JavaScript
    wp_enqueue_script(
        'paksa-mobile-nav',
        PAKSA_THEME_URI . '/assets/js/mobile-nav.js',
        array('paksa-main'),
        $version,
        true
    );

    // Scroll Animations JavaScript
    wp_enqueue_script(
        'paksa-animations-js',
        PAKSA_THEME_URI . '/assets/js/animations.js',
        array('paksa-main'),
        $version,
        true
    );

    // Homepage-specific assets
    if ( is_front_page() ) {
        wp_enqueue_style(
            'paksa-home',
            PAKSA_THEME_URI . '/assets/css/home.css',
            array( 'paksa-main' ),
            $version
        );
        wp_enqueue_script(
            'paksa-home',
            PAKSA_THEME_URI . '/assets/js/home.js',
            array( 'paksa-main' ),
            $version,
            true
        );
    }

    // Products listing page + single product + archive + taxonomy assets
    if (
        is_page_template( 'page-products.php' ) ||
        is_singular( 'paksa_product' ) ||
        is_post_type_archive( 'paksa_product' ) ||
        is_tax( 'paksa_product_cat' )
    ) {
        wp_enqueue_style(
            'paksa-products',
            PAKSA_THEME_URI . '/assets/css/products.css',
            array( 'paksa-main' ),
            $version
        );
        // home.css provides .pk-product-card, .pk-industries-grid, .pk-faq-*, .pk-final-cta
        wp_enqueue_style(
            'paksa-home',
            PAKSA_THEME_URI . '/assets/css/home.css',
            array( 'paksa-main' ),
            $version
        );
        // home.js provides the FAQ accordion
        wp_enqueue_script(
            'paksa-home',
            PAKSA_THEME_URI . '/assets/js/home.js',
            array( 'paksa-main' ),
            $version,
            true
        );
        // products.js (JS category filter) only on the marketing listing page
        // Archive and taxonomy use native <a> navigation — no JS filter needed
        if ( is_page_template( 'page-products.php' ) ) {
            wp_enqueue_script(
                'paksa-products',
                PAKSA_THEME_URI . '/assets/js/products.js',
                array( 'paksa-main' ),
                $version,
                true
            );
        }
    }

    // Contact page
    if ( is_page_template( 'page-contact.php' ) ) {
        wp_enqueue_style(
            'paksa-contact',
            PAKSA_THEME_URI . '/assets/css/contact.css',
            array( 'paksa-main' ),
            $version
        );
        wp_enqueue_script(
            'paksa-contact',
            PAKSA_THEME_URI . '/assets/js/contact.js',
            array(),
            $version,
            true
        );
        wp_localize_script( 'paksa-contact', 'paksaContact', array(
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'paksa_contact_nonce' ),
        ) );
    }

    // About page assets
    if ( is_page_template( 'page-about.php' ) ) {
        wp_enqueue_style(
            'paksa-archive',
            PAKSA_THEME_URI . '/assets/css/archive.css',
            array( 'paksa-main' ),
            $version
        );
        wp_enqueue_style(
            'paksa-home',
            PAKSA_THEME_URI . '/assets/css/home.css',
            array( 'paksa-main' ),
            $version
        );
    }

    // Single service page
    if ( is_singular( 'paksa_service' ) ) {
        wp_enqueue_style(
            'paksa-single-service',
            PAKSA_THEME_URI . '/assets/css/single-service.css',
            array( 'paksa-main' ),
            $version
        );
        wp_enqueue_script(
            'paksa-single-service',
            PAKSA_THEME_URI . '/assets/js/single-service.js',
            array(),
            $version,
            true
        );
    }
    // Service archive + taxonomy
    if ( is_post_type_archive( 'paksa_service' ) || is_tax( 'paksa_service_cat' ) ) {
        wp_enqueue_style(
            'paksa-archive',
            PAKSA_THEME_URI . '/assets/css/archive.css',
            array( 'paksa-main' ),
            $version
        );
    }

    // Product archive + taxonomy: also load archive.css for breadcrumbs
    if ( is_post_type_archive( 'paksa_product' ) || is_tax( 'paksa_product_cat' ) ) {
        wp_enqueue_style(
            'paksa-archive',
            PAKSA_THEME_URI . '/assets/css/archive.css',
            array( 'paksa-main' ),
            $version
        );
    }

    // Products page
    if ( is_page_template( 'page-products.php' ) ) {
        wp_enqueue_style(
            'paksa-products-page',
            PAKSA_THEME_URI . '/assets/css/products-page.css',
            array( 'paksa-main' ),
            $version
        );
        wp_enqueue_script(
            'paksa-single-service',
            PAKSA_THEME_URI . '/assets/js/single-service.js',
            array(),
            $version,
            true
        );
    }

    // Services page assets
    if ( is_page_template( 'page-services.php' ) ) {
        wp_enqueue_style(
            'paksa-services',
            PAKSA_THEME_URI . '/assets/css/services.css',
            array( 'paksa-main' ),
            $version
        );
        wp_enqueue_style(
            'paksa-home',
            PAKSA_THEME_URI . '/assets/css/home.css',
            array( 'paksa-main' ),
            $version
        );
        wp_enqueue_script(
            'paksa-home',
            PAKSA_THEME_URI . '/assets/js/home.js',
            array( 'paksa-main' ),
            $version,
            true
        );
        wp_enqueue_script(
            'paksa-services',
            PAKSA_THEME_URI . '/assets/js/services.js',
            array( 'paksa-main' ),
            $version,
            true
        );
    }

    if (is_singular() && comments_open() && get_comment_thread_rss()) {
        wp_enqueue_script('comment-reply');
    }

    // Dynamic logo height from Customizer
    $logo_height = absint( get_theme_mod( 'paksa_logo_height', 48 ) );
    if ( $logo_height && $logo_height !== 48 ) {
        $inline_css = '.custom-logo { height: ' . $logo_height . 'px; max-height: ' . $logo_height . 'px; }';
        wp_add_inline_style( 'paksa-main', $inline_css );
    }
}
add_action('wp_enqueue_scripts', 'paksa_enqueue_assets');

/**
 * Customizer live preview for logo height
 */
function paksa_customizer_preview_js() {
    ?>
    <script>
    ( function( $ ) {
        wp.customize( 'paksa_logo_height', function( value ) {
            value.bind( function( newval ) {
                var h = parseInt( newval, 10 ) || 48;
                document.querySelectorAll( '.custom-logo' ).forEach( function( el ) {
                    el.style.height = h + 'px';
                    el.style.maxHeight = h + 'px';
                } );
            } );
        } );
    } )( jQuery );
    </script>
    <?php
}
add_action( 'customize_preview_init', function() {
    add_action( 'wp_footer', 'paksa_customizer_preview_js' );
} );
