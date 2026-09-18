<?php
/**
 * Paksa IT Solutions — Final CTA
 * Reusable: get_template_part( 'template-parts/home/final-cta' )
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$heading   = paksa_get_option( 'paksa_cta_heading',        __( 'Ready to Build Something That Works?', 'paksa-it-solutions' ) );
$desc      = paksa_get_option( 'paksa_cta_description',    __( "Tell us what you need. We'll tell you how to build it right.", 'paksa-it-solutions' ) );
$btn_text  = paksa_get_option( 'paksa_cta_primary_text',   __( 'Start a Conversation', 'paksa-it-solutions' ) );
$btn_url   = paksa_get_option( 'paksa_cta_primary_url',    '/contact/' );
$phone     = paksa_get_option( 'paksa_phone',              '+92 305 7772572' );
$email     = paksa_get_option( 'paksa_email',              'info@paksa.com.pk' );
?>
<section class="pk-cta" aria-labelledby="pk-cta-heading">
    <div class="container">
        <div class="pk-cta-wrap pk-animate-on-scroll" data-anim="fade-up">

            <div class="pk-cta-left">
                <p class="pk-cta-overline"><?php esc_html_e( "Let's work together", 'paksa-it-solutions' ); ?></p>
                <h2 id="pk-cta-heading" class="pk-cta-heading"><?php echo esc_html( $heading ); ?></h2>
                <p class="pk-cta-desc"><?php echo esc_html( $desc ); ?></p>
            </div>

            <div class="pk-cta-right">
                <a href="<?php echo esc_url( $btn_url ); ?>" class="pk-cta-btn">
                    <?php echo esc_html( $btn_text ); ?>
                    <svg width="18" height="18" viewBox="0 0 256 256" fill="currentColor" aria-hidden="true"><path d="M221.7 133.7l-72 72a8 8 0 0 1-11.4-11.4L196.7 136H40a8 8 0 0 1 0-16h156.7l-58.4-58.3a8 8 0 0 1 11.4-11.4l72 72a8 8 0 0 1 0 11.4z"/></svg>
                </a>

                <div class="pk-cta-meta">
                    <?php if ( $email ) : ?>
                    <a href="mailto:<?php echo esc_attr( $email ); ?>" class="pk-cta-meta-link">
                        <?php echo esc_html( $email ); ?>
                    </a>
                    <?php endif; ?>
                    <?php if ( $phone ) : ?>
                    <span class="pk-cta-meta-sep" aria-hidden="true">·</span>
                    <a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>" class="pk-cta-meta-link">
                        <?php echo esc_html( $phone ); ?>
                    </a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>
