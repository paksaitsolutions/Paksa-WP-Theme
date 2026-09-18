<?php
/**
 * Paksa Theme — global visual-style variations.
 *
 * Each option changes the existing --pk-* component primitives. This keeps the
 * classic templates, Gutenberg patterns, and editor system on one visual axis.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function paksa_get_style_variation() {
    $allowed = array( 'modern', 'minimal', 'corporate', 'creative', 'elegant' );
    $value   = sanitize_key( paksa_get_option( 'paksa_style_variation', 'modern' ) );
    return in_array( $value, $allowed, true ) ? $value : 'modern';
}

function paksa_add_style_variation_body_class( $classes ) {
    $classes[] = 'paksa-style--' . paksa_get_style_variation();
    return $classes;
}
add_filter( 'body_class', 'paksa_add_style_variation_body_class' );

function paksa_register_style_variation_setting( $wp_customize ) {
    $wp_customize->add_section( 'paksa_style_variation', array(
        'title'    => __( 'Visual Style', 'paksa-it-solutions' ),
        'panel'    => 'paksa_global',
        'priority' => 2,
    ) );
    $wp_customize->add_setting( 'paksa_style_variation', array(
        'default'           => 'modern',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'paksa_style_variation', array(
        'label'       => __( 'Visual personality', 'paksa-it-solutions' ),
        'description' => __( 'Applies shared color relationships, radius, shadows, and button/card treatment without changing content.', 'paksa-it-solutions' ),
        'section'     => 'paksa_style_variation',
        'type'        => 'select',
        'choices'     => array(
            'modern'    => __( 'Modern', 'paksa-it-solutions' ),
            'minimal'   => __( 'Minimal', 'paksa-it-solutions' ),
            'corporate' => __( 'Corporate', 'paksa-it-solutions' ),
            'creative'  => __( 'Creative', 'paksa-it-solutions' ),
            'elegant'   => __( 'Elegant', 'paksa-it-solutions' ),
        ),
    ) );
}
add_action( 'customize_register', 'paksa_register_style_variation_setting', 15 );
