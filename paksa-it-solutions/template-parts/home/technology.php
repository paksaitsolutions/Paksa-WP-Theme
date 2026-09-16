<?php
/**
 * Paksa IT Solutions — Homepage: Core Technology Capabilities
 * Content: Filter-extensible static array
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$steps = apply_filters( 'paksa_technology_steps', array(
    array(
        'number' => '01',
        'title'  => __( 'Business Analysis', 'paksa-it-solutions' ),
        'desc'   => __( 'Understanding operational requirements, workflows and data flows before any architecture decisions.', 'paksa-it-solutions' ),
    ),
    array(
        'number' => '02',
        'title'  => __( 'Solution Architecture', 'paksa-it-solutions' ),
        'desc'   => __( 'Designing scalable, maintainable system architecture aligned to business objectives.', 'paksa-it-solutions' ),
    ),
    array(
        'number' => '03',
        'title'  => __( 'Software Engineering', 'paksa-it-solutions' ),
        'desc'   => __( 'Building robust, well-structured software using appropriate technologies for the problem.', 'paksa-it-solutions' ),
    ),
    array(
        'number' => '04',
        'title'  => __( 'Data & Integration', 'paksa-it-solutions' ),
        'desc'   => __( 'Connecting systems, normalising data and building reliable integration layers.', 'paksa-it-solutions' ),
    ),
    array(
        'number' => '05',
        'title'  => __( 'AI & Intelligence', 'paksa-it-solutions' ),
        'desc'   => __( 'Applying machine learning and predictive analytics where they create genuine business value.', 'paksa-it-solutions' ),
    ),
    array(
        'number' => '06',
        'title'  => __( 'Business Analytics', 'paksa-it-solutions' ),
        'desc'   => __( 'Delivering dashboards, reports and decision intelligence that make data actionable.', 'paksa-it-solutions' ),
    ),
) );

$eyebrow = paksa_get_option( 'paksa_technology_eyebrow', __( 'Our Capabilities', 'paksa-it-solutions' ) );
$heading = paksa_get_option( 'paksa_technology_heading', __( 'From Business Requirements to Intelligent Systems', 'paksa-it-solutions' ) );
$desc    = paksa_get_option( 'paksa_technology_description', __( 'A complete capability stack — from initial analysis through to deployed, intelligent business systems.', 'paksa-it-solutions' ) );
?>
<section class="section section-dark pk-tech-capabilities" aria-labelledby="pk-tech-heading">
    <div class="container">
        <header class="section-header" style="--section-header-color: var(--pk-text-inverse);">
            <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <h2 id="pk-tech-heading" style="color: var(--pk-text-inverse);">
                <?php echo esc_html( $heading ); ?>
            </h2>
            <p style="color: var(--pk-text-inverse-muted);">
                <?php echo esc_html( $desc ); ?>
            </p>
        </header>

        <div class="pk-tech-steps">
            <?php foreach ( $steps as $index => $step ) : ?>
                <div class="pk-tech-step pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( $index * 60 ); ?>">
                    <div class="pk-tech-step-number" aria-hidden="true"><?php echo esc_html( $step['number'] ); ?></div>
                    <div class="pk-tech-step-content">
                        <h3 class="pk-tech-step-title"><?php echo esc_html( $step['title'] ); ?></h3>
                        <p class="pk-tech-step-desc"><?php echo esc_html( $step['desc'] ); ?></p>
                    </div>
                    <?php if ( $index < count( $steps ) - 1 ) : ?>
                        <div class="pk-tech-step-connector" aria-hidden="true"></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
