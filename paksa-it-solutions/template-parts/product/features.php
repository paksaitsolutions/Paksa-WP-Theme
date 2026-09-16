<?php
/**
 * Paksa IT Solutions — Single Product: Key Features
 *
 * Content: _paksa_prod_features_list meta (pipe-delimited: Title | Description)
 * Parsed by paksa_parse_pipe_list().
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$prod_id  = get_the_ID();
$eyebrow  = paksa_prod_meta( 'features_eyebrow', __( 'Features', 'paksa-it-solutions' ), $prod_id );
$heading  = paksa_prod_meta( 'features_heading', __( 'Key Features', 'paksa-it-solutions' ), $prod_id );
$desc     = paksa_prod_meta_textarea( 'features_desc', '', $prod_id );
$raw_list = paksa_prod_meta_textarea( 'features_list', '', $prod_id );
$features = paksa_parse_pipe_list( $raw_list );

/**
 * Filter: paksa_product_features
 * Allows programmatic override of features for a specific product.
 *
 * @param array $features  Parsed feature items.
 * @param int   $prod_id   Product post ID.
 */
$features = apply_filters( 'paksa_product_features', $features, $prod_id );

if ( empty( $features ) ) {
    return;
}
?>
<section class="section pk-prod-features" aria-labelledby="pk-prod-features-heading">
    <div class="container">

        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow'     => $eyebrow,
            'heading'     => $heading,
            'description' => $desc,
        ) );
        ?>

        <div class="pk-prod-features-grid">
            <?php foreach ( $features as $i => $feature ) : ?>
                <div class="pk-prod-feature-item pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>">
                    <div class="pk-prod-feature-icon" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="4,10 8,14 16,6"></polyline>
                        </svg>
                    </div>
                    <div class="pk-prod-feature-body">
                        <h3 class="pk-prod-feature-title"><?php echo esc_html( $feature['title'] ); ?></h3>
                        <?php if ( $feature['desc'] ) : ?>
                            <p class="pk-prod-feature-desc"><?php echo esc_html( $feature['desc'] ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
