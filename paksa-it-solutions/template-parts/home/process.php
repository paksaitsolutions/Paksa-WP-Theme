<?php
/**
 * Paksa IT Solutions — Homepage: How We Work (Process)
 * Content: Customizer headings + filter-extensible steps
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = paksa_get_option( 'paksa_process_eyebrow', __( 'Our Process', 'paksa-it-solutions' ) );
$heading     = paksa_get_option( 'paksa_process_heading', __( 'How We Work', 'paksa-it-solutions' ) );
$description = paksa_get_option( 'paksa_process_description', __( 'A structured approach that moves from business understanding to deployed, evolving technology.', 'paksa-it-solutions' ) );

$steps = apply_filters( 'paksa_process_steps', array(
    array(
        'number' => '01',
        'title'  => __( 'Discover', 'paksa-it-solutions' ),
        'desc'   => __( 'Understand the business, workflows, data requirements and operational context before any technical decisions.', 'paksa-it-solutions' ),
    ),
    array(
        'number' => '02',
        'title'  => __( 'Design', 'paksa-it-solutions' ),
        'desc'   => __( 'Define the solution architecture, system design and implementation strategy aligned to business objectives.', 'paksa-it-solutions' ),
    ),
    array(
        'number' => '03',
        'title'  => __( 'Build', 'paksa-it-solutions' ),
        'desc'   => __( 'Develop the software, integrations and data layers with quality and maintainability as core requirements.', 'paksa-it-solutions' ),
    ),
    array(
        'number' => '04',
        'title'  => __( 'Deploy', 'paksa-it-solutions' ),
        'desc'   => __( 'Test, integrate and deploy the solution with structured handover, training and go-live support.', 'paksa-it-solutions' ),
    ),
    array(
        'number' => '05',
        'title'  => __( 'Evolve', 'paksa-it-solutions' ),
        'desc'   => __( 'Continuously improve the platform as the business grows, requirements change and new opportunities emerge.', 'paksa-it-solutions' ),
    ),
) );
?>
<section class="section pk-process" aria-labelledby="pk-process-heading">
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow'     => $eyebrow,
            'heading'     => $heading,
            'description' => $description,
        ) );
        ?>

        <div class="pk-process-steps" role="list">
            <?php foreach ( $steps as $index => $step ) : ?>
                <div class="pk-process-step pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( $index * 80 ); ?>" role="listitem">
                    <div class="pk-process-step-number" aria-hidden="true"><?php echo esc_html( $step['number'] ); ?></div>
                    <div class="pk-process-step-body">
                        <h3 class="pk-process-step-title"><?php echo esc_html( $step['title'] ); ?></h3>
                        <p class="pk-process-step-desc"><?php echo esc_html( $step['desc'] ); ?></p>
                    </div>
                    <?php if ( $index < count( $steps ) - 1 ) : ?>
                        <div class="pk-process-connector" aria-hidden="true"></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
