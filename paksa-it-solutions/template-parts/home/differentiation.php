<?php
/**
 * Paksa IT Solutions — Homepage: How We Are Different
 * Content: Filter-extensible comparison rows
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$rows = apply_filters( 'paksa_differentiation_rows', array(
    array(
        'traditional' => __( 'Software delivery', 'paksa-it-solutions' ),
        'paksa'       => __( 'Business solution', 'paksa-it-solutions' ),
    ),
    array(
        'traditional' => __( 'Static reporting', 'paksa-it-solutions' ),
        'paksa'       => __( 'Intelligent analytics', 'paksa-it-solutions' ),
    ),
    array(
        'traditional' => __( 'Manual workflows', 'paksa-it-solutions' ),
        'paksa'       => __( 'Intelligent automation', 'paksa-it-solutions' ),
    ),
    array(
        'traditional' => __( 'Disconnected systems', 'paksa-it-solutions' ),
        'paksa'       => __( 'Integrated ecosystem', 'paksa-it-solutions' ),
    ),
    array(
        'traditional' => __( 'Historical data', 'paksa-it-solutions' ),
        'paksa'       => __( 'Predictive intelligence', 'paksa-it-solutions' ),
    ),
    array(
        'traditional' => __( 'Fixed implementation', 'paksa-it-solutions' ),
        'paksa'       => __( 'Modular architecture', 'paksa-it-solutions' ),
    ),
    array(
        'traditional' => __( 'Project completion', 'paksa-it-solutions' ),
        'paksa'       => __( 'Long-term evolution', 'paksa-it-solutions' ),
    ),
) );

$eyebrow = paksa_get_option( 'paksa_diff_eyebrow', __( 'Our Difference', 'paksa-it-solutions' ) );
$heading = paksa_get_option( 'paksa_diff_heading', __( 'More Than Software Development.', 'paksa-it-solutions' ) );
$desc    = paksa_get_option( 'paksa_diff_description', __( 'The difference between a technology vendor and a technology partner.', 'paksa-it-solutions' ) );
?>
<section class="section pk-differentiation" aria-labelledby="pk-diff-heading">
    <div class="container">
        <header class="section-header">
            <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <h2 id="pk-diff-heading"><?php echo esc_html( $heading ); ?></h2>
            <p><?php echo esc_html( $desc ); ?></p>
        </header>

        <div class="pk-diff-table" role="table" aria-label="<?php esc_attr_e( 'Comparison: Traditional approach vs Paksa approach', 'paksa-it-solutions' ); ?>">
            <div class="pk-diff-header" role="row">
                <div class="pk-diff-col pk-diff-col--traditional" role="columnheader">
                    <?php esc_html_e( 'Traditional Approach', 'paksa-it-solutions' ); ?>
                </div>
                <div class="pk-diff-col pk-diff-col--paksa" role="columnheader">
                    <?php esc_html_e( 'Paksa Approach', 'paksa-it-solutions' ); ?>
                </div>
            </div>
            <?php foreach ( $rows as $index => $row ) : ?>
                <div class="pk-diff-row pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( $index * 50 ); ?>" role="row">
                    <div class="pk-diff-col pk-diff-col--traditional" role="cell">
                        <?php echo esc_html( $row['traditional'] ); ?>
                    </div>
                    <div class="pk-diff-col pk-diff-col--paksa" role="cell">
                        <span class="pk-diff-check" aria-hidden="true">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="2,7 5.5,10.5 12,3.5"></polyline>
                            </svg>
                        </span>
                        <?php echo esc_html( $row['paksa'] ); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
