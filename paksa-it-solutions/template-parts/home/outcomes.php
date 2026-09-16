<?php
/**
 * Paksa IT Solutions — Homepage: Business Outcomes
 * Content: Qualitative outcomes only. No fabricated percentages or statistics.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$outcomes = apply_filters( 'paksa_outcomes_items', array(
    array(
        'title' => __( 'Operational Automation', 'paksa-it-solutions' ),
        'desc'  => __( 'Manual, repetitive processes replaced with intelligent automated workflows that reduce errors and free up capacity.', 'paksa-it-solutions' ),
        'icon'  => 'automation',
    ),
    array(
        'title' => __( 'Business Visibility', 'paksa-it-solutions' ),
        'desc'  => __( 'Real-time dashboards and reporting that give decision-makers clear, accurate visibility into operations.', 'paksa-it-solutions' ),
        'icon'  => 'visibility',
    ),
    array(
        'title' => __( 'System Integration', 'paksa-it-solutions' ),
        'desc'  => __( 'Disconnected systems connected into a coherent operational ecosystem where data flows without friction.', 'paksa-it-solutions' ),
        'icon'  => 'integration',
    ),
    array(
        'title' => __( 'Intelligent Decisions', 'paksa-it-solutions' ),
        'desc'  => __( 'AI-powered analytics that surface patterns, predictions and recommendations to support better decisions.', 'paksa-it-solutions' ),
        'icon'  => 'intelligence',
    ),
    array(
        'title' => __( 'Scalable Infrastructure', 'paksa-it-solutions' ),
        'desc'  => __( 'Technology architecture designed to grow with the business without requiring complete rebuilds.', 'paksa-it-solutions' ),
        'icon'  => 'scalable',
    ),
    array(
        'title' => __( 'Operational Control', 'paksa-it-solutions' ),
        'desc'  => __( 'Structured permissions, audit trails and governance built into the system from the architecture level.', 'paksa-it-solutions' ),
        'icon'  => 'control',
    ),
) );

$eyebrow = paksa_get_option( 'paksa_outcomes_eyebrow', __( 'Business Outcomes', 'paksa-it-solutions' ) );
$heading = paksa_get_option( 'paksa_outcomes_heading', __( 'What Changes When Technology Works Properly', 'paksa-it-solutions' ) );
$desc    = paksa_get_option( 'paksa_outcomes_description', __( 'The measurable difference that well-designed business technology makes to operations.', 'paksa-it-solutions' ) );
?>
<section class="section section-alt pk-outcomes" aria-labelledby="pk-outcomes-heading">
    <div class="container">
        <header class="section-header">
            <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <h2 id="pk-outcomes-heading"><?php echo esc_html( $heading ); ?></h2>
            <p><?php echo esc_html( $desc ); ?></p>
        </header>

        <div class="pk-outcomes-grid">
            <?php foreach ( $outcomes as $index => $outcome ) : ?>
                <div class="pk-outcome-item pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $index % 3 ) * 80 ); ?>">
                    <div class="pk-outcome-icon" aria-hidden="true">
                        <?php echo paksa_get_outcome_icon( $outcome['icon'] ); ?>
                    </div>
                    <h3 class="pk-outcome-title"><?php echo esc_html( $outcome['title'] ); ?></h3>
                    <p class="pk-outcome-desc"><?php echo esc_html( $outcome['desc'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
