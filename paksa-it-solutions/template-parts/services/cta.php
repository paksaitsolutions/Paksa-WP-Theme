<?php
/**
 * Services Page — Final CTA
 * Reuses .pk-cta dark split layout from home.css
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$eyebrow = paksa_get_option( 'paksa_cta_eyebrow', __( 'Get Started', 'paksa-it-solutions' ) );
$heading = paksa_svc_meta( 'cta_heading', paksa_get_option( 'paksa_cta_heading', __( 'Ready to Discuss Your Project?', 'paksa-it-solutions' ) ) );
$desc    = paksa_svc_meta_textarea( 'cta_description', paksa_get_option( 'paksa_cta_description', __( "Let's turn your requirements into a technology solution built for the way your business works.", 'paksa-it-solutions' ) ) );
$btn_t   = paksa_svc_meta( 'cta_btn1_text', paksa_get_option( 'paksa_cta_primary_text', __( 'Get a Free Consultation', 'paksa-it-solutions' ) ) );
$btn_u   = paksa_svc_meta_url( 'cta_btn1_url', paksa_get_option( 'paksa_cta_primary_url', '/contact/' ) );
$email   = paksa_get_option( 'paksa_contact_email', 'info@paksa.com.pk' );
$phone   = paksa_get_option( 'paksa_contact_phone', '+92 305 7772572' );
?>
<section class="pk-cta pk-svc-cta-section" id="contact" aria-labelledby="pk-svc-cta-heading">
    <div class="container">
        <div class="pk-cta-wrap">
            <div class="pk-cta-left">
                <?php if ( $eyebrow ) : ?>
                    <p class="pk-cta-overline"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>
                <h2 id="pk-svc-cta-heading" class="pk-cta-heading"><?php echo esc_html( $heading ); ?></h2>
                <?php if ( $desc ) : ?>
                    <p class="pk-cta-desc"><?php echo esc_html( $desc ); ?></p>
                <?php endif; ?>
            </div>
            <div class="pk-cta-right">
                <?php if ( $btn_t && $btn_u ) : ?>
                    <a href="<?php echo esc_url( $btn_u ); ?>" class="pk-cta-btn">
                        <?php echo esc_html( $btn_t ); ?>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="3" y1="8" x2="13" y2="8"/><polyline points="9,4 13,8 9,12"/></svg>
                    </a>
                <?php endif; ?>
                <div class="pk-cta-meta">
                    <?php if ( $email ) : ?>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>" class="pk-cta-meta-link"><?php echo esc_html( $email ); ?></a>
                    <?php endif; ?>
                    <?php if ( $email && $phone ) : ?>
                        <span class="pk-cta-meta-sep" aria-hidden="true">·</span>
                    <?php endif; ?>
                    <?php if ( $phone ) : ?>
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>" class="pk-cta-meta-link"><?php echo esc_html( $phone ); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
