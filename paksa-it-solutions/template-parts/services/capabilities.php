<?php
/**
 * Paksa IT Solutions — Services: Capability Detail
 *
 * Reusable capability presentation component.
 * Each capability supports: title, description, icon, features list, optional link.
 *
 * Content source: apply_filters( 'paksa_svc_capabilities_items', $defaults )
 *
 * Architecture note:
 *   This section is intentionally separate from the homepage capabilities section.
 *   The homepage shows a summary grid. This section shows expanded capability detail
 *   with feature lists — appropriate for a dedicated services page.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow = apply_filters( 'paksa_svc_capabilities_eyebrow',     __( 'Capabilities', 'paksa-it-solutions' ) );
$heading = apply_filters( 'paksa_svc_capabilities_heading',     __( 'What We Deliver', 'paksa-it-solutions' ) );
$desc    = apply_filters( 'paksa_svc_capabilities_description', __( 'Each capability area represents a focused set of skills, tools and delivery experience.', 'paksa-it-solutions' ) );

/**
 * Filter: paksa_svc_capabilities_items
 *
 * Each item:
 *   title    string   Capability name
 *   desc     string   Description
 *   icon     string   Icon key
 *   features array    List of feature strings (optional)
 *   url      string   Link (optional)
 */
$capabilities = apply_filters( 'paksa_svc_capabilities_items', array(
    array(
        'icon'     => 'enterprise',
        'title'    => __( 'Enterprise Platform Development', 'paksa-it-solutions' ),
        'desc'     => __( 'Design and delivery of multi-module business platforms covering finance, operations, inventory, HR and procurement — built to your specific operational model.', 'paksa-it-solutions' ),
        'features' => array(
            __( 'Multi-module architecture', 'paksa-it-solutions' ),
            __( 'Role-based access control', 'paksa-it-solutions' ),
            __( 'Workflow automation', 'paksa-it-solutions' ),
            __( 'Reporting & dashboards', 'paksa-it-solutions' ),
        ),
        'url' => '',
    ),
    array(
        'icon'     => 'ai',
        'title'    => __( 'AI & Machine Learning', 'paksa-it-solutions' ),
        'desc'     => __( 'Applied AI where it creates measurable business value — predictive analytics, intelligent automation, anomaly detection and recommendation systems.', 'paksa-it-solutions' ),
        'features' => array(
            __( 'Predictive analytics', 'paksa-it-solutions' ),
            __( 'Intelligent automation', 'paksa-it-solutions' ),
            __( 'Anomaly detection', 'paksa-it-solutions' ),
            __( 'Recommendation systems', 'paksa-it-solutions' ),
        ),
        'url' => '',
    ),
    array(
        'icon'     => 'bi',
        'title'    => __( 'Data Science & Business Intelligence', 'paksa-it-solutions' ),
        'desc'     => __( 'Turning operational data into decision intelligence — dashboards, KPI tracking, data pipelines and analytical models built around your business questions.', 'paksa-it-solutions' ),
        'features' => array(
            __( 'KPI dashboards', 'paksa-it-solutions' ),
            __( 'Data pipeline design', 'paksa-it-solutions' ),
            __( 'Analytical modelling', 'paksa-it-solutions' ),
            __( 'Reporting automation', 'paksa-it-solutions' ),
        ),
        'url' => '',
    ),
    array(
        'icon'     => 'integration',
        'title'    => __( 'System Integration', 'paksa-it-solutions' ),
        'desc'     => __( 'Connecting ERP systems, ecommerce platforms, APIs and business applications so data and workflows move without friction across your operations.', 'paksa-it-solutions' ),
        'features' => array(
            __( 'API design & integration', 'paksa-it-solutions' ),
            __( 'ERP connectivity', 'paksa-it-solutions' ),
            __( 'Data synchronisation', 'paksa-it-solutions' ),
            __( 'Middleware development', 'paksa-it-solutions' ),
        ),
        'url' => '',
    ),
) );

if ( empty( $capabilities ) ) {
    return;
}
?>
<section class="section section-alt pk-svc-capabilities" aria-labelledby="pk-svc-cap-heading">
    <div class="container">

        <?php
        get_template_part( 'template-parts/components/section-header', null, array(
            'eyebrow'     => $eyebrow,
            'heading'     => $heading,
            'description' => $desc,
        ) );
        ?>

        <div class="pk-svc-cap-grid">
            <?php foreach ( $capabilities as $index => $cap ) : ?>
                <article class="pk-svc-cap-item pk-animate-on-scroll" data-anim="fade-up" data-delay="<?php echo esc_attr( ( $index % 2 ) * 100 ); ?>">

                    <div class="pk-svc-cap-icon" aria-hidden="true">
                        <?php echo paksa_get_capability_icon( $cap['icon'] ); ?>
                    </div>

                    <div class="pk-svc-cap-body">
                        <h3 class="pk-svc-cap-title"><?php echo esc_html( $cap['title'] ); ?></h3>
                        <p class="pk-svc-cap-desc"><?php echo esc_html( $cap['desc'] ); ?></p>

                        <?php if ( ! empty( $cap['features'] ) ) : ?>
                            <ul class="pk-svc-cap-features" aria-label="<?php echo esc_attr( sprintf( __( '%s features', 'paksa-it-solutions' ), $cap['title'] ) ); ?>">
                                <?php foreach ( $cap['features'] as $feature ) : ?>
                                    <li>
                                        <span class="pk-svc-cap-check" aria-hidden="true">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="2,7 5.5,10.5 12,3"></polyline>
                                            </svg>
                                        </span>
                                        <?php echo esc_html( $feature ); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if ( ! empty( $cap['url'] ) ) : ?>
                            <a href="<?php echo esc_url( $cap['url'] ); ?>" class="pk-svc-cap-link">
                                <?php esc_html_e( 'Learn more', 'paksa-it-solutions' ); ?>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <line x1="2" y1="7" x2="12" y2="7"></line>
                                    <polyline points="8,3 12,7 8,11"></polyline>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>

                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>
