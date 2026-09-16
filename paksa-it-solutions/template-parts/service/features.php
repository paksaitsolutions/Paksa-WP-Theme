<?php
/**
 * Paksa IT Solutions — Single Service: Key Capabilities
 *
 * Content: _paksa_svc_features_list post meta (pipe-delimited).
 * Parsed by paksa_parse_pipe_list() from product-meta.php.
 * Reuses .pk-prod-features-grid CSS from products.css.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$svc_id  = get_the_ID();
$eyebrow = paksa_svc_meta( 'features_eyebrow', '', $svc_id );
$heading = paksa_svc_meta( 'features_heading', '', $svc_id );
$raw     = paksa_svc_meta_textarea( 'features_list', '', $svc_id );
$items   = paksa_parse_pipe_list( $raw );

if ( empty( $items ) ) {
    return;
}
?>
<section class="section section-alt pk-svc-features" aria-labelledby="pk-svc-features-heading">
    <div class="container">

        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow'  => $eyebrow,
            'heading'  => $heading ?: __( 'Key Capabilities', 'paksa-it-solutions' ),
        ) );
        ?>

        <div class="pk-prod-features-grid" role="list">
            <?php foreach ( $items as $i => $item ) : ?>
                <div class="pk-prod-feature-item pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 80 ); ?>" role="listitem">
                    <div class="pk-prod-feature-icon" aria-hidden="true">
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3,9 7,13 15,5"></polyline>
                        </svg>
                    </div>
                    <div class="pk-prod-feature-body">
                        <p class="pk-prod-feature-title"><?php echo esc_html( $item['title'] ); ?></p>
                        <?php if ( $item['desc'] ) : ?>
                            <p class="pk-prod-feature-desc"><?php echo esc_html( $item['desc'] ); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
