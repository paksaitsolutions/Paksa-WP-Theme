<?php
/**
 * Paksa IT Solutions — Single Product: Overview
 * Split layout: text left, real product screenshot right.
 *
 * @package paksa-it-solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$prod_id    = get_the_ID();
$eyebrow    = paksa_prod_meta( 'overview_eyebrow', __( 'Overview', 'paksa-it-solutions' ), $prod_id );
$heading    = paksa_prod_meta( 'overview_heading', __( 'About This Product', 'paksa-it-solutions' ), $prod_id );
$content    = paksa_prod_meta_textarea( 'overview_content', '', $prod_id );
$paragraphs = $content ? array_filter( array_map( 'trim', explode( "\n", $content ) ) ) : array();
$use_editor = empty( $paragraphs ) && ! empty( get_the_content() );

// Real screenshot — AI Command Center for overview
$img_id  = (int) get_post_meta( $prod_id, '_paksa_prod_img_ai_cmd', true );
$img_url = $img_id ? wp_get_attachment_image_url( $img_id, 'paksa-large' ) : get_post_meta( $prod_id, '_paksa_prod_img_ai_cmd_url', true );
?>
<section class="pk-prod-overview" id="pk-product-overview" aria-labelledby="pk-prod-overview-heading">
    <div class="container">
        <div class="pk-prod-overview-inner">

            <div class="pk-prod-overview-text pk-animate-on-scroll" data-anim="fade-up">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>
                <h2 id="pk-prod-overview-heading"><?php echo esc_html( $heading ); ?></h2>
                <?php if ( ! empty( $paragraphs ) ) : ?>
                    <?php foreach ( $paragraphs as $para ) : ?>
                        <p><?php echo esc_html( $para ); ?></p>
                    <?php endforeach; ?>
                <?php elseif ( $use_editor ) : ?>
                    <div class="pk-prod-post-content"><?php the_content(); ?></div>
                <?php endif; ?>
            </div>

            <?php if ( $img_url ) : ?>
                <div class="pk-prod-overview-visual pk-animate-on-scroll" data-anim="fade-up" data-delay="120">
                    <img src="<?php echo esc_url( $img_url ); ?>"
                         alt="<?php echo esc_attr( __( 'Paksa ERP AI Command Center', 'paksa-it-solutions' ) ); ?>"
                         loading="lazy"
                         decoding="async"
                         class="pk-prod-overview-img">
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
