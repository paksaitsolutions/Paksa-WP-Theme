<?php
/**
 * Paksa IT Solutions — Single Service: FAQ
 *
 * Content source (priority order):
 *   1. Post meta: _paksa_svc_faq_items (pipe-delimited: Question | Answer, one per line)
 *   2. Filter: paksa_service_faq_items (for programmatic population)
 *
 * Reuses template-parts/components/faq-item.php and home.js accordion.
 * Matches the product FAQ contract exactly.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$svc_id = get_the_ID();

// Build FAQ from post meta first.
$faqs     = array();
$raw_meta = get_post_meta( $svc_id, '_paksa_svc_faq_items', true );

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
 * Filter: paksa_service_faq_items
 * Allows programmatic FAQ population. Meta-sourced items take priority.
 *
 * @param array $items  FAQ items array( 'question' => '', 'answer' => '' ).
 * @param int   $svc_id Service post ID.
 */
if ( empty( $faqs ) ) {
    $faqs = apply_filters( 'paksa_service_faq_items', array(), $svc_id );
}

if ( empty( $faqs ) ) {
    return;
}

$eyebrow = __( 'FAQ', 'paksa-it-solutions' );
$heading = sprintf(
    /* translators: %s: service name */
    __( 'Questions About %s', 'paksa-it-solutions' ),
    get_the_title()
);
?>
<section class="section pk-faq pk-svc-single-faq" aria-labelledby="pk-svc-faq-heading">
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
                        'index'    => 'single-svc-' . $i,
                        'open'     => $i === 0,
                    ) );
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
