<?php
/**
 * Paksa IT Solutions — Services: Final CTA
 *
 * Page-level CTA with fallback to global Customizer settings.
 * Reuses .pk-final-cta CSS from home.css.
 *
 * Priority order:
 *   1. Post meta (_paksa_svc_cta_*)
 *   2. Global Customizer (paksa_cta_*)
 *   3. Translatable fallback strings
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Page-level overrides first, then global Customizer fallbacks.
$eyebrow = paksa_get_option( 'paksa_cta_eyebrow', __( 'Get Started', 'paksa-it-solutions' ) );
$heading = paksa_svc_meta( 'cta_heading', paksa_get_option( 'paksa_cta_heading', __( 'Ready to Discuss Your Project?', 'paksa-it-solutions' ) ) );
$desc    = paksa_svc_meta_textarea( 'cta_description', paksa_get_option( 'paksa_cta_description', __( "Let's turn your requirements into a technology solution built for the way your business works.", 'paksa-it-solutions' ) ) );
$btn1_t  = paksa_svc_meta( 'cta_btn1_text', paksa_get_option( 'paksa_cta_primary_text', __( 'Get a Free Consultation', 'paksa-it-solutions' ) ) );
$btn1_u  = paksa_svc_meta_url( 'cta_btn1_url', paksa_get_option( 'paksa_cta_primary_url', '#contact' ) );
$btn2_t  = paksa_svc_meta( 'cta_btn2_text', paksa_get_option( 'paksa_cta_secondary_text', __( 'Discuss Your Project', 'paksa-it-solutions' ) ) );
$btn2_u  = paksa_svc_meta_url( 'cta_btn2_url', paksa_get_option( 'paksa_cta_secondary_url', '#contact' ) );
?>
<section class="pk-final-cta pk-svc-cta" id="contact" aria-labelledby="pk-svc-cta-heading">
    <div class="container">
        <div class="pk-final-cta-inner pk-animate-on-scroll" data-anim="fade-up">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            <h2 id="pk-svc-cta-heading"><?php echo esc_html( $heading ); ?></h2>
            <?php if ( $desc ) : ?>
                <p class="body-large"><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
            <div class="pk-final-cta-actions">
                <?php if ( $btn1_t && $btn1_u ) : ?>
                    <a href="<?php echo esc_url( $btn1_u ); ?>" class="btn btn-primary">
                        <?php echo esc_html( $btn1_t ); ?>
                    </a>
                <?php endif; ?>
                <?php if ( $btn2_t && $btn2_u ) : ?>
                    <a href="<?php echo esc_url( $btn2_u ); ?>" class="btn btn-outline">
                        <?php echo esc_html( $btn2_t ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
