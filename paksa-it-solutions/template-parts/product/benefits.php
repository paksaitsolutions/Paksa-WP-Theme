<?php
/**
 * Paksa IT Solutions — Single Product: Business Benefits
 *
 * Qualitative business capabilities — no invented statistics.
 * Content: _paksa_prod_benefits_list meta (pipe-delimited: Title | Description)
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$prod_id  = get_the_ID();
$eyebrow  = paksa_prod_meta( 'benefits_eyebrow', __( 'Benefits', 'paksa-it-solutions' ), $prod_id );
$heading  = paksa_prod_meta( 'benefits_heading', __( 'Business Benefits', 'paksa-it-solutions' ), $prod_id );
$raw_list = paksa_prod_meta_textarea( 'benefits_list', '', $prod_id );
$benefits = paksa_parse_pipe_list( $raw_list );

/**
 * Filter: paksa_product_benefits
 *
 * @param array $benefits  Parsed benefit items.
 * @param int   $prod_id   Product post ID.
 */
$benefits = apply_filters( 'paksa_product_benefits', $benefits, $prod_id );

if ( empty( $benefits ) ) {
    return;
}
?>
<section class="section pk-prod-benefits" aria-labelledby="pk-prod-benefits-heading">
    <div class="container">

        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow' => $eyebrow,
            'heading' => $heading,
        ) );
        ?>

        <div class="pk-prod-benefits-grid">
            <?php foreach ( $benefits as $i => $benefit ) : ?>
                <div class="pk-prod-benefit-item pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>">
                    <div class="pk-prod-benefit-icon" aria-hidden="true">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            <polyline points="9 12 11 14 15 10"></polyline>
                        </svg>
                    </div>
                    <h3 class="pk-prod-benefit-title"><?php echo esc_html( $benefit['title'] ); ?></h3>
                    <?php if ( $benefit['desc'] ) : ?>
                        <p class="pk-prod-benefit-desc"><?php echo esc_html( $benefit['desc'] ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
