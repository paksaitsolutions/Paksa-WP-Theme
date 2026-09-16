<?php
/**
 * Paksa IT Solutions — Footer Template
 *
 * @package paksa-it-solutions
 */

if (!defined('ABSPATH')) {
    exit;
}
?>

    <footer class="site-footer" role="contentinfo">
        <div class="container footer-grid">
            <div class="footer-brand">
                <?php echo paksa_get_logo(array('class' => 'site-logo', 'show_text' => true)); ?>
                <p><?php esc_html_e('Technology That Moves Business Forward.', 'paksa-it-solutions'); ?></p>
                <div class="footer-social">
                    <?php
                    $social_links = array(
                        array( 'url' => paksa_get_option( 'paksa_social_facebook', '' ), 'label' => __( 'Facebook', 'paksa-it-solutions' ) ),
                        array( 'url' => paksa_get_option( 'paksa_social_twitter', '' ),  'label' => __( 'Twitter', 'paksa-it-solutions' ) ),
                        array( 'url' => paksa_get_option( 'paksa_social_linkedin', '' ), 'label' => __( 'LinkedIn', 'paksa-it-solutions' ) ),
                        array( 'url' => paksa_get_option( 'paksa_social_github', '' ),   'label' => __( 'GitHub', 'paksa-it-solutions' ) ),
                    );
                    foreach ( $social_links as $link ) :
                        if ( empty( $link['url'] ) ) continue;
                        ?>
                        <a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $link['label'] ); ?>">
                            <?php echo esc_html( $link['label'] ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="footer-column">
                <h3 class="footer-heading"><?php esc_html_e('Company', 'paksa-it-solutions'); ?></h3>
                <nav class="footer-links" aria-label="<?php esc_attr_e('Footer Navigation', 'paksa-it-solutions'); ?>">
                    <?php
                    if ( has_nav_menu( 'footer' ) ) {
                        wp_nav_menu( array(
                            'theme_location' => 'footer',
                            'menu_class'     => 'pk-footer-menu',
                            'depth'          => 1,
                            'fallback_cb'    => false,
                            'container'      => false,
                            'items_wrap'     => '%3$s',
                            'walker'         => new Paksa_Footer_Nav_Walker(),
                        ) );
                    }
                    ?>
                </nav>
            </div>

            <div class="footer-column">
                <h3 class="footer-heading"><?php esc_html_e('Solutions', 'paksa-it-solutions'); ?></h3>
                <?php if ( has_nav_menu( 'footer-solutions' ) ) : ?>
                    <nav class="footer-links" aria-label="<?php esc_attr_e('Footer Solutions Links', 'paksa-it-solutions'); ?>">
                        <?php wp_nav_menu( array(
                            'theme_location' => 'footer-solutions',
                            'depth'          => 1,
                            'fallback_cb'    => false,
                            'container'      => false,
                            'items_wrap'     => '%3$s',
                            'walker'         => new Paksa_Footer_Nav_Walker(),
                        ) ); ?>
                    </nav>
                <?php endif; ?>
            </div>

            <div class="footer-column">
                <h3 class="footer-heading"><?php esc_html_e('Products', 'paksa-it-solutions'); ?></h3>
                <?php if ( has_nav_menu( 'footer-products' ) ) : ?>
                    <nav class="footer-links" aria-label="<?php esc_attr_e('Footer Products Links', 'paksa-it-solutions'); ?>">
                        <?php wp_nav_menu( array(
                            'theme_location' => 'footer-products',
                            'depth'          => 1,
                            'fallback_cb'    => false,
                            'container'      => false,
                            'items_wrap'     => '%3$s',
                            'walker'         => new Paksa_Footer_Nav_Walker(),
                        ) ); ?>
                    </nav>
                <?php endif; ?>
            </div>

            <div class="footer-column">
                <h3 class="footer-heading"><?php esc_html_e('Resources', 'paksa-it-solutions'); ?></h3>
                <?php if ( has_nav_menu( 'footer-resources' ) ) : ?>
                    <nav class="footer-links" aria-label="<?php esc_attr_e('Footer Resources Links', 'paksa-it-solutions'); ?>">
                        <?php wp_nav_menu( array(
                            'theme_location' => 'footer-resources',
                            'depth'          => 1,
                            'fallback_cb'    => false,
                            'container'      => false,
                            'items_wrap'     => '%3$s',
                            'walker'         => new Paksa_Footer_Nav_Walker(),
                        ) ); ?>
                    </nav>
                <?php endif; ?>
            </div>
        </div>

        <div class="container footer-bottom">
            <p>
                <?php
                printf(
                    esc_html__( 'Copyright © %1$s %2$s', 'paksa-it-solutions' ),
                    esc_html( wp_date( 'Y' ) ),
                    esc_html( get_bloginfo( 'name', 'display' ) )
                );
                ?>
            </p>
            <?php if ( has_nav_menu( 'footer-legal' ) ) : ?>
                <nav class="footer-bottom-links" aria-label="<?php esc_attr_e('Legal Links', 'paksa-it-solutions'); ?>">
                    <?php wp_nav_menu( array(
                        'theme_location' => 'footer-legal',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'walker'         => new Paksa_Footer_Nav_Walker(),
                    ) ); ?>
                </nav>
            <?php endif; ?>
        </div>
    </footer>

    <?php get_template_part( 'template-parts/components/whatsapp-fab' ); ?>

    <?php wp_footer(); ?>
</body>
</html>
