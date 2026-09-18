<?php
/**
 * Paksa Theme — Phase 21 Global Design System.
 *
 * Adds Customizer controls that let users change the global visual personality
 * through the existing --pk-* token system. No new token namespace is created.
 *
 * Controls added:
 *   - Global radius personality (sharp / default / rounded / pill)
 *   - Global shadow intensity (flat / subtle / default / elevated)
 *   - Global motion preference (full / reduced / none)
 *   - Global section spacing (compact / default / spacious)
 *
 * All output is a single <style> block of CSS variable overrides on :root.
 * Style variations (body.paksa-style--*) take precedence via cascade order.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ── Customizer registration ─────────────────────────────────────────────── */

function paksa_register_global_design_controls( $wp_customize ) {

    // Section already exists from customizer.php (paksa_global panel).
    // Add a dedicated sub-section for design system controls.
    $wp_customize->add_section( 'paksa_design_system', array(
        'title'       => __( 'Global Design System', 'paksa-it-solutions' ),
        'description' => __( 'These controls adjust the visual personality of the entire site through the shared design token system.', 'paksa-it-solutions' ),
        'panel'       => 'paksa_global',
        'priority'    => 3,
    ) );

    /* Radius personality */
    $wp_customize->add_setting( 'paksa_radius_personality', array(
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'paksa_radius_personality', array(
        'label'       => __( 'Corner Radius', 'paksa-it-solutions' ),
        'description' => __( 'Controls the roundness of buttons, cards, images, and badges.', 'paksa-it-solutions' ),
        'section'     => 'paksa_design_system',
        'type'        => 'select',
        'choices'     => array(
            'sharp'   => __( 'Sharp (0px)', 'paksa-it-solutions' ),
            'default' => __( 'Default', 'paksa-it-solutions' ),
            'rounded' => __( 'Rounded', 'paksa-it-solutions' ),
            'pill'    => __( 'Pill / Circular', 'paksa-it-solutions' ),
        ),
    ) );

    /* Shadow intensity */
    $wp_customize->add_setting( 'paksa_shadow_intensity', array(
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'paksa_shadow_intensity', array(
        'label'       => __( 'Shadow Intensity', 'paksa-it-solutions' ),
        'description' => __( 'Controls the depth of shadows on cards, buttons, and sections.', 'paksa-it-solutions' ),
        'section'     => 'paksa_design_system',
        'type'        => 'select',
        'choices'     => array(
            'flat'     => __( 'Flat (no shadows)', 'paksa-it-solutions' ),
            'subtle'   => __( 'Subtle', 'paksa-it-solutions' ),
            'default'  => __( 'Default', 'paksa-it-solutions' ),
            'elevated' => __( 'Elevated', 'paksa-it-solutions' ),
        ),
    ) );

    /* Motion preference */
    $wp_customize->add_setting( 'paksa_motion_preference', array(
        'default'           => 'full',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'paksa_motion_preference', array(
        'label'       => __( 'Motion & Transitions', 'paksa-it-solutions' ),
        'description' => __( 'Controls hover transitions and entrance animations site-wide. Reduced and None respect user accessibility preferences.', 'paksa-it-solutions' ),
        'section'     => 'paksa_design_system',
        'type'        => 'select',
        'choices'     => array(
            'full'    => __( 'Full', 'paksa-it-solutions' ),
            'reduced' => __( 'Reduced', 'paksa-it-solutions' ),
            'none'    => __( 'None', 'paksa-it-solutions' ),
        ),
    ) );

    /* Section spacing */
    $wp_customize->add_setting( 'paksa_section_spacing', array(
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'paksa_section_spacing', array(
        'label'       => __( 'Section Spacing', 'paksa-it-solutions' ),
        'description' => __( 'Controls the vertical padding of sections and the gap between content blocks.', 'paksa-it-solutions' ),
        'section'     => 'paksa_design_system',
        'type'        => 'select',
        'choices'     => array(
            'compact'  => __( 'Compact', 'paksa-it-solutions' ),
            'default'  => __( 'Default', 'paksa-it-solutions' ),
            'spacious' => __( 'Spacious', 'paksa-it-solutions' ),
        ),
    ) );
}
add_action( 'customize_register', 'paksa_register_global_design_controls', 18 );

/* ── Token output ────────────────────────────────────────────────────────── */

/**
 * Output CSS variable overrides for the active global design settings.
 * Runs after variables.css so it can override defaults.
 * Style variation overrides (body.paksa-style--*) still take precedence
 * because they are more specific selectors.
 */
function paksa_output_global_design_tokens() {
    $radius    = sanitize_key( get_theme_mod( 'paksa_radius_personality', 'default' ) );
    $shadow    = sanitize_key( get_theme_mod( 'paksa_shadow_intensity', 'default' ) );
    $motion    = sanitize_key( get_theme_mod( 'paksa_motion_preference', 'full' ) );
    $spacing   = sanitize_key( get_theme_mod( 'paksa_section_spacing', 'default' ) );

    $tokens = array();

    /* Radius personalities */
    $radius_map = array(
        'sharp'   => array( 'sm' => '0px',    'md' => '0px',    'lg' => '0px',    'xl' => '0px',    'full' => '0px' ),
        'rounded' => array( 'sm' => '8px',    'md' => '14px',   'lg' => '22px',   'xl' => '32px',   'full' => '9999px' ),
        'pill'    => array( 'sm' => '9999px', 'md' => '9999px', 'lg' => '9999px', 'xl' => '9999px', 'full' => '9999px' ),
    );
    if ( isset( $radius_map[ $radius ] ) ) {
        $r = $radius_map[ $radius ];
        $tokens[] = '--pk-radius-sm:' . $r['sm'];
        $tokens[] = '--pk-radius-md:' . $r['md'];
        $tokens[] = '--pk-radius-lg:' . $r['lg'];
        $tokens[] = '--pk-radius-xl:' . $r['xl'];
        $tokens[] = '--pk-radius-full:' . $r['full'];
    }

    /* Shadow intensities */
    $shadow_map = array(
        'flat'     => array(
            'sm' => 'none',
            'md' => 'none',
            'lg' => 'none',
            'xl' => 'none',
        ),
        'subtle'   => array(
            'sm' => '0 1px 2px rgba(18,22,25,.04)',
            'md' => '0 2px 8px rgba(18,22,25,.05)',
            'lg' => '0 4px 16px rgba(18,22,25,.07)',
            'xl' => '0 8px 28px rgba(18,22,25,.09)',
        ),
        'elevated' => array(
            'sm' => '0 2px 6px rgba(18,22,25,.10)',
            'md' => '0 6px 24px rgba(18,22,25,.14)',
            'lg' => '0 12px 40px rgba(18,22,25,.18)',
            'xl' => '0 20px 64px rgba(18,22,25,.22)',
        ),
    );
    if ( isset( $shadow_map[ $shadow ] ) ) {
        $s = $shadow_map[ $shadow ];
        $tokens[] = '--pk-shadow-sm:' . $s['sm'];
        $tokens[] = '--pk-shadow-md:' . $s['md'];
        $tokens[] = '--pk-shadow-lg:' . $s['lg'];
        $tokens[] = '--pk-shadow-xl:' . $s['xl'];
    }

    /* Motion: reduce or disable transitions globally */
    $transition_map = array(
        'reduced' => array( 'fast' => '100ms ease', 'base' => '150ms ease', 'slow' => '200ms ease' ),
        'none'    => array( 'fast' => '0ms',         'base' => '0ms',        'slow' => '0ms' ),
    );
    if ( isset( $transition_map[ $motion ] ) ) {
        $t = $transition_map[ $motion ];
        $tokens[] = '--pk-transition-fast:' . $t['fast'];
        $tokens[] = '--pk-transition-base:' . $t['base'];
        $tokens[] = '--pk-transition-slow:' . $t['slow'];
    }

    /* Section spacing */
    $spacing_map = array(
        'compact'  => array(
            'section-py' => 'clamp(2rem, 4vw, 4rem)',
            'space-16'   => '3rem',
            'space-20'   => '4rem',
            'space-24'   => '5rem',
        ),
        'spacious' => array(
            'section-py' => 'clamp(6rem, 12vw, 11rem)',
            'space-16'   => '6rem',
            'space-20'   => '8rem',
            'space-24'   => '10rem',
        ),
    );
    if ( isset( $spacing_map[ $spacing ] ) ) {
        $sp = $spacing_map[ $spacing ];
        $tokens[] = '--pk-section-py:' . $sp['section-py'];
        $tokens[] = '--pk-space-16:' . $sp['space-16'];
        $tokens[] = '--pk-space-20:' . $sp['space-20'];
        $tokens[] = '--pk-space-24:' . $sp['space-24'];
    }

    if ( empty( $tokens ) ) {
        return;
    }

    echo '<style id="paksa-global-design-tokens">:root{' . implode( ';', $tokens ) . '}</style>' . "\n";
}
add_action( 'wp_head', 'paksa_output_global_design_tokens', 8 );

/* ── Body class for motion preference ───────────────────────────────────── */

function paksa_global_design_body_classes( $classes ) {
    $motion  = sanitize_key( get_theme_mod( 'paksa_motion_preference', 'full' ) );
    $spacing = sanitize_key( get_theme_mod( 'paksa_section_spacing', 'default' ) );
    $radius  = sanitize_key( get_theme_mod( 'paksa_radius_personality', 'default' ) );

    if ( $motion !== 'full' ) {
        $classes[] = 'paksa-motion--' . $motion;
    }
    if ( $spacing !== 'default' ) {
        $classes[] = 'paksa-spacing--' . $spacing;
    }
    if ( $radius !== 'default' ) {
        $classes[] = 'paksa-radius--' . $radius;
    }
    return $classes;
}
add_filter( 'body_class', 'paksa_global_design_body_classes' );

/* ── Customizer live preview JS ─────────────────────────────────────────── */

function paksa_global_design_preview_js() {
    if ( ! is_customize_preview() ) {
        return;
    }
    ?>
    <script>
    ( function() {
        var styleEl = document.getElementById( 'paksa-global-design-tokens' );
        if ( ! styleEl ) {
            styleEl = document.createElement( 'style' );
            styleEl.id = 'paksa-global-design-tokens-preview';
            document.head.appendChild( styleEl );
        }

        var radiusMap = {
            sharp:   { sm:'0px',    md:'0px',    lg:'0px',    xl:'0px',    full:'0px' },
            rounded: { sm:'8px',    md:'14px',   lg:'22px',   xl:'32px',   full:'9999px' },
            pill:    { sm:'9999px', md:'9999px', lg:'9999px', xl:'9999px', full:'9999px' }
        };
        var shadowMap = {
            flat:     { sm:'none', md:'none', lg:'none', xl:'none' },
            subtle:   { sm:'0 1px 2px rgba(18,22,25,.04)', md:'0 2px 8px rgba(18,22,25,.05)', lg:'0 4px 16px rgba(18,22,25,.07)', xl:'0 8px 28px rgba(18,22,25,.09)' },
            elevated: { sm:'0 2px 6px rgba(18,22,25,.10)', md:'0 6px 24px rgba(18,22,25,.14)', lg:'0 12px 40px rgba(18,22,25,.18)', xl:'0 20px 64px rgba(18,22,25,.22)' }
        };
        var transitionMap = {
            reduced: { fast:'100ms ease', base:'150ms ease', slow:'200ms ease' },
            none:    { fast:'0ms', base:'0ms', slow:'0ms' }
        };
        var spacingMap = {
            compact:  { py:'clamp(2rem,4vw,4rem)',   s16:'3rem', s20:'4rem', s24:'5rem' },
            spacious: { py:'clamp(6rem,12vw,11rem)', s16:'6rem', s20:'8rem', s24:'10rem' }
        };

        function rebuild() {
            var tokens = [];
            var r = radiusMap[ window._pkRadius ];
            if ( r ) {
                tokens.push( '--pk-radius-sm:' + r.sm, '--pk-radius-md:' + r.md,
                             '--pk-radius-lg:' + r.lg, '--pk-radius-xl:' + r.xl,
                             '--pk-radius-full:' + r.full );
            }
            var s = shadowMap[ window._pkShadow ];
            if ( s ) {
                tokens.push( '--pk-shadow-sm:' + s.sm, '--pk-shadow-md:' + s.md,
                             '--pk-shadow-lg:' + s.lg, '--pk-shadow-xl:' + s.xl );
            }
            var t = transitionMap[ window._pkMotion ];
            if ( t ) {
                tokens.push( '--pk-transition-fast:' + t.fast, '--pk-transition-base:' + t.base,
                             '--pk-transition-slow:' + t.slow );
            }
            var sp = spacingMap[ window._pkSpacing ];
            if ( sp ) {
                tokens.push( '--pk-section-py:' + sp.py, '--pk-space-16:' + sp.s16,
                             '--pk-space-20:' + sp.s20, '--pk-space-24:' + sp.s24 );
            }
            styleEl.textContent = tokens.length ? ':root{' + tokens.join(';') + '}' : '';
        }

        wp.customize( 'paksa_radius_personality', function( v ) {
            v.bind( function( val ) { window._pkRadius = val; rebuild(); } );
        } );
        wp.customize( 'paksa_shadow_intensity', function( v ) {
            v.bind( function( val ) { window._pkShadow = val; rebuild(); } );
        } );
        wp.customize( 'paksa_motion_preference', function( v ) {
            v.bind( function( val ) { window._pkMotion = val; rebuild(); } );
        } );
        wp.customize( 'paksa_section_spacing', function( v ) {
            v.bind( function( val ) { window._pkSpacing = val; rebuild(); } );
        } );
    } )();
    </script>
    <?php
}
add_action( 'customize_preview_init', function() {
    add_action( 'wp_footer', 'paksa_global_design_preview_js' );
} );
