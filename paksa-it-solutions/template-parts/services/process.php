<?php
/**
 * Services Page — How We Work (Process)
 * Horizontal numbered timeline with connecting line
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$eyebrow = apply_filters( 'paksa_svc_process_eyebrow',     __( 'Our Process', 'paksa-it-solutions' ) );
$heading = apply_filters( 'paksa_svc_process_heading',     __( 'How We Work', 'paksa-it-solutions' ) );
$desc    = apply_filters( 'paksa_svc_process_description', __( 'A structured approach that moves from business understanding to deployed, evolving technology — with clear communication at every stage.', 'paksa-it-solutions' ) );

$steps = apply_filters( 'paksa_svc_process_steps', apply_filters( 'paksa_process_steps', array(
    array(
        'number' => '01',
        'title'  => __( 'Discover', 'paksa-it-solutions' ),
        'desc'   => __( 'Understand the business, workflows, data requirements and operational context before any technical decisions are made.', 'paksa-it-solutions' ),
        'icon'   => 'search',
    ),
    array(
        'number' => '02',
        'title'  => __( 'Design', 'paksa-it-solutions' ),
        'desc'   => __( 'Define the solution architecture, system design and implementation strategy aligned to your business objectives.', 'paksa-it-solutions' ),
        'icon'   => 'design',
    ),
    array(
        'number' => '03',
        'title'  => __( 'Build', 'paksa-it-solutions' ),
        'desc'   => __( 'Develop the software, integrations and data layers with quality and maintainability as core requirements throughout.', 'paksa-it-solutions' ),
        'icon'   => 'code',
    ),
    array(
        'number' => '04',
        'title'  => __( 'Deploy', 'paksa-it-solutions' ),
        'desc'   => __( 'Test, integrate and deploy the solution with structured handover, training and go-live support for your team.', 'paksa-it-solutions' ),
        'icon'   => 'deploy',
    ),
    array(
        'number' => '05',
        'title'  => __( 'Evolve', 'paksa-it-solutions' ),
        'desc'   => __( 'Continuously improve the platform as the business grows, requirements change and new opportunities emerge.', 'paksa-it-solutions' ),
        'icon'   => 'evolve',
    ),
) ) );

if ( empty( $steps ) ) { return; }

$step_icons = array(
    'search' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
    'design' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>',
    'code'   => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>',
    'deploy' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>',
    'evolve' => '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>',
);
?>
<section class="section pk-svc-process" aria-labelledby="pk-svc-process-heading">
    <div class="container">

        <div class="pk-svc-process-header pk-animate-on-scroll" data-anim="fade-up">
            <?php if ( $eyebrow ) : ?>
                <span class="pk-section-label"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            <?php if ( $heading ) : ?>
                <h2 id="pk-svc-process-heading"><?php echo esc_html( $heading ); ?></h2>
            <?php endif; ?>
            <?php if ( $desc ) : ?>
                <p class="pk-svc-process-intro"><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
        </div>

        <div class="pk-svc-process-timeline" role="list">
            <?php foreach ( $steps as $index => $step ) :
                $icon_key = $step['icon'] ?? array_keys( $step_icons )[ $index % count( $step_icons ) ];
                $icon_svg = $step_icons[ $icon_key ] ?? $step_icons['code'];
            ?>
                <div class="pk-svc-process-step pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( $index * 80 ); ?>" role="listitem">
                    <div class="pk-svc-process-step-top">
                        <div class="pk-svc-process-step-icon" aria-hidden="true">
                            <?php echo $icon_svg; ?>
                        </div>
                        <div class="pk-svc-process-step-num" aria-hidden="true"><?php echo esc_html( $step['number'] ); ?></div>
                    </div>
                    <div class="pk-svc-process-step-body">
                        <h3 class="pk-svc-process-step-title"><?php echo esc_html( $step['title'] ); ?></h3>
                        <p class="pk-svc-process-step-desc"><?php echo esc_html( $step['desc'] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
