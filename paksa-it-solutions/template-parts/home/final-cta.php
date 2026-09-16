<?php
/**
 * Paksa IT Solutions — Homepage: Final CTA
 * Content: WordPress Customizer
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow    = paksa_get_option( 'paksa_cta_eyebrow', __( 'Get Started', 'paksa-it-solutions' ) );
$heading    = paksa_get_option( 'paksa_cta_heading', __( 'Have a Business Challenge?', 'paksa-it-solutions' ) );
$desc       = paksa_get_option( 'paksa_cta_description', __( "Let's turn your requirements into a technology solution built for the way your business works.", 'paksa-it-solutions' ) );
$btn1_text  = paksa_get_option( 'paksa_cta_primary_text', __( 'Get a Free Consultation', 'paksa-it-solutions' ) );
$btn1_url   = paksa_get_option( 'paksa_cta_primary_url', '#contact' );
$btn2_text  = paksa_get_option( 'paksa_cta_secondary_text', __( 'Discuss Your Project', 'paksa-it-solutions' ) );
$btn2_url   = paksa_get_option( 'paksa_cta_secondary_url', '#contact' );
?>
<section class="pk-final-cta" id="contact" aria-labelledby="pk-final-cta-heading">
    <div class="container">
        <div class="pk-final-cta-inner pk-animate-on-scroll" data-anim="fade-up">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            <h2 id="pk-final-cta-heading"><?php echo esc_html( $heading ); ?></h2>
            <?php if ( $desc ) : ?>
                <p class="body-large"><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
            <div class="pk-final-cta-actions">
                <?php if ( $btn1_text && $btn1_url ) : ?>
                    <a href="<?php echo esc_url( $btn1_url ); ?>" class="btn btn-primary">
                        <?php echo esc_html( $btn1_text ); ?>
                    </a>
                <?php endif; ?>
                <?php if ( $btn2_text && $btn2_url ) : ?>
                    <a href="<?php echo esc_url( $btn2_url ); ?>" class="btn btn-outline">
                        <?php echo esc_html( $btn2_text ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
