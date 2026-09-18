<?php
/**
 * Paksa IT Solutions — Header Template
 *
 * @package paksa-it-solutions
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <?php paksa_skip_link(); ?>

    <header class="site-header" role="banner">
        <div class="container header-inner">
            <?php echo paksa_get_logo(array('class' => 'site-logo')); ?>

            <nav class="main-nav" aria-label="<?php esc_attr_e('Primary Navigation', 'paksa-it-solutions'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location'  => 'primary',
                    'menu_class'      => 'pk-primary-menu',
                    'depth'           => 2,
                    'fallback_cb'     => false,
                    'items_wrap'      => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
                    'walker'          => new Paksa_Nav_Walker(),
                ));
                ?>
            </nav>

            <div class="nav-cta">
                <a href="<?php echo esc_url( paksa_get_option( 'paksa_cta_primary_url', '/contact/' ) ); ?>" class="btn btn-primary btn-sm">
                    <?php esc_html_e( 'Get in Touch', 'paksa-it-solutions' ); ?>
                </a>
            </div>

            <button class="menu-toggle" aria-controls="mobile-nav" aria-expanded="false" aria-label="<?php esc_attr_e('Open menu', 'paksa-it-solutions'); ?>" type="button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>
    </header>

    <nav id="mobile-nav" class="mobile-nav" aria-label="<?php esc_attr_e('Mobile navigation', 'paksa-it-solutions'); ?>">
        <div class="mobile-nav-header">
            <?php echo paksa_get_logo(array('class' => 'site-logo')); ?>
            <button class="mobile-nav-close" aria-label="<?php esc_attr_e('Close menu', 'paksa-it-solutions'); ?>" type="button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div class="mobile-nav-list">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class'     => 'pk-mobile-menu',
                'depth'          => 2,
                'fallback_cb'    => false,
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            ));
            ?>
        </div>
        <div class="mobile-nav-cta">
            <a href="<?php echo esc_url( paksa_get_option( 'paksa_cta_primary_url', '/contact/' ) ); ?>" class="btn btn-primary">
                <?php esc_html_e( 'Get in Touch', 'paksa-it-solutions' ); ?>
            </a>
        </div>
    </nav>

