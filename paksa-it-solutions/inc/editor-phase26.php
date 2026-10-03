<?php
/**
 * Paksa Theme — Phase 26 Visual Builder Interaction & Container System.
 *
 * Adds:
 *  - Responsive visibility block styles (pk-hide-mobile/tablet/desktop)
 *  - Column width presets as block styles on core/column
 *  - Flexbox direction/justify/align block styles on core/group
 *  - Localized Phase 26 JS payload
 *  - Enqueues editor-phase26.js
 *
 * Does not duplicate anything from earlier phases.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Phase 26 block styles.
 */
function paksa_register_phase26_block_styles() {
    if ( ! function_exists( 'register_block_style' ) ) {
        return;
    }

    // Responsive visibility on any block that supports className
    $visibility_blocks = array( 'core/group', 'core/column', 'core/image', 'core/cover', 'core/columns' );
    foreach ( $visibility_blocks as $block ) {
        register_block_style( $block, array(
            'name'  => 'pk-hide-mobile',
            'label' => __( 'Hide on Mobile', 'paksa-it-solutions' ),
        ) );
        register_block_style( $block, array(
            'name'  => 'pk-hide-tablet',
            'label' => __( 'Hide on Tablet', 'paksa-it-solutions' ),
        ) );
        register_block_style( $block, array(
            'name'  => 'pk-hide-desktop',
            'label' => __( 'Hide on Desktop', 'paksa-it-solutions' ),
        ) );
    }

    // Column width presets on core/column
    $col_widths = array(
        'pk-col-25'  => __( '25% width', 'paksa-it-solutions' ),
        'pk-col-33'  => __( '33% width', 'paksa-it-solutions' ),
        'pk-col-40'  => __( '40% width', 'paksa-it-solutions' ),
        'pk-col-50'  => __( '50% width', 'paksa-it-solutions' ),
        'pk-col-60'  => __( '60% width', 'paksa-it-solutions' ),
        'pk-col-67'  => __( '67% width', 'paksa-it-solutions' ),
        'pk-col-75'  => __( '75% width', 'paksa-it-solutions' ),
    );
    foreach ( $col_widths as $name => $label ) {
        register_block_style( 'core/column', array( 'name' => $name, 'label' => $label ) );
    }

    // Flexbox layout presets on core/group
    $flex_styles = array(
        'pk-flex-row'         => __( 'Flex Row', 'paksa-it-solutions' ),
        'pk-flex-row-center'  => __( 'Flex Row — Centered', 'paksa-it-solutions' ),
        'pk-flex-row-between' => __( 'Flex Row — Space Between', 'paksa-it-solutions' ),
        'pk-flex-col-center'  => __( 'Flex Column — Centered', 'paksa-it-solutions' ),
    );
    foreach ( $flex_styles as $name => $label ) {
        register_block_style( 'core/group', array( 'name' => $name, 'label' => $label ) );
    }
}
add_action( 'init', 'paksa_register_phase26_block_styles', 19 );

/**
 * Enqueue editor-phase26.js and localize its data payload.
 */
function paksa_enqueue_phase26_editor_assets() {
    if ( ! wp_script_is( 'paksa-editor-phase25', 'enqueued' ) ) {
        return;
    }

    wp_enqueue_script(
        'paksa-editor-phase26',
        PAKSA_THEME_URI . '/assets/js/editor-phase26.js',
        array(
            'paksa-editor-phase25',
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

    // Column width presets for the visual width picker
    $col_presets = array(
        array( 'label' => '25%',  'value' => '25%',    'style' => 'pk-col-25' ),
        array( 'label' => '33%',  'value' => '33.33%', 'style' => 'pk-col-33' ),
        array( 'label' => '40%',  'value' => '40%',    'style' => 'pk-col-40' ),
        array( 'label' => '50%',  'value' => '50%',    'style' => 'pk-col-50' ),
        array( 'label' => '60%',  'value' => '60%',    'style' => 'pk-col-60' ),
        array( 'label' => '67%',  'value' => '66.66%', 'style' => 'pk-col-67' ),
        array( 'label' => '75%',  'value' => '75%',    'style' => 'pk-col-75' ),
        array( 'label' => 'Auto', 'value' => '',        'style' => '' ),
    );

    // Layout preset variations for the section layout picker
    $layout_presets = array(
        array( 'label' => '1 Column',      'name' => 'paksa-1col',    'cols' => 1 ),
        array( 'label' => '2 Columns',     'name' => 'paksa-2col',    'cols' => 2 ),
        array( 'label' => '3 Columns',     'name' => 'paksa-3col',    'cols' => 3 ),
        array( 'label' => '4 Columns',     'name' => 'paksa-4col',    'cols' => 4 ),
        array( 'label' => '1/3 + 2/3',    'name' => 'paksa-split-1-2', 'cols' => 2 ),
        array( 'label' => '2/3 + 1/3',    'name' => 'paksa-split-2-1', 'cols' => 2 ),
        array( 'label' => '1/4 + 3/4',    'name' => 'paksa-split-1-3', 'cols' => 2 ),
        array( 'label' => '3/4 + 1/4',    'name' => 'paksa-split-3-1', 'cols' => 2 ),
    );

    wp_localize_script( 'paksa-editor-phase26', 'paksaPhase26', array(
        'colPresets'    => $col_presets,
        'layoutPresets' => $layout_presets,
        'version'       => PAKSA_THEME_VERSION,
    ) );
}
add_action( 'enqueue_block_editor_assets', 'paksa_enqueue_phase26_editor_assets', 26 );
