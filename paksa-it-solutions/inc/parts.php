<?php
/**
 * Paksa Theme — global parts configuration.
 *
 * The theme remains compatible with classic PHP templates while exposing
 * reusable, WordPress-controlled header and footer variations.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function paksa_get_header_variant() {
    $variants = array( 'standard', 'two-actions', 'announcement', 'transparent', 'dark', 'minimal', 'centered', 'contact', 'social' );
    $variant  = sanitize_key( paksa_get_option( 'paksa_header_variant', 'standard' ) );
    return in_array( $variant, $variants, true ) ? $variant : 'standard';
}

function paksa_get_footer_variant() {
    $variants = array( 'multi-column', 'simple', 'cta', 'dark', 'social', 'legal', 'company', 'newsletter', 'contact' );
    $variant  = sanitize_key( paksa_get_option( 'paksa_footer_variant', 'multi-column' ) );
    return in_array( $variant, $variants, true ) ? $variant : 'multi-column';
}

/**
 * Add global visual-part controls after the existing global panel is registered.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function paksa_register_part_customizer_settings( $wp_customize ) {
    $wp_customize->add_section( 'paksa_header_options', array(
        'title'    => __( 'Header Layout', 'paksa-it-solutions' ),
        'panel'    => 'paksa_global',
        'priority' => 8,
    ) );
    $wp_customize->add_setting( 'paksa_header_variant', array(
        'default'           => 'standard',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'paksa_header_variant', array(
        'label'       => __( 'Header variation', 'paksa-it-solutions' ),
        'description' => __( 'Menus remain managed in Appearance → Menus.', 'paksa-it-solutions' ),
        'section'     => 'paksa_header_options',
        'type'        => 'select',
        'choices'     => array(
            'standard'     => __( '01 — Navigation and CTA', 'paksa-it-solutions' ),
            'two-actions'  => __( '02 — Navigation and two actions', 'paksa-it-solutions' ),
            'announcement' => __( '03 — Announcement and navigation', 'paksa-it-solutions' ),
            'transparent'  => __( '04 — Transparent hero header', 'paksa-it-solutions' ),
            'dark'         => __( '05 — Dark header', 'paksa-it-solutions' ),
            'minimal'      => __( '06 — Minimal header', 'paksa-it-solutions' ),
            'centered'     => __( '07 — Centered logo', 'paksa-it-solutions' ),
            'contact'      => __( '08 — Contact information and header', 'paksa-it-solutions' ),
            'social'       => __( '09 — Social actions and header', 'paksa-it-solutions' ),
        ),
    ) );
    paksa_customizer_text( $wp_customize, 'paksa_header_secondary_text', 'paksa_header_options', __( 'Secondary action label', 'paksa-it-solutions' ), __( 'View services', 'paksa-it-solutions' ) );
    paksa_customizer_text( $wp_customize, 'paksa_header_secondary_url', 'paksa_header_options', __( 'Secondary action URL', 'paksa-it-solutions' ), '/services/' );
    paksa_customizer_text( $wp_customize, 'paksa_announcement_text', 'paksa_header_options', __( 'Announcement text', 'paksa-it-solutions' ), __( 'Share a timely update, offer, or important notice here.', 'paksa-it-solutions' ) );
    paksa_customizer_text( $wp_customize, 'paksa_announcement_url', 'paksa_header_options', __( 'Announcement link URL', 'paksa-it-solutions' ), '' );

    $wp_customize->add_section( 'paksa_footer_options', array(
        'title'    => __( 'Footer Layout', 'paksa-it-solutions' ),
        'panel'    => 'paksa_global',
        'priority' => 9,
    ) );
    $wp_customize->add_setting( 'paksa_footer_variant', array(
        'default'           => 'multi-column',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'paksa_footer_variant', array(
        'label'   => __( 'Footer variation', 'paksa-it-solutions' ),
        'section' => 'paksa_footer_options',
        'type'    => 'select',
        'choices' => array(
            'multi-column' => __( 'Multi-column footer', 'paksa-it-solutions' ),
            'simple'       => __( 'Simple footer', 'paksa-it-solutions' ),
            'cta'          => __( 'CTA footer', 'paksa-it-solutions' ),
            'dark'         => __( 'Dark footer', 'paksa-it-solutions' ),
            'social'       => __( 'Social footer', 'paksa-it-solutions' ),
            'legal'        => __( 'Legal footer', 'paksa-it-solutions' ),
            'company'      => __( 'Company information footer', 'paksa-it-solutions' ),
            'newsletter'   => __( 'Newsletter footer', 'paksa-it-solutions' ),
            'contact'      => __( 'Contact information footer', 'paksa-it-solutions' ),
        ),
    ) );
    paksa_customizer_text( $wp_customize, 'paksa_footer_cta_heading', 'paksa_footer_options', __( 'Footer CTA heading', 'paksa-it-solutions' ), __( 'Ready for a useful next step?', 'paksa-it-solutions' ) );
    paksa_customizer_text( $wp_customize, 'paksa_footer_cta_text', 'paksa_footer_options', __( 'Footer CTA text', 'paksa-it-solutions' ), __( 'Tell us what you are working on and we will help you find the right path forward.', 'paksa-it-solutions' ) );
    paksa_customizer_text( $wp_customize, 'paksa_footer_cta_button', 'paksa_footer_options', __( 'Footer CTA button label', 'paksa-it-solutions' ), __( 'Start a conversation', 'paksa-it-solutions' ) );
    paksa_customizer_text( $wp_customize, 'paksa_footer_cta_url', 'paksa_footer_options', __( 'Footer CTA button URL', 'paksa-it-solutions' ), '/contact/' );
    paksa_customizer_text( $wp_customize, 'paksa_footer_newsletter_heading', 'paksa_footer_options', __( 'Newsletter heading', 'paksa-it-solutions' ), __( 'Get useful updates', 'paksa-it-solutions' ) );
    paksa_customizer_textarea( $wp_customize, 'paksa_footer_newsletter_text', 'paksa_footer_options', __( 'Newsletter description', 'paksa-it-solutions' ), __( 'Add a newsletter shortcode below to connect your existing email service.', 'paksa-it-solutions' ) );
    paksa_customizer_text( $wp_customize, 'paksa_footer_newsletter_shortcode', 'paksa_footer_options', __( 'Newsletter form shortcode', 'paksa-it-solutions' ), '' );
}
add_action( 'customize_register', 'paksa_register_part_customizer_settings', 20 );
