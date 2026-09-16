<?php
/**
 * Paksa IT Solutions — Services: FAQ
 *
 * Reuses template-parts/components/faq-item.php (Phase 3 component).
 * Reuses .pk-faq-* CSS from home.css (loaded on this page via enqueue.php).
 * Reuses FAQ accordion JS from home.js (loaded on this page via enqueue.php).
 *
 * No duplication of markup, CSS or JS.
 *
 * Content source: apply_filters( 'paksa_svc_faq_items', $defaults )
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow = apply_filters( 'paksa_svc_faq_eyebrow', __( 'FAQ', 'paksa-it-solutions' ) );
$heading = apply_filters( 'paksa_svc_faq_heading', __( 'Common Questions About Our Services', 'paksa-it-solutions' ) );

/**
 * Filter: paksa_svc_faq_items
 * Service-specific FAQ items. Separate from homepage FAQ (paksa_homepage_faq_items).
 */
$faqs = apply_filters( 'paksa_svc_faq_items', array(
    array(
        'question' => __( 'How do you approach a new software project?', 'paksa-it-solutions' ),
        'answer'   => __( 'Every project begins with a discovery phase — understanding the business, its workflows, data requirements and operational context. Technical decisions follow from that understanding, not the other way around.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'Do you build custom software or use existing platforms?', 'paksa-it-solutions' ),
        'answer'   => __( 'Both, depending on what is right for the requirement. We build custom software where off-the-shelf solutions cannot address the specific operational need. Where existing platforms are appropriate, we configure, extend and integrate them.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'Can you integrate with our existing systems?', 'paksa-it-solutions' ),
        'answer'   => __( 'Yes. System integration is a core capability. We connect ERP systems, ecommerce platforms, APIs and business applications so data and workflows move without friction across your operations.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'What happens after the software is delivered?', 'paksa-it-solutions' ),
        'answer'   => __( 'We design solutions with modular architecture specifically so they can evolve as your business grows and requirements change. Post-delivery support, maintenance and ongoing development are available.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'How do we start a project?', 'paksa-it-solutions' ),
        'answer'   => __( 'The first step is a consultation to understand your business, requirements and objectives. Contact us to arrange an initial discussion — there is no obligation and no cost for the initial conversation.', 'paksa-it-solutions' ),
    ),
) );

if ( empty( $faqs ) ) {
    return;
}
?>
<section class="section pk-faq pk-svc-faq" aria-labelledby="pk-svc-faq-heading">
    <div class="container">
        <div class="pk-faq-inner">

            <?php
            get_template_part( 'template-parts/components/section-header', null, array(
                'eyebrow'  => $eyebrow,
                'heading'  => $heading,
                'align'    => 'left',
            ) );
            ?>

            <div class="pk-faq-list" role="list">
                <?php foreach ( $faqs as $index => $faq ) : ?>
                    <?php
                    get_template_part( 'template-parts/components/faq-item', null, array(
                        'question' => $faq['question'],
                        'answer'   => $faq['answer'],
                        'index'    => 'svc-' . $index,
                        'open'     => $index === 0,
                    ) );
                    ?>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>
