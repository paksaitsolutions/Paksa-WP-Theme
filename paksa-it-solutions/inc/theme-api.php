<?php
/**
 * Paksa Theme — Generic Theme API
 *
 * Provides a stable, business-neutral API for reading site configuration.
 * All functions resolve through the existing Customizer option keys (paksa_*)
 * which are stored in wp_options as theme mods and survive theme updates.
 *
 * ARCHITECTURE:
 *   Generic API function
 *       → reads paksa_* Customizer key (existing DB contract)
 *       → falls back to WordPress core option where appropriate
 *
 * WHY THE OPTION KEYS ARE NOT RENAMED:
 *   Customizer settings are stored in wp_options as theme_mods_{theme-slug}.
 *   Renaming the keys would silently lose all existing configuration on update.
 *   The keys (paksa_phone, paksa_email, etc.) are internal identifiers —
 *   they are never visible to site visitors or shown in public URLs.
 *   The Customizer UI labels are generic (see customizer.php).
 *
 * GITHUB UPDATE SAFETY:
 *   This file is part of the theme code (GitHub-managed).
 *   It reads from the WordPress database (site-managed).
 *   Updating this file via GitHub never overwrites database content.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// =========================================================
// BUSINESS CONTACT INFORMATION
// =========================================================

/**
 * Get the business phone number.
 *
 * @return string Empty string if not configured.
 */
function paksa_get_business_phone() {
    return paksa_get_option( 'paksa_phone', '' );
}

/**
 * Get the business email address.
 * Falls back to WordPress admin email if not configured.
 *
 * @return string
 */
function paksa_get_business_email() {
    $email = paksa_get_option( 'paksa_email', '' );
    if ( empty( $email ) || ! is_email( $email ) ) {
        return get_option( 'admin_email', '' );
    }
    return $email;
}

/**
 * Get the business address.
 *
 * @return string Empty string if not configured.
 */
function paksa_get_business_address() {
    return paksa_get_option( 'paksa_address', '' );
}

/**
 * Get the WhatsApp URL.
 *
 * @return string Empty string if not configured.
 */
function paksa_get_whatsapp_url() {
    return paksa_get_option( 'paksa_whatsapp_url', '' );
}

/**
 * Whether the WhatsApp floating button should be shown.
 *
 * @return bool
 */
function paksa_show_whatsapp_button() {
    return paksa_get_option( 'paksa_whatsapp_show', '1' ) !== '0';
}

// =========================================================
// SOCIAL LINKS
// =========================================================

/**
 * Get all configured social links as an array.
 * Only returns links that have a non-empty URL.
 *
 * @return array[] Each item: ['url' => string, 'label' => string, 'icon' => string]
 */
function paksa_get_social_links() {
    $candidates = array(
        array(
            'url'   => paksa_get_option( 'paksa_social_facebook', '' ),
            'label' => __( 'Facebook', 'paksa-it-solutions' ),
            'icon'  => 'facebook',
        ),
        array(
            'url'   => paksa_get_option( 'paksa_social_twitter', '' ),
            'label' => __( 'Twitter / X', 'paksa-it-solutions' ),
            'icon'  => 'twitter',
        ),
        array(
            'url'   => paksa_get_option( 'paksa_social_linkedin', '' ),
            'label' => __( 'LinkedIn', 'paksa-it-solutions' ),
            'icon'  => 'linkedin',
        ),
        array(
            'url'   => paksa_get_option( 'paksa_social_github', '' ),
            'label' => __( 'GitHub', 'paksa-it-solutions' ),
            'icon'  => 'github',
        ),
    );

    return array_values( array_filter( $candidates, function( $item ) {
        return ! empty( $item['url'] );
    } ) );
}

// =========================================================
// SEO / SCHEMA COMPATIBILITY
// =========================================================

/**
 * Check whether an SEO plugin is active.
 * Alias for paksa_seo_plugin_active() — keeps templates readable.
 *
 * @return bool
 */
function paksa_is_seo_plugin_active() {
    return paksa_seo_plugin_active();
}

// =========================================================
// CONTENT QUERIES
// =========================================================

/**
 * Get published products.
 *
 * @param  array $args Optional WP_Query args to merge.
 * @return WP_Post[]
 */
function paksa_get_products( $args = array() ) {
    $defaults = array(
        'post_type'      => 'paksa_product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
        'no_found_rows'  => true,
    );
    $query = new WP_Query( wp_parse_args( $args, $defaults ) );
    return $query->posts;
}

/**
 * Get published services.
 *
 * @param  array $args Optional WP_Query args to merge.
 * @return WP_Post[]
 */
function paksa_get_services( $args = array() ) {
    $defaults = array(
        'post_type'      => 'paksa_service',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
        'no_found_rows'  => true,
    );
    $query = new WP_Query( wp_parse_args( $args, $defaults ) );
    return $query->posts;
}

/**
 * Get related products for a service.
 * Alias for paksa_get_service_related_products().
 *
 * @param  int $service_id
 * @return int[]
 */
function paksa_get_related_products( $service_id ) {
    return paksa_get_service_related_products( $service_id );
}

/**
 * Get related services for a product.
 * Alias for paksa_get_product_related_services().
 *
 * @param  int $product_id
 * @return int[]
 */
function paksa_get_related_services( $product_id ) {
    return paksa_get_product_related_services( $product_id );
}
