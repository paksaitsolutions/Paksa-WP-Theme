<?php
/**
 * Paksa IT Solutions — Services: Hero Section
 *
 * Content source: post meta (_paksa_svc_hero_*)
 * Fallbacks: translatable placeholder strings — NOT hardcoded business copy.
 * Inherits all design tokens and typography from the existing system.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow = paksa_svc_meta( 'hero_eyebrow',      __( 'IT Solutions', 'paksa-it-solutions' ) );
$heading = paksa_svc_meta( 'hero_heading',       __( 'Enterprise Technology Services', 'paksa-it-solutions' ) );
$desc    = paksa_svc_meta_textarea( 'hero_description', __( 'Purpose-built software, AI-powered systems and intelligent digital infrastructure — designed around the way your business actually works.', 'paksa-it-solutions' ) );
$cta1_t  = paksa_svc_meta( 'hero_cta1_text',    __( 'Get a Free Consultation', 'paksa-it-solutions' ) );
$cta1_u  = paksa_svc_meta_url( 'hero_cta1_url', paksa_get_option( 'paksa_cta_primary_url', '#contact' ) );
$cta2_t  = paksa_svc_meta( 'hero_cta2_text',    __( 'View All Services', 'paksa-it-solutions' ) );
$cta2_u  = paksa_svc_meta_url( 'hero_cta2_url', '#pk-services-portfolio' );

if ( ! $heading ) {
    return;
}
?>
<section class="pk-svc-hero" aria-labelledby="pk-svc-hero-heading">
    <div class="container pk-svc-hero-inner">

        <div class="pk-svc-hero-content">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow pk-animate-on-scroll" data-anim="fade-up"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>

            <h1 id="pk-svc-hero-heading" class="pk-svc-hero-heading pk-animate-on-scroll" data-anim="fade-up" data-delay="100">
                <?php echo esc_html( $heading ); ?>
            </h1>

            <?php if ( $desc ) : ?>
                <p class="pk-svc-hero-desc body-large pk-animate-on-scroll" data-anim="fade-up" data-delay="150">
                    <?php echo esc_html( $desc ); ?>
                </p>
            <?php endif; ?>

            <div class="pk-svc-hero-actions pk-animate-on-scroll" data-anim="fade-up" data-delay="200">
                <?php if ( $cta1_t && $cta1_u ) : ?>
                    <a href="<?php echo esc_url( $cta1_u ); ?>" class="btn btn-primary">
                        <?php echo esc_html( $cta1_t ); ?>
                    </a>
                <?php endif; ?>
                <?php if ( $cta2_t && $cta2_u ) : ?>
                    <a href="<?php echo esc_url( $cta2_u ); ?>" class="btn btn-outline">
                        <?php echo esc_html( $cta2_t ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="pk-svc-hero-visual pk-animate-on-scroll" data-anim="fade-in" data-delay="250" aria-hidden="true">
            <div class="pk-svc-hero-grid">
                <?php
                /**
                 * Filter: paksa_svc_hero_service_labels
                 * Labels shown in the decorative service grid visual.
                 * Replace with actual service names once confirmed.
                 */
                $labels = apply_filters( 'paksa_svc_hero_service_labels', array(
                    array( 'label' => __( 'Enterprise Software', 'paksa-it-solutions' ), 'accent' => false ),
                    array( 'label' => __( 'AI & ML', 'paksa-it-solutions' ),             'accent' => true  ),
                    array( 'label' => __( 'Business Intelligence', 'paksa-it-solutions' ),'accent' => false ),
                    array( 'label' => __( 'Custom Development', 'paksa-it-solutions' ),  'accent' => false ),
                    array( 'label' => __( 'System Integration', 'paksa-it-solutions' ),  'accent' => true  ),
                    array( 'label' => __( 'Ecommerce', 'paksa-it-solutions' ),            'accent' => false ),
                ) );
                foreach ( $labels as $item ) :
                    $cls = $item['accent'] ? ' pk-svc-tile--accent' : '';
                ?>
                    <div class="pk-svc-tile<?php echo esc_attr( $cls ); ?>">
                        <span><?php echo esc_html( $item['label'] ); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>
