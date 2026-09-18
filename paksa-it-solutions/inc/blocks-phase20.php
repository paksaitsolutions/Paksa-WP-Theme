<?php
/**
 * Paksa Theme — Phase 20 composable card blocks.
 *
 * Registers two InnerBlocks-based blocks that replace the monolithic
 * card pattern approach with genuinely composable nested structures:
 *   paksa/product-card  — composable product card
 *   paksa/service-card  — composable service card
 *
 * Both use save() on the JS side (InnerBlocks.Content), so the PHP
 * render callback is only needed for dynamic wrapper attributes.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function paksa_register_phase20_blocks() {
    if ( ! function_exists( 'register_block_type' ) ) {
        return;
    }

    /* ── paksa/product-card ─────────────────────────────────────────────── */
    register_block_type( 'paksa/product-card', array(
        'api_version' => 3,
        'attributes'  => array(
            'variant'      => array( 'type' => 'string',  'default' => 'default' ),
            'showBadge'    => array( 'type' => 'boolean', 'default' => false ),
            'badgeText'    => array( 'type' => 'string',  'default' => '' ),
            'animation'    => array( 'type' => 'string',  'default' => 'none' ),
            'animDelay'    => array( 'type' => 'number',  'default' => 0 ),
            'shadowPreset' => array( 'type' => 'string',  'default' => 'sm' ),
            'hoverEffect'  => array( 'type' => 'string',  'default' => 'lift' ),
        ),
        'supports'    => array(
            'align'   => array( 'left', 'center', 'right' ),
            'color'   => array( 'text' => true, 'background' => true ),
            'spacing' => array( 'margin' => true, 'padding' => true ),
        ),
    ) );

    /* ── paksa/service-card ─────────────────────────────────────────────── */
    register_block_type( 'paksa/service-card', array(
        'api_version' => 3,
        'attributes'  => array(
            'variant'      => array( 'type' => 'string',  'default' => 'default' ),
            'showCategory' => array( 'type' => 'boolean', 'default' => false ),
            'categoryText' => array( 'type' => 'string',  'default' => '' ),
            'animation'    => array( 'type' => 'string',  'default' => 'none' ),
            'animDelay'    => array( 'type' => 'number',  'default' => 0 ),
            'shadowPreset' => array( 'type' => 'string',  'default' => 'sm' ),
            'hoverEffect'  => array( 'type' => 'string',  'default' => 'lift' ),
        ),
        'supports'    => array(
            'align'   => array( 'left', 'center', 'right' ),
            'color'   => array( 'text' => true, 'background' => true ),
            'spacing' => array( 'margin' => true, 'padding' => true ),
        ),
    ) );

    /* ── Additional Phase 20 block styles ───────────────────────────────── */
    if ( ! function_exists( 'register_block_style' ) ) {
        return;
    }

    // Composable card variants
    foreach ( array( 'paksa/product-card', 'paksa/service-card' ) as $block ) {
        register_block_style( $block, array( 'name' => 'dark',     'label' => __( 'Dark',     'paksa-it-solutions' ) ) );
        register_block_style( $block, array( 'name' => 'bordered', 'label' => __( 'Bordered', 'paksa-it-solutions' ) ) );
        register_block_style( $block, array( 'name' => 'glass',    'label' => __( 'Glass',    'paksa-it-solutions' ) ) );
    }

    // Additional core/group card styles for Phase 20 compositions
    $new_group_styles = array(
        'paksa-card-about'   => __( 'Paksa About Card',   'paksa-it-solutions' ),
        'paksa-card-contact' => __( 'Paksa Contact Card', 'paksa-it-solutions' ),
        'paksa-card-faq'     => __( 'Paksa FAQ Card',     'paksa-it-solutions' ),
    );
    foreach ( $new_group_styles as $name => $label ) {
        register_block_style( 'core/group', array( 'name' => $name, 'label' => $label ) );
    }
}
add_action( 'init', 'paksa_register_phase20_blocks', 15 );
