<?php
/**
 * Paksa IT Solutions — Single Product: CTA
 *
 * Reuses .pk-final-cta CSS from home.css.
 * Priority: product meta → Customizer → fallback string.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$prod_id = get_the_ID();
$eyebrow = paksa_get_option( 'paksa_cta_eyebrow', __( 'Get Started', 'paksa-it-solutions' ) );
$heading = paksa_prod_meta( 'cta_heading', paksa_get_option( 'paksa_cta_heading', __( 'Ready to See This Product in Action?', 'paksa-it-solutions' ) ), $prod_id );
$desc    = paksa_prod_meta_textarea( 'cta_description', paksa_get_option( 'paksa_cta_description', __( "Let's arrange a demonstration and discuss how this product can be implemented for your specific requirements.", 'paksa-it-solutions' ) ), $prod_id );
$btn1_t  = paksa_prod_meta( 'cta_btn1_text', paksa_get_option( 'paksa_cta_primary_text', __( 'Request a Demo', 'paksa-it-solutions' ) ), $prod_id );
$btn1_u  = paksa_prod_meta_url( 'cta_btn1_url', paksa_get_option( 'paksa_cta_primary_url', '#contact' ), $prod_id );
$btn2_t  = paksa_prod_meta( 'cta_btn2_text', paksa_get_option( 'paksa_cta_secondary_text', __( 'Contact Us', 'paksa-it-solutions' ) ), $prod_id );
$btn2_u  = paksa_prod_meta_url( 'cta_btn2_url', paksa_get_option( 'paksa_cta_secondary_url', '#contact' ), $prod_id );
?>
<section class="pk-final-cta pk-prod-single-cta" id="contact" aria-labelledby="pk-prod-single-cta-heading">
    <div class="container">
        <div class="pk-final-cta-inner pk-animate-on-scroll" data-anim="fade-up">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            <h2 id="pk-prod-single-cta-heading"><?php echo esc_html( $heading ); ?></h2>
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
