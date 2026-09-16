<?php
/**
 * Paksa IT Solutions — Products Listing: FAQ
 *
 * Reuses template-parts/components/faq-item.php and home.js accordion.
 * Content: apply_filters( 'paksa_prod_faq_items', $defaults )
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow = apply_filters( 'paksa_prod_faq_eyebrow', __( 'FAQ', 'paksa-it-solutions' ) );
$heading = apply_filters( 'paksa_prod_faq_heading', __( 'Common Questions About Our Products', 'paksa-it-solutions' ) );

$faqs = apply_filters( 'paksa_prod_faq_items', array(
    array(
        'question' => __( 'Are these products available as cloud or desktop software?', 'paksa-it-solutions' ),
        'answer'   => __( 'Deployment options vary by product. Contact us to discuss the deployment model that fits your infrastructure and operational requirements.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'Can products be customised for our specific business requirements?', 'paksa-it-solutions' ),
        'answer'   => __( 'Yes. Our products are designed with modular architecture that supports customisation and extension. We work with clients to configure and adapt products to their specific operational workflows.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'Can products integrate with our existing systems?', 'paksa-it-solutions' ),
        'answer'   => __( 'Yes. Integration with existing ERP systems, ecommerce platforms, APIs and business applications is a core capability. We design integration layers as part of the implementation process.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'What support is available after implementation?', 'paksa-it-solutions' ),
        'answer'   => __( 'We provide post-implementation support, maintenance and ongoing development. The specific support model is agreed as part of the project engagement.', 'paksa-it-solutions' ),
    ),
    array(
        'question' => __( 'How do we get started?', 'paksa-it-solutions' ),
        'answer'   => __( 'Contact us to arrange an initial consultation. We will discuss your requirements, demonstrate the relevant product and outline an implementation approach — at no cost and with no obligation.', 'paksa-it-solutions' ),
    ),
) );

if ( empty( $faqs ) ) {
    return;
}
?>
<section class="section pk-faq pk-prod-faq" aria-labelledby="pk-prod-faq-heading">
    <div class="container">
        <div class="pk-faq-inner">
            <?php
            get_template_part( 'template-parts/components/section-header', null, array(
                'eyebrow' => $eyebrow,
                'heading' => $heading,
                'align'   => 'left',
            ) );
            ?>
            <div class="pk-faq-list" role="list">
                <?php foreach ( $faqs as $i => $faq ) : ?>
                    <?php
                    get_template_part( 'template-parts/components/faq-item', null, array(
                        'question' => $faq['question'],
                        'answer'   => $faq['answer'],
                        'index'    => 'prod-' . $i,
                        'open'     => $i === 0,
                    ) );
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
