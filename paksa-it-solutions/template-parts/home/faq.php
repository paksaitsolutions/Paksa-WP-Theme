<?php
/**
 * Paksa IT Solutions — Homepage: FAQ
 * Uses reusable faq-item component.
 * Content: Customizer headings + filter-extensible Q&A pairs.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow = paksa_get_option( 'paksa_faq_eyebrow', __( 'FAQ', 'paksa-it-solutions' ) );
$heading = paksa_get_option( 'paksa_faq_heading', __( 'Common Questions', 'paksa-it-solutions' ) );

/**
 * Filter: paksa_faq_items
 * Reusable on service/product pages via different filter hooks.
 */
$faqs = apply_filters( 'paksa_homepage_faq_items', array(
    array(
        'question' => __( 'What does Paksa IT Solutions do?', 'paksa-it-solutions' ),
        'answer'   => __( 'Paksa IT Solutions builds enterprise software, custom applications, AI-powered systems and business intelligence platforms for businesses that need serious, purpose-built technology.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'What types of software does Paksa build?', 'paksa-it-solutions' ),
        'answer'   => __( 'We build ERP systems, custom business applications, AI and machine learning solutions, business intelligence dashboards, ecommerce platforms and system integrations — all designed around specific business requirements.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'Do you build custom enterprise software?', 'paksa-it-solutions' ),
        'answer'   => __( 'Yes. Custom enterprise software is a core capability. We design and build platforms tailored to your specific operational workflows, data requirements and business processes.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'Does Paksa provide AI and machine learning solutions?', 'paksa-it-solutions' ),
        'answer'   => __( 'Yes. We apply AI and machine learning where they create genuine business value — including predictive analytics, intelligent automation, anomaly detection and recommendation systems.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'Can Paksa integrate existing business systems?', 'paksa-it-solutions' ),
        'answer'   => __( 'Yes. System integration is a core service. We connect ERP systems, ecommerce platforms, APIs and business applications so data and workflows move without friction across your operations.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'Do you work with ecommerce businesses?', 'paksa-it-solutions' ),
        'answer'   => __( 'Yes. We build and integrate ecommerce platforms, connect them to operational systems and develop the backend infrastructure that supports serious ecommerce operations.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'Can solutions be customized after delivery?', 'paksa-it-solutions' ),
        'answer'   => __( 'Yes. We design solutions with modular architecture specifically so they can evolve as your business grows and requirements change — without requiring complete rebuilds.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'How do we start a project with Paksa?', 'paksa-it-solutions' ),
        'answer'   => __( 'The first step is a consultation to understand your business, requirements and objectives. Contact us to arrange an initial discussion — there is no obligation and no cost for the initial conversation.', 'paksa-it-solutions' ),
    ),
) );

if ( empty( $faqs ) ) {
    return;
}
?>
<section class="section pk-faq" aria-labelledby="pk-faq-heading">
    <div class="container">
        <div class="pk-faq-inner">
            <?php
            get_template_part( 'template-parts/components/section-header', null, array(
                'eyebrow'     => $eyebrow,
                'heading'     => $heading,
                'align'       => 'left',
            ) );
            ?>

            <div class="pk-faq-list" role="list">
                <?php foreach ( $faqs as $index => $faq ) : ?>
                    <?php
                    get_template_part( 'template-parts/components/faq-item', null, array(
                        'question' => $faq['question'],
                        'answer'   => $faq['answer'],
                        'index'    => $index,
                        'open'     => $index === 0,
                    ) );
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
