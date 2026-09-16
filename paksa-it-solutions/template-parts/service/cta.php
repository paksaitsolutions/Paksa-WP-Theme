<?php
/**
 * Paksa IT Solutions — Single Service: CTA
 *
 * Priority: service post meta → Customizer → fallback string.
 * Reuses .pk-final-cta CSS from home.css.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$svc_id  = get_the_ID();
$eyebrow = paksa_get_option( 'paksa_cta_eyebrow', __( 'Get Started', 'paksa-it-solutions' ) );
$heading = paksa_svc_meta( 'cta_heading', paksa_get_option( 'paksa_cta_heading', __( 'Ready to Discuss This Service?', 'paksa-it-solutions' ) ), $svc_id );
$desc    = paksa_svc_meta_textarea( 'cta_description', paksa_get_option( 'paksa_cta_description', __( "Let's discuss how this service can be applied to your specific business requirements.", 'paksa-it-solutions' ) ), $svc_id );
$btn1_t  = paksa_svc_meta( 'cta_btn1_text', paksa_get_option( 'paksa_cta_primary_text', __( 'Get a Free Consultation', 'paksa-it-solutions' ) ), $svc_id );
$btn1_u  = paksa_svc_meta_url( 'cta_btn1_url', paksa_get_option( 'paksa_cta_primary_url', '#contact' ), $svc_id );
$btn2_t  = paksa_svc_meta( 'cta_btn2_text', paksa_get_option( 'paksa_cta_secondary_text', __( 'View All Services', 'paksa-it-solutions' ) ), $svc_id );
$btn2_u  = paksa_svc_meta_url( 'cta_btn2_url', get_post_type_archive_link( 'paksa_service' ) ?: paksa_get_option( 'paksa_cta_secondary_url', '#contact' ), $svc_id );
?>
<section class="pk-final-cta pk-svc-cta" id="contact" aria-labelledby="pk-svc-single-cta-heading">
    <div class="container">
        <div class="pk-final-cta-inner pk-animate-on-scroll" data-anim="fade-up">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            <h2 id="pk-svc-single-cta-heading"><?php echo esc_html( $heading ); ?></h2>
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
