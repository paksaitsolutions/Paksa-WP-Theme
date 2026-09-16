<?php
/**
 * Paksa IT Solutions — Products Listing: Hero
 *
 * Content: post meta on the Products page (_paksa_prod_listing_*)
 * Falls back to translatable placeholder strings.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID();
$eyebrow = get_post_meta( $page_id, '_paksa_prod_listing_eyebrow', true );
$heading = get_post_meta( $page_id, '_paksa_prod_listing_heading', true );
$desc    = get_post_meta( $page_id, '_paksa_prod_listing_desc',    true );
$cta1_t  = get_post_meta( $page_id, '_paksa_prod_listing_cta1_text', true );
$cta1_u  = get_post_meta( $page_id, '_paksa_prod_listing_cta1_url',  true );
$cta2_t  = get_post_meta( $page_id, '_paksa_prod_listing_cta2_text', true );
$cta2_u  = get_post_meta( $page_id, '_paksa_prod_listing_cta2_url',  true );

$eyebrow = $eyebrow ?: __( 'Software Solutions', 'paksa-it-solutions' );
$heading = $heading ?: __( 'Products Built for Specific Business Needs', 'paksa-it-solutions' );
$desc    = $desc    ?: __( 'Industry-specific platforms and enterprise software designed around the operational realities of each sector.', 'paksa-it-solutions' );
$cta1_t  = $cta1_t ?: __( 'Get a Demo', 'paksa-it-solutions' );
$cta1_u  = $cta1_u ? esc_url_raw( $cta1_u ) : paksa_get_option( 'paksa_cta_primary_url', '#contact' );
$cta2_t  = $cta2_t ?: __( 'View All Services', 'paksa-it-solutions' );
$cta2_u  = $cta2_u ? esc_url_raw( $cta2_u ) : '';
?>
<section class="pk-prod-listing-hero" aria-labelledby="pk-prod-listing-heading">
    <div class="container pk-prod-listing-hero-inner">

        <div class="pk-prod-listing-hero-content">
            <span class="eyebrow pk-animate-on-scroll" data-anim="fade-up"><?php echo esc_html( $eyebrow ); ?></span>
            <h1 id="pk-prod-listing-heading" class="pk-prod-listing-hero-heading pk-animate-on-scroll" data-anim="fade-up" data-delay="100">
                <?php echo esc_html( $heading ); ?>
            </h1>
            <p class="body-large pk-animate-on-scroll" data-anim="fade-up" data-delay="150">
                <?php echo esc_html( $desc ); ?>
            </p>
            <div class="pk-prod-listing-hero-actions pk-animate-on-scroll" data-anim="fade-up" data-delay="200">
                <?php if ( $cta1_t && $cta1_u ) : ?>
                    <a href="<?php echo esc_url( $cta1_u ); ?>" class="btn btn-primary"><?php echo esc_html( $cta1_t ); ?></a>
                <?php endif; ?>
                <?php if ( $cta2_t && $cta2_u ) : ?>
                    <a href="<?php echo esc_url( $cta2_u ); ?>" class="btn btn-outline"><?php echo esc_html( $cta2_t ); ?></a>
                <?php endif; ?>
            </div>
        </div>

        <?php
        // Category filter pills — built from registered taxonomy terms.
        $cats = get_terms( array(
            'taxonomy'   => 'paksa_product_cat',
            'hide_empty' => true,
        ) );
        if ( ! is_wp_error( $cats ) && ! empty( $cats ) ) :
        ?>
            <nav class="pk-prod-cat-filter pk-animate-on-scroll" data-anim="fade-up" data-delay="250" aria-label="<?php esc_attr_e( 'Filter products by category', 'paksa-it-solutions' ); ?>">
                <button class="pk-prod-cat-pill is-active" data-filter="all" type="button">
                    <?php esc_html_e( 'All Products', 'paksa-it-solutions' ); ?>
                </button>
                <?php foreach ( $cats as $cat ) : ?>
                    <button class="pk-prod-cat-pill" data-filter="<?php echo esc_attr( $cat->slug ); ?>" type="button">
                        <?php echo esc_html( $cat->name ); ?>
                    </button>
                <?php endforeach; ?>
            </nav>
        <?php endif; ?>

    </div>
</section>
