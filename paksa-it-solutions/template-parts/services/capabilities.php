<?php
/**
 * Services Page — Capabilities Detail
 * Alternating feature rows: icon + content side by side
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$eyebrow = apply_filters( 'paksa_svc_capabilities_eyebrow',     __( 'Capabilities', 'paksa-it-solutions' ) );
$heading = apply_filters( 'paksa_svc_capabilities_heading',     __( 'What We Deliver', 'paksa-it-solutions' ) );
$desc    = apply_filters( 'paksa_svc_capabilities_description', __( 'Each capability area represents a focused set of skills, tools and delivery experience — built around real business outcomes.', 'paksa-it-solutions' ) );

$capabilities = apply_filters( 'paksa_svc_capabilities_items', array(
    array(
        'icon'     => 'enterprise',
        'color'    => 'blue',
        'title'    => __( 'Enterprise Platform Development', 'paksa-it-solutions' ),
        'desc'     => __( 'We design and deliver multi-module business platforms that cover the full operational scope of your organisation — finance, inventory, HR, procurement and more. Built to your specific model, not adapted from a generic template.', 'paksa-it-solutions' ),
        'features' => array(
            __( 'Multi-module architecture with role-based access', 'paksa-it-solutions' ),
            __( 'Workflow automation and approval chains', 'paksa-it-solutions' ),
            __( 'Real-time reporting and executive dashboards', 'paksa-it-solutions' ),
            __( 'Scalable from SME to enterprise', 'paksa-it-solutions' ),
        ),
        'url' => '',
    ),
    array(
        'icon'     => 'ai',
        'color'    => 'indigo',
        'title'    => __( 'AI & Machine Learning', 'paksa-it-solutions' ),
        'desc'     => __( 'Applied AI where it creates measurable business value — not AI for its own sake. We build predictive systems, intelligent automation and decision-support tools that integrate directly into your existing operations.', 'paksa-it-solutions' ),
        'features' => array(
            __( 'Predictive analytics and demand forecasting', 'paksa-it-solutions' ),
            __( 'Intelligent process automation', 'paksa-it-solutions' ),
            __( 'Anomaly detection and quality control', 'paksa-it-solutions' ),
            __( 'Recommendation and personalisation engines', 'paksa-it-solutions' ),
        ),
        'url' => '',
    ),
    array(
        'icon'     => 'bi',
        'color'    => 'cyan',
        'title'    => __( 'Data Science & Business Intelligence', 'paksa-it-solutions' ),
        'desc'     => __( 'Turning operational data into decision intelligence. We build dashboards, KPI tracking systems, data pipelines and analytical models that answer the specific business questions your leadership team needs answered.', 'paksa-it-solutions' ),
        'features' => array(
            __( 'Executive and operational KPI dashboards', 'paksa-it-solutions' ),
            __( 'Data pipeline design and ETL processes', 'paksa-it-solutions' ),
            __( 'Statistical modelling and trend analysis', 'paksa-it-solutions' ),
            __( 'Automated reporting and scheduled delivery', 'paksa-it-solutions' ),
        ),
        'url' => '',
    ),
    array(
        'icon'     => 'integration',
        'color'    => 'violet',
        'title'    => __( 'System Integration', 'paksa-it-solutions' ),
        'desc'     => __( 'Connecting ERP systems, ecommerce platforms, APIs and business applications so data and workflows move without friction across your operations. We eliminate the manual data transfer and reconciliation that slows businesses down.', 'paksa-it-solutions' ),
        'features' => array(
            __( 'REST and SOAP API design and integration', 'paksa-it-solutions' ),
            __( 'ERP and accounting system connectivity', 'paksa-it-solutions' ),
            __( 'Real-time data synchronisation', 'paksa-it-solutions' ),
            __( 'Middleware and event-driven architecture', 'paksa-it-solutions' ),
        ),
        'url' => '',
    ),
) );

if ( empty( $capabilities ) ) { return; }

$color_map = array(
    'blue'   => array( 'bg' => 'rgba(97,146,248,0.1)',  'color' => '#6192F8' ),
    'indigo' => array( 'bg' => 'rgba(124,111,247,0.1)', 'color' => '#7c6ff7' ),
    'cyan'   => array( 'bg' => 'rgba(6,182,212,0.1)',   'color' => '#06b6d4' ),
    'violet' => array( 'bg' => 'rgba(139,92,246,0.1)',  'color' => '#8b5cf6' ),
);
?>
<section class="section section-alt pk-svc-capabilities" aria-labelledby="pk-svc-cap-heading">
    <div class="container">

        <div class="pk-svc-cap-header pk-animate-on-scroll" data-anim="fade-up">
            <?php if ( $eyebrow ) : ?>
                <span class="pk-section-label"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            <?php if ( $heading ) : ?>
                <h2 id="pk-svc-cap-heading"><?php echo esc_html( $heading ); ?></h2>
            <?php endif; ?>
            <?php if ( $desc ) : ?>
                <p class="pk-svc-cap-intro"><?php echo esc_html( $desc ); ?></p>
            <?php endif; ?>
        </div>

        <div class="pk-svc-cap-rows">
            <?php foreach ( $capabilities as $index => $cap ) :
                $color_key = $cap['color'] ?? 'blue';
                $colors    = $color_map[ $color_key ] ?? $color_map['blue'];
                $is_even   = $index % 2 === 1;
            ?>
                <div class="pk-svc-cap-row<?php echo $is_even ? ' pk-svc-cap-row--reverse' : ''; ?> pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $index % 2 ) * 100 ); ?>">

                    <div class="pk-svc-cap-row-visual" aria-hidden="true">
                        <div class="pk-svc-cap-row-icon-wrap" style="--cap-color: <?php echo esc_attr( $colors['color'] ); ?>; --cap-bg: <?php echo esc_attr( $colors['bg'] ); ?>;">
                            <div class="pk-svc-cap-row-icon">
                                <?php echo paksa_icon( $cap['icon'], 32 ); ?>
                            </div>
                            <div class="pk-svc-cap-row-number" aria-hidden="true"><?php printf( '%02d', $index + 1 ); ?></div>
                        </div>
                    </div>

                    <div class="pk-svc-cap-row-body">
                        <h3 class="pk-svc-cap-row-title" style="--cap-color: <?php echo esc_attr( $colors['color'] ); ?>;">
                            <?php echo esc_html( $cap['title'] ); ?>
                        </h3>
                        <p class="pk-svc-cap-row-desc"><?php echo esc_html( $cap['desc'] ); ?></p>

                        <?php if ( ! empty( $cap['features'] ) ) : ?>
                            <ul class="pk-svc-cap-row-features" aria-label="<?php echo esc_attr( sprintf( __( '%s features', 'paksa-it-solutions' ), $cap['title'] ) ); ?>">
                                <?php foreach ( $cap['features'] as $feature ) : ?>
                                    <li>
                                        <span class="pk-svc-cap-check" style="background: <?php echo esc_attr( $colors['color'] ); ?>;" aria-hidden="true">
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="1.5,5 4,7.5 8.5,2.5"/></svg>
                                        </span>
                                        <?php echo esc_html( $feature ); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if ( ! empty( $cap['url'] ) ) : ?>
                            <a href="<?php echo esc_url( $cap['url'] ); ?>" class="pk-svc-cap-row-link" style="color: <?php echo esc_attr( $colors['color'] ); ?>;">
                                <?php esc_html_e( 'Learn more', 'paksa-it-solutions' ); ?>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="2" y1="7" x2="12" y2="7"/><polyline points="8,3 12,7 8,11"/></svg>
                            </a>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
