<?php
/**
 * Paksa Theme — Phase 25 Visual Builder registration.
 *
 * Registers additional block styles, localizes the Phase 25 JS payload,
 * and enqueues editor-phase25.js. Does not duplicate anything from
 * editor-controls.php, visual-system.php, or earlier phase files.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Phase 25 block styles not already registered in earlier phases.
 */
function paksa_register_phase25_block_styles() {
    if ( ! function_exists( 'register_block_style' ) ) {
        return;
    }

    // core/image — hover zoom (already in visual-system.php as paksa-image-zoom)
    // core/image — overlay on hover
    register_block_style( 'core/image', array(
        'name'  => 'paksa-overlay-hover',
        'label' => __( 'Paksa Overlay on Hover', 'paksa-it-solutions' ),
    ) );

    // core/columns — equal height cards
    register_block_style( 'core/columns', array(
        'name'  => 'paksa-equal-height',
        'label' => __( 'Paksa Equal Height', 'paksa-it-solutions' ),
    ) );

    // core/columns — masonry-like gap
    register_block_style( 'core/columns', array(
        'name'  => 'paksa-tight-gap',
        'label' => __( 'Paksa Tight Gap', 'paksa-it-solutions' ),
    ) );

    // core/group — highlight band (accent-light bg, left border)
    register_block_style( 'core/group', array(
        'name'  => 'paksa-highlight-band',
        'label' => __( 'Paksa Highlight Band', 'paksa-it-solutions' ),
    ) );

    // core/group — sticky sidebar
    register_block_style( 'core/group', array(
        'name'  => 'paksa-sticky',
        'label' => __( 'Paksa Sticky', 'paksa-it-solutions' ),
    ) );

    // core/paragraph — balance (text-wrap: balance)
    register_block_style( 'core/paragraph', array(
        'name'  => 'paksa-balanced',
        'label' => __( 'Paksa Balanced', 'paksa-it-solutions' ),
    ) );

    // core/heading — underline accent
    register_block_style( 'core/heading', array(
        'name'  => 'paksa-underline',
        'label' => __( 'Paksa Underline Accent', 'paksa-it-solutions' ),
    ) );

    // core/button — icon-only (square, icon-sized)
    register_block_style( 'core/button', array(
        'name'  => 'paksa-button-icon',
        'label' => __( 'Paksa Icon Button', 'paksa-it-solutions' ),
    ) );

    // core/button — large CTA
    register_block_style( 'core/button', array(
        'name'  => 'paksa-button-large',
        'label' => __( 'Paksa Large', 'paksa-it-solutions' ),
    ) );
}
add_action( 'init', 'paksa_register_phase25_block_styles', 18 );

/**
 * Localize Phase 25 data payload and enqueue editor-phase25.js.
 * Runs after paksa_enqueue_visual_editor_assets (priority 10).
 */
function paksa_enqueue_phase25_editor_assets() {
    if ( ! wp_script_is( 'paksa-editor-phase20', 'enqueued' ) ) {
        return;
    }

    wp_enqueue_script(
        'paksa-editor-phase25',
        PAKSA_THEME_URI . '/assets/js/editor-phase25.js',
        array(
            'paksa-editor-phase20',
            'wp-blocks',
            'wp-block-editor',
            'wp-components',
            'wp-element',
            'wp-dom-ready',
            'wp-hooks',
            'wp-compose',
            'wp-data',
        ),
        PAKSA_THEME_VERSION,
        true
    );

    // Palette colours for ColorPalette controls — mirrors theme.json palette
    $palette = array(
        array( 'name' => __( 'Primary',         'paksa-it-solutions' ), 'color' => '#6192f8' ),
        array( 'name' => __( 'Primary Hover',   'paksa-it-solutions' ), 'color' => '#4a7ef5' ),
        array( 'name' => __( 'Dark',            'paksa-it-solutions' ), 'color' => '#121619' ),
        array( 'name' => __( 'Accent Light',    'paksa-it-solutions' ), 'color' => '#eef3fe' ),
        array( 'name' => __( 'Background',      'paksa-it-solutions' ), 'color' => '#ffffff' ),
        array( 'name' => __( 'Background Alt',  'paksa-it-solutions' ), 'color' => '#f8f9fc' ),
        array( 'name' => __( 'Text',            'paksa-it-solutions' ), 'color' => '#1d1d1d' ),
        array( 'name' => __( 'Text Secondary',  'paksa-it-solutions' ), 'color' => '#555f6d' ),
        array( 'name' => __( 'Text Muted',      'paksa-it-solutions' ), 'color' => '#8a94a0' ),
        array( 'name' => __( 'Border',          'paksa-it-solutions' ), 'color' => '#e6e8ea' ),
        array( 'name' => __( 'Success',         'paksa-it-solutions' ), 'color' => '#12b76a' ),
        array( 'name' => __( 'Warning',         'paksa-it-solutions' ), 'color' => '#f79009' ),
        array( 'name' => __( 'Error',           'paksa-it-solutions' ), 'color' => '#f04438' ),
        array( 'name' => __( 'White',           'paksa-it-solutions' ), 'color' => '#ffffff' ),
        array( 'name' => __( 'Black',           'paksa-it-solutions' ), 'color' => '#000000' ),
    );

    // Gradient presets — mirrors theme.json gradients
    $gradients = array(
        array( 'name' => __( 'Primary Flow',  'paksa-it-solutions' ), 'gradient' => 'linear-gradient(135deg, #6192f8 0%, #7c5cfc 100%)' ),
        array( 'name' => __( 'Deep Surface',  'paksa-it-solutions' ), 'gradient' => 'linear-gradient(135deg, #121619 0%, #252d36 100%)' ),
        array( 'name' => __( 'Soft Accent',   'paksa-it-solutions' ), 'gradient' => 'linear-gradient(135deg, #eef3fe 0%, #f8f9fc 100%)' ),
        array( 'name' => __( 'Warm Glow',     'paksa-it-solutions' ), 'gradient' => 'linear-gradient(135deg, #6192f8 0%, #f79009 100%)' ),
        array( 'name' => __( 'Cool Depth',    'paksa-it-solutions' ), 'gradient' => 'linear-gradient(180deg, #121619 0%, #1d2329 100%)' ),
    );

    // Spacing presets for UnitControl / BoxControl helpers
    $spacing_presets = array(
        array( 'label' => '0',       'value' => '0' ),
        array( 'label' => '0.5rem',  'value' => '0.5rem' ),
        array( 'label' => '0.75rem', 'value' => '0.75rem' ),
        array( 'label' => '1rem',    'value' => '1rem' ),
        array( 'label' => '1.5rem',  'value' => '1.5rem' ),
        array( 'label' => '2rem',    'value' => '2rem' ),
        array( 'label' => '3rem',    'value' => '3rem' ),
        array( 'label' => '4rem',    'value' => '4rem' ),
        array( 'label' => '5rem',    'value' => '5rem' ),
        array( 'label' => '7rem',    'value' => '7rem' ),
        array( 'label' => '9rem',    'value' => '9rem' ),
    );

    wp_localize_script( 'paksa-editor-phase25', 'paksaPhase25', array(
        'palette'         => $palette,
        'gradients'       => $gradients,
        'spacingPresets'  => $spacing_presets,
        'units'           => array( 'px', 'rem', '%', 'vw', 'vh', 'em' ),
        'version'         => PAKSA_THEME_VERSION,
    ) );
}
add_action( 'enqueue_block_editor_assets', 'paksa_enqueue_phase25_editor_assets', 25 );
