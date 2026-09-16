<?php
/**
 * Paksa IT Solutions — About: CTA
 *
 * Priority: page meta → Customizer → fallback string.
 * Reuses .pk-final-cta CSS from home.css.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID();
$eyebrow = paksa_get_option( 'paksa_cta_eyebrow', __( 'Get Started', 'paksa-it-solutions' ) );
$heading = paksa_page_meta( 'cta_heading', paksa_get_option( 'paksa_cta_heading', __( 'Ready to Work With Us?', 'paksa-it-solutions' ) ), $page_id );
$desc    = paksa_page_meta_textarea( 'cta_description', paksa_get_option( 'paksa_cta_description', '' ), $page_id );
$btn1_t  = paksa_page_meta( 'cta_btn1_text', paksa_get_option( 'paksa_cta_primary_text', __( 'Get a Free Consultation', 'paksa-it-solutions' ) ), $page_id );
$btn1_u  = get_post_meta( $page_id, '_paksa_page_cta_btn1_url', true );
$btn1_u  = $btn1_u ? esc_url_raw( $btn1_u ) : paksa_get_option( 'paksa_cta_primary_url', '#contact' );
$btn2_t  = paksa_page_meta( 'cta_btn2_text', paksa_get_option( 'paksa_cta_secondary_text', '' ), $page_id );
$btn2_u  = get_post_meta( $page_id, '_paksa_page_cta_btn2_url', true );
$btn2_u  = $btn2_u ? esc_url_raw( $btn2_u ) : paksa_get_option( 'paksa_cta_secondary_url', '' );
?>
<section class="pk-final-cta pk-about-cta" id="contact" aria-labelledby="pk-about-cta-heading">
    <div class="container">
        <div class="pk-final-cta-inner pk-animate-on-scroll" data-anim="fade-up">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            <h2 id="pk-about-cta-heading"><?php echo esc_html( $heading ); ?></h2>
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
