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
$heading = paksa_get_option( 'paksa_faq_heading', __( 'Real Questions, Straight Answers', 'paksa-it-solutions' ) );

/**
 * Filter: paksa_faq_items
 * Reusable on service/product pages via different filter hooks.
 */
$faqs = apply_filters( 'paksa_homepage_faq_items', array(
    array(
        'question' => __( 'How long does a custom ERP implementation take?', 'paksa-it-solutions' ),
        'answer'   => __( 'Most ERP implementations take 3–6 months from requirements sign-off to go-live. We phase delivery so you\'re using core modules within 6–8 weeks, not waiting for a big-bang launch. A single-department deployment moves faster than a multi-branch rollout.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'Can you integrate with our existing systems?', 'paksa-it-solutions' ),
        'answer'   => __( 'Yes. We\'ve connected Paksa ERP and custom platforms to SAP, QuickBooks, WooCommerce, Shopify, and payment gateways used across Pakistan and the UK. If you have REST APIs, database access, or even flat-file exports, we can build the bridge — typically within 2–3 weeks per integration point.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'What support is available after deployment?', 'paksa-it-solutions' ),
        'answer'   => __( 'Every project includes 30 days of post-launch support. After that, we offer structured maintenance plans starting at 15% of project value per month, covering bug fixes, security patches, and minor enhancements. We also provide training documentation and video walkthroughs for your team.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'Do you work with businesses outside Pakistan?', 'paksa-it-solutions' ),
        'answer'   => __( 'Yes. Paksa ERP and our salon management platform are deployed in Pakistan, the UK, and the USA. We handle timezone differences with dedicated overlap hours, and all contracts are available in GBP and USD. For international clients, we use milestone-based billing with clear delivery checkpoints.', 'paksa-it-solutions' ),
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
                'description' => __( 'The things clients actually ask before signing a contract — no padding, no fluff.', 'paksa-it-solutions' ),
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
