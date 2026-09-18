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
    <?php get_template_part( 'template-parts/parts/announcement' ); ?>
    <?php get_template_part( 'template-parts/parts/header-utility' ); ?>

    <header class="site-header site-header--<?php echo esc_attr( paksa_get_header_variant() ); ?>" role="banner">
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

            <?php get_template_part( 'template-parts/parts/header-actions', null, array( 'variant' => paksa_get_header_variant() ) ); ?>

            <button class="menu-toggle" aria-controls="mobile-nav" aria-expanded="false" aria-label="<?php esc_attr_e('Open menu', 'paksa-it-solutions'); ?>" type="button">
                <?php echo paksa_icon( 'menu' ); ?>
            </button>
        </div>
    </header>

    <nav id="mobile-nav" class="mobile-nav" aria-label="<?php esc_attr_e('Mobile navigation', 'paksa-it-solutions'); ?>">
        <div class="mobile-nav-header">
            <?php echo paksa_get_logo(array('class' => 'site-logo')); ?>
            <button class="mobile-nav-close" aria-label="<?php esc_attr_e('Close menu', 'paksa-it-solutions'); ?>" type="button">
                <?php echo paksa_icon( 'close' ); ?>
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
                'walker'         => new Paksa_Nav_Walker(),
            ));
            ?>
        </div>
        <div class="mobile-nav-cta">
            <a href="<?php echo esc_url( paksa_get_option( 'paksa_cta_primary_url', '/contact/' ) ); ?>" class="btn btn-primary">
                <?php esc_html_e( 'Get in Touch', 'paksa-it-solutions' ); ?>
            </a>
        </div>
    </nav>
