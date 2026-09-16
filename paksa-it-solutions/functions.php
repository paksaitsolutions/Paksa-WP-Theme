<?php
/**
 * Paksa IT Solutions — Theme Functions
 *
 * @package paksa-it-solutions
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('PAKSA_THEME_VERSION', '1.0.0');
define('PAKSA_THEME_DIR', get_template_directory());
define('PAKSA_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function paksa_theme_setup() {
    load_theme_textdomain('paksa-it-solutions', PAKSA_THEME_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'comment-list',
        'comment-form',
        'search-form',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('align-wide');
    add_theme_support('editor-styles');
    add_theme_support('editor-color-palette');
    add_theme_support('wp-block-styles');

    register_nav_menus(array(
        'primary'          => __('Primary Navigation', 'paksa-it-solutions'),
        'footer'           => __('Footer Navigation', 'paksa-it-solutions'),
        'footer-solutions' => __('Footer Solutions', 'paksa-it-solutions'),
        'footer-products'  => __('Footer Products', 'paksa-it-solutions'),
        'footer-resources' => __('Footer Resources', 'paksa-it-solutions'),
        'footer-legal'     => __('Footer Legal Links', 'paksa-it-solutions'),
    ));
    // Social links are managed via Customizer → Global Site Settings → Social Media Links.
    // No social menu location is registered to avoid duplicate sources of truth.

    add_image_size('paksa-thumb', 375, 250, true);
    add_image_size('paksa-medium', 768, 512, true);
    add_image_size('paksa-large', 1280, 720, true);
}
add_action('after_setup_theme', 'paksa_theme_setup');

require_once __DIR__ . '/inc/enqueue.php';
require_once __DIR__ . '/inc/security.php';
require_once __DIR__ . '/inc/performance.php';
require_once __DIR__ . '/inc/accessibility.php';
require_once __DIR__ . '/inc/template-functions.php';
require_once __DIR__ . '/inc/template-tags.php';
require_once __DIR__ . '/inc/customizer.php';
require_once __DIR__ . '/inc/icons.php';
require_once __DIR__ . '/inc/nav-walker.php';
require_once __DIR__ . '/inc/services-meta.php';
require_once __DIR__ . '/inc/cpt.php';
require_once __DIR__ . '/inc/product-meta.php';
require_once __DIR__ . '/inc/service-cpt.php';
require_once __DIR__ . '/inc/service-meta.php';
require_once __DIR__ . '/inc/page-meta.php';
require_once __DIR__ . '/inc/products-listing-meta.php';
require_once __DIR__ . '/inc/contact-form.php';
