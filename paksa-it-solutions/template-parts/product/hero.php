<?php
/**
 * Paksa IT Solutions — Single Product: Hero
 *
 * Content: _paksa_prod_hero_* post meta, falls back to post title/excerpt.
 * Featured image used as product visual if set.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$prod_id  = get_the_ID();
$eyebrow  = paksa_prod_meta( 'hero_eyebrow', paksa_prod_meta( 'category_label', __( 'Software Solution', 'paksa-it-solutions' ), $prod_id ), $prod_id );
$heading  = paksa_prod_meta( 'hero_heading', get_the_title(), $prod_id );
$desc     = paksa_prod_meta_textarea( 'hero_description', get_the_excerpt(), $prod_id );
$cta1_t   = paksa_prod_meta( 'hero_cta1_text', __( 'Request a Demo', 'paksa-it-solutions' ), $prod_id );
$cta1_u   = paksa_prod_meta_url( 'hero_cta1_url', paksa_get_option( 'paksa_cta_primary_url', '#contact' ), $prod_id );
$cta2_t   = paksa_prod_meta( 'hero_cta2_text', __( 'Learn More', 'paksa-it-solutions' ), $prod_id );
$cta2_u   = paksa_prod_meta_url( 'hero_cta2_url', '#pk-product-overview', $prod_id );
$badge    = paksa_prod_meta( 'badge', '', $prod_id );
$tagline  = paksa_prod_meta( 'tagline', '', $prod_id );

// Taxonomy terms for breadcrumb/eyebrow
$terms = get_the_terms( $prod_id, 'paksa_product_cat' );
if ( ! $eyebrow && $terms && ! is_wp_error( $terms ) ) {
    $eyebrow = $terms[0]->name;
}
?>
<section class="pk-prod-hero" aria-labelledby="pk-prod-hero-heading">
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

            <h1 id="pk-prod-hero-heading" class="pk-prod-hero-heading pk-animate-on-scroll" data-anim="fade-up" data-delay="80">
                <?php echo esc_html( $heading ); ?>
            </h1>

            <?php if ( $tagline ) : ?>
                <p class="pk-prod-hero-tagline pk-animate-on-scroll" data-anim="fade-up" data-delay="120">
                    <?php echo esc_html( $tagline ); ?>
                </p>
            <?php endif; ?>

            <?php if ( $desc ) : ?>
                <p class="body-large pk-animate-on-scroll" data-anim="fade-up" data-delay="160">
                    <?php echo esc_html( $desc ); ?>
                </p>
            <?php endif; ?>

            <div class="pk-prod-hero-actions pk-animate-on-scroll" data-anim="fade-up" data-delay="200">
                <?php if ( $cta1_t && $cta1_u ) : ?>
                    <a href="<?php echo esc_url( $cta1_u ); ?>" class="btn btn-primary"><?php echo esc_html( $cta1_t ); ?></a>
                <?php endif; ?>
                <?php if ( $cta2_t && $cta2_u ) : ?>
                    <a href="<?php echo esc_url( $cta2_u ); ?>" class="btn btn-outline"><?php echo esc_html( $cta2_t ); ?></a>
                <?php endif; ?>
            </div>

        </div>

        <div class="pk-prod-hero-visual pk-animate-on-scroll" data-anim="fade-in" data-delay="200">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'paksa-large', array(
                    'class'   => 'pk-prod-hero-image',
                    'loading' => 'eager',
                    'alt'     => esc_attr( get_the_title() ),
                ) ); ?>
            <?php else : ?>
                <div class="pk-prod-hero-placeholder" aria-hidden="true">
                    <div class="pk-prod-hero-mock">
                        <div class="pk-mock-bar"></div>
                        <div class="pk-mock-content">
                            <div class="pk-mock-line pk-mock-line--wide"></div>
                            <div class="pk-mock-line"></div>
                            <div class="pk-mock-line pk-mock-line--short"></div>
                            <div class="pk-mock-line pk-mock-line--wide"></div>
                            <div class="pk-mock-line"></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>
