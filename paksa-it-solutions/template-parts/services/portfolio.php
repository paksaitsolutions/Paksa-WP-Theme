<?php
/**
 * Services Page — Service Portfolio Grid
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$eyebrow = __( 'What We Do', 'paksa-it-solutions' );
$heading = __( 'Our Service Portfolio', 'paksa-it-solutions' );
$desc    = __( 'From AI-powered automation to enterprise ERP systems — a complete range of technology services built around real business requirements, not off-the-shelf templates.', 'paksa-it-solutions' );

/* ── Static service data — source of truth until CPT meta is fully populated ── */
$services = array(

        /* ── Artificial Intelligence ── */
        array(
            'icon'        => 'ai',
            'title'       => 'AI & Machine Learning Solutions',
            'description' => 'Predictive models, intelligent decision-support and adaptive systems embedded directly into your business workflows — applied AI that creates measurable operational value from day one.',
            'features'    => array( 'Predictive analytics & forecasting', 'Custom ML model development', 'AI integration into existing systems' ),
            'outcome'     => 'Reduce decision time by 60%',
            'category'    => 'AI & Machine Learning',
            'url'         => home_url( '/services/ai-ml-solutions/' ),
            'featured'    => true,
        ),
        array(
            'icon'        => 'automation',
            'title'       => 'AI Process Automation',
            'description' => 'Eliminate repetitive manual work with intelligent automation — document processing, approval workflows, data entry and operational tasks handled by AI with zero human intervention.',
            'features'    => array( 'Document & invoice processing', 'Multi-step workflow automation', 'RPA + AI hybrid pipelines' ),
            'outcome'     => 'Cut manual effort by 80%',
            'category'    => 'AI Automation',
            'url'         => home_url( '/services/ai-automation/' ),
            'featured'    => false,
        ),
        array(
            'icon'        => 'eye',
            'title'       => 'Computer Vision & Image Recognition',
            'description' => 'Visual AI systems for quality control, defect detection, document scanning and real-time monitoring — deployed on production lines, warehouses and field operations.',
            'features'    => array( 'Real-time defect detection', 'Document & ID scanning', 'Video surveillance analytics' ),
            'outcome'     => '99.2% detection accuracy',
            'category'    => 'AI & Machine Learning',
            'url'         => '',
            'featured'    => false,
        ),

        /* ── Data & Analytics ── */
        array(
            'icon'        => 'analytics',
            'title'       => 'Data Science & Analytics',
            'description' => 'KPI dashboards, data pipelines and analytical models that turn raw operational data into clear, actionable business intelligence for leadership and operations teams.',
            'features'    => array( 'End-to-end data pipelines', 'Statistical modelling & segmentation', 'Automated reporting systems' ),
            'outcome'     => 'Single source of truth for all KPIs',
            'category'    => 'Data Science',
            'url'         => home_url( '/services/data-science/' ),
            'featured'    => false,
        ),
        array(
            'icon'        => 'bi',
            'title'       => 'Business Intelligence & Reporting',
            'description' => 'Automated reporting, executive dashboards and real-time KPI tracking systems that give decision-makers accurate, up-to-date visibility across every business function.',
            'features'    => array( 'Power BI / custom dashboards', 'Scheduled automated reports', 'Cross-department data consolidation' ),
            'outcome'     => 'Real-time visibility across all ops',
            'category'    => 'Data Science',
            'url'         => '',
            'featured'    => false,
        ),

        /* ── Enterprise Software ── */
        array(
            'icon'        => 'enterprise',
            'title'       => 'Enterprise Resource Planning (ERP)',
            'description' => 'Custom ERP systems covering finance, inventory, procurement, HR and operations — built to your specific business model, not adapted from a generic platform.',
            'features'    => array( 'Finance, inventory & procurement', 'HR, payroll & attendance modules', 'Multi-branch & multi-currency support' ),
            'outcome'     => 'Full operational visibility in one system',
            'category'    => 'Software Development',
            'url'         => home_url( '/solutions/paksa-erp/' ),
            'featured'    => false,
        ),
        array(
            'icon'        => 'custom',
            'title'       => 'Custom Software Development',
            'description' => 'Purpose-built applications for unique workflows that off-the-shelf software cannot address — designed for how your business actually operates, not how a vendor assumes it does.',
            'features'    => array( 'Workflow-specific application design', 'Legacy system modernisation', 'Scalable architecture from day one' ),
            'outcome'     => 'Software that fits your exact process',
            'category'    => 'Software Development',
            'url'         => home_url( '/services/software-development/' ),
            'featured'    => false,
        ),
        array(
            'icon'        => 'software',
            'title'       => 'SaaS Product Development',
            'description' => 'End-to-end development of multi-tenant SaaS platforms — from architecture and backend to frontend, billing integration and deployment infrastructure.',
            'features'    => array( 'Multi-tenant architecture', 'Subscription & billing integration', 'CI/CD deployment pipelines' ),
            'outcome'     => 'Launch-ready SaaS in 12–16 weeks',
            'category'    => 'Software Development',
            'url'         => '',
            'featured'    => false,
        ),

        /* ── Integration ── */
        array(
            'icon'        => 'integration',
            'title'       => 'System Integration & APIs',
            'description' => 'Connect ERP, ecommerce, accounting and third-party platforms so data flows without friction across your entire operation — no manual reconciliation, no data silos.',
            'features'    => array( 'REST & GraphQL API development', 'ERP ↔ ecommerce sync', 'Third-party webhook automation' ),
            'outcome'     => 'Zero data silos across all platforms',
            'category'    => 'Integration',
            'url'         => '',
            'featured'    => false,
        ),
        array(
            'icon'        => 'ecommerce',
            'title'       => 'Ecommerce Solutions',
            'description' => 'Connected commerce platforms integrated with your ERP, inventory and fulfilment systems — not standalone stores that create operational silos and manual work.',
            'features'    => array( 'ERP-integrated storefronts', 'Real-time inventory sync', 'Custom checkout & fulfilment flows' ),
            'outcome'     => 'Orders flow straight into your ERP',
            'category'    => 'Integration',
            'url'         => '',
            'featured'    => false,
        ),

        /* ── Web & Digital ── */
        array(
            'icon'        => 'digital',
            'title'       => 'Web Application Development',
            'description' => 'Scalable, performant web applications built with modern frameworks — customer portals, internal tools, booking systems and operational dashboards.',
            'features'    => array( 'React / Next.js / Laravel', 'Role-based access & portals', 'Mobile-first responsive design' ),
            'outcome'     => 'Production-grade apps, not prototypes',
            'category'    => 'Web & Digital',
            'url'         => '',
            'featured'    => false,
        ),
        array(
            'icon'        => 'chart',
            'title'       => 'Digital Transformation Consulting',
            'description' => 'Strategic technology consulting to map your current operations, identify automation opportunities and build a phased roadmap from manual processes to intelligent digital systems.',
            'features'    => array( 'Operations & process audit', 'Technology stack assessment', 'Phased transformation roadmap' ),
            'outcome'     => 'Clear roadmap with ROI at every phase',
            'category'    => 'Web & Digital',
            'url'         => '',
            'featured'    => false,
        ),
);

if ( empty( $services ) ) { return; }

$categories = array( 'All' );
foreach ( $services as $svc ) {
    if ( ! empty( $svc['category'] ) && ! in_array( $svc['category'], $categories, true ) ) {
        $categories[] = $svc['category'];
    }
}
?>
<section class="section pk-svc-portfolio" id="pk-services-portfolio" aria-labelledby="pk-svc-portfolio-heading">
    <div class="container">

        <div class="pk-svc-portfolio-header pk-animate-on-scroll" data-anim="fade-up">
            <span class="pk-section-label"><?php echo esc_html( $eyebrow ); ?></span>
            <h2 id="pk-svc-portfolio-heading"><?php echo esc_html( $heading ); ?></h2>
            <p class="pk-svc-portfolio-desc"><?php echo esc_html( $desc ); ?></p>
        </div>

        <?php if ( count( $categories ) > 2 ) : ?>
            <div class="pk-svc-filter pk-animate-on-scroll" data-anim="fade-up" data-delay="100"
                 role="tablist" aria-label="<?php esc_attr_e( 'Filter services by category', 'paksa-it-solutions' ); ?>">
                <?php foreach ( $categories as $cat ) : ?>
                    <button
                        class="pk-svc-filter-btn<?php echo $cat === 'All' ? ' is-active' : ''; ?>"
                        data-filter="<?php echo esc_attr( $cat ); ?>"
                        role="tab"
                        aria-selected="<?php echo $cat === 'All' ? 'true' : 'false'; ?>"
                    ><?php echo esc_html( $cat ); ?></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="pk-svc-cards-grid" role="list">
            <?php foreach ( $services as $index => $svc ) :
                $is_featured = ! empty( $svc['featured'] );
                $has_link    = ! empty( $svc['url'] );
                $tag         = $has_link ? 'a' : 'article';
                $href        = $has_link ? ' href="' . esc_url( $svc['url'] ) . '"' : '';
                $card_class  = 'pk-svc-card-v2' . ( $is_featured ? ' pk-svc-card-v2--featured' : '' ) . ' pk-animate-on-scroll';
                $delay       = ( $index % 3 ) * 80;
            ?>
                <<?php echo $tag; ?>
                    class="<?php echo esc_attr( $card_class ); ?>"
                    <?php echo $href; ?>
                    data-anim="fade-up"
                    data-delay="<?php echo esc_attr( $delay ); ?>"
                    data-category="<?php echo esc_attr( $svc['category'] ?? 'All' ); ?>"
                    role="listitem"
                    <?php if ( $has_link ) : ?>aria-label="<?php echo esc_attr( $svc['title'] ); ?>"<?php endif; ?>
                >
                    <div class="pk-svc-card-v2-top">
                        <div class="pk-svc-card-v2-icon" aria-hidden="true">
                            <?php echo paksa_get_capability_icon( $svc['icon'] ); ?>
                        </div>
                        <?php if ( ! empty( $svc['category'] ) ) : ?>
                            <span class="pk-svc-card-v2-cat"><?php echo esc_html( $svc['category'] ); ?></span>
                        <?php endif; ?>
                    </div>

                    <h3 class="pk-svc-card-v2-title"><?php echo esc_html( $svc['title'] ); ?></h3>
                    <p class="pk-svc-card-v2-desc"><?php echo esc_html( $svc['description'] ); ?></p>

                    <?php if ( ! empty( $svc['features'] ) ) : ?>
                        <ul class="pk-svc-card-v2-features" aria-label="Key capabilities">
                            <?php foreach ( $svc['features'] as $feat ) : ?>
                                <li>
                                    <svg width="14" height="14" viewBox="0 0 256 256" fill="currentColor" aria-hidden="true"><path d="M173.7 98.3a8 8 0 0 0-11.4 0L112 148.7 93.7 130.3a8 8 0 0 0-11.4 11.4l24 24a8 8 0 0 0 11.4 0l56-56a8 8 0 0 0 0-11.4z"/></svg>
                                    <?php echo esc_html( $feat ); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <div class="pk-svc-card-v2-footer">
                        <?php if ( ! empty( $svc['outcome'] ) ) : ?>
                            <span class="pk-svc-card-v2-outcome">
                                <svg width="12" height="12" viewBox="0 0 256 256" fill="currentColor" aria-hidden="true"><path d="m213.9 133.1-120 112A8 8 0 0 1 80 240v-88H40a8 8 0 0 1-6.2-13.1l120-144A8 8 0 0 1 168 16v88h40a8 8 0 0 1 5.9 13.1z"/></svg>
                                <?php echo esc_html( $svc['outcome'] ); ?>
                            </span>
                        <?php endif; ?>
                        <?php if ( $has_link ) : ?>
                            <span class="pk-svc-card-v2-cta" aria-hidden="true">
                                <?php esc_html_e( 'Learn more', 'paksa-it-solutions' ); ?>
                                <svg width="14" height="14" viewBox="0 0 256 256" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="2" y1="7" x2="12" y2="7"/><polyline points="8,3 12,7 8,11"/></svg>
                            </span>
                        <?php endif; ?>
                    </div>

                </<?php echo $tag; ?>>
            <?php endforeach; ?>
        </div>

    </div>
</section>
