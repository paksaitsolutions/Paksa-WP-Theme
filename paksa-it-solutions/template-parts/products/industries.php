<?php
/**
 * Paksa IT Solutions — Products Listing: Industries
 *
 * Reuses .pk-industries-grid CSS from home.css and paksa_get_industry_icon().
 * Content: apply_filters( 'paksa_prod_industries_items', $defaults )
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow = apply_filters( 'paksa_prod_industries_eyebrow',     __( 'Industries', 'paksa-it-solutions' ) );
$heading = apply_filters( 'paksa_prod_industries_heading',     __( 'Built for the Industries That Drive Business', 'paksa-it-solutions' ) );
$desc    = apply_filters( 'paksa_prod_industries_description', __( 'Our products are designed around the operational realities of specific industries.', 'paksa-it-solutions' ) );

// Reuse the same industry list as the homepage/services unless overridden.
$industries = apply_filters( 'paksa_prod_industries_items', apply_filters( 'paksa_industries_items', array(
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
) ) );

if ( empty( $industries ) ) {
    return;
}
?>
<section class="section section-dark pk-industries pk-prod-industries" aria-labelledby="pk-prod-industries-heading">
    <div class="container">
        <header class="section-header">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            <h2 id="pk-prod-industries-heading" style="color: var(--pk-text-inverse);"><?php echo esc_html( $heading ); ?></h2>
            <?php if ( $desc ) : ?>
                <p style="color: var(--pk-text-inverse-muted);"><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
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
