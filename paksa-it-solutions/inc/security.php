<?php
/**
 * Paksa IT Solutions — Security
 *
 * @package paksa-it-solutions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Security Headers
 */
function paksa_security_headers() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');

    if (!is_admin()) {
        header('X-Download-Options: noopen');
        header('X-Permitted-Cross-Domain-Policies: none');
    }
}
add_action('send_headers', 'paksa_security_headers');

/**
 * Remove WordPress Version from Head
 */
function paksa_remove_wp_version() {
    return '';
}
add_filter('the_generator', 'paksa_remove_wp_version');

/**
 * Disable XML-RPC (unless needed)
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Disable Embeds
 */
function paksa_disable_embeds() {
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    remove_action('rest_api_init', 'wp_oembed_register_route');
    remove_filter('rest_api_dispatch', 'wp_oembed_parse_response');
    remove_action('wp_head', 'wp_embed_add_host_js');
    remove_action('template_redirect', 'wp_oembed_handler');
    remove_action('do_pings', 'wp_oembed_remove_pings');
}
add_action('init', 'paksa_disable_embeds', 999);

/**
 * Limit Login Attempts (basic)
 */
function paksa_limit_login_protections() {
    if (!function_exists('limit_login_protections')) {
        add_action('wp_login_failed', function ($username) {
                $ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
                set_transient('paksa_login_failed_' . md5($ip), time(), HOUR_IN_SECONDS);
            });
    }
}
add_action('init', 'paksa_limit_login_protections');

/**
 * Disable File Editing in Dashboard
 */
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
    define( 'DISALLOW_FILE_EDIT', true );
}

// NOTE: FORCE_SSL_ADMIN must be defined in wp-config.php, not in theme code.
// WordPress evaluates SSL enforcement before any theme is loaded.
// Add this to wp-config.php on production: define( 'FORCE_SSL_ADMIN', true );
