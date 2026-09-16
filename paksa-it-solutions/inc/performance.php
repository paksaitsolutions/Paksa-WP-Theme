<?php
/**
 * Paksa IT Solutions — Performance
 *
 * @package paksa-it-solutions
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enable Lazy Loading for Images (via WordPress native)
 * WordPress 6.5+ handles loading="lazy" and decoding="async" natively.
 * This filter only adds attributes when not already set by core.
 */
function paksa_enable_lazy_loading($attr) {
    if (is_admin()) {
        return $attr;
    }

    if (!isset($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }

    if (!isset($attr['decoding'])) {
        $attr['decoding'] = 'async';
    }

    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'paksa_enable_lazy_loading');

/**
 * Remove DNS Prefetch for Same-Origin
 *
 * WordPress 6.5+ handles resource hinting more intelligently.
 * This filter only prevents duplicate same-origin prefetches.
 */
function paksa_remove_dns_prefetch($hints, $relation_type) {
    if ('dns-prefetch' === $relation_type) {
        return array_diff($hints, array(home_url()));
    }
    return $hints;
}
add_filter('wp_resource_hints', 'paksa_remove_dns_prefetch', 10, 2);

/**
 * Disable Emoji Scripts
 */
function paksa_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    add_filter('emoji_svg_url', '__return_false');
}
add_action('init', 'paksa_disable_emojis');

/**
 * Optimize Script Loader
 */
function paksa_script_loader_filter($tag, $handle, $src) {
    if (is_admin()) {
        return $tag;
    }

    if (strpos($tag, 'script') !== false && strpos($src, '.js') !== false) {
        $tag = str_replace(' type="text/javascript"', '', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'paksa_script_loader_filter', 10, 3);
