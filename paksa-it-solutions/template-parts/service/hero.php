<?php
/**
 * Paksa IT Solutions — Single Service: Hero
 *
 * Content: _paksa_svc_hero_* post meta, falls back to post title/excerpt.
 * Uses paksa_svc_meta() from services-meta.php — works on paksa_service CPT
 * because it reads by post ID, not post type.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$svc_id  = get_the_ID();
$eyebrow = paksa_svc_meta( 'hero_eyebrow', paksa_svc_meta( 'category_label', __( 'IT Service', 'paksa-it-solutions' ), $svc_id ), $svc_id );
$heading = paksa_svc_meta( 'hero_heading', get_the_title(), $svc_id );
$desc    = paksa_svc_meta_textarea( 'hero_description', get_the_excerpt(), $svc_id );
$cta1_t  = paksa_svc_meta( 'hero_cta1_text', __( 'Get a Free Consultation', 'paksa-it-solutions' ), $svc_id );
$cta1_u  = paksa_svc_meta_url( 'hero_cta1_url', paksa_get_option( 'paksa_cta_primary_url', '#contact' ), $svc_id );
$cta2_t  = paksa_svc_meta( 'hero_cta2_text', __( 'Learn More', 'paksa-it-solutions' ), $svc_id );
$cta2_u  = paksa_svc_meta_url( 'hero_cta2_url', '#pk-service-overview', $svc_id );
$badge   = paksa_svc_meta( 'badge', '', $svc_id );

// Taxonomy terms for eyebrow fallback
if ( ! $eyebrow ) {
    $terms = get_the_terms( $svc_id, 'paksa_service_cat' );
    if ( $terms && ! is_wp_error( $terms ) ) {
        $eyebrow = $terms[0]->name;
    }
}
?>
<section class="pk-prod-hero pk-svc-single-hero" aria-labelledby="pk-svc-hero-heading">
    <div class="container pk-prod-hero-inner">

        <div class="pk-prod-hero-content">

            <div class="pk-prod-hero-meta pk-animate-on-scroll" data-anim="fade-up">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>
                <?php if ( $badge ) : ?>
                    <span class="pk-prod-badge"><?php echo esc_html( $badge ); ?></span>
                <?php endif; ?>
            </div>

            <h1 id="pk-svc-hero-heading" class="pk-prod-hero-heading pk-animate-on-scroll" data-anim="fade-up" data-delay="80">
                <?php echo esc_html( $heading ); ?>
            </h1>

            <?php if ( $desc ) : ?>
                <p class="body-large pk-animate-on-scroll" data-anim="fade-up" data-delay="120">
                    <?php echo esc_html( $desc ); ?>
                </p>
            <?php endif; ?>

            <div class="pk-prod-hero-actions pk-animate-on-scroll" data-anim="fade-up" data-delay="160">
                <?php if ( $cta1_t && $cta1_u ) : ?>
                    <a href="<?php echo esc_url( $cta1_u ); ?>" class="btn btn-primary"><?php echo esc_html( $cta1_t ); ?></a>
                <?php endif; ?>
                <?php if ( $cta2_t && $cta2_u ) : ?>
                    <a href="<?php echo esc_url( $cta2_u ); ?>" class="btn btn-outline"><?php echo esc_html( $cta2_t ); ?></a>
                <?php endif; ?>
            </div>

        </div>

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="pk-prod-hero-visual pk-animate-on-scroll" data-anim="fade-in" data-delay="200">
                <?php the_post_thumbnail( 'paksa-large', array(
                    'class'   => 'pk-prod-hero-image',
                    'loading' => 'eager',
                    'alt'     => esc_attr( get_the_title() ),
                ) ); ?>
            </div>
        <?php endif; ?>

    </div>
</section>
