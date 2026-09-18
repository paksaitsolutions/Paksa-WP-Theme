<?php
/**
 * Paksa Theme — Site Chrome (Header & Footer) Configuration.
 *
 * Architecture note
 * -----------------
 * The theme supports two rendering paths:
 *
 *   1. Classic PHP  — header.php / footer.php read paksa_get_header_variant()
 *      directly and apply site-header--{variant} class. This path works as-is.
 *
 *   2. FSE block templates — parts/header.html / parts/footer.html are static
 *      block HTML stored in the database/theme files. They cannot read PHP
 *      Customizer values at render time.
 *
 * Bridge: this file outputs body classes for every site-chrome setting.
 * Both rendering paths inherit body classes, so CSS rules keyed on
 * body.paksa-header--* and body.paksa-footer--* work for both paths.
 *
 * Single source of truth
 * ----------------------
 * All header/footer variant, appearance, behavior, and height settings live
 * here. No parallel system exists in customizer.php, global-design-system.php,
 * or anywhere else.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ── Allowed value registries ────────────────────────────────────────────── */

function paksa_header_variants() {
    return array( 'standard', 'two-actions', 'announcement', 'transparent', 'dark', 'minimal', 'centered', 'contact', 'social' );
}

function paksa_header_appearances() {
    return array( 'solid', 'transparent', 'dark', 'light', 'glass', 'bordered' );
}

function paksa_header_behaviors() {
    return array( 'static', 'sticky', 'sticky-compact', 'hide-on-scroll' );
}

function paksa_header_heights() {
    return array( 'compact', 'standard', 'spacious' );
}

function paksa_footer_variants() {
    return array( 'multi-column', 'simple', 'cta', 'dark', 'social', 'legal', 'company', 'newsletter', 'contact' );
}

/* ── Getters ─────────────────────────────────────────────────────────────── */

function paksa_get_header_variant() {
    $value = sanitize_key( paksa_get_option( 'paksa_header_variant', 'standard' ) );
    return in_array( $value, paksa_header_variants(), true ) ? $value : 'standard';
}

function paksa_get_header_appearance() {
    $value = sanitize_key( paksa_get_option( 'paksa_header_appearance', 'solid' ) );
    return in_array( $value, paksa_header_appearances(), true ) ? $value : 'solid';
}

function paksa_get_header_behavior() {
    $value = sanitize_key( paksa_get_option( 'paksa_header_behavior', 'sticky' ) );
    return in_array( $value, paksa_header_behaviors(), true ) ? $value : 'sticky';
}

function paksa_get_header_height() {
    $value = sanitize_key( paksa_get_option( 'paksa_header_height', 'standard' ) );
    return in_array( $value, paksa_header_heights(), true ) ? $value : 'standard';
}

function paksa_get_footer_variant() {
    $value = sanitize_key( paksa_get_option( 'paksa_footer_variant', 'multi-column' ) );
    return in_array( $value, paksa_footer_variants(), true ) ? $value : 'multi-column';
}

/* ── Body classes — the bridge between Customizer and FSE ────────────────── */

function paksa_site_chrome_body_classes( $classes ) {
    $classes[] = 'paksa-header--' . paksa_get_header_variant();
    $classes[] = 'paksa-header-appearance--' . paksa_get_header_appearance();
    $classes[] = 'paksa-header-behavior--' . paksa_get_header_behavior();
    $classes[] = 'paksa-header-height--' . paksa_get_header_height();
    $classes[] = 'paksa-footer--' . paksa_get_footer_variant();
    return $classes;
}
add_filter( 'body_class', 'paksa_site_chrome_body_classes' );

/* ── CSS token output for height ─────────────────────────────────────────── */

function paksa_site_chrome_tokens() {
    $height_map = array(
        'compact'  => array( 'min-height' => '3.5rem',  'py' => '0.5rem' ),
        'standard' => array( 'min-height' => '4.5rem',  'py' => '0.875rem' ),
        'spacious' => array( 'min-height' => '5.5rem',  'py' => '1.25rem' ),
    );
    $h = paksa_get_header_height();
    $t = isset( $height_map[ $h ] ) ? $height_map[ $h ] : $height_map['standard'];

    echo '<style id="paksa-site-chrome-tokens">:root{'
        . '--pk-header-min-height:' . $t['min-height'] . ';'
        . '--pk-header-py:' . $t['py'] . ';'
        . '}</style>' . "\n";
}
add_action( 'wp_head', 'paksa_site_chrome_tokens', 9 );

/* ── Customizer registration ─────────────────────────────────────────────── */

function paksa_register_part_customizer_settings( $wp_customize ) {

    /* ── Header section ─────────────────────────────────────────────────── */
    $wp_customize->add_section( 'paksa_header_options', array(
        'title'       => __( 'Header', 'paksa-it-solutions' ),
        'description' => __( 'Controls the site header across all templates. Changes apply to both classic PHP templates and FSE block templates via body classes.', 'paksa-it-solutions' ),
        'panel'       => 'paksa_global',
        'priority'    => 8,
    ) );

    /* Layout / variant */
    $wp_customize->add_setting( 'paksa_header_variant', array(
        'default'           => 'standard',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'paksa_header_variant', array(
        'label'       => __( 'Header layout', 'paksa-it-solutions' ),
        'description' => __( 'Menus are managed in Appearance → Menus.', 'paksa-it-solutions' ),
        'section'     => 'paksa_header_options',
        'type'        => 'select',
        'choices'     => array(
            'standard'     => __( '01 — Navigation + CTA', 'paksa-it-solutions' ),
            'two-actions'  => __( '02 — Navigation + two actions', 'paksa-it-solutions' ),
            'announcement' => __( '03 — Announcement bar + navigation', 'paksa-it-solutions' ),
            'transparent'  => __( '04 — Transparent (hero pages)', 'paksa-it-solutions' ),
            'dark'         => __( '05 — Dark header', 'paksa-it-solutions' ),
            'minimal'      => __( '06 — Minimal (logo only)', 'paksa-it-solutions' ),
            'centered'     => __( '07 — Centered logo', 'paksa-it-solutions' ),
            'contact'      => __( '08 — Contact info + navigation', 'paksa-it-solutions' ),
            'social'       => __( '09 — Social links + navigation', 'paksa-it-solutions' ),
        ),
    ) );

    /* Appearance */
    $wp_customize->add_setting( 'paksa_header_appearance', array(
        'default'           => 'solid',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'paksa_header_appearance', array(
        'label'   => __( 'Header appearance', 'paksa-it-solutions' ),
        'section' => 'paksa_header_options',
        'type'    => 'select',
        'choices' => array(
            'solid'      => __( 'Solid (default)', 'paksa-it-solutions' ),
            'transparent'=> __( 'Transparent', 'paksa-it-solutions' ),
            'dark'       => __( 'Dark', 'paksa-it-solutions' ),
            'light'      => __( 'Light / white', 'paksa-it-solutions' ),
            'glass'      => __( 'Glass / frosted', 'paksa-it-solutions' ),
            'bordered'   => __( 'Bordered', 'paksa-it-solutions' ),
        ),
    ) );

    /* Behavior */
    $wp_customize->add_setting( 'paksa_header_behavior', array(
        'default'           => 'sticky',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'paksa_header_behavior', array(
        'label'   => __( 'Header behavior', 'paksa-it-solutions' ),
        'section' => 'paksa_header_options',
        'type'    => 'select',
        'choices' => array(
            'static'        => __( 'Static (scrolls away)', 'paksa-it-solutions' ),
            'sticky'        => __( 'Sticky (stays at top)', 'paksa-it-solutions' ),
            'sticky-compact'=> __( 'Sticky + compact on scroll', 'paksa-it-solutions' ),
            'hide-on-scroll'=> __( 'Hide on scroll down, show on scroll up', 'paksa-it-solutions' ),
        ),
    ) );

    /* Height */
    $wp_customize->add_setting( 'paksa_header_height', array(
        'default'           => 'standard',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'paksa_header_height', array(
        'label'   => __( 'Header height', 'paksa-it-solutions' ),
        'section' => 'paksa_header_options',
        'type'    => 'select',
        'choices' => array(
            'compact'  => __( 'Compact', 'paksa-it-solutions' ),
            'standard' => __( 'Standard', 'paksa-it-solutions' ),
            'spacious' => __( 'Spacious', 'paksa-it-solutions' ),
        ),
    ) );

    /* Secondary CTA */
    paksa_customizer_text( $wp_customize, 'paksa_header_secondary_text', 'paksa_header_options',
        __( 'Secondary action label', 'paksa-it-solutions' ), __( 'View services', 'paksa-it-solutions' ) );
    paksa_customizer_text( $wp_customize, 'paksa_header_secondary_url', 'paksa_header_options',
        __( 'Secondary action URL', 'paksa-it-solutions' ), '/services/' );

    /* Announcement */
    paksa_customizer_text( $wp_customize, 'paksa_announcement_text', 'paksa_header_options',
        __( 'Announcement text', 'paksa-it-solutions' ), '' );
    paksa_customizer_text( $wp_customize, 'paksa_announcement_url', 'paksa_header_options',
        __( 'Announcement link URL', 'paksa-it-solutions' ), '' );

    /* ── Footer section ─────────────────────────────────────────────────── */
    $wp_customize->add_section( 'paksa_footer_options', array(
        'title'       => __( 'Footer', 'paksa-it-solutions' ),
        'description' => __( 'Controls the site footer across all templates via body classes.', 'paksa-it-solutions' ),
        'panel'       => 'paksa_global',
        'priority'    => 9,
    ) );

    $wp_customize->add_setting( 'paksa_footer_variant', array(
        'default'           => 'multi-column',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'paksa_footer_variant', array(
        'label'   => __( 'Footer layout', 'paksa-it-solutions' ),
        'section' => 'paksa_footer_options',
        'type'    => 'select',
        'choices' => array(
            'multi-column' => __( 'Multi-column', 'paksa-it-solutions' ),
            'simple'       => __( 'Simple', 'paksa-it-solutions' ),
            'cta'          => __( 'CTA band + columns', 'paksa-it-solutions' ),
            'dark'         => __( 'Dark enterprise', 'paksa-it-solutions' ),
            'social'       => __( 'Social-focused', 'paksa-it-solutions' ),
            'legal'        => __( 'Legal / minimal', 'paksa-it-solutions' ),
            'company'      => __( 'Company information', 'paksa-it-solutions' ),
            'newsletter'   => __( 'Newsletter', 'paksa-it-solutions' ),
            'contact'      => __( 'Contact information', 'paksa-it-solutions' ),
        ),
    ) );

    /* Footer CTA content */
    paksa_customizer_text( $wp_customize, 'paksa_footer_cta_heading', 'paksa_footer_options',
        __( 'Footer CTA heading', 'paksa-it-solutions' ), __( 'Ready for a useful next step?', 'paksa-it-solutions' ) );
    paksa_customizer_text( $wp_customize, 'paksa_footer_cta_text', 'paksa_footer_options',
        __( 'Footer CTA description', 'paksa-it-solutions' ), '' );
    paksa_customizer_text( $wp_customize, 'paksa_footer_cta_button', 'paksa_footer_options',
        __( 'Footer CTA button label', 'paksa-it-solutions' ), __( 'Start a conversation', 'paksa-it-solutions' ) );
    paksa_customizer_text( $wp_customize, 'paksa_footer_cta_url', 'paksa_footer_options',
        __( 'Footer CTA button URL', 'paksa-it-solutions' ), '/contact/' );

    /* Newsletter */
    paksa_customizer_text( $wp_customize, 'paksa_footer_newsletter_heading', 'paksa_footer_options',
        __( 'Newsletter heading', 'paksa-it-solutions' ), __( 'Get useful updates', 'paksa-it-solutions' ) );
    paksa_customizer_textarea( $wp_customize, 'paksa_footer_newsletter_text', 'paksa_footer_options',
        __( 'Newsletter description', 'paksa-it-solutions' ), '' );
    paksa_customizer_text( $wp_customize, 'paksa_footer_newsletter_shortcode', 'paksa_footer_options',
        __( 'Newsletter form shortcode', 'paksa-it-solutions' ), '' );
}
add_action( 'customize_register', 'paksa_register_part_customizer_settings', 20 );

/* ── Live Customizer preview (postMessage) ───────────────────────────────── */

function paksa_site_chrome_preview_js() {
    if ( ! is_customize_preview() ) {
        return;
    }
    ?>
    <script>
    ( function() {
        var headerClasses = ['paksa-header--standard','paksa-header--two-actions','paksa-header--announcement',
            'paksa-header--transparent','paksa-header--dark','paksa-header--minimal','paksa-header--centered',
            'paksa-header--contact','paksa-header--social'];
        var appearanceClasses = ['paksa-header-appearance--solid','paksa-header-appearance--transparent',
            'paksa-header-appearance--dark','paksa-header-appearance--light','paksa-header-appearance--glass',
            'paksa-header-appearance--bordered'];
        var behaviorClasses = ['paksa-header-behavior--static','paksa-header-behavior--sticky',
            'paksa-header-behavior--sticky-compact','paksa-header-behavior--hide-on-scroll'];
        var heightClasses = ['paksa-header-height--compact','paksa-header-height--standard','paksa-header-height--spacious'];
        var footerClasses = ['paksa-footer--multi-column','paksa-footer--simple','paksa-footer--cta',
            'paksa-footer--dark','paksa-footer--social','paksa-footer--legal','paksa-footer--company',
            'paksa-footer--newsletter','paksa-footer--contact'];

        var heightTokens = {
            compact:  { min: '3.5rem',  py: '0.5rem' },
            standard: { min: '4.5rem',  py: '0.875rem' },
            spacious: { min: '5.5rem',  py: '1.25rem' }
        };

        function swapClass( remove, add ) {
            remove.forEach( function(c) { document.body.classList.remove(c); } );
            document.body.classList.add( add );
        }

        wp.customize( 'paksa_header_variant', function(v) {
            v.bind( function(val) { swapClass( headerClasses, 'paksa-header--' + val ); } );
        } );
        wp.customize( 'paksa_header_appearance', function(v) {
            v.bind( function(val) { swapClass( appearanceClasses, 'paksa-header-appearance--' + val ); } );
        } );
        wp.customize( 'paksa_header_behavior', function(v) {
            v.bind( function(val) { swapClass( behaviorClasses, 'paksa-header-behavior--' + val ); } );
        } );
        wp.customize( 'paksa_header_height', function(v) {
            v.bind( function(val) {
                swapClass( heightClasses, 'paksa-header-height--' + val );
                var t = heightTokens[val] || heightTokens.standard;
                var el = document.getElementById('paksa-site-chrome-tokens');
                if ( el ) {
                    el.textContent = ':root{--pk-header-min-height:' + t.min + ';--pk-header-py:' + t.py + ';}';
                }
            } );
        } );
        wp.customize( 'paksa_footer_variant', function(v) {
            v.bind( function(val) { swapClass( footerClasses, 'paksa-footer--' + val ); } );
        } );
    } )();
    </script>
    <?php
}
add_action( 'customize_preview_init', function() {
    add_action( 'wp_footer', 'paksa_site_chrome_preview_js' );
} );
