<?php
/**
 * Reusable newsletter footer composition.
 * A configured shortcode renders the site's chosen email provider; no duplicate
 * newsletter form or separate subscription persistence is introduced.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) || paksa_get_footer_variant() !== 'newsletter' ) {
    return;
}

$heading   = paksa_get_option( 'paksa_footer_newsletter_heading', __( 'Get useful updates', 'paksa-it-solutions' ) );
$text      = paksa_get_option( 'paksa_footer_newsletter_text', __( 'Add a newsletter shortcode below to connect your existing email service.', 'paksa-it-solutions' ) );
$shortcode = paksa_get_option( 'paksa_footer_newsletter_shortcode', '' );
?>
<section class="pk-footer-newsletter" aria-labelledby="pk-footer-newsletter-heading">
    <div class="container pk-footer-newsletter__inner">
        <div>
            <h2 id="pk-footer-newsletter-heading"><?php echo esc_html( $heading ); ?></h2>
            <?php if ( $text ) : ?><p><?php echo esc_html( $text ); ?></p><?php endif; ?>
        </div>
        <div class="pk-footer-newsletter__form">
            <?php if ( $shortcode ) : ?>
                <?php echo do_shortcode( $shortcode ); ?>
            <?php else : ?>
                <a class="btn btn-outline" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact us', 'paksa-it-solutions' ); ?></a>
            <?php endif; ?>
        </div>
    </div>
</section>
