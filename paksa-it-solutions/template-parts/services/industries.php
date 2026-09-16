<?php
/**
 * Paksa IT Solutions — Services: Industries / Use Cases
 *
 * Reuses paksa_get_industry_icon() from inc/icons.php.
 * Reuses .pk-industries-grid and .pk-industry-item CSS from home.css.
 *
 * Content source: apply_filters( 'paksa_svc_industries_items', $defaults )
 *
 * Architecture note:
 *   In Phase 6, replace filter with get_terms( 'paksa_industry' ).
 *   The markup does not need to change.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow = apply_filters( 'paksa_svc_industries_eyebrow',     __( 'Industries', 'paksa-it-solutions' ) );
$heading = apply_filters( 'paksa_svc_industries_heading',     __( 'Industries We Serve', 'paksa-it-solutions' ) );
$desc    = apply_filters( 'paksa_svc_industries_description', __( 'Our solutions are designed around the operational realities of specific industries — not generic software adapted to fit.', 'paksa-it-solutions' ) );

/**
 * Filter: paksa_svc_industries_items
 * Defaults to the same industry list as the homepage.
 * Override to show a service-specific subset.
 */
$industries = apply_filters( 'paksa_svc_industries_items', apply_filters( 'paksa_industries_items', array(
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
<section class="section section-dark pk-industries pk-svc-industries" aria-labelledby="pk-svc-industries-heading">
    <div class="container">
        <header class="section-header">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            <h2 id="pk-svc-industries-heading" style="color: var(--pk-text-inverse);"><?php echo esc_html( $heading ); ?></h2>
            <?php if ( $desc ) : ?>
                <p style="color: var(--pk-text-inverse-muted);"><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
        </header>

        <ul class="pk-industries-grid" role="list">
            <?php foreach ( $industries as $index => $industry ) : ?>
                <li class="pk-industry-item pk-animate-on-scroll" data-anim="scale-in" data-delay="<?php echo esc_attr( ( $index % 5 ) * 60 ); ?>">
                    <div class="pk-industry-icon" aria-hidden="true">
                        <?php echo paksa_get_industry_icon( $industry['icon'] ); ?>
                    </div>
                    <span class="pk-industry-name"><?php echo esc_html( $industry['name'] ); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
