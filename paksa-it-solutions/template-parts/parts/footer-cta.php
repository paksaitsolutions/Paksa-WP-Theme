<?php
/**
 * Reusable footer CTA, shown only by the CTA footer variation.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) || paksa_get_footer_variant() !== 'cta' ) {
    return;
}

$heading = paksa_get_option( 'paksa_footer_cta_heading', __( 'Ready for a useful next step?', 'paksa-it-solutions' ) );
$text    = paksa_get_option( 'paksa_footer_cta_text', __( 'Tell us what you are working on and we will help you find the right path forward.', 'paksa-it-solutions' ) );
$button  = paksa_get_option( 'paksa_footer_cta_button', __( 'Start a conversation', 'paksa-it-solutions' ) );
$url     = paksa_get_option( 'paksa_footer_cta_url', '/contact/' );
?>
<section class="pk-footer-cta" aria-labelledby="pk-footer-cta-heading">
    <div class="container pk-footer-cta__inner">
        <div>
            <h2 id="pk-footer-cta-heading"><?php echo esc_html( $heading ); ?></h2>
            <p><?php echo esc_html( $text ); ?></p>
        </div>
        <?php if ( $button && $url ) : ?>
            <a class="btn btn-primary" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $button ); ?></a>
        <?php endif; ?>
    </div>
</section>
