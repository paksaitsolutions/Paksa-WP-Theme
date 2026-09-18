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

define('PAKSA_THEME_VERSION', '1.1.1');
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
require_once __DIR__ . '/inc/theme-api.php';
require_once __DIR__ . '/inc/updater.php';
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

/**
 * Admin notice on Home page edit screen — redirect editors to Customizer.
 */
function paksa_homepage_editor_notice() {
    $screen = get_current_screen();
    if ( ! $screen || $screen->id !== 'page' ) return;

    $page_id      = isset( $_GET['post'] ) ? (int) $_GET['post'] : 0;
    $home_page_id = (int) get_option( 'page_on_front' );

    if ( ! $page_id || $page_id !== $home_page_id ) return;

    $customizer_url = add_query_arg(
        array( 'autofocus[panel]' => 'paksa_homepage', 'url' => rawurlencode( home_url( '/' ) ) ),
        admin_url( 'customize.php' )
    );
    ?>
    <div class="notice notice-info" style="display:flex;align-items:center;gap:12px;padding:12px 16px;">
        <span style="font-size:20px;">&#9998;</span>
        <p style="margin:0;">
            <strong><?php esc_html_e( 'Homepage content is managed via the Customizer.', 'paksa-it-solutions' ); ?></strong><br>
            <?php esc_html_e( 'All homepage sections (Hero, Services, Products, etc.) are edited in:', 'paksa-it-solutions' ); ?>
            <a href="<?php echo esc_url( $customizer_url ); ?>" class="button button-primary" style="margin-left:8px;">
                <?php esc_html_e( 'Appearance &rarr; Customize &rarr; Homepage', 'paksa-it-solutions' ); ?>
            </a>
        </p>
    </div>
    <?php
}
add_action( 'admin_notices', 'paksa_homepage_editor_notice' );

/**
 * Register Block Patterns
 */
function paksa_register_block_patterns() {
    if ( ! function_exists( 'register_block_pattern' ) ) {
        return;
    }

    $pattern_files = array(
        'hero-standard',
        'hero-split',
        'hero-dark',
        'hero-minimal',
        'heading-display',
        'heading-section',
        'heading-section-left',
        'heading-compact',
        'paragraph-lead',
        'paragraph-callout',
        'paragraph-highlight',
        'paragraph-cta',
        'heading-paragraph-hero',
        'heading-paragraph-section',
        'services-grid',
        'services-process',
        'services-tabs',
        'services-features',
        'services-stats',
        'services-cta',
        'services-categories',
        'services-categories-grid',
        'service-detail',
        'home-hero',
        'home-trust-strip',
        'home-challenge',
        'home-capabilities',
        'home-technology',
        'home-process',
        'home-why-us',
        'home-intelligence',
        'home-differentiation',
        'home-industries',
        'home-outcomes',
        'home-faq',
        'home-final-cta',
    );

    foreach ( $pattern_files as $file ) {
        $path = __DIR__ . '/inc/patterns/' . $file . '.php';
        if ( file_exists( $path ) ) {
            require_once $path;
        }
    }
}
add_action( 'init', 'paksa_register_block_patterns' );

/**
 * Register custom block pattern categories via register_block_pattern_category().
 * Must be called on init before patterns are registered.
 */
function paksa_register_pattern_categories() {
    register_block_pattern_category( 'paksa-hero', array(
        'label' => __( 'Paksa Hero', 'paksa-it-solutions' ),
    ) );
    register_block_pattern_category( 'paksa-headings', array(
        'label' => __( 'Paksa Headings', 'paksa-it-solutions' ),
    ) );
    register_block_pattern_category( 'paksa-paragraphs', array(
        'label' => __( 'Paksa Paragraphs', 'paksa-it-solutions' ),
    ) );
    register_block_pattern_category( 'paksa-services', array(
        'label' => __( 'Paksa Services', 'paksa-it-solutions' ),
    ) );
    register_block_pattern_category( 'paksa-home', array(
        'label' => __( 'Paksa Home', 'paksa-it-solutions' ),
    ) );
}
add_action( 'init', 'paksa_register_pattern_categories', 5 );
