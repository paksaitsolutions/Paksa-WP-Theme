<?php
/**
 * Paksa IT Solutions — Single Product: FAQ
 *
 * Content source (priority order):
 *   1. Post meta: _paksa_prod_faq_items (pipe-delimited: Question | Answer, one per line)
 *   2. Filter: paksa_product_faq_items (for programmatic population)
 *
 * Reuses template-parts/components/faq-item.php and home.js accordion.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$prod_id = get_the_ID();

// Build FAQ from post meta first.
$faqs     = array();
$raw_meta = get_post_meta( $prod_id, '_paksa_prod_faq_items', true );

if ( ! empty( $raw_meta ) ) {
    $lines = array_filter( array_map( 'trim', explode( "\n", $raw_meta ) ) );
    foreach ( $lines as $line ) {
        $parts = array_map( 'trim', explode( '|', $line, 2 ) );
        if ( ! empty( $parts[0] ) && ! empty( $parts[1] ) ) {
            $faqs[] = array(
                'question' => sanitize_text_field( $parts[0] ),
                'answer'   => sanitize_text_field( $parts[1] ),
            );
        }
    }
}

/**
 * Filter: paksa_product_faq_items
 * Allows programmatic FAQ population. Meta-sourced items take priority.
 *
 * @param array $items   FAQ items array( 'question' => '', 'answer' => '' ).
 * @param int   $prod_id Product post ID.
 */
if ( empty( $faqs ) ) {
    $faqs = apply_filters( 'paksa_product_faq_items', array(), $prod_id );
}

if ( empty( $faqs ) ) {
    return;
}

$eyebrow = __( 'FAQ', 'paksa-it-solutions' );
$heading = sprintf(
    /* translators: %s: product name */
    __( 'Questions About %s', 'paksa-it-solutions' ),
    get_the_title()
);
?>
<section class="section pk-faq pk-prod-single-faq" aria-labelledby="pk-prod-faq-heading">
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
                        'index'    => 'single-prod-' . $i,
                        'open'     => $i === 0,
                    ) );
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
