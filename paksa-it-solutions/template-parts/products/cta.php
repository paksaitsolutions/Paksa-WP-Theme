<?php
/**
 * Paksa IT Solutions — Products Listing: CTA
 *
 * Reuses .pk-final-cta CSS from home.css.
 * Priority: page meta → Customizer → fallback string.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID();
$eyebrow = paksa_get_option( 'paksa_cta_eyebrow', __( 'Get Started', 'paksa-it-solutions' ) );
$heading = get_post_meta( $page_id, '_paksa_prod_listing_cta_heading', true )
          ?: paksa_get_option( 'paksa_cta_heading', __( 'Ready to See a Product Demo?', 'paksa-it-solutions' ) );
$desc    = get_post_meta( $page_id, '_paksa_prod_listing_cta_desc', true )
          ?: paksa_get_option( 'paksa_cta_description', __( "Let's walk through the product that fits your business and discuss how it can be implemented for your specific requirements.", 'paksa-it-solutions' ) );
$btn1_t  = get_post_meta( $page_id, '_paksa_prod_listing_cta_btn1_text', true )
          ?: paksa_get_option( 'paksa_cta_primary_text', __( 'Request a Demo', 'paksa-it-solutions' ) );
$btn1_u  = get_post_meta( $page_id, '_paksa_prod_listing_cta_btn1_url', true )
          ?: paksa_get_option( 'paksa_cta_primary_url', '#contact' );
$btn2_t  = get_post_meta( $page_id, '_paksa_prod_listing_cta_btn2_text', true )
          ?: paksa_get_option( 'paksa_cta_secondary_text', __( 'Contact Us', 'paksa-it-solutions' ) );
$btn2_u  = get_post_meta( $page_id, '_paksa_prod_listing_cta_btn2_url', true )
          ?: paksa_get_option( 'paksa_cta_secondary_url', '#contact' );
?>
<section class="pk-final-cta pk-prod-cta" id="contact" aria-labelledby="pk-prod-cta-heading">
    <div class="container">
        <div class="pk-final-cta-inner pk-animate-on-scroll" data-anim="fade-up">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            <h2 id="pk-prod-cta-heading"><?php echo esc_html( $heading ); ?></h2>
            <?php if ( $desc ) : ?>
                <p class="body-large"><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
            <div class="pk-final-cta-actions">
                <?php if ( $btn1_t && $btn1_u ) : ?>
                    <a href="<?php echo esc_url( $btn1_u ); ?>" class="btn btn-primary"><?php echo esc_html( $btn1_t ); ?></a>
                <?php endif; ?>
                <?php if ( $btn2_t && $btn2_u ) : ?>
                    <a href="<?php echo esc_url( $btn2_u ); ?>" class="btn btn-outline"><?php echo esc_html( $btn2_t ); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
