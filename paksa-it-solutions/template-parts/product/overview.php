<?php
/**
 * Paksa IT Solutions — Single Product: Overview
 *
 * Shows the product overview section.
 * Content: _paksa_prod_overview_* meta + block editor post content.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$prod_id = get_the_ID();
$eyebrow = paksa_prod_meta( 'overview_eyebrow', __( 'Overview', 'paksa-it-solutions' ), $prod_id );
$heading = paksa_prod_meta( 'overview_heading', __( 'About This Product', 'paksa-it-solutions' ), $prod_id );
$content = paksa_prod_meta_textarea( 'overview_content', '', $prod_id );

// Parse meta content into paragraphs.
$paragraphs = array();
if ( $content ) {
    $paragraphs = array_filter( array_map( 'trim', explode( "\n", $content ) ) );
}

// If no meta content, fall back to the block editor post content.
$use_post_content = empty( $paragraphs ) && ! empty( get_the_content() );
?>
<section class="section section-alt pk-prod-overview" id="pk-product-overview" aria-labelledby="pk-prod-overview-heading">
    <div class="container pk-prod-overview-inner">

        <div class="pk-prod-overview-text pk-animate-on-scroll" data-anim="fade-up">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>
            <h2 id="pk-prod-overview-heading"><?php echo esc_html( $heading ); ?></h2>

            <?php if ( ! empty( $paragraphs ) ) : ?>
                <?php foreach ( $paragraphs as $para ) : ?>
                    <p><?php echo esc_html( $para ); ?></p>
                <?php endforeach; ?>
            <?php elseif ( $use_post_content ) : ?>
                <div class="pk-prod-post-content">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</section>
