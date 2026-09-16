<?php
/**
 * Paksa IT Solutions — Single Product: Industries / Use Cases
 *
 * Reads product-specific industries from _paksa_prod_industries_list meta.
 * Falls back to the global industry list if meta is empty.
 * Reuses .pk-industries-grid CSS and paksa_get_industry_icon().
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$prod_id  = get_the_ID();
$raw_list = paksa_prod_meta_textarea( 'industries_list', '', $prod_id );
$industries = paksa_parse_industry_list( $raw_list );

// If no product-specific industries, use the global list.
if ( empty( $industries ) ) {
    $industries = apply_filters( 'paksa_industries_items', array(
        array( 'name' => __( 'Manufacturing', 'paksa-it-solutions' ),  'icon' => 'manufacturing' ),
        array( 'name' => __( 'Distribution', 'paksa-it-solutions' ),   'icon' => 'distribution' ),
        array( 'name' => __( 'Retail', 'paksa-it-solutions' ),         'icon' => 'retail' ),
        array( 'name' => __( 'Ecommerce', 'paksa-it-solutions' ),      'icon' => 'ecommerce' ),
        array( 'name' => __( 'Agriculture', 'paksa-it-solutions' ),    'icon' => 'agriculture' ),
        array( 'name' => __( 'Healthcare', 'paksa-it-solutions' ),     'icon' => 'healthcare' ),
        array( 'name' => __( 'Hospitality', 'paksa-it-solutions' ),    'icon' => 'hospitality' ),
        array( 'name' => __( 'Services', 'paksa-it-solutions' ),       'icon' => 'services' ),
        array( 'name' => __( 'Trading', 'paksa-it-solutions' ),        'icon' => 'trading' ),
        array( 'name' => __( 'Enterprise', 'paksa-it-solutions' ),     'icon' => 'enterprise' ),
    ) );
}

/**
 * Filter: paksa_product_industries
 *
 * @param array $industries  Industry items.
 * @param int   $prod_id     Product post ID.
 */
$industries = apply_filters( 'paksa_product_industries', $industries, $prod_id );

if ( empty( $industries ) ) {
    return;
}
?>
<section class="section section-dark pk-industries pk-prod-single-industries" aria-labelledby="pk-prod-industries-heading">
    <div class="container">
        <header class="section-header">
            <span class="eyebrow"><?php esc_html_e( 'Industries', 'paksa-it-solutions' ); ?></span>
            <h2 id="pk-prod-industries-heading" style="color: var(--pk-text-inverse);">
                <?php esc_html_e( 'Industries & Use Cases', 'paksa-it-solutions' ); ?>
            </h2>
        </header>
        <ul class="pk-industries-grid" role="list">
            <?php foreach ( $industries as $i => $industry ) : ?>
                <li class="pk-industry-item pk-animate-on-scroll" data-anim="scale-in" data-delay="<?php echo esc_attr( ( $i % 5 ) * 60 ); ?>">
                    <div class="pk-industry-icon" aria-hidden="true">
                        <?php echo paksa_get_industry_icon( $industry['icon'] ); ?>
                    </div>
                    <span class="pk-industry-name"><?php echo esc_html( $industry['name'] ); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
