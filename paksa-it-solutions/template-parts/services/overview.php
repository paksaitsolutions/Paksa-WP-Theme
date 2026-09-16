<?php
/**
 * Paksa IT Solutions — Services: Overview Section
 *
 * Content source: post meta (_paksa_svc_overview_*)
 * Each line of overview_content becomes a paragraph.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow = paksa_svc_meta( 'overview_eyebrow', __( 'Our Services', 'paksa-it-solutions' ) );
$heading = paksa_svc_meta( 'overview_heading', __( 'Technology Built Around Your Business', 'paksa-it-solutions' ) );
$content = paksa_svc_meta_textarea( 'overview_content', '' );

// Parse content: each non-empty line becomes a paragraph.
$paragraphs = array();
if ( $content ) {
    $paragraphs = array_filter( array_map( 'trim', explode( "\n", $content ) ) );
}

/**
 * Filter: paksa_svc_overview_stats
 * Supporting stat/highlight items shown alongside the overview text.
 * Default is empty — admin must populate via filter or future meta fields.
 * Do NOT invent statistics.
 *
 * Each item: array( 'value' => string, 'label' => string )
 */
$stats = apply_filters( 'paksa_svc_overview_stats', array() );
?>
<section class="section section-alt pk-svc-overview" aria-labelledby="pk-svc-overview-heading">
    <div class="container">
        <div class="pk-svc-overview-inner">

            <div class="pk-svc-overview-text pk-animate-on-scroll" data-anim="fade-up">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $heading ) : ?>
                    <h2 id="pk-svc-overview-heading"><?php echo esc_html( $heading ); ?></h2>
                <?php endif; ?>

                <?php if ( ! empty( $paragraphs ) ) : ?>
                    <div class="pk-svc-overview-body">
                        <?php foreach ( $paragraphs as $para ) : ?>
                            <p><?php echo esc_html( $para ); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ( ! empty( $stats ) ) : ?>
                <div class="pk-svc-overview-stats pk-animate-on-scroll" data-anim="fade-up" data-delay="100">
                    <?php foreach ( $stats as $stat ) : ?>
                        <div class="pk-svc-stat">
                            <span class="pk-svc-stat-value"><?php echo esc_html( $stat['value'] ); ?></span>
                            <span class="pk-svc-stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
