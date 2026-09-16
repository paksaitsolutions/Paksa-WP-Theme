<?php
/**
 * Paksa IT Solutions — Homepage: Industries
 * Content: Customizer headings + filter-extensible items
 * Architecture: Ready for taxonomy-driven data in Phase 6
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = paksa_get_option( 'paksa_industries_eyebrow', __( 'Industries', 'paksa-it-solutions' ) );
$heading     = paksa_get_option( 'paksa_industries_heading', __( 'Built for the Industries That Drive Business', 'paksa-it-solutions' ) );
$description = paksa_get_option( 'paksa_industries_description', __( 'Our solutions are designed around the operational realities of specific industries — not generic software adapted to fit.', 'paksa-it-solutions' ) );

/**
 * Filter: paksa_industries_items
 * In Phase 6, replace with get_terms( 'paksa_industry' )
 */
$industries = apply_filters( 'paksa_industries_items', array(
    array( 'name' => __( 'Manufacturing', 'paksa-it-solutions' ), 'icon' => 'manufacturing' ),
    array( 'name' => __( 'Distribution', 'paksa-it-solutions' ), 'icon' => 'distribution' ),
    array( 'name' => __( 'Retail', 'paksa-it-solutions' ), 'icon' => 'retail' ),
    array( 'name' => __( 'Ecommerce', 'paksa-it-solutions' ), 'icon' => 'ecommerce' ),
    array( 'name' => __( 'Agriculture', 'paksa-it-solutions' ), 'icon' => 'agriculture' ),
    array( 'name' => __( 'Healthcare', 'paksa-it-solutions' ), 'icon' => 'healthcare' ),
    array( 'name' => __( 'Hospitality', 'paksa-it-solutions' ), 'icon' => 'hospitality' ),
    array( 'name' => __( 'Services', 'paksa-it-solutions' ), 'icon' => 'services' ),
    array( 'name' => __( 'Trading', 'paksa-it-solutions' ), 'icon' => 'trading' ),
    array( 'name' => __( 'Enterprise', 'paksa-it-solutions' ), 'icon' => 'enterprise' ),
) );
?>
<section class="section section-dark pk-industries" aria-labelledby="pk-industries-heading">
    <div class="container">
        <header class="section-header">
            <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <h2 id="pk-industries-heading" style="color: var(--pk-text-inverse);"><?php echo esc_html( $heading ); ?></h2>
            <p style="color: var(--pk-text-inverse-muted);"><?php echo esc_html( $description ); ?></p>
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
